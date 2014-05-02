<?php
	/*
		Author: Pradeep Mani
		Editted by: Christopher Parkins
		Description: Used to pre-populate the form for the Note4Doctor application if the user
					 has entered in details previously.
	*/
	require_once('mysqliDAO.php');

	if(!isset($_POST)){
		die("ERROR POPULATE");
	}
	$mysqli = new MysqliDAO();
	
	$sql = "SELECT * FROM `n4d_healthactivity` WHERE `date` = '" . $_POST['d']['date'] . "' AND `uid` = '" . $_POST['d']['uid'] . "'";
	$result = $mysqli->query($sql);

	$data = json_encode($result->fetch_assoc());

	echo $data;
	
	$mysqli->close();
	die();
?>