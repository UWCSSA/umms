<?php
	// seprate mysql authentication information for hosting the project on github
	// mysql_ini.php is supposed to define a variable $con which has connection to the membership mysql database
	include "mysql_ini.php";

	// captcha validation
	$captcha;
	if(isset($_POST['g-recaptcha-response']))
	  $captcha=$_POST['g-recaptcha-response'];

	if(!$captcha){
	  header("Location: ../captcha_fail.html");
	  exit;
	}
	$response=json_decode(file_get_contents(
		"https://www.google.com/recaptcha/api/siteverify?secret=******&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
	if($response['success'] == false)
	{
	  header("Location: ../captcha_fail.html");
	  exit;
	}


	// prepare and bind
	$stmt = $con->prepare(
		"INSERT INTO members (email,password,mobile,fname,lname,gender,school,sid,program)
		VALUES (?,?,?,?,?,?,?,?,?)"
	);
	$stmt->bind_param("sssssssss", $email, $password, $mobile, $fname, $lname, $gender, $school, $sid, $program);

	// set parameters and execute
	$email = $_POST["email"];
	$password = $_POST["password"];
	$confirm_password = $_POST["confirm_password"];
	$mobile = $_POST["mobile"];
	$fname = $_POST["fname"];
	$lname = $_POST["lname"];
	$gender = $_POST["gender"];
	$school = $_POST["school"];
	$sid = $_POST["sid"];
	$program = $_POST["program"];


	// return result
	if ($stmt->execute()) {
  	header("Location: ../reg_success.html");
  } else {
  	header("Location: ../reg_fail.html");
	}
	$stmt->close();
?>
