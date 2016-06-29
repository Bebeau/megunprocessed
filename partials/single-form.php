<form method="POST" action="" role="form" id="SubmissionForm">
	<section class="form-group">
		<article class="first-name half">
			<label for="fname">
				First Name
			</label>
			<input type="text" name="fname" id="fname" placeholder="jane" />
		</article>
		<article class="last-name half">
			<label for="lname">
				Last Name
			</label>
			<input type="text" name="lname" id="lname" placeholder="doe" />
		</article>
	</section>
	<section class="form-group">
		<article class="birthday">
			<label for="birthday">
				Birthday
			</label>
			<input type="text" name="birthday" id="birthday" placeholder="00/00/0000" />
		</article>
	</section>
	<section class="form-group">
		<article class="emailaddress">
			<label for="emailaddress">
				Email Address
			</label>
			<input type="email" name="emailaddress" id="emailaddress" placeholder="email@address..." />
		</article>
	</section>
	<section class="form-group">
		<article class="country">
			<label for="country">
				Country
			</label>
			<input type="text" name="country" id="country" value="United States" class="disabled" disabled />
		</article>
	</section>
	<section class="form-group">
		<article class="terms">
			<label for="agree">
				<input type="checkbox" name="agree" id="agree" checked />
				I agree to the <a href="http://www.hallmarkchannel.com/crown-media-family-networks-terms-of-use" target="_blank">Terms of Use</a>.
			</label>
		</article>
	</section>
	<section class="form-group">
		<button class="submit-button">Enter Giveaway</button>
	</section>
	<?php wp_nonce_field( 'entry_meta_box_nonce','entry_meta_box_nonce' ); ?>
	<input type="hidden" name="postID" id="postID" value="<?php echo $post->ID; ?>" />
	<input type="hidden" name="winner" id="winner" value="0" />
	<input type="hidden" name="sent" id="sent" value="0" />
	<input type="hidden" name="shipped" id="shipped" value="0" />

	<input type="hidden" name="address" id="address" />
	<input type="hidden" name="address2" id="address2" />
	<input type="hidden" name="city" id="city" />
	<input type="hidden" name="state" id="state" />
	<input type="hidden" name="zip" id="zip" />
	
</form>