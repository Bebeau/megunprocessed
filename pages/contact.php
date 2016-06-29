<?php 

/*
Template Name: Contact
*/

get_header('single'); ?>

<div class="container contact">
	<div class="post-header">
		<h1>Contact <span class="cursive">Sophie</span></h1>
	</div>
	<div class="row">
		<?php
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'large' ); 
			if ($image) {
				echo '<div class="col-sm-2 featured-image side hidden-xs" style="background: url('.$image[0].') no-repeat scroll center / cover; "></div>';
			} else {
				echo '<div class="col-sm-2 featured-image post-image default-image side hidden-xs"></div>';
			} 
		?>
		<div class="col-sm-6 side copy">
			<?php the_content(); ?>
		</div>
		<div class="col-sm-4 side copy contact-form">
			<form role="form" method="POST" action="<?php echo bloginfo('template_directory');?>/partials/forms/contact.php" id="contactfrm">
				<div class="">
					<div class="btn-group">
						<button type="button" class="btn btn-blue btn-block btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Contact Me <span><i class="fa fa-caret-down"></i></span>
						</button>
						<ul class="dropdown-menu">
							<li data-interest="Giveaways">Product Reviews</li>
							<li data-interest="Speaking">Speaking</li>
							<li data-interest="Videos">Videos</li>
							<li data-interest="Broadcast Media">Broadcast Media</li>
							<li data-interest="Giveaways">Giveaways</li>
						</ul>
					</div>
					<input type="hidden" name="interest" id="interest" />
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label for="firstname" class="control-label">First Name <span class="required">*</span></label>
						<input type="text" name="firstname" id="firstname" class="form-control" placeholder="jane"/>
					</div>
					<div class="form-group col-sm-6">
						<label for="lastname" class="control-label">Last Name <span class="required">*</span></label>
						<input type="text" name="lastname" id="lastname" class="form-control" placeholder="doe"/>
					</div>
				</div>
				<div class="form-group">
					<label for="emailaddress" class="control-label">Email <span class="required">*</span></label>
					<input type="text" name="emailaddress" id="emailaddress" class="form-control" placeholder="email@address.." />
				</div>
				<div class="form-group">
					<label for="message" class="control-label">Message <span class="required">*</span></label>
					<textarea type="text" name="message" id="message" class="form-control" placeholder="How can I help?"></textarea>
				</div>
				<div class="form-group">
					<button type="submit" class="btn-custom btn-pink btn-submit">Submit</button>
				</div>
				<input type="hidden" name="password" id="password" val="" />
			</form>
		</div>
	</div>
</div>

<?php get_footer(); ?>