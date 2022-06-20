<?php
/**
 * Contains methods for customizing the theme customization screen.
 * 
 * @link http://codex.wordpress.org/Theme_Customization_API
 */
class Free_Template_Customizer {
	
	static $login_form_systems = array(
		'WordPress'		=> 'WordPress',
		'WooCommerce'	=> 'WooCommerce',
		'WHMCS'			=> 'WHMCS',
	);

   /**
    * This hooks into 'customize_register' (available as of WP 3.4) and allows
    * you to add new sections and controls to the Theme Customize screen.
    * 
    * Note: To enable instant preview, we have to actually write a bit of custom
    * javascript. See live_preview() for more.
    *  
    * @see add_action('customize_register',$func)
    * @param \WP_Customize_Manager $wp_customize
    * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
    */
	public static function register( $wp_customize ) {

		$wp_customize->add_section( 'free-template-pcworms' . '-options', array(
				'title'       		=> esc_html__( 'Theme Options', 'free-template-pcworms' ),										//Visible title of section
				'priority'    		=> 20,																										//Determines what order this appears in
				'capability'  	=> 'edit_theme_options',																			//Capability needed to tweak
				'description'	=> esc_html__('Allows you to customize settings for Theme.', 'free-template-pcworms'),	//Descriptive tooltip
			)
		);
 		$wp_customize->add_setting( 'bootstrap_theme_name',								//No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
			array(
				'default'    		=> 'default',																//Default setting/value to save
				'type'      		=> 'theme_mod', 														//Is this an 'option' or a 'theme_mod'?
				'capability'		=> 'edit_theme_options', 											//Optional. Special permissions for accessing this setting.
				'sanitize_callback'		=> 'Free_Template_Customizer::sanitize_text',
				//'transport'	=> 'postMessage', 														//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);
		/* Supports basic input types `text`, `checkbox`, `textarea`, `radio`, `select` and `dropdown-pages`.
		 * Additional input types such as `email`, `url`, `number`, `hidden` and `date` are supported implicitly. */
		$wp_customize->add_control( new WP_Customize_Control(
			$wp_customize, 																					//Pass the $wp_customize object (required)
			'bootstrap_theme_name', 																	//Set a unique ID for the control
			array(
				'label'      		=> esc_html__( 'Select Theme Name', 'free-template-pcworms' ),	//Admin-visible name of the control
				'description'	=> esc_html__( 'Using this option you can change the theme colors', 'free-template-pcworms' ),
				'settings'		=> 'bootstrap_theme_name', 										//Which setting to load and manipulate (serialized is okay)
				'priority'			=> 10, 																		//Determines the order this control appears in for the specified section
				'section'			=> 'free-template-pcworms' . '-options', 										//ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'type'			=> 'select',
				'choices'		=> array(
					'default' 	=> esc_html__( 'Default', 'free-template-pcworms' ),
					'cerulean' 	=> 'Cerulean',
					'cosmo'		=> 'Cosmo',
					'cyborg' 	=> 'Cyborg',
					'darkly' 		=> 'Darkly',
					'flatly' 		=> 'Flatly',
					'journal'		=> 'Journal',
					'lumen'		=> 'Lumen',
					'paper'		=> 'Paper',
					'readable'	=> 'Readable',
					'sandstone'=> 'Sandstone',
					'simplex'		=> 'Simplex',
					'slate'		=> 'Slate',
					'spacelab'	=> 'Spacelab',
					'superhero'	=> 'Superhero',
					'united'		=> 'United',
					'yeti'			=> 'Yeti',
				)
			)
		) );

		
		if ( function_exists( 'wp_statistics_pages' )){
			$wp_customize->add_setting( 'display_visits',		//No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
				array(
					'default'			=> true,							//Default setting/value to save
					'type'			=> 'theme_mod', 				//Is this an 'option' or a 'theme_mod'?
					'capability'		=> 'edit_theme_options', 	//Optional. Special permissions for accessing this setting.
					'theme_supports'	=> array(), 				//Theme features required to support the panel. Default is none.
					'transport'		=> 'refresh',						//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
					'validate_callback'	=> '',
					'sanitize_callback'		=> 'Free_Template_Customizer::sanitize_checkbox',
					'dirty'					=> '',
				)
			);
			/* Supports basic input types `text`, `checkbox`, `textarea`, `radio`, `select` and `dropdown-pages`.
			 * Additional input types such as `email`, `url`, `number`, `hidden` and `date` are supported implicitly. */
			$wp_customize->add_control( new WP_Customize_Control(
				$wp_customize, 																				//Pass the $wp_customize object (required)
				'display_visits', 																				//Set a unique ID for the control
				array(
					'settings'			=> 'display_visits', 												//Which setting to load and manipulate (serialized is okay)
					'capability'			=> 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
					'priority'				=> 13, 																//Determines the order this control appears in for the specified section , Default: 10
					'section'				=> 'free-template-pcworms' . '-options', 								//ID of the section this control should render in (can be one of yours, or a WordPress default section)
					'label'				=> esc_html__( 'Display visits?', 'free-template-pcworms' ),	//Admin-visible name of the control
					'description'		=> esc_html__( 'Display number of visits in pages and posts', 'free-template-pcworms' ),
					'input_attrs'		=> array(),														// List of custom input attributes for control output, where attribute names are the keys and values are the values.
																													// Not used for 'checkbox', 'radio', 'select', 'textarea', or 'dropdown-pages' control types. Default empty array.
					'allow_addition'	=> false,															// (bool) Show UI for adding new content, currently only used for the dropdown-pages control. Default false.
					'active_callback'	=> array(),
					'type'				=> 'checkbox',													// Control type. Core controls include 'text', 'checkbox', 'textarea', 'radio', 'select', and 'dropdown-pages'.
																													// Additional input types such as 'email', 'url', 'number', 'hidden', and 'date' are supported implicitly. Default 'text'.
					/*
					'choices'			=> [																	// List of choices for 'radio' or 'select' type controls
						'yes'	=> esc_html__( 'Yes', 'free-template-pcworms' ),
						'no'	=> esc_html__( 'No', 'free-template-pcworms' ),
					],
					*/
				)
			) );
		}
		
		$wp_customize->add_section( 'free-template-pcworms' . '-login-form-options', 
			array(
				'title'				=> esc_html__( 'Popup Login Form', 'free-template-pcworms' ),												//Visible title of section
				'priority'			=> 22,																												//Determines what order this appears in
				'capability'		=> 'edit_theme_options',																					//Capability needed to tweak
				'description'	=> esc_html__('Allows you to customize login link and login form.', 'free-template-pcworms'),	//Descriptive tooltip
			)
		);
		$wp_customize->add_setting( 'display_login_link',		//No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
			array(
				'type'					=> 'theme_mod',				//Is this an 'option' or a 'theme_mod'?
				'capability'				=> 'edit_theme_options',	//Optional. Special permissions for accessing this setting.
				'theme_supports'	=> array(),						//Theme features required to support the panel. Default is none.
				'default'					=> false,							//Default value for the setting. Default is empty string.
				'transport'				=> 'refresh',						//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
				'validate_callback'	=> '',
				'sanitize_callback'		=> 'Free_Template_Customizer::sanitize_checkbox',
				'dirty'					=> '',
			)
		);
		$wp_customize->add_control( new WP_Customize_Control(
			$wp_customize,																					//Pass the $wp_customize object (required)
			'display_login_link',																				//Set a unique ID for the control
			array(
				'settings'			=> 'display_login_link',												//Which setting to load and manipulate (serialized is okay)
				'capability'			=> 'edit_theme_options',										//Optional. Special permissions for accessing this setting.
				'priority'				=> 11,																	//Determines the order this control appears in for the specified section , Default: 10
				'section'				=> 'free-template-pcworms' . '-login-form-options',						//ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'label'				=> esc_html__( 'Display login link?', 'free-template-pcworms' ),	//Admin-visible name of the control
				'description'		=> esc_html__( 'Display a link on topmenu for login user', 'free-template-pcworms' ),
				'input_attrs'		=> array(),															// List of custom input attributes for control output, where attribute names are the keys and values are the values.
																													// Not used for 'checkbox', 'radio', 'select', 'textarea', or 'dropdown-pages' control types. Default empty array.
				'allow_addition'	=> false,																// (bool) Show UI for adding new content, currently only used for the dropdown-pages control. Default false.
				'active_callback'	=> array(),
				'type'				=> 'checkbox',														// Control type. Core controls include 'text', 'checkbox', 'textarea', 'radio', 'select', and 'dropdown-pages'.
																													// Additional input types such as 'email', 'url', 'number', 'hidden', and 'date' are supported implicitly. Default 'text'.
				/*
				'choices'			=> [																		// List of choices for 'radio' or 'select' type controls
					'yes'	=> esc_html__( 'Yes', 'free-template-pcworms' ),
					'no'	=> esc_html__( 'No', 'free-template-pcworms' ),
				],
				*/
			)
		) );
		$wp_customize->add_setting( 'login_link_text',				//No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
			array(
				'type'						=> 'theme_mod',				//Is this an 'option' or a 'theme_mod'?
				'capability'					=> 'edit_theme_options',	//Optional. Special permissions for accessing this setting.
				'theme_supports'		=> array(),						//Theme features required to support the panel. Default is none.
				'default'						=> 'Login',							//Default value for the setting. Default is empty string.
				'transport'					=> 'refresh',						//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
				'validate_callback'		=> '',
				'sanitize_callback'			=> 'Free_Template_Customizer::sanitize_login_link_texts',
				'dirty'						=> '',
			)
		);
		$wp_customize->add_control( new WP_Customize_Control(
			$wp_customize,																				//Pass the $wp_customize object (required)
			'login_link_text',																				//Set a unique ID for the control
			array(
				'settings'			=> 'login_link_text',											//Which setting to load and manipulate (serialized is okay)
				'capability'			=> 'edit_theme_options',									//Optional. Special permissions for accessing this setting.
				'priority'				=> 12,																//Determines the order this control appears in for the specified section , Default: 10
				'section'				=> 'free-template-pcworms' . '-login-form-options',					//ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'label'				=> esc_html__( 'Login link text', 'free-template-pcworms' ),	//Admin-visible name of the control
				'description'		=> esc_html__( 'Please select the login link text', 'free-template-pcworms' ),
				'input_attrs'		=> array(),														// List of custom input attributes for control output, where attribute names are the keys and values are the values.
																												// Not used for 'checkbox', 'radio', 'select', 'textarea', or 'dropdown-pages' control types. Default empty array.
				'allow_addition'	=> false,															// (bool) Show UI for adding new content, currently only used for the dropdown-pages control. Default false.
				'active_callback'	=> array(),
				'type'				=> 'select',														// Control type. Core controls include 'text', 'checkbox', 'textarea', 'radio', 'select', and 'dropdown-pages'.
																												// Additional input types such as 'email', 'url', 'number', 'hidden', and 'date' are supported implicitly. Default 'text'.
				'choices'			=>  Free_Template::login_link_texts(),									// List of choices for 'radio' or 'select' type controls
			)
		) );

		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
		$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->default = 'fff';
		$wp_customize->get_setting( 'background_color' )->default = 'inherit';
	  
	}


	static function sanitize_checkbox($input){
		return ( isset( $input ) && true === (bool) $input ? true : false );
	}
	
	static function sanitize_login_link_texts( $input ) {
		return (array_key_exists($input, Free_Template::login_link_texts())) ? $input :  'Login';
	}

	static function sanitize_text($input) {
		return (sanitize_text_field($input));
	}

	
   /**
	* This outputs the javascript needed to automate the live settings preview.
	* Also keep in mind that this function isn't necessary unless your settings 
	* are using 'transport'=>'postMessage' instead of the default 'transport'
	* => 'refresh'
	* 
	* Used by hook: 'customize_preview_init'
	* 
	* @see add_action('customize_preview_init',$func)
	*/
	public static function live_preview() {
		wp_enqueue_script(
			'free-template-pcworms' . '-theme-customizer', // Give the script a unique ID
			get_template_directory_uri() . '/assets/js/theme-customizer.js', // Define the path to the JS file
			array('jquery', 'customize-preview'), // Define dependencies
			wp_get_theme()->get( 'Version' ), // Define a version (optional) 
			true // Specify whether to put in footer (leave this true)
		);
	}

}
