<?php

	$start = $_POST['d'];
	$end = $start+24*3600-1;
	
	require_once "connect.php";
	$conn = @new mysqli($host, $db_user, $db_password, $db_name);

	if ($conn->connect_error) {
		 die("Connection failed: " . $conn->connect_error);
	} 

	$sql_query = "SELECT * FROM measures WHERE measures_stamp>".$start." AND measures_stamp<".$end.";";
	$result = $conn->query($sql_query);

	if ($result->num_rows > 0) {
		$resultLength = $result->num_rows;
		$resarr = array();
		while($row = $result->fetch_assoc()) {
			$timestamp = $row["measures_stamp"];
			array_push($resarr, array($timestamp, $row["measure1"], $row["measure2"]));
		}
		echo json_encode($resarr, JSON_FORCE_OBJECT);
	} else {
		echo "0 results";
	}
	$conn->close();
?>  