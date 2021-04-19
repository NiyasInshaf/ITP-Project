<?php

error_reporting(0);
$hostname_dbconnect = "localhost";
$database_dbconnect = "niyas_insaf";
$username_dbconnect = "root";
$password_dbconnect = "";
$dbconnect = mysql_pconnect($hostname_dbconnect, $username_dbconnect, $password_dbconnect) or trigger_error(mysql_error(),E_USER_ERROR); 


// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "admin_login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_dbconnect, $dbconnect);
  
  $LoginRS__query= "SELECT uname, pword FROM user WHERE uname='$loginUsername' AND pword='$password'"; 
   
  $LoginRS = mysql_query($LoginRS__query, $dbconnect) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username2'] = $loginUsername;
    $_SESSION['MM_UserGroup2'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
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

<body>
<div class="container mt-5">
	
<div class="row mt-5">

	
<div class="col-md-4"></div>	
	
<div class="col-md-4">
	<form ACTION="<?php echo $loginFormAction; ?>" id="form1" name="form1" method="POST">
	  <table width="100%" border="0">
	    <tbody>
	      <tr>
	        <td align="center"><img src="../images/login.png" width="100" height="102" alt=""/></td>
	        </tr>
	      <tr>
	        <td align="center" class="align-content-lg-stretch"><strong>Admin Login</strong></td>
	        </tr>
	      <tr>
	        <td>Username:</td>
	        </tr>
	      <tr>
	        <td><input name="username" type="text" required="required" class="form-control" id="username"></td>
	        </tr>
	      <tr>
	        <td>Password:</td>
	        </tr>
	      <tr>
	        <td><input name="password" type="password" required="required" class="form-control" id="password"></td>
	        </tr>
	      <tr>
	        <td>&nbsp;</td>
	        </tr>
	      <tr>
	        <td><input type="submit" name="submit" id="submit" value="Submit" class="btn btn-block btn-success"></td>
	        </tr>
	      </tbody>
	    </table>
	  </form>
</div>	
	
<div class="col-md-4"></div>	
	
</div>
	
</div>
</body>
</html>