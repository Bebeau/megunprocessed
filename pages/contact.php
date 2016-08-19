<?php 

/*
Template Name: Contact
*/

get_header(); ?>

	<div class="container single-page">

		<div class="row">

			<div class="col-sm-8">

				<div class="single-content">

					<h1><?php the_title(); ?></h1>

					<?php the_content(); ?>

					<form role="form" method="POST" action="<?php echo bloginfo('template_directory');?>/partials/forms/contact.php" id="contactfrm">
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
							<button type="submit" class="btn btn-submit">Submit</button>
						</div>
						<input type="hidden" name="password" id="password" val="" />
					</form>

				</div>

			</div>

			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div>

		</div>

	</div>

<?php get_footer(); ?>