<!DOCTYPE HTML>
<html>
<head>
<title> Testing </title>
</head>
<body style = "background-color:#D0D0D0;" onload = "RevertMiddlePane(); RevertLeftPane(); RevertRightPane()">



<div id = "FullPane" style = "width:800px; height:850px; margin:auto;">
	<div id = "TopPane" style = "height:65px; background-color:#A0A0A0; border-style:solid; border-width:2px; text-align:center">
		<h2> Lucky7's Note4Doctor (Time Stamp: April 15th) </h2>
	</div>
	<div id = "MiddlePane" style = "width:800px; height:600px; background-color:#D0D0D0;">
	</div>
	<div id = "BottomPane" style = "width:800px; float:left">
		<a href="http://www.public.asu.edu/~knguye12/">
			<button type = "button" style = "position:relative; left:325px"> Return to Home Page </button>
		</a>
		<img src = "http://www.public.asu.edu/~knguye12/Gear.png" onclick = "Cog()" width = "4%" style = "position:relative; top:10px; left:620px">
	</div>
</div>



<script type = "text/javascript">
	function RevertMiddlePane()
	{
		document.getElementById("MiddlePane").innerHTML = "";
		var MiddlePane = document.getElementById("MiddlePane");
		MiddlePane.style.width = "796px";
		MiddlePane.style.borderStyle = "solid";
		MiddlePane.style.borderTopWidth = "1px";
		MiddlePane.style.borderBottomWidth = "2px";
		MiddlePane.style.borderLeftWidth = "2px";
		MiddlePane.style.borderRightWidth = "2px";
		MiddlePane.style.textAlign = "center";
		MiddlePane.style.float = "left";

		var LeftPane = document.createElement("LeftPane");
		LeftPane.id = "LeftPane";
		LeftPane.style.width = "397px";
		LeftPane.style.height = "600px";
		LeftPane.style.borderStyle = "solid";
		LeftPane.style.borderTopWidth = "0px";
		LeftPane.style.borderBottomWidth = "0px";
		LeftPane.style.borderLeftWidth = "0px";
		LeftPane.style.borderRightWidth = "1px";
		LeftPane.style.float = "left";
		MiddlePane.appendChild(LeftPane);
		RevertLeftPane();

		var RightPane = document.createElement("RightPane");
		RightPane.id = "RightPane";
		RightPane.style.width = "397px";
		RightPane.style.height = "600px";
		RightPane.style.borderStyle = "solid";
		RightPane.style.borderTopWidth = "0px";
		RightPane.style.borderBottomWidth = "0px";
		RightPane.style.borderLeftWidth = "1px";
		RightPane.style.borderRightWidth = "0px";
		RightPane.style.float = "Right";
		MiddlePane.appendChild(RightPane);
		RevertRightPane();
	}

	function RevertLeftPane()
	{
		document.getElementById("LeftPane").innerHTML = "";
		var LeftPane = document.getElementById("LeftPane");

		var ButtonsPane = document.createElement("div");
		ButtonsPane.id = "ButtonsPane";
		ButtonsPane.style.width = "397px";
		ButtonsPane.style.height = "28px";
		ButtonsPane.style.backgroundColor = "#D0D0D0";
		ButtonsPane.style.textAlign = "center";
		ButtonsPane.style.float = "left";
		ButtonsPane.innerHTML = 
			  "<button onclick = 'AddEdit()' style = 'width:125px'> Add / Edit </button>"
			+ "<button onclick = 'ViewPrint()' style = 'width:125px'> View / Print </button>"
			+ "<button onclick = 'LoadSave()' style = 'width:125px'> Load / Save </button>";
		LeftPane.appendChild(ButtonsPane);

		var ActivitiesPane = document.createElement("div");
		ActivitiesPane.id = "ActivitiesPane";
		ActivitiesPane.style.overflow = "auto";
		ActivitiesPane.style.width = "397px";
		ActivitiesPane.style.height = "284px";
		ActivitiesPane.style.borderStyle = "solid";
		ActivitiesPane.style.borderTopWidth = "2px";
		ActivitiesPane.style.borderBottomWidth = "0px";
		ActivitiesPane.style.borderLeftWidth = "0px";
		ActivitiesPane.style.borderRightWidth = "0px";
		ActivitiesPane.style.textAlign = "center";
		ActivitiesPane.style.float = "left";
		ActivitiesPane.innerHTML = 
			  "<p> Activities Pane </p>"
			+ "<p> Activities Pane </p>"
			+ "<p> Activities Pane </p>"
			+ "<p> Activities Pane </p>"
			+ "<p> Activities Pane </p>"
			+ "<p> Activities Pane </p>"
			+ "<p> Activities Pane </p>"
			+ "<p> Activities Pane </p>"
			+ "<p> Activities Pane </p>"
			+ "<p> Activities Pane </p>";
		LeftPane.appendChild(ActivitiesPane);

		var HealthMeterPane = document.createElement("div");
		HealthMeterPane.id = "HealthMeterPane";
		HealthMeterPane.style.overflow = "auto";
		HealthMeterPane.style.width = "397px";
		HealthMeterPane.style.height = "284px";
		HealthMeterPane.style.borderStyle = "solid";
		HealthMeterPane.style.borderTopWidth = "2px";
		HealthMeterPane.style.borderBottomWidth = "0px";
		HealthMeterPane.style.borderLeftWidth = "0px";
		HealthMeterPane.style.borderRightWidth = "0px";
		HealthMeterPane.style.textAlign = "center";
		HealthMeterPane.style.float = "left";
		HealthMeterPane.innerHTML = 
			  "<p> Health Meter Pane </p>"
			+ "<p> Health Meter Pane </p>"
			+ "<p> Health Meter Pane </p>"
			+ "<p> Health Meter Pane </p>"
			+ "<p> Health Meter Pane </p>"
			+ "<p> Health Meter Pane </p>"
			+ "<p> Health Meter Pane </p>"
			+ "<p> Health Meter Pane </p>"
			+ "<p> Health Meter Pane </p>"
			+ "<p> Health Meter Pane </p>";
		LeftPane.appendChild(HealthMeterPane);
	}

	function RevertRightPane()
	{
		document.getElementById("RightPane").innerHTML = "";
		var RightPane = document.getElementById("RightPane");

		var PicturePane = document.createElement("div");
		PicturePane.id = "PicturePane";
		PicturePane.style.overflow = "auto";
		PicturePane.style.width = "397px";
		PicturePane.style.height = "300px";
		PicturePane.style.textAlign = "center";
		PicturePane.style.float = "left";
		PicturePane.innerHTML =
			  "<p></p>"
			+ "<img src = 'http://stubblemagdotcom.files.wordpress.com/2013/12/doge.png?w=788' width = '85%'>"
			+ "<p> Shibe says this is the Picture Pane</p>";
		RightPane.appendChild(PicturePane);

		var InfoPane = document.createElement("div");
		InfoPane.id = "InfoPane";
		InfoPane.style.overflow = "auto";
		InfoPane.style.width = "397px";
		InfoPane.style.height = "300px";
		InfoPane.style.textAlign = "center";
		InfoPane.style.float = "left";
		InfoPane.innerHTML =
			  "<p> Info Pane </p>"
			+ "<p> Info Pane </p>"
			+ "<p> Info Pane </p>"
			+ "<p> Info Pane </p>"
			+ "<p> Info Pane </p>"
			+ "<p> Info Pane </p>"
			+ "<p> Info Pane </p>"
			+ "<p> Info Pane </p>"
			+ "<p> Info Pane </p>"
			+ "<p> Info Pane </p>";
		RightPane.appendChild(InfoPane);
	}

	function AddEdit()
	{
		var Changes =  "<p> Add/Edit using Left Pane </p>"
		+ "<button onclick = 'RevertLeftPane()' style = 'width:125px'> Revert Left Pane </button>";
		var LeftPane = document.getElementById("LeftPane");
		LeftPane.style.textAlign = "center";
		LeftPane.innerHTML = Changes;
	}

	function ViewPrint()
	{
		var Changes =  "<p> View/Print using Left Pane </p>"
		+ "<button onclick = 'RevertLeftPane()' style = 'width:125px'> Revert Left Pane </button>";
		var LeftPane = document.getElementById("LeftPane");
		LeftPane.style.textAlign = "center";
		LeftPane.innerHTML = Changes;
	}

	function LoadSave()
	{
		var Changes =  "<p> Load/Save using Left Pane </p>"
		+ "<button onclick = 'RevertLeftPane()' style = 'width:125px'> Revert Left Pane </button>";
		var LeftPane = document.getElementById("LeftPane");
		LeftPane.style.textAlign = "center";
		LeftPane.innerHTML = Changes;
	}

	function Cog()
	{
		var Changes =  "<p> Customization using Middle Pane </p>"
		+ "<button onclick = 'RevertMiddlePane()' style = 'width:130px'> Revert Middle Pane </button>";
		var MiddlePane = document.getElementById("MiddlePane");
		MiddlePane.innerHTML = Changes;
	}
</script>
</body>
<html>