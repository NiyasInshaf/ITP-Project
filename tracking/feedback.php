<?php require_once('../Connections/dbconnect2.php'); ?>
<?php

if ((isset($_GET['delete'])) && ($_GET['delete'] != "")) {
  $deleteSQL = "DELETE FROM feedback WHERE seno=".$_GET['delete'];
  $Result1 = mysql_query($deleteSQL, $dbconnect) or die(mysql_error());

  $deleteGoTo = "feedback.php";
  header(sprintf("Location: %s", $deleteGoTo));
}

$query_read_feedbacks = "SELECT * FROM feedback ORDER BY seno DESC";
$read_feedbacks = mysql_query($query_read_feedbacks, $dbconnect) or die(mysql_error());
$row_read_feedbacks = mysql_fetch_assoc($read_feedbacks);
$totalRows_read_feedbacks = mysql_num_rows($read_feedbacks);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Untitled Document</title>
<link href="../css/bootstrap-4.3.1.css" rel="stylesheet" type="text/css">
</head>

<body style="padding-top: 70px">
<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light"> <a class="navbar-brand" href="#">Admin Panel</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent1">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active"> <a class="nav-link" href="index.php">Tracking Management</a> </li>      
      <li class="nav-item active"> <a class="nav-link" href="feedback.php">Read Feedback</a> </li>  
    </ul>
	  
	  <div class="btn btn-warning">Hi <?php echo $admin_name; ?>! (<a href="<?php echo $logoutAction ?>">Logout</a>)</div>  
  </div>
</nav>
	
<div class="container">
	
<div class="row">

	<div class="col-md-12">
	
<h4 class="alert-heading mt-4">Read Feedbacks</h4>			
		
		
<table width="100%" border="0" class="table-bordered table-striped">
  <tbody>
    <tr>
      <th width="30" bgcolor="#CCC" scope="col">#</th>
      <th bgcolor="#CCC" scope="col">Customer</th>
      <th bgcolor="#CCC" scope="col">Order ID</th>
      <th bgcolor="#CCC" scope="col">Order Item</th>
      <th bgcolor="#CCC" scope="col">Description</th>
      <th bgcolor="#CCC" scope="col">Rating</th>
      <th bgcolor="#CCC" scope="col">Reaction</th>
      <th bgcolor="#CCC" scope="col">&nbsp;</th>
    </tr>
	  <?php $i=1; ?>
	  <?php do{ ?>
<?php
$productID = $row_get_order_contents['stock_id'];
	
$orderID = $row_read_feedbacks['order_id'];
	
$query_get_order_details = "SELECT * FROM carts WHERE seno = '$orderID'";
$get_order_details = mysql_query($query_get_order_details, $dbconnect) or die(mysql_error());
$row_get_order_details = mysql_fetch_assoc($get_order_details);
$totalRows_get_order_details = mysql_num_rows($get_order_details);
	
$customerID = $row_get_order_details['customer_id'];
	
$query_get_customer_details = "SELECT * FROM customers WHERE seno = '$customerID'";
$get_customer_details = mysql_query($query_get_customer_details, $dbconnect) or die(mysql_error());
$row_get_customer_details = mysql_fetch_assoc($get_customer_details);
$totalRows_get_customer_details = mysql_num_rows($get_customer_details);
	
$orderItemID = $row_read_feedbacks['order_item_id'];
	
$query_get_stock_data = "SELECT * FROM stock WHERE seno = '$orderItemID'";
$get_stock_data = mysql_query($query_get_stock_data, $dbconnect) or die(mysql_error());
$row_get_stock_data = mysql_fetch_assoc($get_stock_data);
$totalRows_get_stock_data = mysql_num_rows($get_stock_data);	
?>
    <tr>
      <td width="30" align="center"><?php echo $i; ?></td>
      <td><?php echo $row_get_customer_details['name']; ?></td>
      <td><?php echo $orderID; ?></td>
      <td><?php echo $row_get_stock_data['name']; ?></td>
      <td><?php echo $row_read_feedbacks['description']; ?></td>
      <td><?php echo $row_read_feedbacks['rating']; ?></td>
      <td><?php echo $row_read_feedbacks['reaction']; ?></td>
      <td><a href="feedback.php?delete=<?php echo $row_read_feedbacks['seno']; ?>" onClick="return confirm('Are you sure to delete this?')">Delete</a></td>
    </tr>
	  <?php $i++; ?>
	  <?php } while ($row_read_feedbacks = mysql_fetch_assoc($read_feedbacks)); ?>
  </tbody>
</table>
    </div>
	</div>
	</div>
	
	
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap-4.3.1.js"></script>
</body>
</html>