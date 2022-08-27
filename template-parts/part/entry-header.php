<header class=>
	<div class="row entry-header">
		<div class="col pull-left"><?php
			$sticky = is_sticky() ? '<i class="sticky-icon fa fa-thumb-tack fa-lg"></i>' : '';
			$posttypeicon = '';
			if (get_post_format() == 'image'){
				$posttypeicon = '<i class="fa fa-file-image-o fa-fw" aria-hidden="true"></i> ';
			}elseif (get_post_format() == 'gallery'){
				$posttypeicon = '<i class="fa fa-picture-o fa-fw" aria-hidden="true"></i> ';
			}elseif (get_post_format() == 'video'){
				$posttypeicon = '<i class="fa fa-file-video-o fa-fw" aria-hidden="true"></i> ';
			}elseif (get_post_format() == 'audio'){
				$posttypeicon = '<i class="fa fa-file-audio-o fa-fw" aria-hidden="true"></i> ';
			}elseif (get_post_format() == 'chat'){
				$posttypeicon = '<i class="fa fa-comments fa-fw" aria-hidden="true"></i> ';
			}elseif (get_post_format() == 'status'){
				$posttypeicon = '<i class="fa fa-info-circle fa-fw" aria-hidden="true"></i> ';
			}elseif (get_post_format() == 'status'){
				$posttypeicon = '<i class="fa fa-link fa-fw" aria-hidden="true"></i> ';
			}elseif (get_post_format() == 'quote'){
				$posttypeicon = '<i class="fa fa-quote-right fa-fw" aria-hidden="true"></i> ';
			}elseif (get_post_format() == 'aside'){
				$posttypeicon = '<i class="fa fa-sticky-note-o fa-fw" aria-hidden="true"></i> ';
			}

			$icons = $sticky . $posttypeicon;
			
			if ( is_single() or is_page() ) {
				the_title( '<h1 class="entry-title">' . $icons, '</h1>' );
			}elseif( is_front_page() && is_home() ) {
				the_title( '<h2 class="entry-title">' . $icons . '<a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr(get_the_title()) . '" rel="bookmark">', '</a></h2>' );
			}else{
				the_title( '<h2 class="entry-title">' . $icons . '<a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr(get_the_title()) . '" rel="bookmark">', '</a></h2>' );
			} ?>
		</div>
		<div class="header-item pull-right">
			<a class="share-btn" href="javascript:" onclick="navigator.share({ title: '<?php echo esc_attr(get_the_title())?>', url: '<?php echo esc_url( get_permalink() )?>' });"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
			<?php
			if ( current_user_can( 'edit_post', get_the_ID() ) )
				Free_Template::edit_link();
			?>
		</div><?php
		
		if(is_category()){
			$cat 		= get_queried_object();
			$cat_id   	= $cat->term_id;
			$cat_data 	= get_option("taxonomy_$cat_id");
		}
		$options_values = array(
			'date-desc' 					=> esc_html__('New Items', 'pcworms'),
			'date-asc' 						=> esc_html__('Old Items', 'pcworms'),
			'comment-count'		 	=> esc_html__('Most Comments', 'pcworms'),
			'title' 							=> esc_html__('Title', 'pcworms'),
			'author' 						=> esc_html__('Author', 'pcworms'),
			'modified' 						=> esc_html__('New Modifications', 'pcworms'),
		);
		if(function_exists( 'wp_statistics_pages' )){
			$options_values['visit'] = esc_html__('Most Visits', 'pcworms');
		}
		if( isset($_GET['orderedby']) and array_key_exists(wp_unslash($_GET['orderedby']), $options_values) ){ // sanitization ok
			$orderby_value = wp_unslash($_GET['orderedby']); // sanitization ok
		}elseif( isset($cat_data['order-by']) and array_key_exists($cat_data['order-by'], $options_values) ){
			$orderby_value = $cat_data['order-by'];
		}elseif( get_theme_mod('default_category_orderby') and array_key_exists(get_theme_mod('default_category_orderby'), $options_values) ){
			$orderby_value = get_theme_mod('default_category_orderby');
		}else{
			$orderby_value = 'date-desc';
		}

		if ( (is_archive() and !is_tag()) and function_exists( 'wp_statistics_pages' ) && get_theme_mod('display_visits', true) && isset($orderby_value) && $orderby_value=='visit' ) { ?>
		<div class="header-item total-hits pull-right">
			<i class="fa fa-bar-chart fa-lg" title="<?php esc_attr_e('Total Hits', 'pcworms'); ?>" data-toggle="tooltip" data-placement="bottom" aria-hidden="true"></i> 
			<span class="stat-hits" title="<?php esc_attr_e('Total Hits', 'pcworms'); ?>" data-toggle="tooltip" data-placement="bottom">
			<?php echo esc_html( wp_statistics_pages( 'total', "", get_the_ID()) ); ?>
			</span>
		</div><?php
		} ?>
		
	</div>
	<div class="post-info">
		<?php 
		// get_the_author();
		$link = get_author_posts_url(get_the_author_meta( 'ID' ));
		$name = get_the_author_meta("display_name");
		?>
		<span><a href="<?php echo $link ?>"><?php echo $name?></a> <i class="fa fa-user-circle" aria-hidden="true"></i></span>
		<span><?php the_category(' -  ')?> <i class="fa fa-bookmark" aria-hidden="true"></i></span>
		<span><?php the_date('Y-m-d')?> <i class="fa fa-calendar" aria-hidden="true"></i></span>
	</div>
</header><!-- .entry-header -->
