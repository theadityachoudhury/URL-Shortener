<?php require_once('../config.php');

// Database configuration
$dbHost     = QB_DB_HOST;
$dbUsername = QB_DB_USER;
$dbPassword = QB_DB_PASSWORD;
$dbName     = QB_DB_NAME;

// Create database connection
try{
    $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
}catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>QuixelURL - Installation</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../assets/css/bulma.min.css">
        <link rel="stylesheet" href="../assets/css/main.css">
        <link rel="stylesheet" href="install.css">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
<section class="hero is-dark has-text-centered">
<div class="hero-body">

    <h1 class="title is-1">QuixelURL</h1>
    <h1 class="title is-5">Installation</h1>
<?php if(empty($_GET['step'])){
    header('Location:install.php?step=1');
}
?>
    <ul class="steps has-content-centered">
        <li class="steps-segment <?php if($_GET['step'] == "1"){ echo 'is-active'; } ?>">
          <span class="steps-marker"></span>
          <div class="steps-content">
            <p class="is-size-4">Step 1</p>
            <p>Database connection informations</p>
          </div>
        </li>
        <li class="steps-segment <?php if($_GET['step'] == "2"){ echo 'is-active'; } ?>">
          <span class="steps-marker"></span>
          <div class="steps-content">
            <p class="is-size-4">Step 2</p>
            <p>Creating Table in your database</p>
          </div>
        </li>
        <li class="steps-segment <?php if($_GET['step'] == "3"){ echo 'is-active'; } ?>">
          <span class="steps-marker"></span>
          <div class="steps-content">
            <p class="is-size-4">Step 3</p>
            <p>Base Information of your website</p>
          </div>
        </li>
        <li class="steps-segment <?php if($_GET['step'] == "4"){ echo 'is-active'; } ?>">
          <span class="steps-marker"></span>
          <div class="steps-content">
            <p class="is-size-4">Step 4</p>
            <p>Create Administrator user</p>
          </div>
        </li>
        <li class="steps-segment <?php if($_GET['step'] == "5"){ echo 'is-active'; } ?>">
          <span class="steps-marker"></span>
          <div class="steps-content">
            <p class="is-size-4">Step 5</p>
            <p>End of Installation</p>
          </div>
        </li>
      </ul>
</div>
</section>

<section class="hero is-success">
<div class="hero-body">
<?php if($_GET['step'] == "1"){ ?>
     <!-- STEP 1: Database connection informations -->
    <h1 class="title is-4">STEP 1 : Database connection informations</h1>

    <div class="container">
    <?php 
if(isset($_POST['step1submit'])){
    header('Location:?step=2');
}
?>
    <form method="post" action="">
        <h1 class="title is-3">Edit config.php file with your database information and press "Next Step"</h1>
        <div class="field is-grouped">
        <div class="control">
            <input type="submit" name="step1submit" class="button is-link" value="Next Step">
        </div>
        <div class="control">
            <button class="button is-link is-light is-disabled">Cancel</button>
        </div>
        </div>

    </form>
    </div>

<?php } ?>

<?php if($_GET['step'] == "2"){ 
    if(empty(QB_DB_HOST) || empty(QB_DB_NAME) || empty(QB_DB_USER)){
        header('Location:?step=1');
    }
    $db->exec(file_get_contents('install.sql'));

    ?>
     <!-- STEP 2: Creating Table in your databases -->
    <h1 class="title is-4">STEP 2: Creating Table in your database</h1>

    <div class="container">
        <h1 class="title is-3">Table Created, you can go to next step</h1>
    <a href="?step=3"class="button is-link">Next Step</a>
    </div>

<?php } ?>

<?php if($_GET['step'] == "3"){ 
    if(empty(QB_DB_HOST) || empty(QB_DB_NAME) || empty(QB_DB_USER)){
        header('Location:?step=1');
    }
    ?>
    
     <!-- STEP 3: Base Information of your website -->
    <h1 class="title is-4">STEP 3 : Base Information of your website</h1>

    <div class="container">
<?php 
/* Verification if Configuration already exist */
$vquery = "SELECT * FROM short_config";
$vstmt = $db->prepare($vquery);
$vstmt->execute();
$exist = $vstmt->fetch();
if(!empty($exist['webtitle'])){
    header('Location:?step=4');
}else{
    if(isset($_POST['step3submit'])){
        $query = "INSERT INTO short_config (id, webtitle, webdesc, weburl, webshort) VALUES (NULL, :webtitle, :webdesc, :weburl, :webshort)";
        $stmt = $db->prepare($query);
        $params = array(
            "webtitle" => $_POST['sitename'],
            "webdesc" => $_POST['sitedesc'],
            "weburl" => $_POST['siteurl'],
            "webshort" => $_POST['shortsiteurl']
        );
        $stmt->execute($params);
        if($stmt){
            header('Location:?step=4');
        }else{
            header('Location:?step=3');
        }
    }

}
?>

    <form method="post" action="">
    <div class="field">
            <label class="label">Site URL</label>
            <div class="control">
                <input class="input" type="text" name="siteurl" placeholder="Site URL" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Short Site URL</label>
            <div class="control">
                <input class="input" type="text" name="shortsiteurl" placeholder="Short Site URL" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Name of your website</label>
            <div class="control">
                <input class="input" type="text" name="sitename" placeholder="Name of your website" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Description of your website</label>
            <div class="control">
                <input class="input" type="text" name="sitedesc" placeholder="Description of your website" required>
            </div>
        </div>
        <div class="field is-grouped">
        <div class="control">
            <input type="submit" name="step3submit" class="button is-link" value="Next Step">
        </div>
        <div class="control">
            <button class="button is-link is-light is-disabled">Cancel</button>
        </div>
        </div>

    </form>
    </div>

<?php } ?>

<?php if($_GET['step'] == "4"){ 
    if(empty(QB_DB_HOST) || empty(QB_DB_NAME) || empty(QB_DB_USER)){
        header('Location:?step=1');
    }
    ?>
     <!-- STEP 4: Create Administrator user -->
    <h1 class="title is-4">STEP 4 : Create Administrator user</h1>

    <div class="container">
    <?php 
/* Verification if Configuration already exist */
$vquery = "SELECT * FROM short_users WHERE rank = 'admin'";
$vstmt = $db->prepare($vquery);
$vstmt->execute();
$exist = $vstmt->fetch();
if(!empty($exist['rank'])){
    header('Location:?step=5');
}else{
    if(isset($_POST['step4submit'])){ 
        $query = "INSERT INTO short_users (id, email, name, password, rank) VALUES (NULL, :email, :name, :password, 'admin')";
        $stmt = $db->prepare($query);
        $params = array(
            "email" => $_POST['usermail'],
            "name" => $_POST['username'],
            "password" => sha1($_POST['userpassword'])
        );
        $stmt->execute($params);
        if($stmt){
            header('Location:?step=5');
        }else{
            header('Location:?step=4');
        }
    }
}
?>
    <form method="post" action="">
    <div class="field">
            <label class="label">E-mail</label>
            <div class="control">
                <input class="input" type="text" name="usermail" placeholder="E-mail" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Username</label>
            <div class="control">
                <input class="input" type="text" name="username" placeholder="Username" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Password (Password will be encrypted)</label>
            <div class="control">
                <input class="input" type="password" name="userpassword" placeholder="Password" required>
            </div>
        </div>
        <div class="field is-grouped">
        <div class="control">
            <input type="submit" name="step4submit" class="button is-link" value="Next Step">
        </div>
        <div class="control">
            <button class="button is-link is-light is-disabled">Cancel</button>
        </div>
        </div>

    </form>
    </div>

<?php } ?>


<?php if($_GET['step'] == "5"){
    if(empty(QB_DB_HOST) || empty(QB_DB_NAME) || empty(QB_DB_USER)){
        header('Location:?step=1');
    }
    ?>
     <!-- STEP 5: End of Installation -->
    <h1 class="title is-4">STEP 5: End of Installation</h1>

    <div class="container">
        <h1 class="title is-3">Success !</h1>
        <h4 class="title is-4">QuixelURL are installed ! You can delete the /install/ folder in your website and login in your account !</h4>
    </div>

<?php } ?>

</div>
</section>


    </body>
</html>