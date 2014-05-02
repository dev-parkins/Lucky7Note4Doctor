<?php
	ini_set('display_errors', 'On'); // Allows errors to print to browser/console
	session_start();
	session_cache_limiter("public");
	require_once('mysqliDAO.php'); // required for database connections
	//echo("START");
	upload_data("0");
	//echo("<pre>"); print_r($_SESSION);
	
	checkLogin();
	//die("END");
	
	require_once('PersonDAO.php'); // model used for creating person objects
	
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