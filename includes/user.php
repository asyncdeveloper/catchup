<?php
require_once('initialize.php');  

class User extends DatabaseObject {
    protected static $table_name="catchup_user";
    protected static $db_fields = array('user_id', 'username', 'password', 'email', 'number','network');

    public $user_id;
    public $username;
    public $password;
    public $email;
    public $number;
    public $network;

    protected function attribute(){
        return get_object_vars($this);
    }

	public static function authenticate($username="",$password=""){
		global $database;               
        //Trim Data
		$t_username = $database->mysql_prep($username);		
		$t_password = $database->mysql_prep($password);	
		$sql = "SELECT * FROM ".static::$table_name." WHERE username = '$t_username' AND password = SHA('$t_password') LIMIT 1";
        $result_array = static::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
	}
	        
	public function save(){
        return isset($this->user_id) ? $this->update() : $this->create();
	}

    protected function sanitized_attributes() {
        global $database;
        $clean_attributes = array();
        // sanitize the values before submitting
        // Note: does not alter the actual value of each attribute
        foreach($this->attributes() as $key => $value){
            $clean_attributes[$key] = $value;
        }
        return $clean_attributes;
    }

	protected function create(){
		global $database;
        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO ".static::$table_name." (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";
        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }
	
	protected function update(){
		global $database;	
        //Trim Data
        $t_username = $database->mysql_prep($this->username);
        $t_password = $database->mysql_prep($this->password);
        $t_email = $database->mysql_prep($this->email);
        $t_number = $database->mysql_prep($this->number);
        $t_network = $database->mysql_prep($this->network);
        $t_user_id= $database->mysql_prep($this->user_id);
        //Hash Password
        $hashed_password = sha1($t_password);

        $sql = "UPDATE catchup_user SET " ;
		$sql.= "username='". $t_username."', ";
		$sql.= "password='". $hashed_password."', ";
		$sql.= "email='". $t_email ."', ";
		$sql.= "number='".$t_number ."', ";
		$sql.= "network='". $t_network  ."' ";
		$sql.= "WHERE user_id=$t_user_id ";
		
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false ;
				
	}
	
	protected function delete(){
            global $database;	
            $t_user_id= $database->mysql_prep($this->user_id);
               
            $sql = "DELETE FROM ". static::$table_name;
            $sql.= " WHERE user_id=".$t_user_id;
            $sql.= " LIMIT 1 ";          
	    $database->query($sql);
            return ($database->affected_rows() ==1 ) ? true : false ;
	}
       
	public function kill(){
		 return isset($this->user_id) ? $this->delete() : false;
	
	
	}
}
