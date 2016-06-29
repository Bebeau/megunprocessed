<?php

	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
?>

<div id="Comments">

<!-- If a password is required -->
<?php if(!empty($post->post_password)) : ?>  
    <?php if($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>  
    	<div class="alert alert-warning"><?php _e("This post is password protected. Enter the password to view comments."); ?></div>
    <?php endif; ?>  
<?php endif; ?> 

<?php if($comments) : ?>  
    <ul class="list-unstyled commentlist">  
    <?php foreach($comments as $comment) : ?>  
        <li class="comment">  
            <?php if($comment->comment_approved == '0') : ?>  
                <p class="alert alert-success">Your comment is awaiting approval</p>  
            <?php endif; ?>
            <div class="row">
            	<div class="col-md-2">
            		<div class="userimage">
	            		<?php 
							if(function_exists('get_avatar')) {
								echo get_avatar( $comment, 100 );
							} else { ?>
								<img src="<?php bloginfo("template_directory"); ?>/assets/img/ProfilePlaceholder.jpg" alt="Profile" />
							<?php }
						?>
					</div>
            	</div>
            	<div class="col-md-10">
            		<div class="row userinfo">
            			<div class="col-md-6 author">
	            			<strong><?php comment_author_link(); ?></strong> said...
	            		</div>
	            		<div class="col-md-6 timestamp">
	            			<?php comment_date(); ?> @ <?php comment_time(); ?>
	            		</div>
            		</div>
            		<div class="row">
            			<div class="col-md-12">
           					<?php comment_text(); ?>
           				</div>
           			</div>
           		</div>
           	</div>
        </li>  
    <?php endforeach; ?>  
    </ul>  

<?php else : ?>  
    <p class="alert alert-warning">There are currently no comments for this article. Feel free to leave one below!</p>  
<?php endif; ?>

</div>

<?php if ( comments_open() ) : ?>

<section id="respond" class="respond-form">

	<h4 id="comment-form-title"><?php comment_form_title( __("Leave a Reply"), __("Leave a Reply to") . ' %s' ); ?></h4>

	<div id="cancel-comment-reply">
		<p class="small"><?php cancel_comment_reply_link( __("Cancel") ); ?></p>
	</div>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
	  	<div class="help">
	  		<p><?php _e("You must be"); ?> <a href="<?php echo wp_login_url( get_permalink() ); ?>"><?php _e("logged in"); ?></a> <?php _e("to post a comment"); ?>.</p>
	  	</div>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" class="form-vertical clearfix" id="commentform">

		<?php if ( is_user_logged_in() ) : ?>

			<p class="comments-logged-in-as">
				<?php _e("Logged in as"); ?> <strong><?php echo $user_identity; ?></strong>.
				<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e("Log out of this account"); ?>"><?php _e("Log out"); ?> &raquo;</a>
			</p>

		<?php else : ?>
		
			<ul id="comment-form-elements" class="clearfix row list-unstyled">
				
				<li class="col-md-4 form-group">
					<label for="author"><?php _e("Name"); ?> <?php if ($req) echo '<span class="required">*</span>'; ?></label>
					<div class="input-group">
					  	<div class="input-group-addon">
					  		<i class="fa fa-user"></i>
					  	</div>
					  	<input type="text" name="author" id="author" class="form-control" value="" placeholder="<?php _e("Your Name"); ?>" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
				  	</div>
				</li>
				
				<li class="col-md-4 form-group">
					<label for="email"><?php _e("Email"); ?> <?php if ($req) echo '<span class="required">*</span>'; ?></label><span class="help-inline"><?php _e("will not be published"); ?></span>
					<div class="input-group">
					  	<div class="input-group-addon">
					  		<i class="fa fa-envelope"></i>
					  	</div>
					  	<input type="email" name="email" class="form-control" id="email" value="" placeholder="<?php _e("Your Email"); ?>" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
				  	</div>
				</li>
				
				<li class="col-md-4 form-group">
					<label for="url"><?php _e("Website"); ?></label>
					<div class="input-group">
					  <div class="input-group-addon">
					  	<i class="fa fa-home"></i>
					  </div>
					  <input type="url" name="url" id="url" class="form-control" value="" placeholder="<?php _e("Your Website"); ?>" tabindex="3" />
				  	</div>
				</li>
				
			</ul>

		<?php endif; ?>
		
		<div class="clearfix">
			<div class="input form-group">
				<textarea name="comment" class="form-control" id="comment" placeholder="<?php _e("Your Comment Here…"); ?>" tabindex="4"></textarea>
			</div>
		</div>
		
		<div class="form-actions">
		  <input class="btn btn-primary btn-large btn-block" name="submit" type="submit" id="submit" tabindex="5" value="<?php _e("Submit Comment"); ?>" />
		  <?php comment_id_fields(); ?>
		</div>
		
		<?php 
			//comment_form();
			do_action('comment_form', $post->ID); 
		?>
	
	</form>
	
	<?php endif; // If registration required and not logged in ?>
	
</section>

<?php endif; // if you delete this the sky will fall on your head ?>