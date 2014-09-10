<?php
	// seprate mysql authentication information for hosting the project on github
	// mysql_ini.php is supposed to define a variable $con which has connection to the membership mysql database
	include "mysql_ini.php";
	header('Content-type: application/json');
	// retrive information from post method
  $memid = $_POST["memid"];
  // inset values into database
	$sql = "SELECT * FROM members WHERE memid = " . $memid;
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
	if ($row === NULL) {
		echo json_encode(array("error"=>"no such member"));
	} else {
		echo json_encode($row);
	}
?>