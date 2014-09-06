<?php
	header('Content-type: application/json');
	// retrive information from post method
  $memid = $_POST["memid"];
  // inset values into database
	$con = mysqli_connect("localhost", "root", "Justdoit", "umms");
	$sql = "SELECT * FROM members WHERE memid = " . $memid;
	$result = mysqli_query($con, $sql);
	// echo $sql;
	if ($result === false) {
		echo "wrong sql statement " . $sql;
	} else {
		$row = mysqli_fetch_array($result);
		if ($row === NULL) {
			echo json_encode(array("memid"=>-1));
		} else {
			echo json_encode($row);
		}
	}
?>