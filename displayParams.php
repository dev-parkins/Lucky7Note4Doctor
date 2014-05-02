<?php
	/*
		Original Author: Pradeep Mani
		Editted by: Christopher Parkins
		Description: File is used to query the database for certain values used to populate the application
					 with values that will be used to determine averages for each field.
	*/
	require_once('mysqliDAO.php');
	//require_once('dbconn.php'); //Removed to incorporate DAO

	$uid = 2;
	$mysqli = new MysqliDAO();
	$day = date('l', time());
	
	if($day != 'Sunday'){
		$start = date('Y-m-d', strtotime('last sunday'));
		$end = date('Y-m-d', strtotime('today'));
		
		$sql = "SELECT round(round(avg(heart), 0), 0) as avgHeart, round(round(avg(sbp), 0), 0) as avgSbp, round(round(avg(dbp), 0), 0) as avgDbp, round(round(avg(sugar), 0), 0) as avgSugar, round(round(avg(cholesterol), 0), 0) as avgCholesterol, round(round(avg(sleep), 0), 0) as avgSleep, round(round(avg(cardio), 0), 0) as avgCardio, round(round(avg(strength), 0), 0) as avgStrength FROM n4d_healthactivity WHERE uid = {$uid} and date >= '{$start}' and date <= '{$end}'";
	
	} else {
		$today = date('Y-m-d', strtotime('today'));
		$sql = "SELECT round(avg(heart), 0) as avgHeart, round(avg(sbp), 0) as avgSbp, round(avg(dbp), 0) as avgDbp, round(avg(sugar), 0) as avgSugar, round(round(avg(cholesterol), 0), 0) as avgCholesterol, round(avg(sleep), 0) as avgSleep, round(avg(cardio), 0) as avgCardio, round(avg(strength), 0) as avgStrength FROM n4d_healthactivity WHERE uid = {$uid} and date = '{$today}'";
	}
	$result = $mysqli->query($sql);

	$data = $result->fetch_array();
	
	if(is_null($data[0])){
		foreach ($data as $key => $value) {
			$data[$key] = 0;
		}
	}
	echo json_encode($data);
?>