<?php
require_once("../../includes/admin_header.php");

if(!$session->is_logged_in()){
    redirect("login.php");
}
$page = !empty($_GET['page']) ? sanitize_int($_GET['page']) : 1;  // Current age

$articles = $post::find_by_id($page);

if(!$articles){
    redirect("/PhpProject/public/admin/index.php");
}

?>

<body>
<?php if(isset($message) && !empty($message)) {?>
    <div class="alert alert-success">
        <center><?php echo htmlentities($message); ?></center>
    </div>


<?php }?>

<?php foreach($articles as $article):?>
    <section class="site-content">
        <div class="post">
            <h1 class="post-title">
                <?php
                echo "{$article->page_name}<br>";
                ?>
            </h1>

            <span class="post-info">
                    <span><i class="fa fa-user"></i>	 <?php echo $article->author ?></span>
                    <span><i class="fa fa-clock-o"></i>  <?php echo $article->date_created ?></span>
                    <span><i class="fa fa-folder"></i>   <?php echo  $article->subject_id ?></span>
                </span>

            <div class="post-content">
                <?php echo  $article->content ; ?>
            </div>
        </div>

    </section>

    <!--Form Processing-->

    <?php
    if(isset($_POST['submit'])) {
        $author = trim($_POST['author']);
        $body = trim($_POST['body']);
        if(empty($author)) $author = "Anonymous";
        $new_comment = Comment::make($article->id,$author,$body);
        if($new_comment && $new_comment->create()) {
            redirect("/PhpProject/public/post/{$article->friendly_url}");
        }else {
            $message = "There was an error that prevented the comment from being saved.";
        }
    }else {
        $author = "";
        $body = "";
    }

          $comments = Comment::find_comments_on($article->id);
    ?>

    <!--List Comments-->

    <section>
        <div id="comments">
            <?php foreach($comments as $comment):
                ?>
                <div class="comment">

                    <div class="comment-author">
                        <?php
                        echo  htmlentities($comment->author) ;
                        ?> wrote:
                    </div>

                    <div class="comment-body">
                        <?php echo strip_tags($comment->body,'<strong><em><p>'); ?>
                    </div>

                    <div class="comment-date">
                        <?php echo datetime_to_text($comment->date_created); ?>
                    </div>

                    <div class="delete-comment">
                        <?php echo "<a href=delete_comment.php?id={$comment->id}&post={$article->id}> DeleteComment </a>"; ?>
                    </div>
                </div>

            <?php endforeach; ?>
            <?php //if(empty($comments)) { echo "No Comments."; } ?>

        </div>
    </section>

    <!--Comment Form-->
    <div id="form-comment">
        <form method="post" class="form-horizontal" action="<?php  echo "/PhpProject/public/post/{$article->friendly_url}"; ?>" >

            <div class="control-group">
                <label class="control-label" for="inputName">Name</label>

                <div class="controls">
                    <input type="text" class="form-control " value="<?php if(isset($author)) echo htmlentities($author); ?>" id="inputName" placeholder="Name" name="author">
                </div>
            </div>

            <div class="comment-form-text">
                <label for="comment">Your Comment: </label><br>
                <textarea id="textarea" name="body" cols="45" rows="8" maxlength="65525" aria-required="true" class="form-control"  required="required"><?php if(isset($body)) echo htmlentities($body); ?></textarea>
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
require_once(LIB_PATH.DS.'footer.php');
?>






