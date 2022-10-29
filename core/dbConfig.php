<?php
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