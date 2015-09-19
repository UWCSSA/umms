<?php
	// seprate mysql authentication information for hosting the project on github
	// mysql_ini.php is supposed to define a variable $con which has connection to the membership mysql database
	include "mysql_ini.php";

	// prepare and bind
	$stmt = $con->prepare(
		"SELECT fname,lname,memid,credit FROM members
    WHERE email = ? AND password = ?"
	);
	$stmt->bind_param("ss", $email, $password);

	// set parameters and execute
	$email = $_POST["email"];
	$password = $_POST["password"];

	// return result
	if ($stmt->execute()) {
    // get result
    $stmt->bind_result($user_fname, $user_lname, $user_memid, $user_credit);
    $stmt->fetch();
  } else {
  	header("Location: ../fail.html");
	}
	$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<!-- mobile support -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>UWCSSA Membership Management System - Find Member</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="shortcut icon" href="../img/icon.jpg">
</head>
<body>
	<!-- top navigation bar -->
	<div class="navbar navbar-default navbar-static-top" role="navigation">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<a href="../index.html" class="navbar-brand">UWCSSA Membership Management System</a>
				<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="navbar-collapse collapse" id="navbar-main">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="../index.html">Register</a>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="active"><img src="../img/logo.png" width="110" height="50"></li>
				</ul>
			</div>
		</div>
	</div>

	<!-- account information -->
  <div class="container">
    <?php if ($user_fname !== NULL) { ?>
  		<table class="table table-bordered table-nonfluid">
  			</tbody>
  				<tr><th class="col-md-2">First Name</th><td class="col-md-6"><?php echo $user_fname?></td></div></tr>
  				<tr><th class="col-md-2">Last Name</th><td class="col-md-6"><?php echo $user_lname?></td></tr>
  				<tr><th class="col-md-2">Member ID</th><td class="col-md-6"><?php echo $user_memid?></td></tr>
  				<tr><th class="col-md-2">Credit</th><td class="col-md-6"><?php echo $user_credit?></td></tr>
  			</tbody>
  		</table>
  		<a href="../login.html" class="btn btn-warning" role="button">Logout</a>
    <?php } else { ?>
      <h5>Account Doesn't Exist Or Incorrect Password!</h5></br>
      <a href="../login.html" class="btn btn-warning" role="button">Back</a>
    <?php } ?>
  </div>

	<script type="text/javascript" src="../js/jquery-2.1.1.js"></script>
	<script type="text/javascript" src="../js/bootstrap.js"></script>
	<script type="text/javascript" src="../js/validator.js"></script>
</body>
</html>
