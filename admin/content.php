<?php

require_once('../admin_header.php');


if(!$session->is_logged_in()){
	redirect("login.php");
}
$subjectx->find_selected_subject();
?>
<body>

<?php if(isset($message) && !empty($message)) { ?>
    <div class="alert alert-info">
            <center><?php echo htmlentities($message); ?></center>
    </div>


<?php }?>
	<div class="container">
			<div class="row">   
	   
				<?php 		
					echo $subjectx->table_subjects();  
					echo $post->table_page();	  
				?>  
			</div>
		</div>
	</body>

    <?php
    require_once('../footer.php');
    ?>

