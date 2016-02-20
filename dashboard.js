var deviceID    = "54ff6b066672524824571267";
var accessToken = "190f01b0033fd757de47b3014d8bb65016738067";
var setFunc = "setVal";
var getFunc = "getVal";
var getMeasure1 = "measure1ardu";
var getMeasure2 = "measure2ph";

function updateTable1() {
	
	start_date = document.getElementById('requiredDate').value
	var myDate = start_date;
	start_stamp = (new Date(myDate).getTime())/1000;
	start_stamp = start_stamp + 3600;
	
	$.ajax({
		type: 'POST',
		url: 'readsql.php',
		data: {
			d : start_stamp,
		},
		dataType: 'text',
		success: function(content) {
			var tablestr = "";
			if(String(content) == String("0 results  ")){
				tablestr += "<tr><td>no results from this day</td></tr>"
			}else{
				var parsed = JSON.parse(content);
				var arr = [];
				for(var x in parsed){
					arr.push(parsed[x]);
				}
				for(i=0;i<arr.length;i++){
					tablestr += "<tr>";
					tablestr += "<td>"+timeConverter(arr[i][0])+"</td>"+"<td>"+arr[i][1]+"</td>"+"<td>"+arr[i][2]+"</td>";
					tablestr += "</tr>";
				}
			}
			//document.write(tablestr);
			$('#tablecontent').html(tablestr);
		},
		error: function() {
			$('#tablecontent').html("<h2>Error</h2>");
		}
	});
}

function timeConverter(UNIX_timestamp){
  var a = new Date(UNIX_timestamp * 1000);
  var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  var year = a.getFullYear();
  var month = months[a.getMonth()];
  var date = a.getDate();
  if(date<10){date = "0" + date.toString();}
  var hour = a.getHours();
  if(hour<10){hour = "0" + hour.toString();}
  var min = a.getMinutes();
  if(min<10){min = "0" + min.toString();}
  var sec = a.getSeconds();
  if(sec<10){sec = "0" + sec.toString();}
  var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
  return time;
}

function setValue(obj) {
	var newValue = document.getElementById('degBoxId').value;
	newValue = Math.round(newValue*255/100);
	sparkSetPos(newValue);
}

function fineAdjust(value) {
	var currentValue = parseInt(document.getElementById('curPos').innerHTML);
	var setValue = value + currentValue;
	sparkSetPos(Math.round(setValue*255/100));
	$("#degBoxId").val(setValue);
}

function sparkSetPos(newValue) {
	var requestURL = "https://api.spark.io/v1/devices/" +deviceID + "/" + setFunc + "/";
	$.post( requestURL, { params: newValue, access_token: accessToken });
}

function getCol(matrix, col){
    var column = [];
    for(var i=0; i<matrix.length; i++){
        column.push(matrix[i][col]);
    }
    return column;
}