<?php
	/*
		Author: Pradeep Mani
		Editted by: Christopher Parkins
		Description: This file is used to export a csv file to the user with values from the database regarding
					 the user's history that they have commited to the Note4Doctor application
	*/
	require_once('mysqliDAO.php');

	if(!isset($_POST['uid'])){
		die("No UID sent");
	}

	$mysqli = new MysqliDAO();

	$sql = "SELECT * FROM `n4d_healthactivity` WHERE `uid`='" . $_POST['uid'] . "'";
	$result = $mysqli->query($sql);
	//die(print_r($result->fetch_assoc(), TRUE));
	$fieldcount = $result->num_rows;

	while ($fieldinfo = $result->fetch_field()) {
		$heading = $fieldinfo->name;
		$columns .= '"'.$heading.'",';
	}
	echo($columns . PHP_EOL);

	while ($row = $result->fetch_assoc()) {
		$rowOutput = "";
		//die(print_r($row, TRUE));
/* 		for ($i = 0; $i < $fieldcount; $i++) {
			$rowOutput .='"' . $row[$i] . '",';
		} */
 		foreach($row as $key => $value){
			$rowOutput .='"' . $value . '",';
		}
		$rowOutput = substr($rowOutput, 0, -1);
		echo($rowOutput . PHP_EOL);
	}

	header('Content-type: application/csv');
	header('Content-Disposition: attachment; filename=Note4Doctor.csv');
	
	exit;
?>