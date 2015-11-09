<?php
// including the db_connect file for database helper functions
include 'db_connect.php';
// opening the connection to the mysql database
$mysql_link = connect('root', '', 'lab_db');

$id = $_GET['id'];
$users = $mysql_link->query( "
  SELECT
    product.name,
    sale.created_at,
    sale_product.price,
    sale_product.quantity
  FROM
    sale
  INNER JOIN
    sale_product
  ON
    sale.id = sale_product.sale_id
  INNER JOIN
    product
  ON
    product.id = sale_product.product_id
  WHERE
    sale.created_at = '".$id."' "
  );
if($mysql_link->error) throw new \Exception($mysql_link->error);

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Sale Details</title>
  </head>
  <body>
    <a href="/">Manage Products</a> | 
    <a href="new-sale.php">Create Sale</a> |
    <a href="sales.php">View Sales</a>
  
    <h1>Sale Created At <?=$_GET['id']?> </h1>

    <table>
      <tr>
        <th style="padding-right: 15px;">Name:</th>
        <th style="padding-right: 15px;">Quantity:</th>
        <th style="padding-right: 15px;">Price:</th>
        <th style="padding-right: 15px;">Total:</th>
      </tr>
      <?php foreach ($users as $user) { 
        if($user['quantity']*$user['price'] != '0') {
        ?>
      <tr>
        <td style="padding-left: 15px;"><?=$user['name']?></td>
        <td><?=$user['quantity']?></td>
        <td>$<?=$user['price']?></td>
        <td>$<?=$user['quantity']*$user['price']?></td>
      </tr>
      <?php } }?>
      <tr>
        <th style="padding-top: 50px;">Grand Total:</th>
        <td></td>
        <td></td>
        <td style="padding-top: 50px;">$<?=$_GET['total']?> </td>
      </tr>
    </table>
  </body>
</html>

