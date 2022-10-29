<?php 
require_once('config.php'); 
require_once('core/dbConfig.php');
require_once('core/short.class.php');
require_once('core/core.php');
session_start();

$core = new Core($db);

$DeclareDefine = $core->DeclareConfigDefine();

if(empty($DeclareDefine)){
    header('Location:install/install.php?step=1');
}

define('QB_WEBTITLE', $DeclareDefine['webtitle']);
define('QB_WEBDESC', $DeclareDefine['webdesc']);
define('QB_SITEURI', $DeclareDefine['weburl']);
define('QB_SHORTURL', $DeclareDefine['webshort']);

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= QB_WEBTITLE; ?> &mdash; <?= QB_WEBDESC; ?></title>
        <meta name="description" content="Made with QuixelURL">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?= QB_SITEURI; ?>assets/css/bulma.css">
        <link rel="stylesheet" href="<?= QB_SITEURI; ?>assets/css/main.css">
        <link rel="stylesheet" href="<?= QB_SITEURI; ?>assets/css/all.css">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="container">
    <nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="container">
        <div class="navbar-brand">
            <a class="navbar-item" href="#">
            <?= QB_WEBTITLE; ?>
            </a>

            <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
            <a href="index.php" class="navbar-item">
                Home
            </a>

            <a href="index.php#shorturl" class="navbar-item">
                Short URL
            </a>

            </div>

            <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                <a href="account.php" class="button is-primary">
                    <strong>My Account</strong>
                </a>
                </div>
            </div>
            </div>
        </div>
    </div>
    </nav>
