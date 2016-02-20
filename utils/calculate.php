<?php
	require_once "connect.php";
	$conn = @new mysqli($host, $db_user, $db_password, $db_name);

	function calculation($data){
		//
		//
		// calculation to obtain the resulting value for next morning for 
		// boiler, from solar radiation data end data about the 
		// solarthermal panels
		$result = 0.11* array_sum($data)/count($data); 
		// simulation of result for next day for specific boiler...
		//
		//
		return $result;
	}
	
	$current_time = time();
	$current_day =  date('d', $current_time );
	$current_month = date('m', $current_time );
	$current_year = date('Y', $current_time);
	$start_date = $current_day."-".$current_month."-".$current_year;
	
	$start_stamp = strtotime($start_date);
	$end_stamp = $start_stamp +24*3600 - 1;
	
	echo $start_stamp."</br></br>".$end_stamp."</br>";
	
	echo "from: ".date('m/d/Y H:i:s', $start_stamp)." to: ".date('m/d/Y H:i:s', $end_stamp);
	
	$sql = "SELECT * FROM test_data WHERE data_timestamp>'$start_stamp' AND data_timestamp<'$end_stamp'";
	
	if($conn->connect_errno!=0){
		echo "Error: ".$conn->connect_errno;
	}else{		
		if($result = @$conn->query($sql)){
			$rows_number = $result->num_rows;
			if($rows_number>0){
				echo "</br></br>".$rows_number." rows loaded from database!";
				
				$original_data = array();
				while($rows_assoc = $result->fetch_assoc()) {
					array_push($original_data, $rows_assoc["value"]);
				}
				//print_r($original_data);
				$result->close();
				
				$final_value = calculation($original_data);
				
				echo "</br></br>".$final_value."    ".$start_stamp;
				
				$sql = "INSERT INTO final_results (start_stamp, value) VALUES ('".$start_stamp."','".$final_value."');";
				
				// echo "</br></br>".$sql."</br></br>";
				
				if($conn->query($sql) === TRUE){
					echo "</br>result updated!";
				}else{
					echo "</br>result NOT updated!";
				}
	
			}else{
				echo "</br></br>No data loaded from database!";
			}
		}
		$conn->close();
	}

?>