<?php

	require_once('dbconn.php');

	$value = $_POST["d"];

	$sql = "SELECT * FROM Health_Activity WHERE date = '{$value["date"]}'";
	$result = mysqli_query($con, $sql);

	if(!$result->num_rows) {
		$sql = "INSERT INTO Health_Activity VALUES (1, '{$value["date"]}', {$value["heart"]}, {$value["sbp"]}, {$value["dbp"]}, {$value["sugar"]}, {$value["sleep"]}, {$value["cardio"]}, {$value["strength"]})";
		mysqli_query($con, $sql);
	} else {
		$sql = "UPDATE Health_Activity SET heart = {$value["heart"]}, sbp = {$value["sbp"]}, dbp = {$value["dbp"]}, sugar = {$value["sugar"]}, sleep = {$value["sleep"]}, cardio = {$value["cardio"]}, strength = {$value["strength"]} WHERE date='{$value["date"]}'";
		mysqli_query($con, $sql);
	}

	mysqli_close($con);

?>