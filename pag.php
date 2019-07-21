<?php
require_once("header.php");

$error_no = $_SERVER['QUERY_STRING'];
$page = str_replace( "page=","", $error_no) . "<br>";
if(!empty($page)){
    $page = sanitize_int($page) ;  // Current page
    if(!$page) $page = 1;
}
else{
    $page = 1;
}


$total_count= $post::count_all();

$pagination = new Pagination($page,$total_count);
$sql = "SELECT * FROM pages WHERE visible=1 ORDER BY date_created DESC LIMIT {$pagination->per_page} OFFSET {$pagination->offset()}";
$articles = $post::find_by_sql($sql);

if(!$articles){
    $message= "No Posts Found";
}
?>


<?php if(!empty($message)) { ?>
    <div class="alert alert-info">
        <center><?php echo htmlentities($message);  ?></center>
    </div>


<?php }?>


<?php foreach($articles as $article){ ?>
    <section class="site-content">
        <div class="post">
            <h1 class="post-title">

                <?php
 $title = strtoupper($article->page_name);
                     echo "<a href=../post/{$article->friendly_url}>$title</a>";
                ?>

            </h1>

            <span class="post-info">
                        <span><i class="fa fa-user"></i>	 <?php echo $article->author ?></span>
                        <span><i class="fa fa-clock-o"></i>  <?php echo datetime_to_text_post( $article->date_created) ?></span>
                        <span><i class="fa fa-folder"></i>   <?php echo  $subjectx->get_subject_name_by_id($article->subject_id) ?></span>
                    </span>

            <div class="post-content">
                <?php echo  substr($article->content, 0, 350) ; ?>
            </div>


            <div class="btn-read-more">
                <?php
                    echo "<a href=../post/{$article->friendly_url}>Continue Reading</a>";
                ?>
            </div>

        </div>

    </section>

<?php } ?>



<!--    Pagination links-->

    <ul class="pager">

    <?php
       if($pagination->total_pages() > 1) {
         if($pagination->has_previous_page()) {
               echo "<li class='previous pag-prev'><a href=../page/{$pagination->previous_page()}> Newer Posts</a></li>";
          }
          if($pagination->has_next_page()) {
              echo "<li class='next pag-next'><a href=../page/{$pagination->next_page()}> Older Posts</a></li>";
         }
      }

    ?>

    </ul>


</body>
<?php
require_once('footer.php');

?>