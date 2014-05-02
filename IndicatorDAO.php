<?php
	/*
		Author: Christopher C Parkins
		Description: <Unused> This file is used to pull in health indications that are given
					 by the user and pulled from the n4d_indicators table.
	*/
	ini_set('display_errors', 'On'); // Allows errors to print to browser/console
	indicDAOTest();
	function indicDAOTest(){
		$obj = new IndicatorDAO("bob");
		$obj->newIndicator(array("n4d_user" => "bob", "indic_name" => "Running", "indic_value" => "21", "timestamp" => time()));
		print_r($obj); die();
	}
	
	
/*
	IndicatorDAO is the model used for interacting with the 
	`n4d_indicators` table and automatically populates an
	object if they exist within the database, getting
	and setting data by querying with a MysqliDAO object
*/
class IndicatorDAO{
	private $owner = NULL;
	protected $indicators = array();
	private $required = array(
		"indic_name", "indic_value", "timestamp"
	);
	
	/*
		__construct(String $username)
		
		Constructs a IndicatorDAO using a username
		that queries the database to create a
		populated object or a blank object to be
		added later into the table.
	*/
	public function __construct($username){
		try{
			if($username != NULL AND !empty($username)){
				$this->owner = $username;
			} else {
				throw new Exception("Missing required username, NULL or EMPTY GIVEN.");
			}
		} catch(Exception $e){
			print_r($e);
		}
		
		$data = $this->dbRetrieve($username);
		echo("<pre>");print_r($data);
		if($data != NULL){
			$result = $this->dbSet($data);
			if($result == TRUE){
				echo("<br>New IndicatorDAO created successfully!");
			} else {
				echo("<br>Error in dbSet function");
			}
			
		}
	}
	
	/*
		dbRetrieve(void)
		
		Creates a MySqliDAO and queries the database
		using the included username as input to determine
		if a user already exists, retrieving details about
		that user and returning it.
		
		returns Error or output from database
	*/
	private function dbRetrieve(){
		$output = NULL;
		
		try{
			$mysqli = new MysqliDAO();
			print_r($mysqli);
			echo("SELECT * FROM `n4d_indicators` WHERE `n4d_user`='" . $this->owner. "'");
			if($query = $mysqli->query("SELECT * FROM `n4d_indicators` WHERE `n4d_user`='" . $this->owner. "'") && $mysqli->affected_rows > 0){
				while($result = $query->fetch_assoc()){
					echo("<pre>"); print_r($result);
					$output[$result['aid']] = $result;
				}
			} else {
				echo("<br>NO INDICATOR DATA FOUND WITH USERNAME SUBMITTED: '" . $this->owner . "'");
				return NULL;
			}
		} catch(Exception $e) {
			die("Exception caught in dbRetrieve function with caught Exception:" . $e);
		}
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
				$this->indicators[$key] = $value;
			}
		}
	}
	
	/*
		newIndicator(array $array)
		
		Is used to populate a new entry that will be inserted
		into the database and must have all fields to
		successfully be pushed.
		
		Returns TRUE or FALSE
	*/
	public function newIndicator($array){
		if(!empty($array) && is_array($array)){
			$newArray = array();
			foreach($this->required as $key => $value){
				if(!array_key_exists($value, $array)){
					echo("Missing required property to create new indicator object: " . $value . "<br>");
					return FALSE;
				} else {
					$newArray[$value] = $array[$value];
				}
			}
			
			try{
				array_push($this->indicators, $newArray);
				$mysqli = new MysqliDAO();
				echo("INSERT INTO `n4d_indicators` VALUES (" . $newArray['timestamp'] . ", " . $this->owner . ", " . $newArray['indic_name'] . ", " . $newArray['indic_value'] . ")");
				$query = $mysqli->query("INSERT INTO `db_indicators` (" . $newArray['timestamp'] . ", " . $this->owner . ", " . $newArray['indic_name'] . ", " . $newArray['indic_value'] . ")");
				//die("HERE'S STUFF::::: " . print_r($query, TRUE));
				return TRUE;
			} catch(Exception $e){
				print_r($e);
				return FALSE;
			}
		}
	}
}
?>