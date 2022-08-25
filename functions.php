<?php

new Free_Template;

/**
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

class Free_Template{
	
	public function __construct(){

		add_action( 'after_setup_theme',							array($this, 'setup') );
		add_action( 'widgets_init',									array($this, 'widgets_init') );
		add_action( 'wp_enqueue_scripts', 						array($this, 'enqueue_all') );
		add_action( 'customize_register',							array('Free_Template_Customizer' , 'register') );
		add_action( 'customize_preview_init', 					array('Free_Template_Customizer' , 'live_preview') );

		add_filter( 'excerpt_more', 									array($this, 'excerpt_more') );
		add_filter( 'wp_link_pages_link', 							array($this, 'bs_link_pages') );
		add_filter( 'wp_link_pages_args', 							array($this, 'wp_link_pages_args_prevnext_add') );
		add_filter( 'comment_form_default_fields',				array($this, 'bootstrap3_comment_form_fields') );
		add_filter( 'comment_form_defaults', 					array($this, 'bootstrap3_comment_form') );
		add_filter( 'widget_nav_menu_args', 						array($this, 'add_div_nav_widget') );
		add_filter( 'body_class', 										array($this, 'body_classes') );
		add_filter( 'wp_get_attachment_image_attributes', array($this, 'image_item_add_title'), 10, 2 );
		add_filter( 'excerpt_length', 								array($this, 'custom_excerpt_length'), 999 );

		// allow html in author description
		remove_filter('pre_user_description', 'wp_filter_kses');

		// custom rss templates
		// TODO: make this feature optional (configurable from template customization)
		remove_all_actions( 'do_feed_atom' );
		remove_all_actions( 'do_feed_rdf' );
		remove_all_actions( 'do_feed_rss' );
		remove_all_actions( 'do_feed_rss2' );
		add_action( 'do_feed_atom', array($this,'custom_feed_atom'));
		add_action( 'do_feed_rdf', array($this,'custom_feed_rdf'));
		add_action( 'do_feed_rss', array($this,'custom_feed_rss'));
		add_action( 'do_feed_rss2', array($this,'custom_feed_rss2'));

		// Check if WooCommerce is active
		if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
			// Order product collections by stock status, instock products first.
			add_filter('posts_clauses', array($this, 'order_by_stock_status'), 2000);
		}

		require( get_template_directory() . '/inc/megamenu-nav-walker.php' );
		require( get_template_directory() . '/inc/megamenu-widget-nav-walker.php' );
		require( get_template_directory() . '/inc/megamenu-bottom-nav-walker.php' );
		require( get_template_directory() . '/inc/comment-walker.php' );
		require( get_template_directory() . '/inc/customizer.php' );

	}

	public function custom_feed_atom() { get_template_part( 'template-parts/feeds/feed-atom', 'atom'); }
	public function custom_feed_rdf() { get_template_part( 'template-parts/feeds/feed-rdf', 'rdf'); }
	public function custom_feed_rss() { get_template_part( 'template-parts/feeds/feed-rss', 'rss'); }
	public function custom_feed_rss2() { get_template_part( 'template-parts/feeds/feed-rss2', 'rss2'); }
	
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */

	public function setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'pcworms', get_template_directory() . '/languages' );
		
		// Define and register starter content to showcase the theme on new sites.
		$starter_content = array(
			'widgets' => array(
				'sidebar-1' => array(
					'categories',
					'meta',
				),
				'frontend-content-top' => array(
					'text_about',
				),
				'frontend-content-bottom' => array(
					'text_business_info',
				),
				'footer-column-1' => array(
					'calendar',
				),
				'footer-column-2' => array(
					'archives',
				),
				'footer-column-3' => array(
					'recent-posts',
				),
				'footer-column-4' => array(
					'recent-comments',
				),
			),

			// Specify the core-defined pages to create and add custom thumbnails to some of them.
			'posts' => array(
				'home',
				'blog',
				'news',
				'about',
				'contact',
				'homepage-section',
				/*
				'homepage-section' => array(
					'thumbnail' => '{{image-espresso}}',
				),
				*/
			),

			// Default to a static front page and assign the front and posts pages.
			'options' => array(
				'show_on_front' => 'page',
				'page_on_front' => '{{home}}',
				'page_for_posts' => '{{blog}}',
			),

			// Set up nav menus for each of the two areas registered in the theme.
			'nav_menus' => array(
				// Assign a menu to the "top" location.
				'primary' => array(
					'name' => __( 'Top Menu', 'pcworms' ),
					'items' => array(
						'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
						'page_about',
						'page_blog',
						'page_news',
						'page_contact',
					),
				),

				'bottom' => array(
					'name' => __( 'Bottom of Site', 'pcworms' ),
					'items' => array(
						'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
						'page_about',
						'page_blog',
						'page_news',
						'page_contact',
					),
				),

				// Assign a menu to the "header" location.
				'header' => array(
					'name' => __( 'Bottom of Header', 'pcworms' ),
					'items' => array(
						'link_instagram',
						'link_facebook',
						'link_twitter',
						'link_email',
					),
				),
				
				// Assign a menu to the "header-right" location.
				'header-right' => array(
					'name' => __( 'Bottom of Header - Right', 'pcworms' ),
					'items' => array(
						'link_youtube',
						'link_github',
						'link_linkedin',
						'link_pinterest',
					),
				),
			),
		);

		add_theme_support( 'starter-content', $starter_content );

		$background_defaults = array(
			'default-color'          => 'ffffff',
			'default-image'          => '',
			'default-repeat'         => '',
			'default-position-x'     => '',
			'default-attachment'     => '',
			'wp-head-callback'       => array($this, 'change_custom_background_cb'),
			'admin-head-callback'    => '',
			'admin-preview-callback' => ''
		);
		add_theme_support( 'custom-background', $background_defaults );
		
		$header_defaults = array(
			'default-image'          => '%s/assets/images/default.jpg',
			'width'                  => 1000,
			'height'                 => 250,
			'random-default'         => false,
			'flex-width'             => true,
			'flex-height'            => true,
			'default-text-color'     => 'ffffff',
			'header-text'            => true,
			'uploads'                => true,
			'wp-head-callback'       => '',
			'admin-head-callback'    => '',
			'admin-preview-callback' => '',
			'video' => false,
			'video-active-callback' => 'is_front_page',
		);
		add_theme_support( 'custom-header', $header_defaults );
		
		register_default_headers( array(
			'default-header' => array(
				'url'           => '%s/assets/images/default.jpg',
				'thumbnail_url' => '%s/assets/images/default.jpg',
				'description'   => get_bloginfo(),
			),
		) );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title. By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		add_theme_support( 'wc-product-gallery-zoom' );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'audio',
			'status',
			'chat',
		) );

		// Add theme support for Custom Logo.
		//https://make.wordpress.org/core/2016/03/10/custom-logo/
		//https://codex.wordpress.org/Theme_Logo
		add_theme_support( 'custom-logo', array(
			'width'       => 150,
			'height'      => 150,
			'flex-width'  => true,
			'flex-height' => false,
			// Classes(s) of elements to hide.
			// It can pass an array of class names here for all elements constituting header text that could be replaced by a logo.
			//'header-text' => array( 'site-title', 'site-description' ),
		) );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary'			=> esc_html__( 'Top Menu', 'pcworms' ),
			'header'			=> esc_html__( 'Bottom of Header', 'pcworms' ),
			'header-right'	=> esc_html__( 'Bottom of Header - Right', 'pcworms' ),
			'bottom'		=> esc_html__( 'Bottom of Site', 'pcworms' ),
		) );

		//add_image_size( 'pcworms' . '-featured-image', 2000, 1200, true );
		//add_image_size( 'pcworms' . '-thumbnail-avatar', 90, 90, true );

		// Set the default content width.
		$GLOBALS['content_width'] = 525;

		// This theme styles the visual editor to resemble the theme style, specifically font, colors, and column width.
		add_editor_style( 'assets/css/editor-style.css' );
		if(is_rtl()){
			add_editor_style( 'rtl.css' );
		} else {
			add_editor_style( 'style.css' );
		}

	}
	
	/**
	 * Register widget area.
	 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
	 */
	public function widgets_init() {
		register_sidebar( array(
			'name'				=> esc_html__( 'Sidebar', 'pcworms' ),
			'id'					=> 'sidebar-1',
			'description'		=> esc_html__( 'Add widgets here to appear in your sidebar.', 'pcworms' ),
			'before_widget'	=> '<div id="%1$s" class="widget %2$s panel box">',
			'after_widget'		=> '</div>',
			'before_title'		=> '<h4 class="widget-title">',
			'after_title'			=> '</h4>',
		) );

		register_sidebar( array(
			'name'				=> esc_html__( 'Frontend Content Top', 'pcworms' ),
			'id'           			=> 'frontend-content-top',
			'description'   		=> esc_html__( 'Add widgets here to appear in your top of content in Frontpage.', 'pcworms' ),
			'before_widget' 	=> '<div id="%1$s" class="widget %2$s panel box">',
			'after_widget'  	=> '</div>',
			'before_title'  	=> '<h4 class="widget-title">',
			'after_title'  		=> '</h4>',
		) );

		register_sidebar( array(
			'name'          		=> esc_html__( 'Frontend Content Bottom', 'pcworms' ),
			'id'            		=> 'frontend-content-bottom',
			'description'   		=> esc_html__( 'Add widgets here to appear in your bottom of content in Frontpage.', 'pcworms' ),
			'before_widget' 	=> '<div id="%1$s" class="widget %2$s panel box">',
			'after_widget'  	=> '</div>',
			'before_title'  	=> '<h4 class="widget-title">',
			'after_title'   		=> '</h4>',
		) );

		register_sidebar( array(
			'name'          		=> esc_html__( 'Content Top', 'pcworms' ),
			'id'            		=> 'content-top',
			'description'   		=> esc_html__( 'Add widgets here to appear in your top of content.', 'pcworms' ),
			'before_widget' 	=> '<div id="%1$s" class="widget %2$s panel box">',
			'after_widget'  	=> '</div>',
			'before_title'  	=> '<h4 class="widget-title">',
			'after_title'   		=> '</h4>',
		) );

		register_sidebar( array(
			'name'          		=> esc_html__( 'Content Bottom', 'pcworms' ),
			'id'            		=> 'content-bottom',
			'description'   		=> esc_html__( 'Add widgets here to appear in your bottom of content.', 'pcworms' ),
			'before_widget' 	=> '<div id="%1$s" class="widget %2$s panel box">',
			'after_widget'  	=> '</div>',
			'before_title'  	=> '<h4 class="widget-title">',
			'after_title'   		=> '</h4>',
		) );

		register_sidebar( array(
			'name'          		=> esc_html__( 'Footer Column 1', 'pcworms' ),
			'id'            		=> 'footer-column-1',
			'description'   		=> esc_html__( 'Add widgets here to appear in your footer column 1.', 'pcworms' ),
			'before_widget' 	=> '<div id="%1$s" class="widget %2$s" data-aos="fade-left">',
			'after_widget'  	=> '</div>',
			'before_title'  	=> '<h4 class="widget-title">',
			'after_title'   		=> '</h4>',
		) );

		register_sidebar( array(
			'name'          		=> esc_html__( 'Footer Column 2', 'pcworms' ),
			'id'            		=> 'footer-column-2',
			'description'   		=> esc_html__( 'Add widgets here to appear in your footer column 2.', 'pcworms' ),
			'before_widget' 	=> '<div id="%1$s" class="widget %2$s" data-aos="fade-left">',
			'after_widget'  	=> '</div>',
			'before_title'  	=> '<h4 class="widget-title">',
			'after_title'   		=> '</h4>',
		) );

		register_sidebar( array(
			'name'          		=> esc_html__( 'Footer Column 3', 'pcworms' ),
			'id'            		=> 'footer-column-3',
			'description'   		=> esc_html__( 'Add widgets here to appear in your footer column 3.', 'pcworms' ),
			'before_widget' 	=> '<div id="%1$s" class="widget %2$s" data-aos="fade-left">',
			'after_widget'  	=> '</div>',
			'before_title'  	=> '<h4 class="widget-title">',
			'after_title'   		=> '</h4>',
		) );

		register_sidebar( array(
			'name'          		=> esc_html__( 'Footer Column 4', 'pcworms' ),
			'id'            		=> 'footer-column-4',
			'description'   		=> esc_html__( 'Add widgets here to appear in your footer column 4.', 'pcworms' ),
			'before_widget' 	=> '<div id="%1$s" class="widget %2$s" data-aos="fade-left">',
			'after_widget'  	=> '</div>',
			'before_title'  	=> '<h4 class="widget-title">',
			'after_title'   		=> '</h4>',
		) );


	}

	public function enqueue_all(){

		// nprogress css
		wp_deregister_style( 'nprogress' );
		wp_enqueue_style( 'nprogress', get_stylesheet_directory_uri() . '/assets/nprogress/css/nprogress.min.css', array(), '0.2.0', 'all');

		// nprogress js load in header
		wp_enqueue_script( 'nprogress', get_stylesheet_directory_uri() . '/assets/nprogress/js/nprogress.js', array(), '0.2.0', false);

		// tether js (for tooltips , should before bootstrap) load in footer
		wp_enqueue_script( 'tether', get_stylesheet_directory_uri() . '/assets/tether/js/tether.min.js', array(), '1.4.0', true);

		// bootstrap js css load in footer
		wp_enqueue_script( 'bootstrap', get_stylesheet_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array('jquery'), '3.3.7', true);

		wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css', array(), '3.3.7', 'all');

		// bootstrap theme css
		if (get_theme_mod('bootstrap_theme_name') != 'default' && get_theme_mod('bootstrap_theme_name') ) {
			wp_enqueue_style( 'bootswatch', get_stylesheet_directory_uri() . '/assets/bootswatch/' . esc_html( get_theme_mod( 'bootstrap_theme_name' ) ) . '/bootstrap.min.css', array(), '3.3.7', 'all');
		} else {
			wp_enqueue_style( 'bootstrap-theme', get_stylesheet_directory_uri() . '/assets/bootstrap/css/bootstrap-theme.min.css', array(), '3.3.7', 'all');
		}

		// rtl bootstrap
		if ( is_rtl() ) {
			wp_enqueue_style( 'partial-bootstrap-rtl', get_stylesheet_directory_uri() . '/assets/bootstrap-rtl/css/bootstrap.rtl.css', array(), '3.3.7.2', 'all');
		}

		// 1000hz-bootstrap-validator js load in footer
		wp_enqueue_script( 'bootstrap-validator', get_stylesheet_directory_uri() . '/assets/bootstrap-validator/validator.min.js', array(), '0.11.9', true);

		// fancybox
		wp_enqueue_style( 'fancybox', get_stylesheet_directory_uri() . '/assets/fancybox/jquery.fancybox.min.css', array(), '3.1.24', 'all');
		// load in footer
		wp_enqueue_script( 'fancybox', get_stylesheet_directory_uri() . '/assets/fancybox/jquery.fancybox.min.js', array('jquery'), '3.1.24', true);
		
		// font awesome css
		wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css', array(), '4.7.0', 'all');

		// main css
		if ( !is_rtl() ) {
			wp_enqueue_style( 'theme-style', get_stylesheet_uri(), array( ), wp_get_theme()->get( 'Version' ), 'all' );
		}

		// dedidata js load in footer
		wp_enqueue_script( 'dedidata', get_stylesheet_directory_uri() . '/assets/js/dedidata.js', array('jquery'), wp_get_theme()->get( 'Version' ), true);

		// custom js load in footer
		wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'), wp_get_theme()->get( 'Version' ), true);

		// aos : animate on scroll
		if ( function_exists( 'is_woocommerce' ) ){
			// woocommerce is enabled
			if( ! is_woocommerce() ){
				wp_enqueue_style( 'aos', get_stylesheet_directory_uri() . '/assets/aos/aos.css', array(), '2.2.0', 'all');
				wp_enqueue_script( 'aos', get_stylesheet_directory_uri() . '/assets/aos/aos.js', array(), '2.2.0', true);
			}
		}else{
			wp_enqueue_style( 'aos', get_stylesheet_directory_uri() . '/assets/aos/aos.css', array(), '2.2.0', 'all');
			wp_enqueue_script( 'aos', get_stylesheet_directory_uri() . '/assets/aos/aos.js', array(), '2.2.0', true);
		}

		// html5shiv js
		wp_enqueue_script( 'html5shiv', get_stylesheet_directory_uri() . '/assets/html5shiv/html5shiv.min.js', array(), '3.7.3', true);
		wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

		// printshiv js
		wp_enqueue_script( 'html5shiv-printshiv', get_stylesheet_directory_uri() . '/assets/html5shiv/html5shiv-printshiv.min.js', array(), '3.7.3', true);
		wp_script_add_data( 'html5shiv-printshiv', 'conditional', 'lt IE 9' );

		// respond
		wp_enqueue_script( 'respond', get_stylesheet_directory_uri() . '/assets/respond/respond.min.js', array(), '1.4.2', true);
		wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );

		// ie 10 viewport bug js css load in footer
		wp_enqueue_script( 'ie10-viewport-bug', get_stylesheet_directory_uri() . '/assets/ie10-viewport-bug/js/ie10-viewport-bug-workaround.min.js', array(), null, true);
		wp_script_add_data( 'ie10-viewport-bug', 'conditional', 'IE 10' );
		wp_enqueue_style( 'ie10-viewport-bug', get_stylesheet_directory_uri() . '/assets/ie10-viewport-bug/css/ie10-viewport-bug-workaround.min.css');
		wp_style_add_data( 'ie10-viewport-bug', 'conditional', 'IE 10' );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_register_style('Palette', get_stylesheet_directory_uri() . '/palette.css');

		// prism
		//if ( is_single() && has_tag( 'code' ) ) {
			wp_register_style('prismCSS', get_stylesheet_directory_uri() . '/assets/prism/prism.css');
			wp_register_script('prismJS', get_stylesheet_directory_uri() . '/assets/prism/prism.js');
			wp_enqueue_style('prismCSS');
			wp_enqueue_script('prismJS');
		//}

	}
	
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a 'Continue reading' link.
	 * @param string $link Link to single post/page.
	 * @return string 'Continue reading' link prepended with an ellipsis.
	 */
	public function excerpt_more( $link ) {
		if ( is_admin() ) {
			return $link;
		}

		$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link btn btn-default" title="%2$s" data-toggle="tooltip" data-placement="bottom" aria-hidden="true"><span class="fa fa-eye"></span> ' . esc_html__( 'Continue reading', 'pcworms' ) . '</a></p>',
			esc_url( get_permalink( get_the_ID() ) ),
			esc_attr(get_the_title())
		);
		return ' &hellip; ' . $link;
	}

	/**
	 * Filter wp_link_pages to wrap current page
	 *
	 * @param $link
	 * @return string
	 */
	public function bs_link_pages( $link ) {
		if ( ctype_digit( $link ) ) {
			return '<li class="active"><span aria-hidden="true">' . $link . '</span></li>';
		}
		return '<li>' . $link . '</li>';
	}

	// Add prev and next links to a numbered page link list
	public function wp_link_pages_args_prevnext_add($args){
		global $page, $numpages, $more, $pagenow;

		if (!$args['next_or_number'] == 'next_and_number')
			return $args; # exit early

		$args['next_or_number'] = 'number'; # keep numbering for the main part
		if (!$more)
			return $args; # exit early

		//<li class="disabled"><a href="#"><span aria-hidden="true">&laquo;</span></a></li>

		if($page-1) {# there is a previous page
			$args['before'] .= '<li>' . _wp_link_page($page-1) . $args['link_before']. '<span aria-hidden="true">' . $args['previouspagelink'] . '</span>' . $args['link_after'] . '</a></li>';
		}else{
			$args['before'] .= '<li class="disabled">' . $args['link_before'] . '<span aria-hidden="true">' . $args['previouspagelink'] . '</span>' . $args['link_after'] . '</li>';
		}

		if ($page<$numpages){ # there is a next page
			$args['after'] = '<li>' . _wp_link_page($page+1) . $args['link_before'] . '<span aria-hidden="true">' . $args['nextpagelink'] . '</span>' . $args['link_after'] . '</a>' . $args['after'];
		}else{
			$args['after'] = '<li class="disabled">' . $args['link_before'] . '<span aria-hidden="true">' . $args['nextpagelink'] . '</span>' . $args['link_after'] . $args['after'];
		}

		return $args;
	}

	public function bootstrap3_comment_form_fields( $fields ) {
		$commenter = wp_get_current_commenter();

		$req      = intval(get_option( 'require_name_email' ));
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$html5    = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;

		$fields   =  array(
			'author' => '<div class="form-group has-feedback comment-form-author">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user fa-lg"></i></span>
									<input placeholder="' . esc_attr__( 'Name', 'pcworms' ) .( $req ? ' *' : '' ) . '" class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" required="required" data-error="' . esc_html__('Please enter your name!', 'pcworms') . '"' . $aria_req . ' />
								</div>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
								<div class="help-block with-errors"></div>
							</div>',
			'email'  => '<div class="form-group has-feedback comment-form-email">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-at fa-lg"></i></span>
									<input placeholder="' . esc_attr__( 'Email', 'pcworms' ) . ( $req ? ' *' : '' ) . '" style="direction: ltr;" class="form-control" id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" required="required" data-error="' . esc_html__('Please enter your email address!', 'pcworms') . '"' . $aria_req . ' />
								</div>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
								<div class="help-block with-errors"></div>
							</div>',
			'url'    => '<div class="form-group has-feedback comment-form-url">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-globe fa-lg"></i></span>
									<input placeholder="' . esc_attr__( 'Website', 'pcworms' ) . '" style="direction: ltr;" class="form-control" id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" data-error="' . esc_html__('Please enter a valid website starting with http:// on nothing!', 'pcworms') . '" />
								</div>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
								<div class="help-block with-errors"></div>
							</div>',
		);

		return $fields;
	}

	public function bootstrap3_comment_form( $args ) {
		$args['comment_field'] = '
											<div class="form-group has-feedback comment-form-comment">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-comments fa-lg"></i></span>
													<textarea placeholder="' . esc_attr__( 'Comment', 'pcworms' ) . '" class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true" required="required" data-error="' . esc_html__('Please enter your comment!', 'pcworms') . '"></textarea>
												</div>
												<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
												<div class="help-block with-errors"></div>
											</div>';
		$args['class_submit'] = 'btn btn-default'; // since WP 4.1

		return $args;
	}

	public function add_div_nav_widget( $args ) {
		$args['menu_class'] = 'nav nav-stacked';
		//$args['fallback_cb'] = 'WP_Bootstrap_Navwalker::fallback';
		$args['walker'] = new WP_Bootstrap_Widget_Navwalker();
		return $args;
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	public function body_classes( $classes ) {
		// Add class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Add class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		// Add class if we're viewing the Customizer for easier styling of theme options.
		if ( is_customize_preview() ) {
			$classes[] = 'pcworms' . '-customizer';
		}
		
		//$classes[] = esc_html( get_theme_mod( 'bootstrap_theme_name' ) ) . '-theme';

		if( ! (has_nav_menu( 'primary' ) or get_theme_mod('display_login_link') ) ) {
			$classes[] = 'non-top-menu';
		}
		
		return $classes;
	}

	/**
	 * Filter attributes for the current gallery image tag.
	 *
	 * @param array   $atts       Gallery image tag attributes.
	 * @param WP_Post $attachment WP_Post object for the attachment.
	 * @return array (maybe) filtered gallery image tag attributes.
	 */
	public function image_item_add_title( $atts, $attachment ) {
		if($atts['alt'] !== ''){
			$atts['title'] = $atts['alt'];
		}
		return $atts;
	}

	/**
	 * Filter the except length to 45 words.
	 *
	 * @param int $length Excerpt length.
	 * @return int (Maybe) modified excerpt length.
	 */
	public function custom_excerpt_length( $length ) {
		if ( ! is_admin() ) {
			return 255;
		}
	}

	public function order_by_stock_status($posts_clauses){
		global $wpdb;
		// only change query on WooCommerce loops
		if (is_product_category() || is_product_tag()) {
			$posts_clauses['join'] .= " INNER JOIN $wpdb->postmeta istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";
			$posts_clauses['orderby'] = " istockstatus.meta_value ASC, " . $posts_clauses['orderby'];
			$posts_clauses['where'] = " AND istockstatus.meta_key = '_stock_status' AND istockstatus.meta_value <> '' " . $posts_clauses['where'];
		}
		return $posts_clauses;
	}

	/* change custom background */
	public function change_custom_background_cb() {
		$background = get_background_image();
		$color = get_background_color();
		$head_txt_color = get_header_textcolor();
		if ( ! $background && ! $color )
			return;

		$style = $color ? "background-color: #$color !important;" : '';

		if ( $background ) {
			$image = " background-image: url('$background') !important;";

			$repeat = get_theme_mod( 'background_repeat', 'repeat' );
			$size="background-size: 18%;";

			if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) ){
				$repeat = 'repeat';
				$size = "-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;background-size: cover !important;";
			}

			$repeat = " background-repeat: $repeat !important;";

			$position = get_theme_mod( 'background_position_x', 'left' );

			if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
				$position = 'left';

			$position = " background-position: top $position !important;";

			$attachment = get_theme_mod( 'background_attachment', 'scroll' );

			if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
				$attachment = 'scroll';

			$attachment = " background-attachment: $attachment !important;";

			$style .= $image . $repeat . $position . $attachment . $size;
		}
		?>
		<style type="text/css" id="custom-background-css">
			body.custom-background { <?php echo trim( $style ); // xss ok ?>
			}
			#HeaderCarousel .carousel-caption h3,
			#HeaderCarousel .carousel-caption h3 a,
			#HeaderCarousel .carousel-caption h4,
			#HeaderCarousel .carousel-caption h4 a,
			#HeaderCarousel .carousel-caption p{
				color: #<?php echo esc_html($head_txt_color); // xss ok ?>;
			}
		</style>
		<?php
	}
	
	static function login_link_texts(){
		return array(
			'Login'				=> esc_html__('Login', 'pcworms'),
			'Customer Panel'	=> esc_html__('Customer Panel', 'pcworms'),
			'Customer Login'	=> esc_html__('Customer Login', 'pcworms'),
			'Management'		=> esc_html__('Management', 'pcworms'),
			'Administration'	=> esc_html__('Administration', 'pcworms'),
		);
	}

	/****** CONTENT FUNCTIONS ******/

	public static function validate_comment_form(){
		ob_start();
		comment_form();
		echo str_replace('novalidate','data-toggle="validator" ',ob_get_clean()); // xss ok
	}

	public static function comments_pagination( $args = array() ) {
		$navigation = '';
		$args['echo'] = false;
		$links = paginate_comments_links( $args );

		if ( $links ) {
			$navigation = _navigation_markup( $links, 'comments-pagination', '' );
		}
		$navigation = str_replace("ul class='" , "ul class='pagination ", $navigation);
		$navigation = str_replace("<li><span class='page-numbers current'" , "<li class='active'><span class='page-numbers current'", $navigation);
		echo $navigation; // xss ok
	}

	public static function posts_pagination( $args = array() ) {
		$navigation = '';

		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages > 1 ) {
			$args = wp_parse_args( $args, array(
				'mid_size'           => 1,
				'prev_text'          => esc_html__( 'Previous', 'pcworms' ),
				'next_text'          => esc_html__( 'Next', 'pcworms' ),
			) );

			// Make sure we get a string back. Plain is the next best thing.
			if ( isset( $args['type'] ) && 'array' == $args['type'] ) {
				$args['type'] = 'plain';
			}

			// Set up paginated links.
			$links = paginate_links( $args );

			if ( $links ) {
				$navigation = _navigation_markup( $links, 'posts-pagination', '' );
			}
		}

		$navigation = str_replace("ul class='" , "ul class='pagination ", $navigation);
		$navigation = str_replace("<li><span class='page-numbers current'" , "<li class='active'><span class='page-numbers current'", $navigation);
		echo $navigation; // xss ok
	}

	/**
	 * Returns an accessibility-friendly link to edit a post or page.
	 *
	 * This also gives us a little context about what exactly we're editing
	 * (post or page?) so that users understand a bit more where they are in terms
	 * of the template hierarchy and their content. Helpful when/if the single-page
	 * layout with multiple posts/pages shown gets confusing.
	 */
	public static function edit_link() {
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				'<i class="fa fa-pencil-square-o fa-lg" data-toggle="tooltip" data-placement="top" title="%s" aria-hidden="true"></i>',
				esc_attr( __('Edit ', 'pcworms') . get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
		return false;
	}
	
	// Prints HTML with meta information for the current post-date/time and author.
	public static function posted_on() {
		$time_string = '<time class="entry-date published" title="'. esc_html__('Posted on', 'pcworms') .'" data-toggle="tooltip" data-placement="bottom" datetime="%1$s">%2$s</time>';

		$time_string = sprintf( $time_string,
			get_the_date( DATE_W3C ),
			get_the_date()
		);

		// Finally, let's write all of this to the page.
		?>
		<span class="posted-on">
			<i class="fa fa-calendar" aria-hidden="true" title="<?php esc_attr_e('Posted on', 'pcworms'); ?>" data-toggle="tooltip" data-placement="bottom"></i> 
			<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php echo $time_string; // xss ok ?></a>
		</span>
		<?php
	}

	// Prints HTML with meta information for the current post-date/time and author.
	public static function modified_on() {
		$time_string = '<time class="entry-date updated" title="' . esc_html__('Updated on', 'pcworms') .'" data-toggle="tooltip" data-placement="bottom" datetime="%1$s">%2$s</time>';
		$time_string = sprintf( $time_string,
			get_the_modified_date( DATE_W3C ),
			get_the_modified_date()
		);

		// Finally, let's write all of this to the page.
		?>
		<span class="modified-on">
			<i class="fa fa-pencil fa-lg" aria-hidden="true" title="<?php esc_attr_e('Updated on', 'pcworms'); ?>" data-toggle="tooltip" data-placement="bottom"></i>
			<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php echo $time_string; // xss ok ?></a>
		</span>
		<?php
	}
	
	public static function get_post_image($size = 'thumbnail') {
		if(has_post_thumbnail()) {
			$image_id = get_post_thumbnail_id();
			$image_url = wp_get_attachment_image_src($image_id, $size);
			$image_url = $image_url[0];
		}else {
			global $post, $posts;
			$image_url = '';
			preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
			$image_url = (isset($matches [1][0]))? $matches [1][0] : get_template_directory_uri() . "/assets/images/content-image.png";
		}
		return esc_url($image_url);
	}
}

function render_badges($inp){
	$matches = array();
	$brands = null;
	$cache = get_transient("badges");
	$update_cache = false;
	if ($cache == false){
		$cache = array();
		$brands = json_decode(file_get_contents(get_template_directory() . '/assets/simple-icon/brands-color.json'), true);
		$res = set_transient("badges",$cache,300);
	}
	preg_match_all("/;([^;-]*)-?([^;]*);/",$inp,$matches,PREG_UNMATCHED_AS_NULL);
	for($i=0;$i<count($matches[1]);$i++){
		$badge = $matches[0][$i];
		if (array_key_exists($badge,$cache)){
			$inp = str_replace($badge,$cache[$badge],$inp);
		}else{
			$icon = strtolower($matches[1][$i]);
			$text = $matches[2][$i]!=""  ?  $matches[2][$i]  :  $matches[1][$i];
			if (is_null($brands))
				$brands = json_decode(file_get_contents(get_template_directory() . '/assets/simple-icon/brands-color.json'), true);
			$has_icon = array_key_exists($icon,$brands);
			if($has_icon)
				$color = $brands[$icon];
			else
				$color = sprintf('%06X', mt_rand(0, 0xFFFFFF));
			$src = 'https://img.shields.io/badge/' . str_replace('+','%20',urlencode($text)) . '-' . $color . '?logo=' . urlencode($icon) . '&logoColor=white';
			$img = '<img title="'.$text.'" src="'.$src.'">';
			$cache[$badge] = $img;
			$update_cache = true;
			$inp = str_replace($badge,$img,$inp);
		}
	}
	echo $inp;
	if ($update_cache)
		$res = set_transient("badges",$cache,300);
}

function custom_get_the_content_feed( $feed_type = null ) {
	if ( ! $feed_type ) {
		$feed_type = get_default_feed();
	}

	/** This filter is documented in wp-includes/post-template.php */
	$post_id = get_the_ID();
	$post_field = get_post_field( 'post_content', $post_id );
	$content_parts = get_extended( $post_field );
	$content = $content_parts['main'];
	$more_link_text = '<button class="continue-read btn dark-red"><span class="fa fa-eye"></span> ' . esc_html__( 'Continue reading', 'pcworms' ) . '</button>';
	$more = apply_filters( 'the_content_more_link', ' <a href="' . get_the_permalink() . "#more-{post_id}\" class=\"more-link\">$more_link_text</a>", $more_link_text );
	$content = apply_filters( 'the_content', $content ) . $more;
	$content = str_replace( ']]>', ']]&gt;', $content );

	return apply_filters( 'the_content_feed', $content, $feed_type );
}