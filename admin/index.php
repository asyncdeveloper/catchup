<?php
require_once('../admin_header.php');


if(!$session->is_logged_in()) {
    redirect("login.php");
}

$error_no = $_SERVER['QUERY_STRING'];
echo $error_no;

$pag = str_replace( "page=","", $error_no);
$page = !isset($pag) ? sanitize($pag) : 1;  // Current age

    $total_count= $post::count_all();
    $pagination = new Pagination($page,$total_count);
    $sql = "SELECT * FROM pages LIMIT {$pagination->per_page} OFFSET {$pagination->offset()}";
    $articles = $post::find_by_sql($sql);

?>
<center><h2> Welcome To Admin Area </h2></center>

<ul>
    <li><a href="content.php"> Manage Website Content </li>
    <li><a href="signup.php"> Add Admin User   </li>
	
 </ul>






<?php
require_once('../footer.php');
?>
							  
					
