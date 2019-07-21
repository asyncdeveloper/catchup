<?php
require_once('initialize.php');
class DatabaseObject{ //Late Static Binding

    protected static $table_name="catchup_user";
    
    public static function find_all(){        
        global $database;
        $result_set = $database->query("SELECT * FROM ".static::$table_name);
        return $result_set;
    }
	
    public static function find_by_id($id=0){
        $result_array =  static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE id={$id} LIMIT 1");
        return !empty($result_array) ? $result_array : false ;
    }
	
    public static function find_by_sql($sql=""){
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();
        while($row= $database->fetch_array($result_set)){
            $object_array[] = static::instantiate($row);
        }
        return $object_array;
    }

    public static function count_all() {
        global $database;
        $sql = "SELECT COUNT(*) FROM ".static::$table_name;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }
    public static function count_by_id($id) {
        global $database;
        $sql= "SELECT COUNT(*)FROM ".static::$table_name ." WHERE subject_id=$id";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }
	
    private static function instantiate($record){
        $class_name = get_called_class(); 
		$object = new $class_name;

        foreach($record as $attribute=>$value){
            if($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }
	
    private function has_attribute($attribute){
        $object_vars = get_object_vars($this);
        return array_key_exists($attribute, $this->attributes());
    }

    protected function attributes() {
        // return an array of attribute names and their values
        $attributes = array();
        foreach(static::$db_fields as $field) {
            if(property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }
	
	 protected function sanitized_attributes() {
        global $database;
        $clean_attributes = array();
        // sanitize the values before submitting
        // Note: does not alter the actual value of each attribute
        foreach($this->attributes() as $key => $value){
            $clean_attributes[$key] = $database->mysql_prep($value);
        }
        return $clean_attributes;
    }	
	
    
    public function validate_username($username){               
       global $database;       
       global $username_error; 
			if(empty($username)){
				return $username_error = "Username must be at least 6 characters";   
			}
            if(strlen($username) < 6 || empty($username) ){
                return $username_error = "Username must be at least 6 characters";                
            }
           else if(!preg_match('/^[a-zA-Z0-9]/',$username)){
                return  $username_error = "Only Alphabets and Digits are allowed ";
            }
            else if($username_error==" "){
                $sql = "SELECT * FROM catchup_user WHERE username = '$username'";
                $result_set = $database->query($sql);          
                if (!($database->num_rows($result_set)) == 0) {
                    return $username_error = "An account already exists for this username ";                	
                }
            }else{
               return  true;
            }
        
    }
    
    public function validate_email($email){
        global $database;
		global $email_error ;
        if(empty($email)){
             return $email_error = "Field is Required";
		}	
        else if(!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9\._\-&!?=#]*@/',$email)){
         return $email_error = "Invalid email format";
        }
        else if($email_error == " "){
            $sql = "SELECT * FROM catchup_user WHERE email  = '$email'";
            $result_set = $database->query($sql);          
            if (!($database->num_rows($result_set)) == 0) {
               return  $email_error = "An account already exists for this email ";                	
            }
        }else{
            return  true;
        }        
        
    }    
    
    public function validate_number($number){
      global $database;
      global $number_error;
     
        // check if number  is valid or not
		if(empty($number)){
			return  $number_error = "Enter A Number ";
		}
        else if (!preg_match('/^\d{11}/',$number)) {
            return  $number_error = "Invalid Number";
        }
        else if($number_error==" "){
            $sql = "SELECT * FROM catchup_user WHERE number  = '$number'";
            $result_set = $database->query($sql);          
            if (!($database->num_rows($result_set)) == 0) {
                return $number_error = "An account already exists for this number ";                	
            }
        }else {
            return true;
        }        
       
    }
    
    public function validate_password($password1,$password2){
        global $password_error;
        if(empty($password1) || empty($password2)){
                return $password_error = "Field Is Required";
        }
        else if((strlen($password1) < 6) || (strlen($password2) < 6)) {
           return  $password_error = "Password must be at least 6 characters";
        }
        else if ($password1 !== $password2){ 
            return $password_error = "Passwords do not Match";
        }
        else {
            return  true;
        }
        
    }
    
    public function validate_radio($radio){		
        global $network_error;
        if(empty($radio)){			
                return  $network_error = "Select a Valid Option";
        }	
        else{
                return true; 
        }

	 
    }

	
		
}

?>