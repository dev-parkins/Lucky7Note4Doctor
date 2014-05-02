<?php
	ini_set('display_errors', 'On'); // Allows errors to print to browser/console
	require_once('mysqliDAO.php'); // required for database connections
	
	HealthActivityDAOTest();
	function HealthActivityDAOTest(){
		$obj = new HealthActivityDAO("bob");
		print_r($obj); die();
	}
	
	
/*
	Activity is the model used for interacting with the 
	`n4d_activities` table and automatically populates an
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
		__construct(String $username)
		
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
		activity_getData(String $username)
		
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
		person_setData(String $username)
		
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
	
	public function getActivities(){
		return $this->activities;
	}
}
?>