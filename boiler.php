<?php
	session_start();
	
	if(!isset($_SESSION['logged'] )){
		header("Location: index.php");
		exit();
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">	
		
		<!-- (Should be) Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"><\/script>')</script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		
		<title>Dashboard Template for Bootstrap</title>
		<link href="dashboard.css" rel="stylesheet">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">		
		<script src="dashboard.js"></script>
		
	</head>

	<body>
	
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">My home info (logged: <?php echo $_SESSION['user_logged']; ?>)</a>
				</div>		
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#">Dashboard</a></li>
						<li><a href="#">Settings</a></li>
						<li><a href="#">Profile</a></li>
						<li><a href="#">Help</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
					<form class="navbar-form navbar-right">
						<input type="text" class="form-control" placeholder="Search somewhere...">
					</form>
				</div>
			</div>
		</nav>

		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3 col-md-2 sidebar">
				    <ul class="nav nav-sidebar" style="margin-bottom: 10px">
						<li><a href="#">Overview <span class="sr-only">(current)</span></a></li>
						<li><a href="#">Other</a></li>
						<li><a href="#">Other</a></li>
						<li><a href="#">Analytics</a></li>
				    </ul>
				    <ul class="nav nav-sidebar" style="margin-bottom: 10px">
						<li class="active"><a href="index.php">Boiler</a></li>
						<li><a href="meters.php">Meters</a></li>
						<li><a href="">Other function</a></li>
						<li><a href="">Other function</a></li>
				    </ul>
				    <ul class="nav nav-sidebar" style="margin-bottom: 10px">
						<li><a href="">Other data</a></li>
						<li><a href="">Other data</a></li>
						<li><a href="">Other data</a></li>
				    </ul>
				</div>
				
				<div class="col-sm-9 col-md-10 main">
					<h1 class="page-header">My home dashboard</h1>

					<div class="row placeholders">
						<div class="col-xs-6 col-sm-3 placeholder">
						<a href="index.php">
						  <img src="img/boiler.png" width="200" height="200" class="img-responsive" alt="Boiler">
						</a>
						  <h4>Boiler</h4>
						  <span class="text-muted">Heating optimisation</span>
						</div>
						<div class="col-xs-6 col-sm-3 placeholder">
						<a href="meters.php">
						  <img src="img/meters.png" width="200" height="200" class="img-responsive" alt="Meters">
						</a>
						  <h4>Meters</h4>
						  <span class="text-muted">Real time measures</span>
						</div>
						<div class="col-xs-6 col-sm-3 placeholder">
						  <img src="img/function.png" width="200" height="200" class="img-responsive" alt="Other function">
						  <h4>Other function</h4>
						  <span class="text-muted">With awesome functionality</span>
						</div>
						<div class="col-xs-6 col-sm-3 placeholder">
						  <img src="img/function.png" width="200" height="200" class="img-responsive" alt="Other function">
						  <h4>Other function</h4>
						  <span class="text-muted">With awesome functionality</span>
						</div>
					</div>
					
					<div id="setboilermanually" style="min-height:250px">
						<h2 class="sub-header" >Set boiler manually</h2>
		
						<input type="range" name="degBox" id="degBoxId" min="0" max="100" step="5" list="myData" onchange="setValue(this)" />
						
						<!-- This adds the tick marks to the range but does not in Safari -->
							<datalist id="myData">
							   <option value="10" />
							   <option value="20" />
							   <option value="30" />
							   <option value="40" />
							   <option value="50" />
							   <option value="60" />
							   <option value="70" />
							   <option value="80" />
							   <option value="90" />
							   <option value="100" />
							</datalist>
						<br/>
	
						<button id="minusbutton" onclick="fineAdjust(-5)" type="button" class="btn btn-primary">&lArr; -5%</button>
						
						<button id="plusbutton"  onclick="fineAdjust(+5)" type="button" class="btn btn-primary">+5% &rArr;</button>
						</br>

						<div style="text-align: center;" class="meterpool">Current Settings:<br/> 
						<span id="curPos" class="measureValue"></span></div>
						<div style="clear:both;"></div>
						
					</div>
					
					<div id="setboilerauto" style="min-height:250px">
						<h2 class="sub-header" >Set boiler automatically</h2><br/>
						<button id="autobutton" onclick="setautomode()" type="button" class="btn btn-primary">Let the algorithm adjust boiler level!</button>
					</div>

				</div>
		    </div>
		</div>	
		
		<!--Data picker include css and js-->
		<link rel="stylesheet" href="bootstrap-datepicker-1.5.1-dist/css/bootstrap-datepicker3.css" type="text/css" />
		<script src="bootstrap-datepicker-1.5.1-dist/js/bootstrap-datepicker.js"></script> 
		<script src="bootstrap-datepicker-1.5.1-dist/locales/bootstrap-datepicker.en-GB.min.js"></script>
		
		<script>
		
			window.setInterval(function() {
				requestURL = "https://api.spark.io/v1/devices/" + deviceID + "/" + getFunc + "/?access_token=" + accessToken;

				$.getJSON(requestURL, function(json) {
					var res = Math.round(parseInt(json.result)*100/255);
					document.getElementById("curPos").innerHTML = res + "%";
					document.getElementById("degBoxId").value = res;
					});
			}, 1000);
			
			function setautomode() {
				
				var today = new Date();
				today.setHours(0,0,0,0);
				var midnight = new Date(today).getTime();
				var midnight_stamp = (midnight/1000);
				
				$.ajax({
					type: 'POST',
					url: 'readsql_results.php?d='+midnight_stamp,
					data: {
						d : midnight_stamp,
					},
					dataType: 'text',
					success: function(content){
						var parsed = JSON.parse(content);
						var alldata = [];
						for(var x in parsed){
							alldata.push(parsed[x]);
						}
						value = parseInt(alldata[0][1]) * 255/100;
						sparkSetPos(value); //exact value from database into percentage
					}, 
					error: function(){
						$("#testspan").html("chart1 error");
						sendData([0,0]);
					}
				});	
			}	
			
		</script>

	</body>
</html>
