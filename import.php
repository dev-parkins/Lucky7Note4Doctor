<?php
	/*
		Author: Christopher Parkins
		Description: This file is used to import data that is given by the user
					 in the form of a csv.
	*/
	require_once('mysqliDAO.php');

	if(!isset($_FILES)){
		die("No Data sent");
	}

	$mysqli = new MysqliDAO();

	if (!empty($_FILES) && $_FILES['csv']['size'] > 0) {
		$mysqli = new MysqliDAO();
		//$mysqli->query("DELETE FROM `n4d_healthactivity` WHERE `uid`='" . $_FILES['uid'] . "'");
		//get the csv file 
		
		$file = $_FILES['csv']['tmp_name']; 
		$handle = fopen($file,"r"); 
		 
		//loop through the csv file and insert into database 
		$uid = "";
		do {
			if (!empty($data[0]) && trim($data[0]) != '"uid"') { 
				if(empty($uid)){
					$uid = $data[0];
					$result = $mysqli->query("DELETE FROM `n4d_healthactivity` WHERE `uid`='" . substr($uid, 1, 1) . "'");
					echo("DELETE FROM `n4d_healthactivity` WHERE `uid`='" . substr($uid, 1, 1) . "'<br>");
					echo("<pre>" . print_r($result, TRUE));
				}
				$data = str_replace('"', "", $data);
				echo("<pre>"); print_r($data);
 				$mysqli->query("INSERT INTO `n4d_healthactivity` (uid, date, heart, sbp, dbp, sugar, sleep, cardio, strength) VALUES 
					(
						'".$data[0]."',
						'".$data[1]."',
						'".$data[2]."',
						'".$data[3]."',
						'".$data[4]."',
						'".$data[5]."',
						'".$data[6]."',
						'".$data[7]."',
						'".$data[8]."'
					)
				");
			} 
		} while ($data = fgetcsv($handle,1000,",","'"));
		//redirect 
		header('Location: https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/index.php'); die; 
	}
	exit;
?>