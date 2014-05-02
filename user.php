<?php
	ini_set("display_errors", "On");
	require_once('mysqliDAO.php');

	if(isset($_POST['q'])){
		$q = $_POST['q'];
	} else {
		die("No uid sent");
	}
	
	$mysqli = new MysqliDAO();
	$sql="SELECT `first_name`, `last_name` FROM `n4d_profile` WHERE `uid` = '".$q."'";

	$result = $mysqli->query($sql);
	$out = '';

	if($result->num_rows == 0){
		die("User not found: " . $q);
	} else {
		while($row = $result->fetch_assoc()){
		  $out .= "Welcome " . $row['last_name'] .", " .$row['first_name'];
		}
	}
	$mysqli->close();
	die($out);
?>