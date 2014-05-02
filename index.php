<?php
	/*
		Authors: Kenny Nyugen, Salman Mallick, Christopher Parkins
		Description: This file is used as the main part of the Note4Doctor Application
					 that contains the HTML that will be displayed to the user as well
					 as the verification process in order to access content.
	*/
	ini_set('display_errors', 'On'); // Allows errors to print to browser/console
	session_start();
	session_cache_limiter("public");
	require_once('mysqliDAO.php'); // required for database connections
	//die(print_r($_SESSION, TRUE));
	if(isset($_SESSION['authKey'])){
		$mysqli = new MysqliDAO();
		$query = $mysqli->query("SELECT `auth_key`, `uid` FROM `n4d_users` WHERE `auth_key`='" . $_SESSION['authKey'] . "'");
		if($query->num_rows != 0){
			$key = $query->fetch_assoc();
			if($key['auth_key'] != $_SESSION['authKey']){
				unset($_SESSION['authKey']);
				header("Location: https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/login.php?redirect=true");
				die();
			}
			$_SESSION['userId'] = $key['uid'];
		} else {
			unset($_SESSION['authKey']);
			unset($_SESSION['userId']);
			header("Location: https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/login.php?redirect=true");
			die();
		}
	} elseif(isset($_POST['username']) && isset($_POST['pass'])){
		die('huh');
	} else {
		header("Location: https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/login.php?redirect=true");
		die();
	}
?>

<!DOCTYPE HTML>
<html>
<head>
	<title> Note 4 Doctor </title>
	<script src="js/jquery-1.10.1.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<link rel="stylesheet" href="css/jquery-ui.css">
	<script src="js/highcharts.js"></script>
	<script src="js/exporting.js"></script>
	<script type="text/javascript" src="n4d.js"></script>
	<!--Below are the CSS settings for each of the panes used-->
	<style>
		#FullPane {
			width: 1000px;
			height: 850px;
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
		
		#LeftPane, #RightPane, #CustomizationPane  {
			height: 600px;
			border-style: solid;
			border-top-width: 2px;
			border-bottom-width: 2px;
		}
		
		#LeftPane {
			background-color: #D0D0D0;
			width: 397px;
			border-right-width: 1px;
			border-left-width: 2px;
			float: left;
		}
		
		#RightPane {
			background-color: #D0D0D0;
			width: 597px;
			border-left-width: 1px;
			border-right-width: 2px;
			float: left;
		}

		#CustomizationPane {
			background-color: #D0D0D0;
			width: 996px;
			border-left-width: 2px;
			border-right-width: 2px;
		}
				
		#ButtonsPane {
			background-color: #D0D0D0;
			border-style: solid;
			border-width: 0px 0px 2px;
			padding: 0px 7px;
			text-align: center;
		}
		
		#BottomPane {
			width: 1000px; 
			float:left;
		}
		
		#CogPane {
			width: 1000px;
			height: 50px;
			float: right;
		}

		#AddEditPane form input {
			width: 60px;
		}

		#HealthMeterPane {
			background-color: #D0D0D0;
			height: 287px;
			width: 397px;
			overflow: auto;
			border-style: solid;
			border-width: 0px 0px 2px;
		}

		#ActivityPane {
			background-color: #D0D0D0;
			height: 283px;
			width: 397px;
			overflow: auto;
		}
		
		#LoadSaveBack {
			left:215px;
			position:absolute;
			top:101px;
		}
	</style>
</head>
<!--The background color is set to light gray by default, the same as the default color for all the panes except the title-->
<body style = "background-color:#D0D0D0;" onload = "RevertLeftPane()">

<div id = "FullPane">
	<!--This contains the title in the uppermost box of the web application-->
	<div id = "TopPane">
			<h2> Lucky7's Note4Doctor (Time Stamp: April 29th) </h2>
	</div>
	<!--This is the rest of the web application, which contains both the left and right side of the web application-->
	<div id="MiddlePane">
		<div id="user" style="display:none"><?php if(isset($_SESSION['userId'])){ print($_SESSION['userId']); }?></div>
		<div id="UserPane"></div>
		<!--This is the left side of the middle pane, which has the buttons, health meter, and activities respectively from top to bottom-->
		<div id = "LeftPane">
			<!--This div contains the buttons for Add/Edit, View/Print, and Load/Save-->
			<div id = "ButtonsPane">
				<button id = "btnAddEdit" onclick = 'AddEditForm()' style = 'width:120px'> Add / Edit </button>
				<button id = "btnViewPrint" onclick = 'ViewPrintForm()' style = 'width:120px'> View / Print </button>
				<button id = "btnLoadSave" onclick = 'LoadSaveForm()' style = 'width:120px'> Load / Save </button>
			</div>
			<!--When the Add/Edit button is pressed, this pane is loaded with the data from the database-->
			<div id = "AddEditPane" style = "display: none; position: relative;">
				<div style="text-align: center;"><h3>Add/Edit Pane</h3></div>
				<form action="javascript:void(0);" name="add" onsubmit="submitAddEdit()">
					<div>
						<table style="margin: 40px auto;">
							<tr>
							  <td><b>Date:</b></td>
							  <td><input name="date" type="text" id="datepicker1" onchange="loadAddEditData(this.value);" style="width:75px;" readonly /></td> 
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
							  <td><b>Blood Sugar Level</b> <i>(mg/dL)</i>:</td>
							  <td><input name="sugar" type="number" min="50" max="500" required /></td>
							</tr>
							<tr>
							  <td><b>Total Cholesterol Level</b> <i>(mg/dL)</i>:</td>
							  <td><input name="cholesterol" type="number" min="110" max="390" required /></td>
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
			<!--When the View/Print button is pressed, this pane is loaded with a button to generate the report-->
			<div id = "ViewPrintPane" style = "display: none; position: relative;">
				<div style="text-align: center;"><h3>View/Print Pane</h3></div>
				<form action="javascript:void(0);" name="add" onsubmit="generateReport()">
					<div>
						<table style="margin: 40px auto;">
							<tr>
							  <td><b>Start Date:</b></td>
							  <td><input name="startdate" type="text" id="datepicker2" style="width:75px;" readonly /></td>
							</tr>
							<tr>
							  <td><b>End Date:</b></td>
							  <td><input name="enddate" type="text" id="datepicker3" style="width:75px;" readonly /></td> 
							</tr>
						</table>
					</div>
					<div style = "margin: 40px 0 0 140px;"><input type="submit" value="View"></div>
				</form>
				<button onclick = "RevertLeftPane('view')" style="bottom: 0; left: 200px; position: absolute;"> Back </button>
			</div>
			<!--When the Load/Save button is pressed, this pane is loaded with a button to save the data from the database into a flat file or load it from the user's computer-->
			<div id = "LoadSavePane" style = "display: none; position: relative;">
				<div style="text-align: center;"><h3>Load/Save Pane</h3></div>
				<form method="post" name="backup" action="https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/export.php">
					<input name="uid" value="<?php if(isset($_SESSION['userId'])){ print($_SESSION['userId']); } ?>" style="display:none;"></input>
					<div style="text-align: center;"> Download as .csv file !!!</div>
					<div style = "margin: 40px 0 0 130px;"><input type="submit" value="Download" style="width: 75px;"></div>
				</form>
				<button onclick = "RevertLeftPane('load');" id="LoadSaveBack">Back</button>
				<center><div style="padding-top: 10%">
					<form action="https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/import.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
						<div style="text-align: center; padding-bottom: 5%;">OR Upload Local Data</div>
						<input name="csv" type="file" id="csv" />
						<input type="submit" name="Submit" value="Submit" />
					</form>
				</div></center>
			</div>
			<!--This is the top of the left pane, which displays the health meter parameters-->
			<div id = "HealthMeterPane" style = "height: 287px; width: 397px; overflow: auto; border-style: solid; border-width: 0px 0px 2px;">
				<div style="text-align: center;"><h3>Health Meter</h3></div>
			</div>
			<!--This is the bottom of the right pane, which displays the activity parameters (example: sleeping)-->
			<div id = "ActivityPane">
				<div style="text-align: center;"><h3>Activities Meter</h3></div>
			</div>
		</div>
		<!--This is the right side of the middle pane, which has the graphs-->
		<div id = "RightPane">
			<div id="container1" style="height: 290px; margin: 0 auto; padding:5px"></div>
			<div id="container2" style="height: 290px; margin: 0 auto; padding:5px"></div>
			
		</div>
			<!--This is made visible when the cog is pressed and has the 4 drop down menus for customizing the layout of the web application-->
			<div id = "CustomizationPane" style="text-align: center;">
			<p> Customization</p>
			<p> Instructions: Select which pane you want to edit followed by the color, font, and font size.</p>
			<p> Notes: Add / Edit, View / Print, and Load / Save uses the same pane. Changing one changes all of them. </p>
			<!--This allows the user to select which pane to customize-->
			<select id = "WhichPane">
				<option value = "ActivityPane"> Activities Meter </option>
				<option value = "LeftPane"> Add / Edit </option>
				<option value = "CustomizationPane"> Customization </option>
				<option value = "RightPane"> Graphs </option>
				<option value = "HealthMeterPane"> Health Meter </option>
				<option value = "LeftPane"> Load / Save </option>
				<option value = "UserPane"> Spacing </option>
				<option value = "TopPane"> Title </option>
				<option value = "LeftPane"> View / Print </option>
			</select>
			<!--This allows the user to select which background color to change the selected pane to-->
			<select id = "WhichColor">
				<option value = "Default"> Default </option>
				<option value = "#66CCFF"> Blue </option>
				<option value = "#A0A0A0"> Dark Gray </option>
				<option value = "#00CC99"> Green </option>
				<option value = "#D0D0D0"> Light Gray </option>
				<option value = "#FF9966"> Orange </option>
				<option value = "#FF99CC"> Pink </option>
				<option value = "#6666CC"> Purple </option>
				<option value = "#A00000"> Red </option>
			</select>
			<!--This allows the user to select which font to change the selected pane to-->
			<select id = "WhichFont">
				<option value = "Default"> Default </option>
				<option value = "Arial"> Arial </option>
				<option value = "Comic Sans MS"> Comic Sans MS </option>
				<option value = "Courier New"> Courier New </option>
				<option value = "Impact"> Impact </option>
				<option value = "Lucida Console"> Lucida Console </option>
				<option value = "Tahoma"> Tahoma </option>
				<option value = "Verdana"> Verdana </option>
			</select>
			<!--This allows the user to select which font size to change the selected pane to-->
			<select id = "WhichSize">
				<option value = "Default"> Default </option>
				<option value = "8px"> 8pt </option>
				<option value = "9px"> 9pt </option>
				<option value = "10px"> 10pt </option>
				<option value = "11px"> 11pt </option>
				<option value = "12px"> 12pt </option>
				<option value = "14px"> 14pt </option>
				<option value = "16px"> 16pt </option>
				<option value = "18px"> 18pt </option>
				<option value = "20px"> 20pt </option>
				<option value = "22px"> 22pt </option>
			</select>
			<!--The first button applies the customization while the second button hides the customization pane-->
			<button onclick = "ChangeColorFont()" style = "width:130px"> Change </button>
			<button onclick = "RevertLeftPane('customize')"> Return </button>
		</div>
	</div>
	<!--This last pane is under the middle pane, but is not actually visible. It has a button which returns the user to the home page, or logs out. It also has the cog for customization-->
	<div id="BottomPane">
		<a href="https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/index.php">
			<button type="button" style="position:relative; left:420px"> Return to Home Page </button>
		</a>
		<a href="https://graduate-dev.asu.edu/sites/all/modules/playgroundmodule/Test/logout.php"><button type="button" style="position:relative; left:420px">Logout</button></a>
		<div id = "CogPane" style="margin: 0 auto 0 auto;float:left">
			<img src="http://www.public.asu.edu/~knguye12/Gear.png" onclick="Cog()" style="height: 35px; width: auto; float:right;"/>
		</div>
	</div>
	<div id="HiddenReport" style="display:none;"></div>
</div>

	
</body>
<html>