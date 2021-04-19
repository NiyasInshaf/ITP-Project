<?php require_once('../Connections/dbconnect2.php'); ?>
<?php
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = "INSERT INTO tracking (order_id, updated_date, `description`, `user`) VALUES ('".$_POST['order_id']."', '".$_POST['updated_date']."', '".$_POST['description']."', '".$_POST['user']."')";
  $Result1 = mysql_query($insertSQL, $dbconnect) or die(mysql_error());

  $insertGoTo = "index.php?orderID=".$_POST['order_id'];
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_GET['delete'])) && ($_GET['delete'] != "")) {
  $deleteSQL = "DELETE FROM tracking WHERE tracking_id=".$_GET['delete'];
  $Result1 = mysql_query($deleteSQL, $dbconnect) or die(mysql_error());

  $deleteGoTo = "index.php?orderID=".$_GET['orderID'];
  header(sprintf("Location: %s", $deleteGoTo));
}
?>
<?php require_once('../Connections/dbconnect2.php'); ?>
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
	
<h4 class="alert-heading mt-4">Tracking Management</h4>			
		
		
<?php if(isset($_GET['orderID'])){ ?>		
<?php
$orderID = $_GET['orderID'];
	
$query_get_order_details = "SELECT * FROM carts WHERE seno = '$orderID'";
$get_order_details = mysql_query($query_get_order_details, $dbconnect) or die(mysql_error());
$row_get_order_details = mysql_fetch_assoc($get_order_details);
$totalRows_get_order_details = mysql_num_rows($get_order_details);

$query_get_tracking_data = "SELECT * FROM tracking ORDER BY `updated_date` ASC";
$get_tracking_data = mysql_query($query_get_tracking_data, $dbconnect) or die(mysql_error());
$row_get_tracking_data = mysql_fetch_assoc($get_tracking_data);
$totalRows_get_tracking_data = mysql_num_rows($get_tracking_data);		
?>
		
<table width="100%" border="0" class="table-bordered table-striped">
  <tbody>
    <tr>
      <td colspan="5" bgcolor="#DDD"><strong>Order ID: <?php echo $row_get_order_details['seno']; ?></strong></td>
      </tr>
    <tr>
      <td width="30" bgcolor="#CCC">#</td>
      <td bgcolor="#CCC">Description</td>
      <td bgcolor="#CCC">Date</td>
      <td bgcolor="#CCC">Updated By</td>
      <td bgcolor="#CCC">&nbsp;</td>
    </tr>
    <tr>
      <td width="30" align="center">1</td>
      <td>Order Placed</td>
      <td><?php echo $row_get_order_details['date']; ?></td>
      <td></td>
      <td></td>
    </tr>
	  <?php $i=2; ?>
	  <?php do{ ?>
<?php
$userID = $row_get_tracking_data['user'];
	
$query_get_admin_details = "SELECT * FROM user WHERE seno = '$userID'";
$get_admin_details = mysql_query($query_get_admin_details, $dbconnect) or die(mysql_error());
$row_get_admin_details = mysql_fetch_assoc($get_admin_details);
$totalRows_get_admin_details = mysql_num_rows($get_admin_details);	
?>
    <tr>
      <td width="30" align="center"><?php echo $i; ?></td>
      <td><?php echo $row_get_tracking_data['description']; ?></td>
      <td><?php echo $row_get_tracking_data['updated_date']; ?></td>
      <td><?php echo $row_get_admin_details['name']; ?></td>
      <td><a href="index.php?delete=<?php echo $row_get_tracking_data['tracking_id']; ?>&orderID=<?php echo $_GET['orderID']; ?>" onClick="return confirm('Are you sure to delete this?')">Delete</a></td>
    </tr>
	  <?php $i++; ?>
	  <?php } while ($row_get_tracking_data = mysql_fetch_assoc($get_tracking_data)); ?>
  </tbody>
</table>
	<br>
	
<div>
  <form action="<?php echo $editFormAction; ?>" id="form2" name="form2" method="POST">
    <table width="400" border="0">
      <tbody>
        <tr>
          <td><strong>Add Tracking Details</strong></td>
          </tr>
        <tr>
          <td>Description:</td>
          </tr>
        <tr>
          <td><select name="description" id="description" class="form-control">
			  <option></option>
			  <option vlaue="Items Packed">Items Packed</option>
			  <option vlaue="Package is Warehouse">Package is Warehouse</option>
			  <option vlaue="Package Shipped">Package Shipped</option>
			  <option vlaue="Out for Delivery">Out for Delivery</option>
			  <option vlaue="Delivered">Delivered</option>
			  <option vlaue="Delivery Attempt Failed">Delivery Attempt Failed</option>
			  <option vlaue="Not Delivered">Not Delivered</option>
			  <option vlaue="Delivery Cancelled">Delivery Cancelled</option>
            </select></td>
          </tr>
        <tr>
          <td>Date Updated:</td>
          </tr>
        <tr>
          <td><input type="date" name="updated_date" id="updated_date" class="form-control" value="<?php echo date('Y-m-d'); ?>"></td>
          </tr>
        <tr>
          <td>
			  <input type="hidden" name="order_id" id="order_id" value="<?php echo $row_get_order_details['seno']; ?>">
			  <input type="hidden" name="user" id="user" value="<?php echo $admin_id; ?>">
			  <input type="submit" name="submit" id="submit" value="Save Status" class="btn btn-primary mt-2"></td>
          </tr>
      </tbody>
    </table>
    <input type="hidden" name="MM_insert" value="form2">
  </form>
</div>		
		
<?php } else{ ?>
		
<?php
$query_list_orders = "SELECT * FROM carts ORDER BY `date` DESC";
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
	
	
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap-4.3.1.js"></script>
</body>
</html>