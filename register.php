<?php
	ini_set("display_errors", "On");
	session_start();
	session_cache_limiter("public");
	require_once('mysqliDAO.php'); // required for database connections
	$valid = createAccount();
?>

<!DOCTYPE HTML>
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
			<div id = "HealthMeterPane" style = "height: 350; width: 397px; overflow: auto; border-style: solid; border-width: 0px 0px 2px;">
				<center><h4>Registration</h4><form action="https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/register.php" method="POST">
					<table>
					<tr style="text-align:right;"><td>Username:</td><td><input type="text" name="username" required value="<?php if(isset($_POST['username'])){ print($_POST['username']);}?>"></td></tr>
					<tr style="text-align:right;"><td>Password:</td><td><input type="password" name="pass" required value="<?php if(isset($_POST['pass'])){ print($_POST['pass']);}?>"></td></tr>
					<tr style="text-align:right;"><td>First Name:</td><td><input type="text" name="first_name" required value="<?php if(isset($_POST['first_name'])){ print($_POST['first_name']);}?>"></td></tr>
					<tr style="text-align:right;"><td>Last Name:</td><td><input type="text" name="last_name" required value="<?php if(isset($_POST['last_name'])){ print($_POST['last_name']);}?>"></td></tr>
					<tr style="text-align:right;"><td>Email Address:</td><td><input type="email" name="email" required value="<?php if(isset($_POST['email'])){ print($_POST['email']);}?>"></td></tr>
					<tr style="text-align:right;" ><td>Date of Birth:</td><td><input type="date" name="dob" required value="<?php if(isset($_POST['dob'])){ print($_POST['dob']);}?>"></td></tr>
					<tr style="text-align:right;"><td>Weight (lb):</td><td><input name="weight" required type="number" min="50" value="<?php if(isset($_POST['weight'])){ print($_POST['weight']);}?>"></td></tr>
					<tr style="text-align:right;"><td>Height (in):</td><td><input type="number" name="height" required min="48" value="<?php if(isset($_POST['height'])){ print($_POST['height']);}?>"></td></tr>
					
					</table>
					<input type="submit" value="Submit">
				</form>
				<?php
					if(userExists()){
				?>
					<h4 style="color:red;">THAT USER ACCOUNT ALREADY EXISTS</h4>
				<?php
					} elseif(!$valid){
				?>
					<h4 style="color:red;">
				<?php
					}
				?>
				</center>
			</div>
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
	function userExists(){
		if(isset($_POST['username']) AND isset($_POST['pass'])){
			$mysqli = new MysqliDAO();
			$query = $mysqli->query("SELECT * FROM `n4d_users` WHERE `username`='" . $_POST['username'] . "'");
			$rows = $mysqli->affected_rows;
			if($rows > 0){
				return TRUE;
			}
		}
		return FALSE;
	}
	
	function createAccount(){
		foreach($_POST as $key => $value){
			if(empty($value)){
				return FALSE;
			}
		}
		if(isset($_POST['username']) && isset($_POST['pass'])){
			$mysqli = new MysqliDAO();
			(string)$salt = rand(0, 100000000000);
			(string)$hash = hash('md5', $_POST['pass'] . $salt);
			$_SESSION['authKey'] = assignKey();
			$mysqli->query("INSERT INTO `n4d_users` (`username`, `hash`, `salt`, `auth_key`) VALUES ('" . $_POST['username']. "', '" . $hash . "', '" . $salt . "', '" . $_SESSION['authKey'] . "')");
			$query = $mysqli->query("SELECT `uid` FROM `n4d_users` WHERE `username`='" . $_POST['username'] . "'");
			$uid = $query->fetch_assoc();
			$mysqli->query("INSERT INTO `n4d_profile` (`uid`, `first_name`, `last_name`, `email`, `dob`, `weight`, `height`) 
									VALUES ('" . $uid['uid'] . "','" . $_POST['first_name'] . "','" . $_POST['last_name'] . "','" . $_POST['email'] . "','" . $_POST['dob'] . "','" . $_POST['weight'] . "','" . $_POST['height'] . "')");
			header("Location: https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/index.php", TRUE, 301);
			die();
		}
	}
	
	function assignKey(){
		return(base_convert(rand(0, 10000000000000), 36, 16));
	}
	
?>