<?php
	/*
		Author: Pradeep Mani
		Description: Original connection used for connecting to the database.
					 Superseded by mysqliDAO.php
	*/
	$con = mysqli_connect('localhost','root','root','note4doc');
	if (!$con) {
	  die('Could not connect: ' . mysqli_error($con));
	}
?>