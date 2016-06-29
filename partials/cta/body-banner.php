<?php 
	$FullWidthImage = get_option('sophie_horizontalImage');

	if(!empty($FullWidthImage)) {
?>
	<div class="fw-CTA cta" style="background: url('<?php echo $FullWidthImage; ?>') no-repeat scroll top left / cover #1e2015;">
<?php } else { ?>
	<div class="fw-CTA cta">
<?php } ?>
		<article class="col-md-8 col-sm-6">
			<h3 class="cta-title">Sign Up for <span class="cursive">Sophie’s</span> Weekly Dose of Goodness</h3>
			<form role="form" class="form" id="newsletter-frm-2" data-form="2" method="post" action="<?php echo bloginfo('template_directory');?>/partials/forms/newsletter.php">
				<div class="row">
					<div class="form-group col-md-4">
						<label for="firstname_2">First Name <span class="required">*</span></label>
						<input type="text" name="firstname" id="firstname" placeholder="jane" class="form-control"/>
					</div>
					<div class="form-group col-md-4">
						<label for="lastname_2">Last Name <span class="required">*</span></label>
						<input type="text" name="lastname" id="lastname" placeholder="doe" class="form-control"/>
					</div>
					<div class="form-group col-md-4">
						<label for="emailaddress_2">Email <span class="required">*</span></label>
						<input type="email" name="emailaddress_2" id="emailaddress_2" placeholder="email@address.." class="form-control"/>
					</div>
				</div>
				<div class="form-group">
					<button class="btn-custom btn-pink btn-submit">
						Subscribe
					</button>
				</div>
			</form>
		</article>
	</div>