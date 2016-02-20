<?php

	session_start();
	require_once("connect.php");

	if(!isset($_POST['login'])){
		header("Location: index.php");
		exit();
	}	
	
	$conn = @new mysqli($host, $db_user, $db_password, $db_name);
	
	$login = $_POST['login'];
	$password = $_POST['pass'];
	$password_hash = password_hash($password, PASSWORD_DEFAULT);

	if($conn->connect_errno!=0){
		echo "Error with connection!";
	}else{

		if($result = $conn->query("SELECT * FROM users WHERE user='".$login."'")){

			if($result->num_rows==0){
				
				$_SESSION['e_wrong_password'] = true;
				header("Location: index.php");
				
			}elseif($result->num_rows==1){
				$row = $result->fetch_assoc();
				
				if(password_verify($password, $row['password'])){
					
					$_SESSION['logged'] = true;
					$_SESSION['user_logged'] = $login;
					header("Location: boiler.php");		
					unset($_SESSION['e_wrong_password']);
					
				}else{
					
					$_SESSION['e_wrong_password'] = true;
					header("Location: index.php");			
					
				}
				
			}else{
				echo "Unexpected number of record returned from database while logging in!";
			}	
			
			$result->close();
		}
		$conn->close();
	}


?>

