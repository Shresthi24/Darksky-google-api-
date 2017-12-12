
<?php
if (!empty($_GET['location'])) {
   
    $maps_url = 'https://' .
        'maps.googleapis.com/' .
        'maps/api/geocode/json' .
        '?address=' . urlencode($_GET['location']).
	'&sensor='.'false';
    $maps_json = file_get_contents($maps_url);
    $maps_array = json_decode($maps_json, true);
    $lat = $maps_array['results'][0]['geometry']['location']['lat'];
    $lng = $maps_array['results'][0]['geometry']['location']['lng'];


	$url = 'https://' .
        	'api.darksky.net/forecast/' .
	        'bd99513aa194d63242db4e3ab20df7aa/'.
        	 $lat . ','.
        	 $lng ;
    $json = file_get_contents($url);
    $array = json_decode($json, true);
	
$date=$_GET['from'];
$date1=$_GET['to'];
	
	$d=strtotime($date);
	$d1=strtotime($date1);
	$dpart=$d1+86400;

$rows = array();
$table = array();

$table['cols'] = array(
 array(
  'label' => 'Date Time', 
  'type' => 'number'
 ),
 array(
  'label' => 'Temperature', 
  'type' => 'number'
 )
);

$result=array();
while($d!=$dpart)
{
$under=1;
$top="ashish".$under;
	$url = 'https://' .
        	'api.darksky.net/forecast/' .
        	'bd99513aa194d63242db4e3ab20df7aa/'.
        	 $lat . ','.
        	 $lng.','.
		 $d ;
   $json1 = file_get_contents($url);
    $array1 = json_decode($json1, true);
	
    $currents=$array1['daily']['data'][0]['temperatureHigh'];

	 $sub_array = array();
	 $sub_array[] =  array(
      "v" => $d
     );
 $sub_array[] =  array(
      "v" => $currents
     );
 $rows[] =  array(
     "c" => $sub_array
    );
	$d=$d+86400;
}

$table['rows'] = $rows;
$jsonTable = json_encode($table);



}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>test</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">


google.charts.load('current', {'packages':['corechart']});
      	google.charts.setOnLoadCallback(drawChart);


      function drawChart() {
        var data =new google.visualization.DataTable(
	<?php echo $jsonTable ?>
	);
      

        var options = {
          title: 'Weather',
          curveType: 'function',
          legend: { position: 'bottom' }

      

        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
</script>
   
</head>
<body>
<span> Location: </span>
<form action="" method="get">
    <input type="text" name="location"/>

<h1></h1>
<span>From: </span>
<form action="" method="get">
    <input type="date" name="from"/>
 
<h1></h1>
<span> To: </span>
	<input type="date" name="to"/>
<h1></h1>
    <button type="submit">Submit</button>
</form>
<br/>


  <div id="curve_chart" style="width: 900px; height: 500px"></div>


</body>
</html>
