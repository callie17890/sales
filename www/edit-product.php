<?php
// including the db_connect file for database helper functions
include 'db_connect.php';
// opening the connection to the mysql database
$mysql_link = connect('root', '', 'lab_db');

if (isset($_POST['submit'])) {

$id = $mysql_link->real_escape_string($_GET['id']);

$name = $mysql_link->real_escape_string($_POST['name']);
$price = $mysql_link->real_escape_string($_POST['price']);
$updated_at=date("Y-m-d H:i:s");

$users = $mysql_link->query("
  UPDATE product
  SET name='$name', price='$price', updated_at='$updated_at'
  WHERE id='$id'
");
if($mysql_link->error) throw new \Exception($mysql_link->error);


header('Location: index.php');
}

$id = $mysql_link->real_escape_string($_GET['id']);

$users = $mysql_link->query( "
  SELECT
    name,
    price
  FROM product
  WHERE id='$id'
  ");
if($mysql_link->error) throw new \Exception($mysql_link->error);

?>

<!DOCTYPE>
<html>
  <head>
    <title>
      Project 2
    </title>
  </head>
  <body>
    <h1>Update Product</h1>
    <form method="POST" action="">
    	<table>
        <?php foreach($users as $user){ ?>
    		<tr>
    			<td>Name:</td>
    			<td><input type="text" name="name" value="<?=$user['name']?>" autofocus/></td>
    		</tr>
    		<tr>
    			<td>Price:</td>
    			<td><input type="currency" name="price" value="<?=$user['price']?>"/></td>
        </tr>
        <tr>
    			<td><a style="padding-right: 10px;" href="/">Cancel</a><button name='submit' type="submit">Submit</button></td>
        </tr>
        <?php } ?>
    	</table>

  </body>
</html>