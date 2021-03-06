<?php
//	echo "TEST";
//	echo __FILE__;	

	require_once "/opt/lampp/htdocs/project/connect.php";
	require_once "/opt/lampp/htdocs/project/sparkcore_credentials.php";
	
	$conn = new mysqli($host, $db_user, $db_password, $db_name);
	
	$measuresNames = array("measure1ardu", "measure2ph"); // names from Spark Core
	$n_measures = count($measuresNames);
	
	for($i = 0; $i < $n_measures; $i++){
		$request =  "https://api.spark.io/v1/devices/" . $deviceID . "/" . $measuresNames[$i] . "/?access_token=" . $accessToken;
		
		$JSON = file_get_contents($request);
		$data = json_decode($JSON, true);		
		
		$measure_stamp = $data['coreInfo']['last_heard'];
		$measure_timestamp = strtotime($measure_stamp);
		$measure_value[$i] = intval($data['result']);
	}
	
	if($conn->connect_errno!=0){
		echo "Connection error: ".$conn->connect_errno;
	}else{
		$sql = "";
		$sql = "INSERT INTO measures (measures_stamp, measure1, measure2) VALUES (";
		
		$sql_values = "'$measure_timestamp'";
		
		for($i = 0; $i < $n_measures; $i++){
			$sql_values = $sql_values.",'".$measure_value[$i]."'";
		}
		$sql_values = $sql_values.");";
		$sql = $sql.$sql_values;
		
		if($conn->query($sql) === TRUE){
			echo "</br>measures updated!";
		}else{
			echo "</br>measures NOT updated!";
		}
		$conn->close();
	}
	
?>
