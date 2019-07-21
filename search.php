<?php
require_once("header.php");


if(isset($_POST['submit'])){
    $search = sanitize_search($_POST['search']);
    if(!$search) $message = "No Results Found";;
}else{
    $search = sanitize_search($_GET['search']);
    if(!$search) $message = "No Results Found";;
}

    $query = $database->build_query($search);   // Use function to build query

    $page = !empty($_GET['page']) ? sanitize_int($_GET['page']) : 1;  // Get Current page

    $total_count= $database->num_rows($database->query($query)); // query and get number of rows to know count
    $pagination = new Pagination($page,$total_count);
    $query.= " LIMIT {$pagination->per_page} OFFSET {$pagination->offset()}";
    $articles = $post::find_by_sql($query);
    if(!$articles){
         $message = "No Results Found";
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
                           echo "<h1 class=\"post-title page-header \"><a href=post/{$article->friendly_url}>$title</a></h1>";
                        ?>

                    <span class="post-info">
                        <span><i class="fa fa-user"></i>	 <?php echo $article->author ?></span>
                        <span><i class="fa fa-clock-o"></i>  <?php echo datetime_to_text_post( $article->date_created) ?></span>
                        <span><i class="fa fa-folder"></i>   <?php echo  $subjectx->get_subject_name_by_id($article->subject_id) ?></span>

                    </span>

                    <div class="post-content">
                        <?php echo   substr( $article->content, 0, 350 ) ; ?>
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
                    echo "<li class='previous pag-prev'><a href=search.php?search={$search}&page={$pagination->previous_page()}>Newer Posts &rarr;</a></li>";

                }

                if($pagination->has_next_page()) {
                    echo "<li class='next pag-next'><a href=search.php?search={$search}&page={$pagination->next_page()}> &larr; Older Posts</a></li>";
                }
            }
            ?>
        </ul>
    </nav>


</body>






<?php
require_once('footer.php');

?>