<?php
// 測試資料自動增加

require('config/constants.php');
require('class/JbLink.php');

$link = new mysqlilink();
$link->JbLink(_HOST, _USER, _PASSWD, _DB);
$link->debug = true;

$sql = "INSERT INTO auto (title, content, createtime) 
		VALUES ('測試資料', '".date('Y-m-d H:i:s',time())." - 測試資料測試資料測試資料測試資料測試資料', '".time()."');";
$link->query($sql);

echo 'insert 1 data';
?>
