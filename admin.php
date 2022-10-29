<?php include('includes/header.php'); 
if(!isset($_SESSION['name'])){
    header('Location:login.php');
}
if(!$core->CheckUserIsAdmin($_SESSION['email'])){
    header('Location:account.php');
}
?>

<section class="hero is-success is-bold has-text-centered">
<div class="hero-body">
    <h1 class="title is-3">Admin Panel</h1>
</div>
</section>
<section class="hero is-white">
    <div class="hero-body">
    <nav class="level">
  <!-- Left side -->
  <div class="level-left">
  </div>

  <!-- Right side -->
  <div class="level-right">
  <p class="level-item"><a href="index.php#shorturl" class="modal-button button is-success">New Short Link</a></p>
  <?php if($core->CheckUserIsAdmin($_SESSION['email'])){
    ?>
<p class="level-item"><a href="admin.php" class="modal-button button is-info">Admin Panel</a></p>
    <?php 
  } ?>
  <p class="level-item"><a href="logout.php" class="button is-danger">Log Out</a></p>
  </div>
</nav>
<?php 
if(!empty($_GET['remove'])){
    if($core->RemoveLinkById($_GET['remove'])){
?>
<div class="notification is-danger">
  <button class="delete"></button>
  Link with ID <strong><?= $_GET['remove']; ?></strong> has been deleted<br>
  This page will be refreshed in 5 seconds...
</div>
<?php
header("Refresh:5; url=admin.php");
    }else{
    ?>
<div class="notification is-danger">
  <button class="delete"></button>
  An error occured while trying to delete Link with ID <strong><?= $_GET['remove']; ?></strong><br>
  This page will be refreshed in 5 seconds...
</div>
    <?php
    header("Refresh:5; url=admin.php");
    }
}
?>
<section class="hero is-stats">
    <div class="hero-body">
        <nav class="level is-mobile">
        <div class="level-item has-text-centered">
            <div>
            <p class="heading">Shorted Link</p>
            <p class="title"><?= $core->GetNbLinkOfAllUsers(); ?></p>
            </div>
        </div>
        <div class="level-item has-text-centered">
            <div>
            <p class="heading">Users Registered</p>
            <p class="title"><?= $core->GetAllUsers(); ?></p>
            </div>
        </div>
        <div class="level-item has-text-centered">
            <div>
            <p class="heading">Redirection</p>
            <p class="title"><?= $core->GetAllHits(); ?></p>
            </div>
        </div>
        </nav>
    </div>
</section>
<br>
<table class="table">
  <thead>
    <tr>
    <th>ID</th>
    <th>Original Link</th>
    <th>Short Code</th>
    <th>Hits</th>
    <th>Author</th>
    <th>Date</th>
    <th>Actions</th>
    </tr>
  </thead>
  <tbody>
  <?= $core->GetLinkFromAllUsers(); ?>
</tbody>
</table>

    </div>
</section>


<?php include('includes/footer.php'); ?>