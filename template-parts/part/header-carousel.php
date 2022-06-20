<?php /*
<section class="main-slider">
	<div id="HeaderCarousel" class="carousel slide" data-ride="carousel" data-interval="8000">
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
			console_log($attachment['url'], $counter);
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
</section> */?>
<?php
function Console_log($output) {
    $js_code = 'console.log( `' . json_encode($output, JSON_PRETTY_PRINT) . '`);';
    echo '<script>' . $js_code . '</script>';
}
$args=array(
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => 5,
	'caller_get_posts'=> 1
  );
$my_query = null;
$my_query = new WP_Query($args);
if((is_home() or is_front_page()) and $my_query->have_posts() ) {?>
	<div id="header" class="container-fluid full-header">
		<div class="container">
		<div id="header-content" class="row">
			<div id="header-title" class="col-sm-6 text-center align-middle">
				<div class="row"><div class="col-md-12"><div id="header-logo align-center"><?php the_custom_logo(); ?></div></div></div>
				<div class="row"><div class="col-md-12"><h2 class="site-title"><a href="<?php echo home_url( '/' ); // xss ok ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2></div></div>
				<div class="row"><div class="col-md-12"><h4 class="site-description"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></h4></div></div>
			</div>
			<div class="col-sm-6 hidden-xs">
				<h2 class="text-center"><?php __("Last posts")?></h2>
				<div id="last-posts-carousel" class="carousel slide" data-ride="carousel" data-interval="8000">
					<ol class="carousel-indicators"><?php
						for($counter=0; $counter < $my_query->post_count ; $counter++){ ?>
							<li data-target="#last-posts-carousel" data-slide-to="<?php echo esc_attr($counter); ?>"<?php echo ($counter == 0) ? ' class="active"' : ''; ?>></li><?php
						} ?>
					</ol>
					<div class="carousel-inner">
						<?php
						$counter=0;
						while($my_query->have_posts()){
							$my_query->the_post();
							get_template_part( 'template-parts/part/post-slide', get_post_format(), ['counter'=>$counter] );
							$counter++;
						}
						?>
					</div><!-- /.carousel -->
			</div>
			</div>
		</div>
		</div>
	</div>
<?php
} elseif((is_home() or is_front_page()) and get_header_image()) { ?>
<section class="main-slider">
	<div id="HeaderCarousel" class="carousel slide carousel-fade" data-ride="carousel" data-interval="8000">
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<div class="overlay"></div>
				<img class="item-image slide-1" src="<?php echo esc_url(get_header_image()); ?>" title="<?php echo esc_attr(get_bloginfo()); ?>" alt="<?php echo esc_attr(get_bloginfo()); ?>" />
				<div class="carousel-caption">
					<h3><?php echo esc_html( get_bloginfo() ); ?></h3>
					<h4><?php echo esc_html( get_bloginfo( 'description' ) ); ?></h4>
				</div>
			</div>
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
