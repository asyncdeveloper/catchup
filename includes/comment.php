<?php
class Comment extends Pages{
    protected static $table_name= "comments";
    protected static $db_fields=array('id', 'page_id', 'date_created', 'author', 'body');
    public $id;
    public $page_id;
    public $date_created;
    public $author;
    public $body;

    public static function number_of_comments($page_id){
        global $database;
        $sql = "SELECT COUNT(*) FROM " .static::$table_name;
        $sql.= " WHERE page_id='$page_id'" ;
        $result = $database->query($sql);
        $count = $database->fetch_array($result);
        return !empty($result) ? array_shift($count) : false ;

    }

    public static function make($page_id, $author, $body="") {
        if(!empty($page_id)  && !empty($author) && !empty($body)) {
            $comment = new Comment();
            $comment->page_id = (int)$page_id;
            $comment->date_created = strftime("%Y-%m-%d %H:%M:%S", time());
            $comment->author = $author;
            $comment->body = $body;
            return $comment;
        } else {
            return false;
        }
    }

    public static function find_comments_on($page_id=0) {

        $id=$page_id;
        $sql = "SELECT * FROM " .static::$table_name;
        $sql.= " WHERE page_id='$id'" ;

        return static::find_by_sql($sql);
    }

    public function remove(){
        return isset($this->id) ? $this->delete() : false;
    }

    public function create(){
        global $database;
        $sql = "INSERT INTO ". static::$table_name;;
        $sql.= "(page_id,date_created,author,body";
        $sql.= ") VALUES ('";
        $sql.= $database->mysql_prep($this->page_id) . "', '";
        $sql.= $database->mysql_prep($this->date_created) ."', '";
        $sql.= $database->mysql_prep($this->author) ."', '";
        $sql.= $database->mysql_prep($this->body) ."')" ;

        if($database->query($sql)){
            $this->id = $database->insert_id();
            return true;
        }else{
            return false;
        }
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