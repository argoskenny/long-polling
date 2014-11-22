<?php
// 測試資料自動增加

require('config/constants.php');
require('class/JbLink.php');

$link = new mysqlilink();
$link->JbLink(_HOST, _USER, _PASSWD, _DB);
$link->debug = true;
$html = '';
$refresh_no = '';
$row = array();
$content = '';
$title = '';

switch($_POST['cond'])
{
	case '1':
		$sql = "SELECT * 
				FROM auto 
				WHERE createtime < '".time()."' 
				ORDER BY no DESC 
				LIMIT 6";
		$link->query($sql);
		while($row = $link->fetch())
		{
			$html .= $row['title'].' - '.$row['content'].' - '.date('Y-m-d H:i:s',$row['createtime']).'<br/>';
			$refresh_no = $row['no'];
		}

		$data['status'] = 'success';
		$data['html'] = $html;
		$data['refresh_no'] = $refresh_no;
		echo json_encode($data);
		break;
	
	case '2':
		$newest_no = ($_POST['newest_no'] == '') ? 1 : $_POST['newest_no'];
		$sql = "SELECT * 
				FROM auto 
				WHERE no >= '".$newest_no."' 
				ORDER BY no DESC";
		$link->query($sql);
		while($row = $link->fetch())
		{
			$html .= $row['title'].' - '.$row['content'].' - '.date('Y-m-d H:i:s',$row['createtime']).'<br/>';
		}

		$data['status'] = 'success';
		$data['html'] = $html;

		echo json_encode($data);
		break;

	case '3':
		$_POST['title'] = mysqli_real_escape_string($link->link, $_POST['title']);
		$_POST['content'] = mysqli_real_escape_string($link->link, $_POST['content']);
		$sql = "INSERT INTO auto (title, content, createtime) 
				VALUES ('".$_POST['title']."','".$_POST['content']."', '".time()."');";
		$link->query($sql);

		$newest_no = ($_POST['newest_no'] == '') ? 1 : $_POST['newest_no'];
		$sql = "SELECT * 
				FROM auto 
				WHERE no >= '".$newest_no."' 
				ORDER BY no DESC";
		$link->query($sql);
		while($row = $link->fetch())
		{
				$html .= $row['title'].' - '.$row['content'].' - '.date('Y-m-d H:i:s',$row['createtime']).'<br/>';
		}

		$data['status'] = 'success';
		$data['html'] = $html;
		
		echo json_encode($data);
		break;
}

exit;
?>