<?php

	require_once('dbconn.php');

	$q = intval($_POST['q']);

	$sql="SELECT * FROM user_profile WHERE id = '".$q."'";

	$result = mysqli_query($con,$sql);
	$out = '';

	//$out = "<table border='0'>";
	// <tr>
	// <th>Firstname</th>
	// <th>Lastname</th>
	// <th>Height</th>
	// <th>Weight</th>
	// <th>DoB</th>
	// <th>Age</th>
	// </tr>";

	while($row = mysqli_fetch_array($result))
	  {
	  //$out .= "<tr>";
	  //$out .= "<td>" . $row['firstName'] . "</td>";
	  //$out .= "<td>" . $row['lastName'] . "</td>";
	  //$out .= "<td>Welcome " . $row['lastName'] .", " .$row['firstName']. "</td>";
	  //$out .= "<td>" . $row['height'] . " cms.</td>";
	  //$out .= "<td>" . $row['weight'] . " kgs.</td>";
	  //$out .= "<td>" . $row['dob'] . "</td>";
	  
	  $out .= "Welcome " . $row['lastName'] .", " .$row['firstName'];
	  
	  $dob = new DateTime($row['dob']);
	  $age = $dob->diff(new DateTime);
	  
	  //$out .= "<td>" . $age->y . "</td>";
	  //$out .= "</tr>";
	  }
	//$out .= "</table>";

	echo $out;
	mysqli_close($con);

?>