<?php
	/*
		Author: Christopher Parkins
		Description: Used to test features during implementation process.  This file includes a checkLogin function
					 as well as the uplaod_data function used to upload a csv to the database.
	*/
	
	ini_set('display_errors', 'On'); // Allows errors to print to browser/console
	session_start();
	session_cache_limiter("public");
	require_once('mysqliDAO.php'); // required for database connections

	upload_data("0");

	
	checkLogin();
	
	require_once('PersonDAO.php'); // model used for creating person objects
	
	/*
		Checks the user logging in by grabbing the authorization key and verifying that it exists in the database,
		and pushing the user's browser to the login page if not found with a $_GET value to change content.
	*/
	function checkLogin(){
		if(isset($_SESSION['authKey'])){
			$mysqli = new MysqliDAO();
			$query = $mysqli->query("SELECT `auth_key` FROM `n4d_users` WHERE `auth_key`='" . $_SESSION['authKey'] . "'");
			if($query->num_rows != 0){
				$key = $query->fetch_assoc();
				if($key['auth_key'] != $_SESSION['authKey']){
					unset($_SESSION['authKey']);
					header("Location: https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/login.php?redirect=true");
					die();
				}
			} else {
				unset($_SESSION['authKey']);
				header("Location: https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/login.php?redirect=true");
				die();
			}
		} elseif(isset($_POST['username']) && isset($_POST['pass'])){
			die('huh');
		} else {
			header("Location: https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/login.php?redirect=true");
			die();
		}
	}
	
	/*
		Upon selecting the file to upload, the $_FILES array should contain a csv which will be used to push up to the database
		for the user, requiring certain fields and a certain number of values to successfully upload.  After successful upload,
		the page will reload with a message indicating that the file was uploaded.
	*/
	function upload_data($uid){
		if (!empty($_FILES) && $_FILES['csv']['size'] > 0) {
			$mysqli = new MysqliDAO();
			$mysqli->query("DELETE FROM `n4d_healthactivity` WHERE `uid`='" . $uid . "'");
			//get the csv file 
			
			$file = $_FILES['csv']['tmp_name']; 
			$handle = fopen($file,"r"); 
			 
			//loop through the csv file and insert into database 
			do {
				if (!empty($data[0]) && trim($data[0]) != '"uid"') { 
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
					die("INSERT INTO `n4d_healthactivity` (uid, date, heart, sbp, dbp, sugar, sleep, cardio, strength) VALUES 
						(
							'".$data[0]."',
							'".$data[1]."',
							'".$data[2]."',
							'".$data[3]."',
							'".$data[4]."',
							'".$data[5]."',
							'".$data[6]."',
							'".$data[7]."',
							'".$data[8]."',
						)
					"); 
				} 
			} while ($data = fgetcsv($handle,1000,",","'"));
			die();
			//redirect 
			header('Location: https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/test.php?success=1'); die; 
		} 
	}
?> 

<--Test DIV for the upload csv function->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<title>Import a CSV File with PHP & MySQL</title> 
</head> 

<body> 

<?php if (!empty($_GET['success'])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?> 

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
  Choose your file: <br /> 
  <input name="csv" type="file" id="csv" /> 
  <input type="submit" name="Submit" value="Submit" /> 
</form> 

</body> 
</html> 