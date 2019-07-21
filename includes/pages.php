<?php

class Pages extends Subjects{
   public $id;
   public $subject_id;
   public $author;
   public $page_name;
   public $visible; 
   public $date_created;
   public $content; 
   public $friendly_url;
      	
    protected static $table_name="pages";
    protected static $db_fields=array('id', 'subject_id', 'author', 'page_name', 'visible','content','date_created','friendly_url');

    public function get_subject_name($subject_id){
        global $database;
        $sql= "SELECT friendly_url FROM subjects WHERE id=" . $subject_id . "";
        $result_set = $database->query($sql);
        $result = $database->fetch_array($result_set);
        return array_shift($result);

    }

    public function get_all_pages($public= false){
        global $database;
        $sql = "SELECT * FROM ".static::$table_name;
        if ($public) {
            $sql.= " WHERE visible = 1 ";
        }           
        $result_set = $database->query($sql);
        return $result_set;
    }

    public function get_pages_for_subject($subject_id){
        global $database;
        $sql= "SELECT * FROM ".static::$table_name ." WHERE subject_id=$subject_id ORDER BY position ASC ";
        $page_set = $database->query($sql);
        return $page_set;
    }
 
    public function get_page_by_id($page_id){
        global $database;   
        $sql= "SELECT * FROM pages WHERE id=" . $page_id . "";
        $result_set = $database->query($sql);
        if($result = $database->fetch_array($result_set)){
            return $result;
        }else{
            return NULL;
        }
    }
		
    public function find_selected_page(){        
        global $sel_page;
        if(isset($_GET['page']) ){
            $sel_page = $this->get_page_by_id($_GET['page']);
            
        }else {			
            $sel_page = NULL;
        }
    }

    public function get_subject_name_by_id($subject_id){
        global $database;
        $sql= "SELECT subject_name FROM subjects WHERE id='$subject_id'" ;
        $result_set = $database->query($sql);
        $result = $database->fetch_array($result_set);
        return array_shift($result);
    }
 
    public function table_page(){
		global $database;
		$output = "<div class=\"col-xs-12  col-med-12  col-lg-6     \">";
		$output.= "<table class=\"table table-bordered table-hover    \">";
		$output.="<thead class=\"success \"><tr  class=\"success  \"> <th>Title</th>  <th>Author</th>";
		$output.="<th>Visible</th> <th>Date Created</th> <th> Comments</th>  <th> Category </th>  </tr></thead>";
		$output.="<tbody><tr>";
		$page_set= $this->get_all_subjects($public=false);
		while($post = $database->fetch_array($page_set)){          
			$output.=  "<td class=\"success\"><a href=\"edit_page.php?page=".urlencode($post["id"])."\"> ";
			$output.=  "{$post['page_name']} </a></td>" ;
			$output.=  "<td  class=\"success  text-center  \"> {$post['author']} </td>" ;

			$output.=  "<td  class=\"success  text-center  \"> {$post['visible']} </td>" ;
			$output.=  "<td  class=\"success  text-center  \"> {$post['date_created']} </td>" ;
			$id = $post['id']; //Current page id
            $number = Comment::number_of_comments($id); //Get Number of comments for page
            $output.=  "<td  class='success text-center'> <a class='btn btn-primary btn-lg' href=\"comments.php?page=".urlencode($id)."\">" ;

            $output.= "<span class=\"badge\">{$number}</span>  </a></td>";
            $subject_id = (int) $post['subject_id'];
            $subj_name = $this->get_subject_name_by_id($subject_id);
            $output.=  "<td  class=\"success  text-center  \"> $subj_name </td>" ;
            $output.=  "</tr>";
		}   
			$output.="<tr class=\"danger\">   <td> <a href=\" ";
			$output.=  " " . (htmlentities('new_page.php'))  ." ";
			$output.= "  \">+ Add A New Page</a></td>  	<tr>	   
				</tbody></table> ";
			$output.=" </div>  ";
			return $output;
	}

    public function save(){
        return isset($this->id) ? $this->update() : $this->create();
	}
	
	public function remove(){
		return isset($this->id) ? $this->delete() : false;
	}  
		 	
    protected function create(){
        global $database;

        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO ".static::$table_name." (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";

		if($database->query($sql)){
			$this->id = $database->insert_id();
            if($this->set_permalink($this->page_name)){
                $link = "UPDATE ".static::$table_name." SET friendly_url = '{$this->friendly_url}' WHERE id = '{$this->id}' ";
                $database->query($link);
            }
			return true;
		}else{
			return false;
		}
	}
   
	protected function update(){
        global $database;
        $page_id =$this->id;
        $subject_id= $this->subject_id;
        $author = $this->author;
        $page_name = $this->page_name;
        $visible = $this->visible ;
        $content = $this->content;

        $sql = "UPDATE pages SET " ;
        $sql.= "subject_id='".$subject_id."',";
        $sql.= "author='". $author."',";
        $sql.= "page_name='".$page_name."',";
        $sql.= "visible='".$visible."',";
        $sql.= "content='".$content."'";
        $sql.= "WHERE id=CAST('$page_id' AS UNSIGNED) ";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false ;
		
	}	
	
	protected function delete(){
		global $database;	
		$t_page_id= $database->mysql_prep($this->id);
		$sql = "DELETE FROM ". static::$table_name;
		$sql.= " WHERE id=".$t_page_id;
		$sql.= " LIMIT 1 ";          
		$database->query($sql);
		return ($database->affected_rows() ==1 ) ? true : false ;
	}



 }	
	
   $post= new Pages();