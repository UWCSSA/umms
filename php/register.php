<?php
	header('Content-type: application/json');
	// retrive information from post method
  $memid = $_POST["memid"];
  $fname = $_POST["fname"];
  $lname = $_POST["lname"];
  $contact = $_POST["contact"];
  // inset values into database
	$con = mysqli_connect("localhost", "root", "Justdoit", "umms");
	$insert = "INSERT INTO members (memid,fname,lname,contact) VALUES ('" 
		. $memid . "','" 
		. $fname . "','" 
		. $lname . "','"
		. $contact . "')";
	$query = "SELECT * from members WHERE memid = " . $memid;
	// return result
	if (mysqli_query($con,$insert) && $result = mysqli_query($con, $query)) {
  		$row = mysqli_fetch_array($result);
  		if ($row !== NULL) {
  			echo json_encode($row);
  		}
  } else {
  	echo json_encode(array("error"=>mysqli_error($con)));
	}
?>