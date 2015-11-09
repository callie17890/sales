<?php

// including the db_connect file for database helper functions
include 'db_connect.php';

// opening the connection to the mysql database
$mysql_link = connect('root', '', 'lab_db');

$users = $mysql_link->query( "
  SELECT
    id,
    name,
    price
  FROM product
  WHERE active = 1
  ");

$deactivate = $mysql_link->query( "
  SELECT
    id,
    name,
    price
  FROM product
  WHERE active = 0
  ");

if($mysql_link->error) throw new \Exception($mysql_link->error);
?>

<!DOCTYPE>
<html>
  <head>
    <title>Project 2</title>
  </head>
  <body>
    <?php foreach($users as $user){ ?>
    <a href="new-sale.php">
      <?php } ?>
      Create Sale</a>
    |
    <a href="sales.php">View Sales</a>
    <h1>Product Listing Page</h1>

    <table>
      <tr>
        <th style="padding-right: 80px;">Name</th>
        <th style="padding-right: 60px;">Unit Price</th>
        <th></th>
      </tr>
      <?php foreach($users as $user){ ?>
      <tr>
        <td><?=$user['name']?></td>
        <td>$<?=$user['price']?></td>
        <td><a href="edit-product.php?id=<?=$user['id']?>">edit</a>
        |
        <a href="remove-product.php?id=<?=$user['id']?>">remove</a></td>
      </tr>
      <?php } ?>
    </table>
    <br>
    <a href="new-product.php">[+] Create New Product</a>

    <h2 style="margin-top: 100px;">Inactive Products</h2>
    <table>
      <tr>
        <th style="padding-right: 80px;">Name</th>
        <th style="padding-right: 60px;">Unit Price</th>
        <th></th>
      </tr>
      <?php foreach($deactivate as $user){ ?>
      <tr>
        <td><?=$user['name']?></td>
        <td>$<?=$user['price']?></td>
        <td><a href="reactivate.php?id=<?=$user['id']?>">activate</a></td>
      </tr>
      <?php } ?>
    </table>
  </body>
</html>
