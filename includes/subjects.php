<?php

class Subjects extends DatabaseObject{
    public $subject_name;
    public $position;
    public $visible;     
    public $subject_id;
    public $friendly_url;
	protected static $table_name="subjects";
    protected static $db_fields=array('id', 'subject_name','position','visible','friendly_url');

	public function friendly_seo_string($vp_string){
        $vp_string = trim($vp_string);

        $vp_string = html_entity_decode($vp_string);

        $vp_string = strip_tags($vp_string);

        $vp_string = strtolower($vp_string);

        $vp_string = preg_replace('~[^ a-z0-9_\.]~', ' ', $vp_string);

        $vp_string = preg_replace('~ ~', '-', $vp_string);

        $vp_string = preg_replace('~-+~', '-', $vp_string);

        return $vp_string;

    }

    public function set_permalink($subject){

        global $database;
        $query =  "SELECT * FROM ".static::$table_name." WHERE friendly_url = '' ";
        $result = $database->query($query);
        while($row = mysqli_fetch_assoc($result)){
			
            # get friendly url from title
            $new_friendly_url = $vl_url_string = $this->friendly_seo_string($subject);
            $counter = 1;
            $intial_friendly_url = $new_friendly_url;
            # while we not found unique friendly url
            $sql = "SELECT * FROM ".static::$table_name." WHERE friendly_url = '$new_friendly_url' ";
            while(mysqli_num_rows($database->query($sql))){
                  
                $counter++ ;
                # we reapeat this until url-2 url-3 url-4..... until we find not used url for articles
                $new_friendly_url = "{$intial_friendly_url}-{$counter}";
            }
           
            $this->friendly_url = $new_friendly_url ;
            return true;
        
		}
   
	

   }

    public function get_position($public=null){
		global $database;			
		$sql = "SELECT position FROM ".static::$table_name;
		$sql.= " ORDER BY position DESC ";            
		$result_set = $database->query($sql);
		$result_array = $database->fetch_array($result_set) ;
		$count = array_shift($result_array);		
			for($i=1;$i<=$count+1;$i++){
				echo "<option value=\"{$i}\"";				
				echo ">$i</option>";
			}									   
	}
	
	public function get_all_subject_name(){
		global $database;			
		$sql = "SELECT * FROM ".static::$table_name;
		$sql.= " ORDER BY position ASC ";            
		$result_set = $this->get_all_subjects();
		while ($rows=$database->fetch_array($result_set)) {
			extract($rows);			
			echo "<option value=\"{$id}\"";

			echo ">$subject_name </option>";				
		}    
    }
		
	public function get_all_subjects($public= false){
        global $database;
        $sql = "SELECT * FROM ".static::$table_name;
        if ($public) {
            $sql.= " WHERE visible = 1 ";
        }
                   
        $subject_set = $database->query($sql);
        return $subject_set;
    }

    public function get_subject_by_id($subject_id){
        global $database;
        $sql= "SELECT * FROM ".static::$table_name." WHERE id=" . $subject_id . "";
        $result_set = $database->query($sql);
        $result = $database->fetch_array($result_set);
        return $result;

    }

    public function get_subject_name_by_id($subject_id){
        global $database;
        $sql= "SELECT subject_name FROM ".static::$table_name." WHERE id=" . $subject_id . "";
        $result_set = $database->query($sql);
        $result = $database->fetch_array($result_set);
        return array_shift($result);
    }


    public function number_of_pages($subject_id){
        global $database;
        $sql= "SELECT * FROM pages WHERE subject_id=$subject_id ";
        $page_set = $database->query($sql);
        $number = $database->num_rows($page_set);
        return $number ;
        
    }

    public function table_subjects(){
    global $database;
    $output = "<div class=\"col-xs-12  col-med-12  col-lg-6 \">";
    $output.= "<table class=\"table table-bordered table-hover\">";
    $output.="<thead><tr  class=\"success\"> <th>Name </th> <th>Number of Pages</th>  <th>Position</th>
            <th>Visible</th></tr></thead><tbody>";               
    $output.="<tr>";
    $subject_set= $this->get_all_subjects();
    while($subject = $database->fetch_array($subject_set)){          
        $count = $this->number_of_pages($subject['id']);           
        $output.=  "<td  class=\"success\"> <a href=\"edit_subject.php?subj=".urlencode($subject["id"])."\">  ";                                                    
        $output.=  "{$subject['subject_name']} </a></td>" ;
        $output.=  "<td  class=\"success\"> {$count} </td>" ;
        $output.=  "<td  class=\"success\"> {$subject['position']} </td>" ;
        $output.=  "<td  class=\"success\"> {$subject['visible']} </td>" ;        
        $output.="</tr>";  
    }   
     $output.="<tr class=\"danger\">   <td> <a href=\" ";
     $output.=  " " . (htmlentities('new_subject.php'))  ." ";
     $output.= "  \">+ Add A New Subject</a></td>  	<tr>	   
        </tbody></table> ";
      $output.=" </div> ";
       return $output;
	}
		
    public function find_selected_subject(){
        global $sel_subject;
        if(isset($_GET['subj'])){
             $sel_subject = $this->get_subject_by_id($_GET['subj']) ;                
        }else{
            $sel_subject =NULL;                
        }
    }

	public function save(){
        return isset($this->subject_id) ? $this->update() : $this->create();
	}
	
	public function remove(){
		return isset($this->subject_id) ? $this->delete() : false;
	
	}  
		
    protected function create(){
        global $database;

        $sql = "INSERT INTO " . static::$table_name;
        $sql .= "(subject_name,position,visible";
        $sql .= ") VALUES ('";
        $sql .= $database->mysql_prep($this->subject_name) . "', '";
        $sql .= $database->mysql_prep($this->position) . "', '";
        $sql .= $database->mysql_prep($this->visible) . "')";

        if ($database->query($sql)) {
            $this->subject_id = $database->insert_id();
           if($this->set_permalink($this->subject_name)){
               $link = "UPDATE ".static::$table_name." SET friendly_url = '{$this->friendly_url}' WHERE id = '{$this->subject_id }' ";
               $database->query($link);
           }
            return true;
        }else{
            return false;
        }
    }
   
	protected function update(){
		global $database;	
		$subject_id= $this->subject_id;		
        $visible = $this->visible ;
		$position = $this->position;
        $subject_name = $this->subject_name;
		
		
        $sql = "UPDATE subjects SET " ;
		$sql.= "subject_name='". $subject_name."', ";
		$sql.= "position='". $position."', ";
		$sql.= "visible='". $visible  ."' ";
		$sql.= "WHERE id=CAST('$subject_id' AS UNSIGNED) ";
		
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false ;
				
	}
	
	protected function delete(){
		global $database;	
		$t_subject_id= $database->mysql_prep($this->subject_id);
		
		$sql = "DELETE FROM ". static::$table_name . " WHERE id={$t_subject_id} LIMIT 1";
				 
		$database->query($sql);
		return ($database->affected_rows() == 1 ) ? true : false ;
	}


}		

    

$subjectx = new Subjects();

?>