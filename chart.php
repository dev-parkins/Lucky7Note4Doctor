<?php
	require_once('mysqliDAO.php');
	//require_once('dbconn.php');
	$mysqli = new MysqliDAO();
	$uid = 2;
	$type = $_POST['param'];
	
	$day = date('l', time());
	
	if($day != 'Sunday'){

		$start = date('Y-m-d', strtotime('last sunday'));
		$end = date('Y-m-d', strtotime('today'));
		
		$sql="SELECT date, ".$type." FROM n4d_healthactivity WHERE uid = {$uid} and date >= '{$start}' and date <= '{$end}' order by date";
	
	} else {
	
		$today = date('Y-m-d', strtotime('today'));

		$sql="SELECT date, ".$type." FROM n4d_healthactivity WHERE uid = {$uid} and date = '{$today}' order by date";
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
?>