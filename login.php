<?php
	/*
		Authors: Kenny Nyugen, Salman Mallick, Christopher Parkins
		Description: This file is used to login to the Note4Doctor application
					 Contains several functions in order to authorize the user
					 by giving an auth token that will be verified after logging
					 in as well as to save the session for the user (avoiding
					 a login when leaving the page or closing the browser)
	*/
	ini_set("display_errors", "On");
	session_start();
	session_cache_limiter("public");
	require_once('mysqliDAO.php'); // required for database connections
	//die(print_r($_SESSION, TRUE));
	if(validAuthKey()){
		header("Location: https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/index.php");
		die();
	}
	
	$valid = validCredentials();

?>


<html>
<head>
	<title> Testing </title>
	<style>
		#FullPane {
			width: 1000px;
			height: 800px;
			margin: 0 auto;
		}
		
		#TopPane {
			height: 65px;
			background-color: #A0A0A0;
			border-style: solid;
			border-width: 2px;
			text-align: center;
		}
		
		#UserPane {
			border-style: solid;
			border-width: 0 2px;
			text-align: right;
			padding: 10px;
			font-style: oblique;
			font-weight: bold;
		}
		
		#LeftPane, #RightPane {
			height: 600px;
			background-color: #D0D0D0;
			border-style: solid;
			border-top-width: 2px;
			border-bottom-width: 2px;
			float: left;
		}
		
		#LeftPane {
			width: 397px;
			border-right-width: 1px;
			border-left-width: 2px;
		}
		
		#RightPane {
			width: 597px;
			border-left-width: 1px;
			border-right-width: 2px;
		}
		
		#ButtonsPane {
			border-style: solid;
			border-width: 0px 0px 2px;
			padding: 0px 7px;
		}
		
		#BottomPane {
			width: 1000px; 
			float:left;
		}
		
		#LoginForm{
			vertical-align: text-top;
		}
	</style>
</head>
<body style = "background-color:#D0D0D0;" onload = "RevertLeftPane()">

<div id = "FullPane">
	<div id = "TopPane">
		<h2> Lucky7's Note4Doctor</h2>
	</div>
	<div id="MiddlePane">
		<div id="UserPane"></div>
		<div id = "LeftPane">
			<div id = "ButtonsPane">
				<button id = "btnAddEdit"  style = 'width:125px'> Add / Edit </button>
				<button id = "btnViewPrint" style = 'width:125px'> View / Print </button>
				<button id = "btnLoadSave"  style = 'width:125px'> Load / Save </button>
			</div>
			<div id = "AddEditPane" style = "display: none; position: relative;">
				<div style="text-align: center;"><h3>Add/Edit Pane</h3></div>
					<form action="javascript:void(0);" name="add" onsubmit="submitAddEdit()">
						<div>
							<table style="margin: 40px auto;">
								<tr>
								  <td><b>Date:</b></td>
								  <td><input name="date" type="text" id="datepicker" onchange="loadAddEditData(this.value);" style="width:75px;" readonly /></td> 
								</tr>
								<tr><td><br></td></tr>
								<tr>
								  <td><b>Heart Rate</b> <i>(bpm)</i>:</td>
								  <td><input name="heart" type="number" min="60" max="100" required /></td>
								</tr>
								<tr>
								  <td><b>Blood Pressure</b> <i>(mm Hg)</i>:</td>
								  <td>
									<input name="sbp" type="number"  min="110" max="180" required /> 
									/ 
									<input name="dbp" type="number"  min="70" max="110" required />
								  </td>
								</tr>
								<tr>
								  <td><b>Blood Sugar Level</b> <i>(mg/dl)</i>:</td>
								  <td><input name="sugar" type="number" min="50" max="500" required /></td>
								</tr>
								<tr><td><br><br></td></tr>
								<tr>
								  <td><b>Hours Slept</b> <i>(hrs)</i>:</td>
								  <td><input name="sleep" type="number" min="0" max="24" required /></td>
								</tr>
								<tr>
								  <td><b>Cardio Workouts</b> <i>(hrs)</i>:</td>
								  <td><input name="cardio" type="number" min="0" max="24" required /></td>
								</tr>
								<tr>
								  <td><b>Strength Workouts</b> <i>(hrs)</i>:</td>
								  <td><input name="strength" type="number" min="0" max="24" required /></td>
								</tr>
							</table>
						</div>
						<div style = "margin: 40px 0 0 120px;"><input type="submit"></div>
					</form>
					<button onclick = "RevertLeftPane('add')" style="bottom: 0; left: 200px; position: absolute;"> Cancel </button>
			</div>
			<div id = "ViewPrintPane" style = "display: none;">
				<div style="text-align: center;"><h3>View/Print Pane</h3></div>
				<button onclick = "RevertLeftPane('view')" style="margin: 10px 10px 0; float:right;"> Back </button>
			</div>
			<div id = "LoadSavePane" style = "display: none; position: relative;">
				<div style="text-align: center;"><h3>Load/Save Pane</h3></div>
				<form action="export.php" name="backup">
					<div style="text-align: center;"> Download as .csv file !!!</div>
					<div style = "margin: 40px 0 0 130px;"><input type="submit" value="Download" style="width: 75px;"></div>
				</form>
				<button onclick = "RevertLeftPane('load');" style="bottom: 0; left: 215px; position: absolute;"> Back </button>
			</div>
			<div id = "HealthMeterPane" style = "height: 287px; width: 397px; overflow: auto; border-style: solid; border-width: 0px 0px 2px;">
				<center><h4>Login</h4><form id="LoginForm"action="https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/login.php" method="POST">
					Username: <input type="text" name="username"><br>
					Password: <input type="password" name="pass"><br>
					<input type="submit" value="Submit">
				</form>
			<div>OR <a href="https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/register.php">REGISTER</a></div>
<?php
	if(!$valid){
		if(isset($_GET['redirect']) && $_GET['redirect'] == 'true'){ //If the user never was authorized from the index.php page, this will indicate to the user
?>
			<h4 style="color:red">You will need to login in order to view Note4Doctor content</h4>
<?php
		} elseif(isset($_POST['username']) || isset($_POST['password'])){ // If bad password or username, then this will indicate that to the user
?>
			<h4 style="color:red">Invalid Username or Password</h4>
<?php
		}
	}
?>
			</div></center>
			<div id = "ActivityPane" style = "height: 287px; width: 397px; overflow: auto;">

			</div>
		</div>
		<div id = "RightPane">
			<div id="container1" style="height: 290px; margin: 0 auto; padding:5px"></div>
		</div>
	</div>
	<div id="BottomPane">
		<a href="https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/login.php">
			<button type="button" style="position:relative; left:420px"> Return to Home Page </button>
		</a>
		<img src="http://www.public.asu.edu/~knguye12/Gear.png" onclick="Cog()" style="position: relative; top: 10px; left: 795px; height: 35px; width: auto;" />
	</div>
</div>
</body>
<html>


<?php
	/*
		validAuthKey(void)
		
		This functino is used to determine if the session variable's authKey is valid and current, else it
		will unset the variable and return FALSE
		
		returns TRUE or FALSE
	*/
	function validAuthKey(){
		if(isset($_SESSION['authKey'])){
			$mysqli = new MysqliDAO();
			$query = $mysqli->query("SELECT * FROM `n4d_users` WHERE `auth_key`='" . $_SESSION['authKey'] . "'");
			$rows = $mysqli->affected_rows;
			$mysqli->close();
			if($rows > 0){
				return TRUE;
			} else {
				unset($_SESSION['authKey']);
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	
	/*
		validCredentials(void)
		
		This function is used to verifify the username and password and set a new session variable for the user in order
		to access the Note4Doctor application upon redirect
		
		returns FALSE or redirects
	*/
	function validCredentials(){
		if(isset($_POST['username']) && isset($_POST['pass'])){
			$mysqli = new MysqliDAO();
			$mysqli->query("SELECT * FROM `n4d_users` WHERE `username`='" . $_POST['username'] ."'");
			if($mysqli->affected_rows > 0){
				$query = $mysqli->query("SELECT `hash`, `salt` FROM `n4d_users` WHERE `username`='" . $_POST['username'] ."'");
				if($mysqli->affected_rows > 0){
					$array = $query->fetch_assoc();
					$hashedPass = hash('md5', $_POST['pass'] . $array['salt']);
					if($hashedPass == $array['hash']){
						$_SESSION['authKey'] = assignKey();
						$mysqli->query("UPDATE `n4d_users` SET `auth_key`='" . (string)$_SESSION['authKey'] . "' WHERE `username`='" . (string)$_POST['username'] . "'");
						//die("UPDATE `n4d_users` SET `auth_key`='" . (string)$_SESSION['authKey'] . "' WHERE `username`'='" . (string)$_POST['username'] . "'");
						header("Location: https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/index.php");
						die();
					}
				}
			}
		}
		return FALSE;
	}
	
	/*
		assignKey(void)
		
		This function is used to generate an authorization key for the user for login purposes.
	*/
	function assignKey(){
		return(base_convert(rand(0, 10000000000000), 36, 16));
	}
	
/* 	function stuff(){
		$newSalt = time() . $_POST['username'] . (time() % 147);
					$newHash = hash('md5', $_POST['pass'] . $newSalt);
					$mysqli->query("INSERT INTO `n4d_authorizaiton` (" . $_POST['usernname'] ", " . $newHash . ", " . $newSalt . ")"); // assign new auth key
	} */
	
?>