<?php
// including the db_connect file for database helper functions
include 'db_connect.php';

// opening the connection to the mysql database
$mysql_link = connect('root', '', 'lab_db');

$id = $mysql_link->real_escape_string($_GET['id']);

$users = $mysql_link->query("
  UPDATE product 
  SET active = 1
  WHERE id = '$id'
");

if($mysql_link->error) throw new \Exception($mysql_link->error);

header('location: index.php');
?>