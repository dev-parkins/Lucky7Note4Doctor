<?php
	require_once('mysqliDAO.php');
	//require_once('dbconn.php');
	if(empty($_POST)){
		die('EMPTY POST in reportChart.php');
	}
	$mysqli = new MysqliDAO();
	$start = $_POST["start"];
	$end = $_POST["end"];
	$days = $_POST["days"];
	
	$uid = 2;
	$type = $_POST['param'];
	
	$day = date('l', time());
	
	// if no. of days is 1
	if($days != 1){
		$sql="SELECT `date`, " . $type . " FROM `n4d_healthactivity` WHERE `uid` ='" . $uid . "' AND `date` >= '" . $start . "' and `date` <= '" . $end . "' order by date";
	} else {
		$sql="SELECT `date`, " . $type . " FROM `n4d_healthactivity` WHERE `uid` = '" . $uid ." AND `date` = '" . $start . "' order by date";
	}

	$result = $mysqli->query($sql);

	$values = array();
	$categories = array();
	
	while($row = $result->fetch_assoc()){
		array_push($values,intval($row[$type]));
		array_push($categories, $row['date']);
	}
	
	$graph_data = array('categories'=>$categories, $type=>$values);
	
	echo json_encode($graph_data);
	die();
?>