<?php
	/*
		Author: Pradeep Mani
		Eddited by: Christopher Parkins
		Description: Checks to see if the data entered by the user is a duplicate entry and 
					 adds in a new entry or overrides data for the date provided by the user.
	*/
	//ini_set("display_errors", "On");
	require_once('mysqliDAO.php');
	
	if(isset($_POST['d'])){
		$value = $_POST['d'];
	} else {
		die("ERROR ADDEDIT");
	}
	$mysqli = new MysqliDAO();
	
	$sql = "SELECT * FROM `n4d_healthactivity` WHERE `date` = '" . $value["date"] . "' AND `uid`='" . $value['uid'] . "'";
	$result = $mysqli->query($sql);

	// Insert if no data is found for the date
	if(!$result->num_rows) {
		$sql = "INSERT INTO `n4d_healthactivity` VALUES ('" . $value['uid'] . "', '" . $value["date"] . "', '" . $value["heart"] . "', '" . $value["sbp"] . "', '" . 
				$value["dbp"] . "', '" . $value["sugar"] . "', '" . $value["cholesterol"] . "', '" . $value["sleep"] . "', '" . $value["cardio"] . "', '" .$value["strength"] . "')";
		$mysqli->query($sql);
	} else {
		$sql = "UPDATE `n4d_healthactivity` SET `heart` = '" . $value["heart"] . "',  `sbp` = '" . $value["sbp"] . "', `dbp` = '" . 
				$value["dbp"] . "', `sugar` = '" . $value["sugar"] . "', `cholesterol` = '" . $value['cholesterol'] . "', `sleep` = '" . $value["sleep"] . "', `cardio` = '" . $value["cardio"] . "',
				`strength` = '" . $value["strength"] . "' WHERE `date`='" . $value["date"] . "'";
		$mysqli->query($sql);
	}
	$mysqli->close();
	die();
?>