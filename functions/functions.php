<?php

function redirect($location)
{
    header("location: {$location}");
    exit();
}

//postavljanje poruke korisniku ako je sesija uspostavljena
function set_message($message)
{
    if (!empty($message)) {
        $_SESSION['message'] = $message;
    } else {
        $message = "";
    }
}

function display_message()
{
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}


function email_exists($email)
{
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $query = "SELECT id FROM users WHERE email = '$email'";
    $result = query($query);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function user_exists($username)
{
    $user = filter_var($username, FILTER_SANITIZE_STRING);
    $query = "SELECT id FROM users WHERE username = '$user'";
    $result = query($query);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function validate_user()
{
    $greska = [];
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $first_name = ($_POST['first_name']);
        $last_name = ($_POST['last_name']);
        $username = ($_POST['username']);
        $email = ($_POST['email']);
        $password = ($_POST['password']);
        $confirm_password = ($_POST['confirm_password']);
        if (strlen($first_name) < 3) {
            $greska[] = "Tvoje ime ne moze biti krace od tri karaktera";
        }
        if (strlen($last_name) < 3) {
            $greska[] = "Tvoje prezime ne moze biti krace od tri karaktera";
        }
        if (strlen($username) < 3) {
            $greska[] = "Tvoj username ne moze biti kraci od tri karaktera";
        }
        if (strlen($username) > 20) {
            $greska[] = "Tvoje ime ne moze biti krace od tri karaktera";
        }
        if (email_exists($email)) {
            $greska[] = "Email je vec koriscen";
        }
        if (user_exists($username)) {
            $greska = "Username je vec koriscen";
        }
        if (strlen($password) < 8) {
            $greska[] = "Sifra mora imati vise od 8 karaktera";
        }
        if ($password != $confirm_password) {
            $greska[] = "Sifre nisu iste!";
        }
        if (!empty($greska)) {
            foreach ($greska as $error) {
                echo '<div class="alert">' . $error . '</div>';
            }
        } else {
            creiranje_korisnika($first_name,$last_name,$username,$email,$password);
        }
    }
}

function creiranje_korisnika($first_name,$last_name,$username,$email,$password){
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $first_name = escape($_POST['first_name']);
        $last_name = escape($_POST['last_name']);
        $username = escape($_POST['username']);
        $email = escape($_POST['email']);
        $password = escape($_POST['password']);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(first_name,last_name,username,profile_image,email,password) ";
        $sql .= "VALUES('$first_name','$last_name','$username','uploads/default.jpg','$email','$password')";
        confirm(query($sql));
    
        set_message("Uspesno ste se registrovali, molimo ulogujte se");
        
        redirect("login.php");
    }
}

function validacija_login()
{
    $greska = [];
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = ($_POST['email']);
        $password = ($_POST['password']);

        if (empty($email)) {
            $greska[] = "Polje za email ne moze biti prazno";
        }
        if (empty($password)) {
            $greska[] = "Polje za sifru ne moze biti prazno";
        }
        if (empty($greska)) {
            if (user_login($email, $password)) {
                redirect('index.php');
            } else {
                $greska[] = "Vasa sifra ili email nisu tacni, probajte opet!";
            }
        }
        if (!empty($greska)) {
            foreach ($greska as $error) {
                echo '<div class="alert">' . $error . '</div>';
            }
        }
    }

}

function user_login($email, $password)
{
    $password = filter_var($password, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = query($query);

    if ($result->num_rows == 1) {
        $data = $result->fetch_assoc();//ova funkcija na uzima red iz baze i pretvara ga u asocijativni niz

        if (password_verify($password, $data['password'])) {
            $_SESSION['email'] = $email;
            return true;
        } else {return false;}
    } else {return false;}
}


//funkcija za dodavanje korisnika na index stanicu "Welcome user"
function get_user($id = NULL)
{
    if ($id != NULL) {
        $query = "SELECT * FROM users WHERE id=" . $id;
        $result = query($query);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return "Korisnik nije pronadjen";
        }
    } else {
        $query = "SELECT * FROM users WHERE email='" . $_SESSION['email'] . "'";
        $result = query($query);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return "Korisnik nije pronadjen";
        }
    }
}
function creiranje_posta(){
    $greska =  [];
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $post = $_POST['post'];

        if(strlen($post)>200){
            $greska = "Vas post je veci od 200 karaktera!";
        }

        if(strlen($post)==0){
            $greska = "Polje mora biti popunjeno!";
        }

        if(!empty($greska)){
            echo '<div class="greska">'.$greska.'</div>';
        }else{
            $user = get_user();
            $user_id= $user['id'];

            $sql = "INSERT INTO posts(user_id,content,likes)";
            $sql .= "VALUES($user_id,'$post',0)";
            
            confirm(query($sql));
            set_message('Dodali ste novi post!');
            redirect("index.php");
       }
    }
}


function sortiranje_posta()
{
    $query = "SELECT * FROM posts ORDER BY created_time DESC";
    $result = query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user = get_user($row['user_id']);

            echo "<div class='post'><p><img src='" . $user['profile_image'] . "' alt=''><i><b>" . $user['first_name'] . " " . $user['last_name'] . "</b></i>
                    ". "     " . "<button onclick='delete_post(this)' class='btn btn-danger' data-post-id='". $row['id'] ."'><i class='fas fa-trash-alt'>Obrisi post</i></button></li></p>
                    <p>" . $row['content'] . "</p>
                    <p><i>Date: <b>" . $row['created_time'] . "</b></i></p><br>

                    <div class='likes'>
                    <a style='cursor: pointer;' onclick='who_like(this)' data-post-id='". $row['id'] ."' data-toggle='modal' data-target='#likes' >Likes</a> <b id='likes_".$row['id']."'>" . $row['likes'] . "</b>

                    <button onclick='post_comments(this)' data-post-id=". $row['id'] . " data-toggle='modal' data-target='#comments' style='float: right;' class='btn btn-info' >Comments</button>

                    </div>  
                </div>";

        $id_post = $row['id'];
        $user = get_user();
        $myname2 = $user['first_name'];
        $sql2 = "SELECT * FROM likes WHERE name = '$myname2' AND post_id = '$id_post'";
        $result2 = query($sql2);
        confirm(query($sql2));
            if($result2->num_rows > 0){
                
                    echo "<div class='lajkovanje'><button id='unlike{$row['id']}' onclick='unlike_post(this)'  data-post-id='{$row['id']}'  class='btn btn-primary' >Unlike</button><br></div>";
                    echo "<div class='lajkovanje'><button style='display:none;' id='like{$row['id']}' onclick='like_post(this)'  data-post-id='{$row['id']}'  class='btn btn-primary' >Like</button><br></div>";
            
            }else{
                
                echo "<div class='lajkovanje'> <button id='like{$row['id']}' onclick='like_post(this)'  data-post-id='{$row['id']}'  class='btn btn-primary' >Like</button><br></div>";
                echo "<div class='lajkovanje'> <button style='display:none;' id='unlike{$row['id']}' onclick='unlike_post(this)'  data-post-id='{$row['id']}'  class='btn btn-primary' >Unlike</button><br> </div>";
                
            }
        }
    }
}

function profilna_slika()
{
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $target_dir = "uploads/";
        $user = get_user();
        $user_id = $user['id'];
        $target_file = $target_dir . $user_id . "." .pathinfo(basename($_FILES["profile_image_file"]["name"]), PATHINFO_EXTENSION);;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $error = "";

        $check = getimagesize($_FILES["profile_image_file"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $greska = "File nije slika.";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $greska = "Zao nam je ali format koji podrzavamo je samo JPG, JPEG, PNG i GIF";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            set_message('Greska pri uploudovanju fajla: '. $greska);
        } else {
            $sql = "UPDATE users SET profile_image='$target_file' WHERE id=$user_id";
            confirm(query($sql));
            set_message('Profilna slika je uploudovana!');

            if (!move_uploaded_file($_FILES["profile_image_file"]["tmp_name"], $target_file)) {//remesta iz trenute memorije u bazu
                set_message('Greska pri ploudovanju fajla: '. $greska);
            }
        }
        redirect('profile.php');
    }
}

