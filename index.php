<?php include('includes/header.php'); ?>

    <section class="hero is-medium is-dark is-bold has-text-centered">
  <div class="hero-body">
    <div class="container">
      <h1 class="title">
      <?= QB_WEBTITLE; ?>
      </h1>
      <h2 class="subtitle">
      <?= QB_WEBDESC; ?>
      </h2>
    </div>
  </div>
</section>
<section class="hero is-white is-bold">
<div class="hero-body">
<nav class="level is-mobile">
  <div class="level-item has-text-centered">
    <div>
      <p class="heading">Link Generated</p>
      <p class="title"><?= $core->GetGeneratedLink(); ?></p>
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

<section class="hero has-text-centered is-success is-bold" id="shorturl">
    <div class="hero-body">
    <h1 class="title is-2 is-spaced">Ready ? Go !</h1>
    <p class="title is-4 is-spaced">Generate your Short URL now !</p>
<?php 
if(isset($_POST['submit'])){

    $shortener = new Shortener($db);

    // Long URL
    $longURL = $_POST['url'];
    
    // Prefix of the short URL 
    $shortURL_Prefix = QB_SHORTURL.'/'; // with URL rewrite
    
    try{
        // Get short code of the URL
        $shortCode = $shortener->urlToShortCode($longURL);
        
        // Create short URL
        $shortURL = $shortURL_Prefix.$shortCode;
        ?>
<div class="notification is-link">
  <button class="delete"></button>
  Original Link: <strong><?= $longURL; ?></strong><br>
  Short URL: <strong><?= $shortURL; ?></strong>
</div>
        <?php
    }catch(Exception $e){
        // Display error
        echo $e->getMessage();
    }

}

?>
        <form method="post" action="">
            <div class="control shorturl">
                <input type="url" name="url" class="input" placeholder="Your Lonnnnnggggg URL">
                <input type="submit" name="submit" class="button is-dark" value="Short !">
            </div>
        </form>
    </div>
</section>


<?php include('includes/footer.php'); ?>