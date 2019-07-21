<?php

require_once('initialize.php');

class MySQLDatabase {
    private $connection; 
    public  $last_query; 
    private $real_escape_string_exists;
    private $magic_quotes_active;
    function  __construct(){
        $this->open_connection();
        $this->magic_quotes_active = get_magic_quotes_gpc();
        $this->real_escape_string_exists = function_exists("mysqli_real_escape_string");      
    }

    public function open_connection(){
        $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die("Error Connecting to Database");
    }
	
    public function close_connection(){
        if(isset($this->connection)){
        mysqli_close($this->connection);
        unset($this->connection);
        }
    }
	
    public function query($sql){       
       $result = mysqli_query($this->connection,$sql);
       $this->confirm_query($result);     
       return $result;
    }
	
    public function mysql_prep($value){
        if($this->real_escape_string_exists){
          if($this->magic_quotes_active){
            $value = stripslashes($value);
          }  
            $value = mysqli_real_escape_string($this->connection,trim($value));
        }  else {
            if(!$this->magic_quotes_active){
                $value = addslashes($value);
            }
        }
        return $value;
    }
	
    public function fetch_array($result_set){
        return mysqli_fetch_array($result_set);
    }
    public function fetch_associate($result_set){
        return mysqli_fetch_assoc($result_set);
    }
    public function num_rows($result_set){
        return mysqli_num_rows($result_set);
    }
	
    public function insert_id(){
        return mysqli_insert_id($this->connection);
    }
	
    public function affected_rows(){
        return mysqli_affected_rows($this->connection);
    }
	
    private function confirm_query($result){
        if (!$result) {
            die("Database Query Failed : ". mysqli_error($this->connection));
        }
    }
	
	public function build_query($user_search) {
	$search_query = "SELECT * FROM pages";

    // Extract the search keywords into an array
    $clean_search = str_replace(',', ' ', $user_search);
    $search_words = explode(' ', $clean_search);
    $final_search_words = array();
    if (count($search_words) > 0) {
      foreach ($search_words as $word) {
        if (!empty($word)) {
          $final_search_words[] = $word;
        }
      }
    }

    // Generate a WHERE clause using all of the search keywords
    $where_list = array();
    if (count($final_search_words) > 0) {
      foreach($final_search_words as $word) {
        $where_list[] = "page_name LIKE '%$word%'";
		$where_list[] = "content LIKE '%$word%'";
      }
    }
    $where_clause = implode(' OR ', $where_list);

    // Add the keyword WHERE clause to the search query
    if (!empty($where_clause)) {
      $search_query .= " WHERE $where_clause";
      $search_query .= " AND  visible=1 ";

    }

    
      $search_query .= " ORDER BY date_created DESC";
    
	  

    return $search_query;
  }
	
   
}    
    $database = new MySQLDatabase();
    $db =& $database;
    
?>