<?php
	// seprate mysql authentication information for hosting the project on github
	// mysql_ini.php is supposed to define a variable $con which has connection to the membership mysql database
	include "mysql_ini.php";

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
