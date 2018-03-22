<header class="entry-header" data-aos="zoom-in">
	<div class="row">
		<div class="col <?php echo ((current_user_can( 'edit_post', get_the_ID() ) or is_archive()) ? 'pull-left' : 'col-xs-12'); ?>"><?php
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
		</div><?php
		if ( current_user_can( 'edit_post', get_the_ID() ) ) { ?>
		<div class="header-item pull-right">
			<?php Free_Template::edit_link(); ?>
		</div><?php }
		
		if(is_category()){
			$cat 		= get_queried_object();
			$cat_id   	= $cat->term_id;
			$cat_data 	= get_option("taxonomy_$cat_id");
		}
		$options_values = array(
			'date-desc' 					=> esc_html__('New Items', 'free-template'),
			'date-asc' 						=> esc_html__('Old Items', 'free-template'),
			'comment-count'		 	=> esc_html__('Most Comments', 'free-template'),
			'title' 							=> esc_html__('Title', 'free-template'),
			'author' 						=> esc_html__('Author', 'free-template'),
			'modified' 						=> esc_html__('New Modifications', 'free-template'),
		);
		if(function_exists( 'wp_statistics_pages' )){
			$options_values['visit'] = esc_html__('Most Visits', 'free-template');
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
			<i class="fa fa-bar-chart fa-lg" title="<?php esc_attr_e('Total Hits', 'free-template'); ?>" data-toggle="tooltip" data-placement="bottom" aria-hidden="true"></i> 
			<span class="stat-hits" title="<?php esc_attr_e('Total Hits', 'free-template'); ?>" data-toggle="tooltip" data-placement="bottom">
			<?php echo esc_html( wp_statistics_pages( 'total', "", get_the_ID()) ); ?>
			</span>
		</div><?php
		}

		if((is_archive() and !is_tag()) && isset($orderby_value) && ($orderby_value=='date-desc' || $orderby_value=='date-asc')){ ?>
		<div class="header-item created-on pull-right">
			<?php Free_Template::posted_on(); ?>
		</div>
		<?php
		}
		
		if((is_archive() and !is_tag()) && isset($orderby_value) && $orderby_value=='modified'){ ?>
		<div class="header-item modified-on pull-right">
			<?php Free_Template::modified_on(); ?>
		</div>
		<?php }
		
		if((is_archive() and !is_tag()) && isset($orderby_value) && $orderby_value=='author') { ?>
		<div class="header-item author-name pull-right">
				<i class="fa fa-user fa-lg" title="<?php esc_attr_e('Author', 'free-template'); ?>" data-toggle="tooltip" data-placement="bottom" aria-hidden="true"></i>
				<span class="author vcard" title="<?php esc_attr_e('Author', 'free-template'); ?>" data-toggle="tooltip" data-placement="bottom">
					<a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo get_the_author(); ?></a>
				</span>
		</div>
		<?php }
		
		if(comments_open( get_the_ID() ) && is_archive() && isset($orderby_value) && $orderby_value=='comment-count') { ?>
		<div class="header-item comments-number pull-right">
			<i class="fa fa-comments fa-lg" title="<?php esc_attr_e('Comments Number', 'free-template'); ?>" data-toggle="tooltip" data-placement="bottom" aria-hidden="true"></i> 
			<span class="comments-count" title="<?php esc_attr_e('Comments Number', 'free-template'); ?>" data-toggle="tooltip" data-placement="bottom">
			<?php echo esc_html(get_comments_number()); ?>
			</span>
		</div>
		<?php } ?>
		
	</div>
</header><!-- .entry-header -->
