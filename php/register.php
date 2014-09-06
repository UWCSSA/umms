<?php
	header('Content-type: application/json');
	// retrive information from post method
  $memid = $_POST["member_id"];
  $fname = $_POST["first_name"];
  $lname = $_POST["last_name"];
  $contact = $_POST["contact"];
  // inset values into database
	$con = mysqli_connect("localhost", "root", "Justdoit", "umms");
	$sql = "INSERT INTO members (memid,fname,lname,contact) VALUES (" 
		. $memid . "," 
		. $fname . "," 
		. $lname . ","
		. $contact . ")";
	// return result
	if (mysqli_query($con,$sql)) {
  	echo json_encode($_POST);
	} else {
  	echo "Error registering: " . mysqli_error($con);
	}
?>