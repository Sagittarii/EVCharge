<?php
// Usage : php chargetime.php from=10 to=80 model=Hyundai_IONIQ_28 station_max_power=50 station_max_current=125


parse_str(implode('&', array_slice($argv, 1)), $_GET);

//print_r($_GET);


$from=$_GET['from'];
$to=$_GET['to'];
$max_power=$_GET['station_max_power'];
$max_current=$_GET['station_max_current'];
$model=$_GET['model'];

$data = file_get_contents('charge.json');
$local_json = json_decode($data, true);

//var_dump($local_json);
$power = $local_json[$model]["power"];
$current = $local_json[$model]["current"];
$capacity  = $local_json[$model]["capacity"];
//var_dump($power);
//print($current);

$total_time = 0;

for ($i = $from; $i < $to; $i++)
{
	$coeff =  min(1, $max_power/$power[$i]);
	if ($current[$i] != 0) // Current limitation if vehicle max charging current provided
	{
		$coeff = min(min(1, $max_current/$current[$i]), $coeff);
	}
	$delta_time = $capacity / ($power[$i] * $coeff) / 100 * 3600;
	$total_time += $delta_time;
	//print("\ncoeff=");
	//print_r($coeff);
	//print("\ndelta=");
	//print_r($delta_time);
	//print("\npow=");
	//print_r($power[$i]*$coeff );
	//print("\n");
	//print_r($total_time);
	//print_r([$i, $max_current,$current[$i], $max_power, $power[$i], $coeff, $power[$i]*$coeff]);
}
print("time=");
print_r($total_time/60);
print("\n");

?>
