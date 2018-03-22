<?php
$attachments = get_uploaded_header_images();
if( (is_home() or is_front_page()) and $attachments ) { ?>
<section class="main-slider">
	<div id="HeaderCarousel" class="carousel slide carousel-fade" data-ride="carousel" data-interval="8000">
		<ol class="carousel-indicators"><?php

		for($counter=0; $counter < count($attachments) ; $counter++){ ?>
			<li data-target="#HeaderCarousel" data-slide-to="<?php echo esc_attr($counter); ?>"<?php echo ($counter == 0) ? ' class="active"' : ''; ?>></li><?php
		} ?>
		</ol>
		<div class="carousel-inner" role="listbox"><?php
		$counter = 1;
		foreach($attachments as $attachment){
			$attachment = wp_prepare_attachment_for_js($attachment['attachment_id']); ?>
			<div class="item<?php echo(($counter == 1) ? " active" : ""); ?>"><?php
				if($attachment['title']) { ?>
				<a href="<?php echo(esc_url($attachment['alt'])); ?>" title="<?php echo(esc_attr($attachment['title'])); ?>"><?php
				} ?>
					<div class="overlay"></div>
					<img class="item-image slide-<?php echo $counter; // xss ok ?>" src="<?php echo(esc_url($attachment['url'])); ?>" title="<?php echo(esc_attr($attachment['title'])); ?>" alt="<?php echo(esc_attr($attachment['title'])); ?>" /><?php
				if($attachment['title']) { ?>
				</a><?php
				} ?>
				<div class="carousel-caption"><?php
						if($attachment['title']) { ?>
						<a href="<?php echo(esc_url($attachment['alt'])); ?>"  title="<?php echo(esc_attr($attachment['title'])); ?>">
							<h3><?php echo(esc_html($attachment['title'])); ?></h3>
						</a><?php
						}
						if($attachment['caption']) { ?>
							<h4><?php echo(esc_html($attachment['caption'])); ?></h4><?php
						}
						if($attachment['description']) { ?>
							<p><?php echo(esc_html($attachment['description'])); ?></p><?php
						} ?>
				</div>
			</div><?php
			//$attachment['title']
			//$attachment['url']
			//$attachment['alt']
			//$attachment['description']
			//$attachment['caption']
			//$attachment['sizes']['thumbnail']['url']
			//$attachment['sizes']['thumbnail']['width']
			//$attachment['sizes']['thumbnail']['height']
			$counter += 1;
		} ?>
		</div>
		<div class="control-box">
			<a class="left carousel-control" href="#HeaderCarousel" role="button" data-slide="prev">
				<span class="control-icon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			</a>
			<a class="right carousel-control" href="#HeaderCarousel" role="button" data-slide="next">
				<span class="control-icon glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			</a>
		</div>

	
	</div><!-- /.carousel -->
</section><?php
} else {
	if(display_header_text()){ ?>
	<div id="header" class="container"><?php
		if(has_custom_logo()){ ?>
			<div id="header-logo" class="pull-left"><?php the_custom_logo(); ?></div><?php
		} ?>
		<div id="header-title" class="pull-left">
			<h3 class="site-title"><a href="<?php echo home_url( '/' ); // xss ok ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h3><?php
			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) { ?>
				<p class="site-description"><?php echo esc_html($description); ?></p><?php
			} ?>
		</div>
	</div><?php
	}
}
