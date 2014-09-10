<?php
	header('Content-type: application/json');
	// retrive information from post method
  $memid = $_POST["memid"];
  // inset values into database
	$con = mysqli_connect("localhost", "root", "Justdoit", "umms");
	$sql = "SELECT * FROM members WHERE memid = " . $memid;
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
	if ($row === NULL) {
		echo json_encode(array("error"=>"no such member"));
	} else {
		echo json_encode($row);
	}
?>