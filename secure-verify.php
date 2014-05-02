<?php
	if(isset($_SESSION['authKey'])){
		//check that auth token is current and correct
	} elseif(isset($_POST['username']) && isset($_POST['password'])){
		//if username and password are correct, issue new auth token
	} else {
		header("Location: https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/login.php?redirect=true");
		die();
	}
?>