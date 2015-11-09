<?php
if (isset($_POST['submit'])) {
// including the db_connect file for database helper functions
include 'db_connect.php';

// opening the connection to the mysql database
$mysql_link = connect('root', '', 'lab_db');

$UUID = get_uuid($mysql_link);

$name = $mysql_link->real_escape_string($_POST['name']);
$price = $mysql_link->real_escape_string($_POST['price']);
$created_at = date("Y-m-d H:i:s");

$users = $mysql_link->query("
  INSERT INTO product (
    id,
    name,
    price,
    created_at,
    active
  ) VALUES (
    '$UUID',
    '$name',
    '$price',
    '$created_at',
    1
  )
");

if($mysql_link->error) throw new \Exception($mysql_link->error);
header('Location: index.php');
}

?>

<!DOCTYPE>
<html>
  <head>
    <title>
      Project 2
    </title>
  </head>
  <body>
    <h1>Create New Product</h1>
    <form method="POST" action="new-product.php">
    	<h2>New Product</h2>
    	<table>
    		<tr>
    			<td>Name:</td>
    			<td><input type="text" name="name" autofocus /></td>
    		</tr>
    		<tr>
    			<td>Price:</td>
    			<td><input type="currency" name="price" /></td>
    		</tr>
    		<tr>
    			<td><button name='submit' type="submit">Submit</button></td>
    		</tr>
    	</table>

  </body>
</html>