<?php

	$midnight = $_POST['d'];
	
	require_once "connect.php";
	$conn = @new mysqli($host, $db_user, $db_password, $db_name);

	if ($conn->connect_error) {
		 die("Connection failed: " . $conn->connect_error);
	} 

	$sql_query = "SELECT * FROM final_results WHERE start_stamp=".$midnight.";";
	$result = $conn->query($sql_query);

	if ($result->num_rows > 0) {
		$resultLength = $result->num_rows; //should be 1
		$resarr = array();
		while($row = $result->fetch_assoc()) {
			$timestamp = $row["start_stamp"];
			array_push($resarr, array($timestamp, $row["value"]));
		}
		echo json_encode($resarr, JSON_FORCE_OBJECT);
	} else {
		echo "0 final_results for ".$midnight."!";
	}
	$conn->close();
?>  