<?php
include('inc/header.php');
?>

<?php if (isset($_SESSION['email'])): ?>
    <?php creiranje_posta(); ?>
    
    <br>

    <form method="POST">
        <h3>Create new post</h3>
        <textarea name="post" cols="35" rows="10" placeholder="Post content..." style="height: 78px;"></textarea>
        <input type="submit" value="Post" name="submit" class="btn btn-info">
    </form>
    <div class="modal fade" id="comments">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Komentari</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
     
        <div id="post_comments222"></div>
        <br>
        <br>
      <center>
      <input type="text" placeholder="Comments" id="comments33"> <button class="btn btn-primary" onclick="comments()" >Post</button>
      </center>
      </div>
    </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="likes">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">LIKES</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

        <dov id="who"></dov>
    
      </div>

      

    </div>
  </div>
</div>

    <div>
        <?php display_message(); ?>
    </div>

    <hr>

    <div class="posts">
        <?php sortiranje_posta(); ?>
    </div>

    <script src="js/scripts.js"></script>
    <script src="js/scriptcom.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php else: ?>

    <div class="homepage">

        <h1>Dobrodosli na Drustvenu mrezu PVA</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci at cupiditate deserunt ducimus fugit impedit in iusto quae sint vitae. Aliquid aspernatur consectetur fuga impedit mollitia necessitatibus nihil non recusandae?</p>

        <h2>Pritisni <a href="register.php">ovde</a> da nam se pridruzis! </h2>

        <img src="css/img/social.jpg" alt="">

    </div>

<?php endif; ?>

<?php include('inc/footer.php'); ?>