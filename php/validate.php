<?php
	// seprate mysql authentication information for hosting the project on github
	// mysql_ini.php is supposed to define a variable $con which has connection to the membership mysql database
	include "mysql_ini.php";

	// prepare and bind
	$stmt = $con->prepare(
		"SELECT COUNT(*) FROM members WHERE email = ?"
	);
	$stmt->bind_param("s", $email);

	// set parameters and execute
	$email = $_GET["email"];
  $stmt->execute();
  $stmt->bind_result($num_email);
  $stmt->fetch();

	// return result
	if ($num_email === 0) {
    http_response_code(200);
  } else {
    header("HTTP/1.0 400 The email address has already been used");
	}
	$stmt->close();
?>
