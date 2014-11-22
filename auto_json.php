<?php
// 測試資料自動生成JSON

require('config/constants.php');
require('class/JbLink.php');

$link = new mysqlilink();
$link->JbLink(_HOST, _USER, _PASSWD, _DB);
$link->debug = true;
$count = 0;
$newest_no = 0;
$path = 'data/*.json';

$files_list = glob($path);

if(count($files_list) > 0)
{
	foreach($files_list as $key => $value)
	{
		$value = str_replace('data/', '', $value);
		$value = str_replace('.json', '', $value);
		$files_arr[(int)$value] = (int)$value;
	}
	ksort($files_arr);
	foreach($files_arr as $key => $value)
	{
		echo $key.'<br/>';
		$newest_no = $key;
	}
}
$sql = "SELECT * 
		FROM auto 
		WHERE no > '".$newest_no."'";
$link->query($sql);
while($row = $link->fetch())
{
	$jsondata = json_encode($row);
	$fp = fopen('data/'.$row['no'].'.json', 'w');
	fwrite($fp, $jsondata);
	fclose($fp);
	$count++;
}

echo $count.' json file ok';
?>