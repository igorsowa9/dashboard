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

		<script src="Chart.js-master/Chart.js"></script>

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
					<a class="navbar-brand" href="#">My home info</a>
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
						<li><a href="index.php">Boiler</a></li>
						<li class="active"><a href="meters.php">Meters</a></li>
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
					
					<div style="min-height:250px">
						<h2 class="sub-header" >Real time meters reading</h2>
						<div class="meterpool">
							Electricity:</br><span id="curMeasure1" class="measureValue">-</span>
						</div>
						<div class="meterpool">
							Gas:</br><span id="curMeasure2" class="measureValue">-</span>
						</div>
						<div style="clear:both;"></div>
					</div>
					
					
					<div style="min-height:150px">
						<h2 class="sub-header">Graphs (today's hour avarages)</h2>
						
						<div style="width:100%">
							<div style="padding: 25px">
								<canvas id="chart1" height="100" width="800"></canvas>
							</div>
						</div>
						<div style="width:100%">
							<div style="padding: 25px">
								<canvas id="chart2" height="100" width="800"></canvas>
							</div>
						</div>
						
						<button id="updateCharts" type="button" class="btn btn-primary">Update Charts</button>
					</div>	
					</br>
					<div style="min-height:300px">
						<h2 class="sub-header">Measures data from database</h2>
						
						<input data-provide="datepicker" type="text" id="requiredDate" name="date">

						<button id="updateTable" type="button" class="btn btn-primary">Update Table</button>

						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Date and time</th>
										<th>Value 1</th>
										<th>Value 2</th>
									</tr>
								</thead>		  
								<tbody id="tablecontent">
								</tbody>
							</table>
						</div>
					</div>
					
				</div>
		    </div>
		</div>	
		
		<script>
			window.setInterval(function() {
			
				requestURL1 = "https://api.spark.io/v1/devices/" + deviceID + "/" + getMeasure1 + "/?access_token=" + accessToken;
				
				requestURL2 = "https://api.spark.io/v1/devices/" + deviceID + "/" + getMeasure2 + "/?access_token=" + accessToken;

				$.getJSON(requestURL1, function(json) {
					var res1 = parseInt(parseInt(json.result)/10);
					document.getElementById("curMeasure1").innerHTML = res1;
					});	
				$.getJSON(requestURL2, function(json) {
					var res2 = json.result;
					document.getElementById("curMeasure2").innerHTML = res2;
					});
			}, 2000);
			
		</script>
		
		<!--Data picker include css and js-->
		<link rel="stylesheet" href="bootstrap-datepicker-1.5.1-dist/css/bootstrap-datepicker3.css" type="text/css" />
		<script src="bootstrap-datepicker-1.5.1-dist/js/bootstrap-datepicker.js"></script> 
		<script src="bootstrap-datepicker-1.5.1-dist/locales/bootstrap-datepicker.en-GB.min.js"></script>
		
		<script>
		
		function chartsDataUpdate(){
			
			var today = new Date();
			today.setHours(0,0,0,0);
			var midnight = new Date(today).getTime();
			var midnight_stamp = (midnight/1000)+3600-6*24*3600;
			
			// !!!!!!!!!!!!!!!!!!
			//
			// TO BE CHANGED
			//
			// !!!!!!!!!!!!!!!!!!
			
			$.ajax({
				type: 'POST',
				url: 'readsql.php?d='+midnight_stamp,
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
					var ch1data = new Array();
					var ch2data = new Array();
					
					var nperiods = 24;
					var tperiod = 3600;
					
					var start_stamp;
					var end_stamp;
					
					var period_sum1;
					var period_card1;
					var period_avg1;
					
					var period_sum2;
					var period_card2;
					var period_avg2;
					
					for(n=0; n<nperiods; n++){
						start_stamp = midnight_stamp + n*tperiod;
						end_stamp = midnight_stamp + (n+1)*tperiod;
						
						period_sum1 = 0;
						period_card1 = 0;
						period_avg1 = 0;
						
						period_sum2 = 0;
						period_card2 = 0;
						period_avg2 = 0;
						
						for(i=0; i<alldata.length; i++){
							
							if (parseInt(alldata[i][0])>=start_stamp && parseInt(alldata[i][0])<end_stamp){
								period_sum1 = period_sum1 + parseInt(alldata[i][1]);
								period_card1++;
							}	
						}
						if (period_card1==0){
							break;
						}else{
						period_avg1 = period_sum1/period_card1;
						}
						ch1data[n] = period_avg1;
						
						for(i=0; i<alldata.length; i++){
							
							if (parseInt(alldata[i][0])>=start_stamp && parseInt(alldata[i][0])<end_stamp){
								period_sum2 = period_sum2 + parseInt(alldata[i][2]);
								period_card2++;
							}	
						}
						if (period_card2==0){
							break;
						}else{
						period_avg2 = period_sum2/period_card2;
						}
						ch2data[n] = period_avg2;
					}
					
					var lineChart1Data = {
						labels :
						["0h","1h","2h","3h","4h","5h","6h","7h","8h","9h","10h","11h","12h","13h","14h","15h","16h","17h","18h","19h","20h","21h","22h","23h"],
						datasets : [
							{
								label: "My First dataset",
								fillColor : "rgba(220,220,220,0.7)",
								strokeColor : "rgba(120,120,120,1)",
								pointColor : "rgba(120,120,120,1)",
								pointStrokeColor : "#fff",
								pointHighlightFill : "#fff",
								pointHighlightStroke : "rgba(220,220,220,1)",
								data : ch1data
							}
						]
					}
					
					var ctx = document.getElementById("chart1").getContext("2d");
						window.myLine = new Chart(ctx).Line(lineChart1Data, {
						responsive: true
						
					});
					
					var lineChart2Data = {
						labels :
						["0h","1h","2h","3h","4h","5h","6h","7h","8h","9h","10h","11h","12h","13h","14h","15h","16h","17h","18h","19h","20h","21h","22h","23h"],
						datasets : [
							{
								label: "My First dataset",
								fillColor : "rgba(220,220,220,0.7)",
								strokeColor : "rgba(120,120,120,1)",
								pointColor : "rgba(120,120,120,1)",
								pointStrokeColor : "#fff",
								pointHighlightFill : "#fff",
								pointHighlightStroke : "rgba(220,220,220,1)",
								data : ch2data
							}
						]
					}
					
					var ctx = document.getElementById("chart2").getContext("2d");
						window.myLine = new Chart(ctx).Line(lineChart2Data, {
						responsive: true
						
					});
				}, 
				error: function(){
					$("#testspan").html("chart1 error");
					sendData([0,0]);
				}
			});
		}
		
		$("#updateCharts").click(function () {
			chartsDataUpdate();
		});
		
		$("#updateTable").click(function () {
			updateTable1();
		});
		
		window.onload = function(){
			chartsDataUpdate();
		}
		
		</script>

	</body>
</html>
