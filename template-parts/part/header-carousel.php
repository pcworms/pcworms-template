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

$attachments = get_uploaded_header_images();
$args = array(
	'posts_per_page' => 5,
	'post_status' => 'publish',
	'post_type' => 'post'
);
$query = new WP_Query($args);
if((is_home() or is_front_page()) and $query->have_posts() ) {?>
	<div id="header" class="container-fluid">
		<div id="header-content" class="row">
			<div id="header-title" class="col-xs-6 text-center">
				<div class="row"><div class="col-xs-12"><div id="header-logo"><?php the_custom_logo(); ?></div></div></div>
				<div class="row"><div class="col-xs-12"><h3 class="site-title"><a href="<?php echo home_url( '/' ); // xss ok ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h3></div></div>
				<div class="row"><div class="col-xs-12"><h6 class="site-description"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></h6></div></div>
			</div>
			<div class="col-md-6">
				<h3 class="text-center">جدیدترین مطالب</h3>
				<div id="last-posts-carousel" class="carousel slide" data-ride="carousel" data-interval="8000">
					<ol class="carousel-indicators"><?php
						$posts = $query->posts;
						for($counter=0; $counter < count($posts) ; $counter++){ ?>
							<li data-target="#last-posts-carousel" data-slide-to="<?php echo esc_attr($counter); ?>"<?php echo ($counter == 0) ? ' class="active"' : ''; ?>></li><?php
						} ?>
					</ol>
					<div class="carousel-inner">
						<?php
						for($counter=0; $counter < count($posts) ; $counter++){
							$post = $posts[$counter];
							$post_id = $post->ID;
							$post_title = $post->post_title;
							$post_content = $post->post_content;
							$summery = substr( $post_content, strpos( $post_content, '<p>' ), strpos( $post_content, '</p>' ) - strpos( $post_content, '<p>' ) +4 );
							?>
							<div class="item<?php echo ($counter == 0) ? ' active' : ''; ?>">
								<div class="post-slide">
									<a href="#<?php echo $post_id;?>"><h3><?php echo $post_title;?></h3></a>
									<?php echo $summery;?>
								</div>
							</div><?php
							}
						?>
					</div>
					<div class="control-box">
						<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>
			</div><!-- /.carousel -->
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
