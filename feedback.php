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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
	
$orderID = $_POST['order_id'];
$orderItemID = $_POST['order_item_id'];
	
$query_get_existing_feedbacks = "SELECT * FROM feedback WHERE order_id = '$orderID' AND order_item_id = '$orderItemID'";
$get_existing_feedbacks = mysql_query($query_get_existing_feedbacks, $dbconnect) or die(mysql_error());
$row_get_existing_feedbacks = mysql_fetch_assoc($get_existing_feedbacks);
$totalRows_get_existing_feedbacks = mysql_num_rows($get_existing_feedbacks);
	
if(!empty($row_get_existing_feedbacks['seno'])){	
	$updateSQL = "UPDATE feedback SET order_id='".$_POST['order_id']."', order_item_id='".$_POST['order_item_id']."', stock_id='".$_POST['stock_id']."', `description`='".$_POST['description']."', rating='".$_POST['rating']."', reaction='".$_POST['reaction']."', `date`='".$_POST['date']."'";
  	$Result1 = mysql_query($updateSQL, $dbconnect) or die(mysql_error());
} else{
  	$insertSQL = "INSERT INTO feedback (order_id, order_item_id, stock_id, `description`, rating, reaction, `date`) VALUES ('".$_POST['order_id']."', '".$_POST['order_item_id']."', '".$_POST['stock_id']."', '".$_POST['description']."', '".$_POST['rating']."', '".$_POST['reaction']."', '".$_POST['date']."')";
  	$Result1 = mysql_query($insertSQL, $dbconnect) or die(mysql_error());
}
	
  $insertGoTo = "feedback.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_dbconnect, $dbconnect);
$query_list_orders = "SELECT * FROM carts ORDER BY `date` DESC";
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

	
<h4 class="alert-heading mt-4">Feedback Management</h4>		
		
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
		
	
		
<table width="100%" border="0" class="table-bordered">
  <tbody>
    <tr>
      <td colspan="5" bgcolor="#DDD"><strong>Order ID: <?php echo $orderID; ?></strong></td>
      </tr>
    <tr>
      <td width="30" align="center"><strong>#</strong></td>
      <td align="center"><strong>Product</strong></td>
      <td align="center"><strong>Quantity</strong></td>
      <td align="center"><strong>Rate</strong></td>
      <td align="center"><strong>Amount</strong></td>
    </tr>
	  <?php $n=1; $cartTotal = 0; ?>
	  <?php do{ ?>
<?php
$productID = $row_get_order_contents['stock_id'];
	
$orderID = $row_get_order_contents['cart_id'];
$orderItemID = $row_get_order_contents['seno'];
	
$query_get_stock_data = "SELECT * FROM stock WHERE seno = '$productID'";
$get_stock_data = mysql_query($query_get_stock_data, $dbconnect) or die(mysql_error());
$row_get_stock_data = mysql_fetch_assoc($get_stock_data);
$totalRows_get_stock_data = mysql_num_rows($get_stock_data);
	
$query_get_existing_feedbacks = "SELECT * FROM feedback WHERE order_id = '$orderID' AND order_item_id = '$orderItemID'";
$get_existing_feedbacks = mysql_query($query_get_existing_feedbacks, $dbconnect) or die(mysql_error());
$row_get_existing_feedbacks = mysql_fetch_assoc($get_existing_feedbacks);
$totalRows_get_existing_feedbacks = mysql_num_rows($get_existing_feedbacks);
	

$description = '';
$rating = '';
$reaction = '';
$date = date('Y-m-d');
if(!empty($row_get_existing_feedbacks['seno'])){
	$description = $row_get_existing_feedbacks['description'];
	$rating = $row_get_existing_feedbacks['rating'];
	$reaction = $row_get_existing_feedbacks['reaction'];
	$date = $row_get_existing_feedbacks['date'];
}
	
$amount = $row_get_order_contents['quantity'] * $row_get_stock_data['price_selling'];
?>
        <form action="<?php echo $editFormAction; ?>" id="form2" name="form2" method="POST">
    <tr>
      <td width="30" rowspan="2" align="center"><?php echo $n; ?></td>
      <td align="center"><?php echo $row_get_stock_data['name']; ?></td>
      <td align="center"><?php echo $row_get_order_contents['quantity']; ?></td>
      <td align="center"><?php echo $row_get_stock_data['price_selling']; ?></td>
      <td align="right"><strong><?php echo number_format((float)$amount,2,'.',''); ?></strong></td>
    </tr>
    <tr>
      <td align="left" valign="top">Description:<br>
        <textarea name="description" rows="5" required="required" class="form-control" id="description"><?php echo $description; ?></textarea></td>
      <td align="left" valign="top">Rate The Product:<br>
        <select name="rating" required="required" class="form-control" id="rating" >
			<option></option>
			<option value="1" <?php if($rating == 1){ echo 'selected'; } ?>>1</option>
			<option value="2" <?php if($rating == 2){ echo 'selected'; } ?>>2</option>
			<option value="3" <?php if($rating == 3){ echo 'selected'; } ?>>3</option>
			<option value="4" <?php if($rating == 4){ echo 'selected'; } ?>>4</option>
			<option value="5" <?php if($rating == 5){ echo 'selected'; } ?>>5</option>
        </select></td>
      <td align="left" valign="top">How Satisfies of our service?<br>
        <select name="reaction" required="required" class="form-control" id="reaction" >
			<option></option>
			<option value="Nothing to Say" <?php if($reaction == 'Nothing to Say'){ echo 'selected'; } ?>>Nothing to Say</option>
			<option value="Has to be Improved" <?php if($reaction == 'Has to be Improved'){ echo 'selected'; } ?>>Has to be Improved</option>
			<option value="Satisfied" <?php if($reaction == 'Satisfied'){ echo 'selected'; } ?>>Satisfied</option>
			<option value="Perfectly Satisfied" <?php if($reaction == 'Perfectly Satisfied'){ echo 'selected'; } ?>>Perfectly Satisfied</option>
        </select>
		  </td>
      <td align="left" valign="top"><br>
<input type="submit" value="Send Feedback" class="btn btn-block btn-primary">
<input type="hidden" name="order_id" id="order_id" value="<?php echo $row_get_order_contents['cart_id']; ?>">
<input type="hidden" name="order_item_id" value="<?php echo $row_get_order_contents['seno']; ?>" id="order_item_id">
<input type="hidden" name="stock_id" value="<?php echo $productID; ?>" id="stock_id">
<input name="date" type="hidden" id="date" value="<?php echo $date; ?>"></td>
    </tr>
    <input type="hidden" name="MM_insert" value="form2">
        </form>
	  <?php $n++; $cartTotal += $amount;  ?>
	  <?php } while ($row_get_order_contents = mysql_fetch_assoc($get_order_contents)); ?>
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
	
	
	<br>
	
	
	
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-4.3.1.js"></script>
</body>
</html>
<?php
mysql_free_result($list_orders);
?>
