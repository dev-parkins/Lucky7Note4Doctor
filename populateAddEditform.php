<?php
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