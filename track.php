<?php require_once('Connections/dbconnect.php'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Untitled Document</title>
<link href="css/bootstrap-4.3.1.css" rel="stylesheet" type="text/css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark"> <a class="navbar-brand" href="#">Tracking &amp; Feedback</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent1">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active"> <a class="nav-link" href="orders.php">View Orders</a> </li>
      <li class="nav-item active"> <a class="nav-link" href="track.php">Track Orders</a> </li>      
      <li class="nav-item active"> <a class="nav-link" href="feedback.php">Post Feedback</a> </li>   
    </ul>
	  
	 <div class="btn btn-warning">Hi <?php echo $customer_name; ?>! (<a href="<?php echo $logoutAction ?>">Logout</a>)</div>   
  </div>
</nav>
	
	
	
<div class="container mt-3">
	
<div class="row">

	<div class="col-md-12">
	
	<table width="100%" border="0" class="table-bordered">
  <tbody>
    <tr>
      <td width="150"><strong>Customer Name:</strong></td>
      <td><?php echo $customer_name; ?></td>
      </tr>
    <tr>
      <td width="150"><strong>Phone:</strong></td>
      <td><?php echo $row_get_customer_info['phone']; ?></td>
      </tr>
    <tr>
      <td width="150"><strong>e-mail:</strong></td>
      <td><?php echo $row_get_customer_info['email']; ?></td>
      </tr>
  </tbody>
</table>

<h4 class="alert-heading mt-4">Order Tracking</h4>
		
		
<?php if(isset($_GET['orderID'])){ ?>	
	
<?php
$orderID = $_GET['orderID'];
	
$query_get_order_details = "SELECT * FROM carts WHERE seno = '$orderID'";
$get_order_details = mysql_query($query_get_order_details, $dbconnect) or die(mysql_error());
$row_get_order_details = mysql_fetch_assoc($get_order_details);
$totalRows_get_order_details = mysql_num_rows($get_order_details);
	
$query_get_order_contents = "SELECT * FROM carts_items WHERE cart_id = '$orderID'";
$get_order_contents = mysql_query($query_get_order_contents, $dbconnect) or die(mysql_error());
$row_get_order_contents = mysql_fetch_assoc($get_order_contents);
$totalRows_get_order_contents = mysql_num_rows($get_order_contents);
	
$query_tracking_info = "SELECT * FROM tracking WHERE order_id = '$orderID' ORDER BY `updated_date` ASC";
$tracking_info = mysql_query($query_tracking_info, $dbconnect) or die(mysql_error());
$row_tracking_info = mysql_fetch_assoc($tracking_info);
$totalRows_tracking_info = mysql_num_rows($tracking_info);	
?>	
		
<div class="mt-3">
<div style="width: 30px; height:30px; background-color: #06054D; display: inline-block; vertical-align: top; font-weight: bolder; color:#CCC; text-align: center; border-radius:100px;">1</div>
<div style="display: inline-block; vertical-align: top;">Order Placed | <small><?php echo $row_get_order_details['date']; ?></small></div>
</div>

<?php $i = 2; ?>
<?php do{ ?>
<div class="mt-3">
<div style="width: 30px; height:30px; background-color: #06054D; display: inline-block; vertical-align: top; font-weight: bolder; color:#CCC; text-align: center; border-radius:100px;"><?php echo $i; ?></div>
<div style="display: inline-block; vertical-align: top;"><?php echo $row_tracking_info['description']; ?> | <small><?php echo $row_tracking_info['updated_date']; ?></small></div>
</div>	
<?php $i++; ?>
<?php } while ($row_tracking_info = mysql_fetch_assoc($tracking_info)); ?>		
		
		
<h6 class="alert-heading mt-4">Order Details</h6>		
		
<table width="100%" border="0" class="table-bordered">
  <tbody>
    <tr>
      <td colspan="5" bgcolor="#DDD"><strong>Order ID: <?php echo $orderID; ?></strong></td>
      </tr>
    <tr>
      <td width="30" align="center" bgcolor="#CCC"><strong>#</strong></td>
      <td align="center" bgcolor="#CCC"><strong>Product</strong></td>
      <td align="center" bgcolor="#CCC"><strong>Quantity</strong></td>
      <td align="center" bgcolor="#CCC"><strong>Rate</strong></td>
      <td align="center" bgcolor="#CCC"><strong>Amount</strong></td>
    </tr>
	  <?php $n=1; $cartTotal = 0; ?>
	  <?php do{ ?>
<?php
$productID = $row_get_order_contents['stock_id'];		
	
$query_get_stock_data = "SELECT * FROM stock WHERE seno = '$productID'";
$get_stock_data = mysql_query($query_get_stock_data, $dbconnect) or die(mysql_error());
$row_get_stock_data = mysql_fetch_assoc($get_stock_data);
$totalRows_get_stock_data = mysql_num_rows($get_stock_data);		   
	
$amount = $row_get_order_contents['quantity'] * $row_get_stock_data['price_selling'];
?>
    <tr>
      <td width="30" align="center"><?php echo $n; ?></td>
      <td align="center"><?php echo $row_get_stock_data['name']; ?></td>
      <td align="center"><?php echo $row_get_order_contents['quantity']; ?></td>
      <td align="center"><?php echo $row_get_stock_data['price_selling']; ?></td>
      <td align="right"><strong><?php echo number_format((float)$amount,2,'.',''); ?></strong></td>
    </tr>
	  <?php $n++; $cartTotal += $amount;  ?>
	  <?php } while ($row_get_order_contents = mysql_fetch_assoc($get_order_contents)); ?>
    <tr>
      <td colspan="4" align="right"><strong>Total</strong></td>
      <td align="right"><strong><?php echo number_format((float)$cartTotal,2,'.',''); ?></strong></td>
    </tr>
  </tbody>
</table>

		
		
<?php } else{ ?>
	
<?php
$query_list_orders = "SELECT * FROM carts WHERE customer_id = '$cusID' ORDER BY `date` DESC";
$list_orders = mysql_query($query_list_orders, $dbconnect) or die(mysql_error());
$row_list_orders = mysql_fetch_assoc($list_orders);
$totalRows_list_orders = mysql_num_rows($list_orders);	
?>
		
<form id="form1" name="form1" method="get">
	Select Order:
      <select name="orderID" id="orderID" class="form-control" style="width:400px;" required>
		  <option></option>
		  <?php do{ ?>
			<?php
			$orderID = $row_list_orders['seno'];

			$query_order_contents = "SELECT COUNT(seno), SUM(quantity) FROM carts_items WHERE cart_id = '$orderID'";
			$order_contents = mysql_query($query_order_contents, $dbconnect) or die(mysql_error());
			$row_order_contents = mysql_fetch_assoc($order_contents);
			$totalRows_order_contents = mysql_num_rows($order_contents);
			?>
		  <option value="<?php echo $row_list_orders['seno']; ?>">ID <?php echo $row_list_orders['seno']; ?> | Date <?php echo $row_list_orders['date']; ?> | <?php echo $row_order_contents['COUNT(seno)']; ?> Items / <?php echo $row_order_contents['SUM(quantity)']; ?> Quantity</option>
		  <?php } while ($row_list_orders = mysql_fetch_assoc($list_orders)); ?>
      </select>
	
	<input type="submit" class="btn btn-success mt-2" value="Track Order">
</form>
<?php } ?>
		
	</div>
	
</div>	
</div>
	
	
	
	
	
	
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-4.3.1.js"></script>
</body>
</html>
<?php
mysql_free_result($get_order_details);
?>
