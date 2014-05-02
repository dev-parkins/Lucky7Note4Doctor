<?php
	session_start();
	session_unset();
	session_destroy();
	header("Location: https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/login.php");
	die();
?>