<?php
require_once("header.php");
if(!empty($_GET['page'])){
    $page = sanitize_int($_GET['page']) ;  // Current page
    if(!$page) $page = 1;
}
else{
    $page = 1;
}

$total_count= $post::count_all();
$pagination = new Pagination($page,$total_count);
$sql = "SELECT * FROM pages WHERE visible=1 ORDER BY date_created DESC LIMIT 10 ";
$articles = $post::find_by_sql($sql);
if(!$articles){
    $message = "No Posts Found";
}
?>

<body>

<?php if(!empty($message)) { ?>
    <div class="alert alert-info">
        <center><?php echo htmlentities($message); ?></center>
    </div>


<?php }?>


<?php foreach($articles as $article){ ?>
    <section class="site-content">
        <div class="post">

            <?php
            $title = strtoupper($article->page_name);
            echo "<h1 class=\"post-title page-header \"><a href=post/{$article->friendly_url}>  $title</a></h1>";

            ?>

            <span class="post-info">
                        <span><i class="fa fa-user"></i>	 <?php echo $article->author ?></span>
                        <span><i class="fa fa-clock-o"></i>  <?php echo datetime_to_text_post( $article->date_created) ?></span>
                        <span><i class="fa fa-folder"></i>   <?php echo  $subjectx->get_subject_name_by_id($article->subject_id) ?></span>

                    </span>

            <div class="post-content">
                <?php echo   substr(($article->content), 0, 350) ; ?> ....
            </div>


            <div class="btn-read-more">
                <?php
                echo "<a href=post/{$article->friendly_url}>Continue Reading</a>";
                ?>
            </div>

        </div>

    </section>
<?php } ?>


<!--    Pagination links-->

<nav class="pagination" role="navigation">
    <ul class="pager">
        <?php
        if($pagination->total_pages() > 1) {
            if($pagination->has_previous_page()) {
                echo "<li class='previous pag-prev'><a href=page/{$pagination->previous_page()}>Newer Posts &rarr;</a></li>";
            }

            if($pagination->has_next_page()) {
                echo "<li class='next pag-next'><a href=page/{$pagination->next_page()}> &larr; Older Posts</a></li>";
            }
        }
        ?>
    </ul>
</nav>


</body>


<?php
require_once('footer.php');

?>





