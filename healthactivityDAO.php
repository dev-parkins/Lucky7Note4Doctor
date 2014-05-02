<?php
	/*
		Author: Christopher Parkins
		Description: This file is used to serve as an intermediary between the controller and the database in order to 
					 avoid side effects that could result from directly querying the database.  This object will automatically
					 populate the values from the database which would be incorporated into a PersonDAO or other location.
	*/
	ini_set('display_errors', 'On'); // Allows errors to print to browser/console
	require_once('mysqliDAO.php'); // required for database connections
	
	HealthActivityDAOTest();
	function HealthActivityDAOTest(){
		$obj = new HealthActivityDAO("bob");
		print_r($obj); die();
	}
	
	
/*
	Activity is the model used for interacting with the 
	`n4d_healthindicators` table and automatically populates an
	object if they exist within the database, getting
	and setting data by querying with a MysqliDAO object
*/
class HealthActivityDAO{
	private $activities = array();
	private $uid;
	private $required = array(
		"date", "heart", "sbp", "dbp", "sugar", "sleep", "cardio", "strength",
	);
	
	/*
		__construct(String $uid)
		
		Constructs a ActivityDAO using a username
		that queries the database to create a
		populated object or a blank object to be
		added later into the table.
	*/
	public function __construct($uid){
		$this->uid = $uid;
		$data = $this->dbRetrieve($uid);
		echo("<pre>");print_r($data);
		if($data != NULL){
			$this->dbSet($data);
		}
	}
	
	/*
		dbRetrieve(String $uid)
		
		Creates a MySqliDAO and queries the database
		using the included username as input to determine
		if a user already exists, retrieving details about
		that user and returning it.
	*/
	private function dbRetrieve($uid){
		$output = NULL;
		
		try{
			$mysqli = new MySqliDAO();
			if($query = $mysqli->query("SELECT * FROM `n4d_healthactivity` WHERE `uid`='" . $uid. "'")){
				while($result = $query->fetch_assoc()){
					echo("<pre>"); print_r($result);
					$output[$result['date']] = $result;
				}
			} else {
				echo("<br>NO ACTIVITY DATA FOUND WITH uid SUBMITTED: '" . $uid . "'");
				return NULL;
			}
		} catch(Exception $e) {
			die("Exception caught in getData function with caught Exception:" . $e);
		}
		$mysqli->close();
		unset($mysqli);
		return $output;
	}
	
	/*
		dbSet(array $array)
		
		Used to set the data that is included as input
		and adds the data to the object if it is a key
		found in the field.
	*/
	private function dbSet($array){
		if(!empty($array) && is_array($array)){
			foreach($array as $key => $value){
				$this->activities[$key] = $value;
			}
		}
	}
	/*
		getActivities(void)
		
		Returns the activities array to the requestee in case
		they would rather work with the data directly.
	*/
	public function getActivities(){
		return $this->activities;
	}
}
?>