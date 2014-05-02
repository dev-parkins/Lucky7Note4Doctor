<?php
	/*
		Author: Christopher Parkins
		Description: Destroys session token up logging out and redirecting to login page.
	*/
	session_start();
	session_unset();
	session_destroy();
	header("Location: https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/login.php");
	die();
?>