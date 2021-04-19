<?php require_once('Connections/dbconnect.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_dbconnect, $dbconnect);
$query_list_orders = "SELECT * FROM carts WHERE customer_id = '$cusID' ORDER BY `date` DESC";
$list_orders = mysql_query($query_list_orders, $dbconnect) or die(mysql_error());
$row_list_orders = mysql_fetch_assoc($list_orders);
$totalRows_list_orders = mysql_num_rows($list_orders);

?>
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

		
<h4 class="alert-heading mt-4">Orders</h4>		
		

<?php do { ?>
<?php
$orderID = $row_list_orders['seno'];
	
$query_order_contents = "SELECT COUNT(seno), SUM(quantity) FROM carts_items WHERE cart_id = '$orderID'";
$order_contents = mysql_query($query_order_contents, $dbconnect) or die(mysql_error());
$row_order_contents = mysql_fetch_assoc($order_contents);
$totalRows_order_contents = mysql_num_rows($order_contents);
?>
  <table width="100%" border="0" class="table-bordered table-striped">
    <tbody>
      <tr>
        <td width="150" bgcolor="#CCC"><strong>Order ID:</strong></td>
        <td><?php echo $row_list_orders['seno']; ?></td>
        </tr>
      <tr>
        <td width="150" bgcolor="#CCC"><strong>Order Date:</strong></td>
        <td><?php echo $row_list_orders['date']; ?></td>
        </tr>
      <tr>
        <td width="150" bgcolor="#CCC"><strong>Delivery Address:</strong></td>
        <td><?php echo $row_list_orders['delivery_address']; ?></td>
        </tr>
      <tr>
        <td bgcolor="#CCC"><strong>Content:</strong></td>
        <td><?php echo $row_order_contents['COUNT(seno)']; ?> Items / <?php echo $row_order_contents['SUM(quantity)']; ?> Quantity </td>
      </tr>
      <tr>
        <td width="150" bgcolor="#CCC"><strong>Status:</strong></td>
        <td><a href="track.php?orderID=<?php echo $row_list_orders['seno']; ?>">Track Order</a></td>
        </tr>
    </tbody>
  </table><br>

  <?php } while ($row_list_orders = mysql_fetch_assoc($list_orders)); ?>	
	</div>
	
</div>	
</div>	
	
	
	
	
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-4.3.1.js"></script>
</body>
</html>
<?php
mysql_free_result($list_orders);

mysql_free_result($order_contents);

mysql_free_result($get_customer_info);
?>
