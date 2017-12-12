
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

	$currents=$array['currently']['summary'];
	$currenttemp=$array['currently']['temperature'];
	$currenthumid=$array['currently']['humidity'];

	$after12hrs=$array['hourly']['data'][0]['summary'];
	$after12hrstemp=$array['hourly']['data'][0]['temperature'];
	$after12hrshumid=$array['hourly']['data'][0]['humidity'];

	$tomorrow=$array['daily']['data'][1]['summary'];
	$tomorrowtemp=$array['daily']['data'][1]['temperatureHigh'];
	$tomorrowhumid=$array['daily']['data'][1]['humidity'];

	$tomorrow2=$array['daily']['data'][2]['summary'];
	$tomorrow2temp=$array['daily']['data'][2]['temperatureHigh'];
	$tomorrow2humid=$array['daily']['data'][2]['humidity'];
	
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
    <input type="text" name="location"/><br>
<h1> </h1>
<button type="submit">Submit</button>
</form>
<h1></h1>
<?php

 echo 'Current weather:';
echo '<br/>Summary:'.$currents ;
echo '<br/>Temperature:'. $currenttemp ;
echo '<br/>Humidity:'. $currenthumid  ;



 echo '<br/>After 12 hours weather:';

echo '<br/>Summary:'. $after12hrs ; 
echo '<br/>Temperature:'. $after12hrstemp ;
echo '<br/>Humidity:'. $after12hrshumid  ;

echo '<br/>Tomorrow weather:';

echo '<br/>Summary:'. $tomorrow ; 
echo '<br/>Temperature:'. $tomorrowtemp ;
echo '<br/>Humidity:'. $tomorrowhumid  ;


 echo '<br/>Day after tomorrow weather:';

echo '<br/>Summary:'. $tomorrow2; 
echo '<br/>Temperature:'. $tomorrow2temp ;
echo '<br/>Humidity:'. $tomorrow2humid  ;

?>
</body>
</html>
