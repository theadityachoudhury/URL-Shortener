<?php include('includes/header.php'); 
if(!isset($_SESSION['name'])){
    header('Location:login.php');
}
?>

<section class="hero is-success is-bold has-text-centered">
<div class="hero-body">
    <h1 class="title is-3">My Account</h1>
</div>
</section>
<section class="hero is-white">
    <div class="hero-body">
    <nav class="level">
  <!-- Left side -->
  <div class="level-left">
    <div class="level-item">
      <p class="subtitle is-5">
        <strong><?= $core->GetNbLinkOfUsers($_SESSION['name']); ?></strong> Shorted Link
      </p>
    </div>

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


<table class="table">
  <thead>
    <tr>
    <th>ID</th>
    <th>Original Link</th>
    <th>Short Code</th>
    <th>Hits</th>
    <th>Date</th>
    </tr>
  </thead>
  <tbody>
  <?= $core->GetLinkFromUsers($_SESSION['name']); ?>
</tbody>
</table>

    </div>
</section>


<?php include('includes/footer.php'); ?>