<?php
	// seprate mysql authentication information for hosting the project on github
	// mysql_ini.php is supposed to define a variable $con which has connection to the membership mysql database
	include "mysql_ini.php";

	header('Content-type: application/json');

	$stmt = $con->prepare(
		"SELECT email, memid, fname,lname,credit FROM members WHERE email = ?"
	);
	$stmt->bind_param("s", $email);

	// set parameters and execute
	$email = $_POST["email"];
  $stmt->execute();
  $stmt->bind_result($user_email, $memid, $fname, $lname, $credit);
  $stmt->fetch();

	if ($user_email === NULL) {
		echo json_encode(array("error"=>"no such member"));
	} else {
		$row = array(
			'email' => $user_email,
			'memid' => $memid,
			'fname' => $fname,
			'lname' => $lname,
			'credit'=> $credit,
		);
		echo json_encode($row);
	}
?>
