<?php
include_once('assets/properties.php');

$hostname     = Database::HOST;
$username     = Database::USER;
$password     = Database::PASS; 
$databasename = Database::NAME; 
// Create connection 
$conn = new mysqli($hostname, $username, $password,$databasename) or die("Unable to connect to database; " . $conn->connect_error);
