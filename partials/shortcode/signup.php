<div class="cta" id="NewsletterForm">
	<article class="col-md-6 col-sm-6">
		<h3 class="cta-title">Sign Up for <span class="cursive">Sophie’s</span><br /> Weekly Dose of Goodness</h3>
		<form role="form" class="form" id="newsletter-frm-2" data-form="2" method="post" action="<?php echo bloginfo('template_directory');?>/partials/forms/newsletter.php">
			<div class="form-group">
				<label for="firstname">First Name <span class="required">*</span></label>
				<input type="text" name="firstname" id="firstname" placeholder="jane" class="form-control"/>
			</div>
			<div class="form-group">
				<label for="lastname">Last Name <span class="required">*</span></label>
				<input type="text" name="lastname" id="lastname" placeholder="doe" class="form-control"/>
			</div>
			<div class="form-group">
				<label for="emailaddress">Email <span class="required">*</span></label>
				<input type="email" name="emailaddress" id="emailaddress" placeholder="email@address.." class="form-control"/>
			</div>
			<div class="form-group">
				<button class="btn-custom btn-pink btn-submit">
					Subscribe
				</button>
			</div>
		</form>
	</article>
</div>