<?php
/*
$args=array(
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => get_option('latest-posts-carousel-count', 5),
	'caller_get_posts'=> 1
  );
$my_query = null;
$my_query = new WP_Query($args);
if((is_home() or is_front_page()) and $my_query->have_posts() ) {?>
		<div id="header" class="row full-header px-sm-5">
			<div id="header-title" class="col-md-6 text-center align-middle">
				<div class="row"><div class="col-md-12"><div id="header-logo align-center"><?php the_custom_logo(); ?></div></div></div>
				<div class="row"><div class="col-md-12"><h2 class="site-title"><a href="<?php echo home_url( '/' ); // xss ok ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2></div></div>
				<div class="row"><div class="col-md-12"><h4 class="site-description"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></h4></div></div>
			</div>
			<div class="col-sm-6 d-none d-md-block">
				<h2 class="text-center"><?php echo __("Latest Posts", 'pcworms')?></h2>
				<div id="last-posts-carousel" class="carousel slide" data-ride="carousel" data-interval="5000" >
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
} else {*/
if(display_header_text()){ ?>
	<div id="header" class="row <?php if (is_home() || is_front_page()) echo "no-gutters";?>">
		<div class="col-8 mx-auto">
			<?php
			if(has_custom_logo()){ ?>
				<div id="header-logo" class="d-inline-block"><?php the_custom_logo(); ?></div><?php
			} ?>
			<div id="header-title" class="d-inline-block">
				<h3 class="site-title"><a href="<?php echo home_url( '/' ); // xss ok ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h3><?php
				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) { ?>
					<p class="site-description"><?php echo esc_html($description); ?></p><?php
				} ?>
			</div>
		</div>
	</div>
<?php
	}
//}
