<?php
// including the db_connect file for database helper functions
include 'db_connect.php';

// opening the connection to the mysql database
$mysql_link = connect('root', '', 'lab_db');

if (isset($_POST['submit'])) {

//generates a new UUID and set it to a variable
$UUID = get_uuid($mysql_link);

$created_at = date("Y-m-d H:i:s");

$count=0;

$mysql_link->query("
  INSERT INTO sale (
    id,
    created_at
  ) VALUES (
    '$UUID',
    '$created_at'
  )
");


for($i=0; $i<count($_POST['quantity']); $i++) {
$product_id = $mysql_link->real_escape_string($_POST['id'][$i]);
$price = $mysql_link->real_escape_string($_POST['price'][$i]);
$quantity = $mysql_link->real_escape_string($_POST['quantity'][$i]);

$mysql_link->query("
  INSERT INTO sale_product (
    sale_id,
    product_id,
    price,
    quantity
  ) VALUES (
    '$UUID',
    '$product_id',
    '$price',
    '$quantity'
  )
");

}

if($mysql_link->error) throw new \Exception($mysql_link->error);
header('Location: sales.php');
}

$users = $mysql_link->query( "
  SELECT
    id,
    name,
    price
  FROM product
  WHERE active = 1
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
    <h1>Create Order</h1>
    <form method="POST" action="new-sale.php">
    	<table>
    		<tr>
          <th style="padding-right: 80px;">Name:</th>
          <th style="padding-right: 30px;">Unit Price:</th>
          <th>Quantity:</th>
        </tr>
        <?php foreach($users as $user){ ?>
        <tr>
          <td><?=$user['name']?></td>
          <td><?=$user['price']?></td>
          <td><input type="currency" name="quantity[<?=$count?>]" /></td>
          <td><input type="hidden" name="price[<?=$count?>]" value="<?=$user['price']?>"></td>
          <td><input type="hidden" name="id[<?=$count?>]" value="<?=$user['id']?>"></td>
          <?php $count++;} ?>
        </tr>
        <tr>
    			<td><a style="padding-right: 10px;" href="/">Cancel</a><button name='submit' value="Submit" type="submit">Submit</button></td>
    		</tr>
    	</table>
    </form>

  </body>
</html>