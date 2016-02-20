<?php
	require_once "connect.php";
	$conn = @new mysqli($host, $db_user, $db_password, $db_name);
	
	$url = 'http://api.openweathermap.org/data/2.5/forecast?id=6356055&appid=2de143494c0b295cca9337e1e96b00e0';
	$JSON = file_get_contents($url);
	$data = json_decode($JSON, true);
	$city_name = $data['city']['name'];
	
	$max_stamp_idx = 0;
	while(@$data['list'][$max_stamp_idx]['dt']){ 
		$max_stamp_idx+=1;
	}
	$max_stamp_idx = $max_stamp_idx - 1; //length of time data from api
	
	/*for ($i=0; $i<=$max_stamp_idx; $i++) {
		echo gmdate("d-m-Y\tH:i:s", $data['list'][$i]['dt'])."\t".$data['list'][$i]['main']['value']."</br>";	
	}*/
	
	if($conn->connect_errno!=0){
		echo "Error: ".$conn->connect_errno;
	}else{
		$sql = "";
		for ($i=0; $i<=$max_stamp_idx; $i++) {	
			//conv_date = gmdate("d-m-Y\tH:i:s", $data['list'][$i]['dt']);
			$sql .= "INSERT INTO test_data (data_timestamp, value) VALUES ('".$data['list'][$i]['dt']."','".$data['list'][$i]['main']['temp']."');";
		}
		
		if(mysqli_multi_query($conn, $sql)){
			echo "multi done!";
		}else{
			echo "multi undone!";
		}

		$conn->close();
	}
?>