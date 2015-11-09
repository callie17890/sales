<?php
// including the db_connect file for database helper functions
include 'db_connect.php';

// opening the connection to the mysql database
$mysql_link = connect('root', '', 'lab_db');

$users = $mysql_link->query( "
  SELECT
    sale.created_at,
    sale_product.price,
    sale_product.quantity
  FROM
    sale
  INNER JOIN
    sale_product
  ON
    sale.id = sale_product.sale_id
    ORDER BY sale.created_at DESC
  ");

$results = array();
$current_date = 0;
$length = 0;
foreach ($users as $user) {
  
  if ($current_date == $user['created_at']) {
    $results[$length-1]['price'] += $user['price'] * $user['quantity'];
  }
  else {
    $current_date = $user['created_at'];
    $results[$length] = array('date'=>null, 'price'=>null);
    $results[$length]['date'] = $current_date;
    $results[$length]['price'] = $user['price'] * $user['quantity'];
    $length++;
  }
}

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
    <a href="index.php">
      Manage Products</a>
    |
    <a href="new-sale.php">Create Sale</a>
    <h1>Sales Listing Page</h1>
    	<table>
    		<tr>
          <th style="padding-right: 80px;">Created At:</th>
          <th style="padding-right: 30px;">Total Price:</th>
        </tr>
        
        <?php foreach($results as $result){ ?>
        <tr>
          <td><a href="sale-details.php?id=<?php echo $result['date'];?>&total=<?php echo $result['price'];?>"> <?=$result['date']?> </td></a>
          <td> $<?=$result['price']?> </td>
          <?php } ?>
        </tr>
    	</table>

  </body>
</html>