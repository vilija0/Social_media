<?php
include('inc/header.php');

?>

    <div>
        <?php display_message(); ?>
    </div>

<?php

$user = get_user();
echo "<img class='profile-image' src='" . $user['profile_image'] . "'>";

profilna_slika();

?>

    <form method="POST" enctype="multipart/form-data">
        Odaberite zeljenu sliku:
        <input type="file" name="profile_image_file">
        <input type="submit" value="Upload Image" name="submit">
    </form>

<?php
include('inc/footer.php');
?>