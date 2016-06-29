<?php 
	if(has_post_thumbnail()) {
		$postImage = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), 'large', false ); 
	} else { 
		$postImage = get_bloginfo('template_directory').'/assets/images/default_facebook.jpg'; 
	};
?>

<div class="social-share">
	<div class="share-text">Share with your friends &amp; followers!</div>
	<!-- Facebook (url) -->
	<a target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" class="facebook">
	    <i class="fa fa-facebook"></i>
	</a>
	<!-- Twitter (url, text, @mention) -->
	<a class="twitter" target="_blank" href="http://twitter.com/share?url=<?php the_permalink(); ?>&text=Thanks to this, I'm one step closer to a Gorgeously Green Life - &via=sophieuliano">
	    <i class="fa fa-twitter"></i>
	</a>
	<!-- Google Plus (url) -->
	<a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $postImage; ?>&description=<?php echo strip_tags(get_the_excerpt()); ?>" class="pinterest" count-layout="horizontal">
	    <i class="fa fa-pinterest"></i>
	</a>
</div>