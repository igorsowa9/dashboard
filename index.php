<?php
	session_start();

	if(isset($_SESSION['logged']) && $_SESSION['logged']==true)
	{
		header("Location: boiler.php");
		exit();
	}
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="login to dashboard">
		<meta name="author" content="IS">	
		
		<title>Dashboard Template for Bootstrap</title>
		<link href="dashboard.css" rel="stylesheet"/>
		
	</head>

	<body>
		
		<form action="logging.php" method="post"> 
			Login:<br/>
			<input type="text" name="login" /><br/>
			Password: <br/>
			<input type="password" name="pass" />
			<br/><br/>
			<input type="submit" value="Log in">
		</form>
		
		<?php
		
			if(isset($_SESSION['e_wrong_password'])){
				echo '<p style="color:red">Wrong password!</p>';
			}
	
		?>
		
	</body>
	
</html>
