<?php
	require_once('dbconn.php');

	$date = $_POST['date'];

	$sql = "SELECT * FROM Health_Activity WHERE date = '{$date}'";
	$result = mysqli_query($con, $sql);

	$data = json_encode(mysqli_fetch_array($result));

	echo $data;
	
	mysqli_close($con);
?>