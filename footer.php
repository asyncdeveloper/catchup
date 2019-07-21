<section id="footer" class="footer alert alert-info">

    <?php echo "<strong>Copyright &copy;".date("Y",time())." CatchUp Inc. </strong>";
    if(isset($database)) $database->close_connection();
    ?>
    <div class="container">
        <div class="row  pad-bottom">
                            <strong> SOCIAL LINKS </strong>
                <p>
                    <a href="http://facebook.com/Sheyi98"><i class="fa fa-facebook-square fa-3x"></i></a>
                    <a href="http://twitter.com/sheyilaaw"><i class="fa fa-twitter-square fa-3x"></i></a>
                    <a href="#"><i class="fa fa-linkedin-square fa-3x"></i></a>
                    <a href="#"><i class="fa fa-google-plus-square fa-3x"></i></a>
                </p>
        </div>
    </div>
    </div>

</section>