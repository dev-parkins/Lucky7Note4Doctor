<?php
	/*
		MysqliDAO class used to automatically create
		a database object that uses a separate file
		with login credentials in order to hide sensitive
		information from implementation.
	*/
	class MysqliDAO extends mysqli{
		function __construct(){
			require('databaseCredentials.php'); // Contains login credentials for MySQL Server
			parent::__construct($login['host'],$login['username'],$login['password'], $login['database']); // Call mysqli constuctor and include login details
		}
	}
?>