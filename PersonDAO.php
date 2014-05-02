<?php
/*
	PersonDAO is the model used for interacting with the 
	`Persons_Test_Table` and automatically populates an
	object if they exist within the database, getting
	and setting data by querying with a MysqliDAO object
*/
class PersonDAO{
		protected $username = "";
		protected $profile = array();
		protected $activities = array();
	
	/*
		__construct(String $username)
		
		Constructs a PersonDAO using a username
		that queries the database to create a
		populated object or a blank object to be
		added later into the table.
	*/
	public function __construct($username){
		$data = $this->person_getData($username);
		$this->person_setData($data);
	}
	
	/*
		person_getData(String $username)
		
		Creates a MySqliDAO and queries the database
		using the included username as input to determine
		if a user already exists, retrieving details about
		that user and returning it.
	*/
	private function person_getData($username){
		$output = NULL;
		try{
			$mysqli = new MySqliDAO();
			if($query = $mysqli->query("SELECT * FROM `Persons_Test_Table` WHERE `username`='" . $username. "'")){
				$output = $query->fetch_array();
			} else {
				echo("NO USERNAME FOUND WITH SUBMITTED: '" . $username . "'");
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
	private function person_setData($array){
		if(!empty($array) && is_array($array)){
			foreach($array as $key => $value){
				if(array_key_exists($key, $this->info)){
					$this->info[$key] = $value;
				}
			}
		}
	}
	
	public function upload_data(){
		
	}
}
?>