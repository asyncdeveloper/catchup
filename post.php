<?php
require_once("header.php");

$error_no = $_SERVER['QUERY_STRING'];

$url = str_replace( "url=","", $error_no) ;

if(!empty($url)){
    $url = sanitize_str($url) ;  // Current page
    if(!$url) redirect("../index.php");
}
else{
    redirect("../index.php");
}

$sql =  "SELECT * FROM pages  WHERE visible=1 AND friendly_url = '$url' ";
$articles = $post::find_by_sql($sql);

if(!$articles){
    $message= "No Posts Found";
}

?>
    <body>


    <?php if(!empty($message)) { ?>
        <div class="alert alert-info">
            <center><?php echo htmlentities($message);  ?></center>
        </div>


    <?php }?>


        <?php foreach($articles as $article): ?>
        <section class="site-content">
            <div class="post">
                <h1 class="post-title">
                    <?php
                    $title = strtoupper($article->page_name);
                    echo "{$title}<br>";
                    ?>
                </h1>

                <span class="post-info">
                    <span><i class="fa fa-user"></i>	 <?php echo $article->author ?></span>
                    <span><i class="fa fa-clock-o"></i>  <?php echo datetime_to_text_post( $article->date_created) ?></span>
                    <span><i class="fa fa-folder"></i>   <?php echo  $subjectx->get_subject_name_by_id($article->subject_id) ?>     </span>
                    <span><i class="fa fa-comments"></i> <?php echo Comment::number_of_comments($article->id); ?></span>
                </span>

                <div class="post-content">
                    <?php echo  $article->content ; ?>
                </div>
            </div>

        </section>

    <!--Form Processing-->

        <?php
            if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD']) {
                $author = $database->mysql_prep($_POST['author']);
                $body = $database->mysql_prep($_POST['body']);
                if(!preg_match('/\w/', $body))
                    $error = "Invalid Characters";
                if(empty($author)) $author = "Anonymous";
                    if(preg_match('/^[a-zA-Z0-9]/',$author)){

                        $new_comment = Comment::make($article->id,$author,$body);
                        if($new_comment && $new_comment->create() && empty($error)) {
                            redirect("$b/post/{$article->friendly_url}");
                        }else {
                            $error = "There was an error that prevented the comment from being saved.";
                        }
                    }
                $error= "Alphabets and numbers only";
            }

                $comments = Comment::find_comments_on($article->id);
        ?>
        
        <!--List Comments-->

        <section>
            <div id="comments">
                <?php foreach($comments as $comment): ?>
                    <div class="comment">

                        <div class="comment-author">
                            <?php
                                  echo  htmlentities($comment->author) ;
                            ?> wrote:
                        </div>

                        <div class="comment-body">
                            <?php echo strip_tags($comment->body, '<strong><em><p>'); ?>
                        </div>

                        <div class="comment-date">
                            <?php echo datetime_to_text($comment->date_created); ?>
                        </div>

                    </div>

                <?php endforeach; ?>
               <?php //if(empty($comments)) { echo "No Comments."; } ?>

            </div>
    </section>

<!--            Error Message -->

            <?php if(!empty($error)){ ?>
                <div class="alert alert-info">

                    <center><?php echo htmlentities($error); ?></center>
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>

        <!--Comment Form-->
            <div id="form-comment">
                <form method="post" onsubmit="document.getElementById('submit').disabled = true;" class="form-horizontal" action="<?php  echo "$b/post/{$article->friendly_url}"; ?>" >
                    <input type='hidden' name='token' value='<?= md5(uniqid()) ?>'/>
                    <div class="control-group">
                        <label class="control-label" for="inputName">Name</label>

                        <div class="controls">
                            <input type="text" class="form-control " value="<?php if(isset($author)) echo htmlentities($author); ?>" id="inputName" placeholder="Name" name="author">
                        </div>
                    </div>

                    <div class="comment-form-text">
                            <label for="comment">Your Comment: </label><br>
                                  <textarea id="textarea" name="body" cols="45" rows="8" maxlength="<?php echo 65525 ;?>" aria-required="true" class="form-control"  required="required"><?php if(isset($body)) echo htmlentities($body); ?></textarea>
                    </div>

                     <div class="form-footer">
                         <button name="submit" type="submit" class="btn btn-info">
                              <span class="glyphicon glyphicon-log-in"></span> Submit Comment
                         </button>
                    </div>


                </form>
        </div>

             <?php endforeach; ?>

</body>

<?php
    require_once('footer.php');
?>






