<?php
// Usage : php chargetime.php from=10 to=80 model=Hyundai_IONIQ_28 max_power=6.6


parse_str(implode('&', array_slice($argv, 1)), $_GET);

//print_r($_GET);


$from=$_GET['from'];
$to=$_GET['to'];
$max_power=$_GET['max_power'];
$model=$_GET['model'];

$data = file_get_contents('charge.json');
$local_json = json_decode($data, true);

//var_dump($local_json);
$power = $local_json[$model]["power"];
$capacity  = $local_json[$model]["capacity"];
//var_dump($power);

$total_time = 0;

for ($i = $from; $i < $to; $i++)
{
	$delta_time = $capacity / min($max_power, $power[$i]) / 100 * 3600;
	$total_time += $delta_time;
	//print("\ndelta=");
	//print_r($delta_time);
	//print("\npow=");
	//print_r(min($max_power, $power[$i]) );
}
print("time=");
print_r($total_time/60);
print("\n");

?>
