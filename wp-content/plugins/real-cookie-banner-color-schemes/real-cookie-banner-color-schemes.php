<?php
/**
 *  Plugin Name: Real Cookie Banner - Color schemes
 *  Description: With the Color schemes add on for Real Cookie Banner you can setup the colors for the single objects in Groups. You don't have to go through all sections anymore.
 *  Version: 1.5.3
 *  Author: Holger "der_wasi" Wassenhoven
 *  Author URI: https://wasiwarez.net/
 *  Plugin URI: https://de.wordpress.org/plugins/real-cookie-banner-color-schemes/
 *  Text Domain: rcb-color-schemes
 *  Domain Path: /languages
 *  
 *  Requires plugin: Real Cookie Banner from devowl.io
 *  Required plugins URI: https://de.wordpress.org/plugins/real-cookie-banner/
 *  
 */

defined('ABSPATH') or die('Fehlerhafter Aufruf');
 
if(!defined('RCBCS_PLUGIN_BASENAME')) define('RCBCS_PLUGIN_BASENAME', plugin_basename(__FILE__));
if(!defined('RCBCS_PLUGIN_URL')) define('RCBCS_PLUGIN_URL', plugin_dir_url(__FILE__));
if(!defined('RCBCS_TEXTDOMAIN')) define('RCBCS_TEXTDOMAIN', 'rcb-color-schemes');
if(!defined('RCBCS_CAP')) define('RCBCS_CAP', 'edit_theme_options');

/**
 *  Activate developer mode
 *  
 *  Is used to load the fully readable scripts instead of the minified ones.
 */
if(!defined('RCBCS_DEV_MODE')) define('RCBCS_DEV_MODE', false);

/**
 *  Executes on plugin activation
 *  
 *  A transient is set to show the thank you message on page reload.
 *  
 *  @since 1.0.0
 *  @since 1.1.1	Colors are fetched on activation of plugin
 *  @since 1.2.0	Added option accept essentials like accept all
 *  
 *  @return void
 */

function rcbcs_activationHook() {
	update_option('rcbcs-primary-color', get_option('rcb-banner-body-design-btn-accept-all-bg'));
	update_option('rcbcs-primary-color-hover', get_option('rcb-banner-body-design-btn-accept-all-hover-bg'));
	update_option('rcbcs-secondary-like-primary', get_option('rcb-banner-body-design-btn-accept-essentials-use-accept-all'));
	update_option('rcbcs-save-like-primary', get_option('rcb-save-button-use-accept-all'));
	update_option('rcbcs-secondary-color', get_option('rcb-banner-body-design-btn-accept-essentials-bg'));
	update_option('rcbcs-secondary-color-hover', get_option('rcb-banner-body-design-btn-accept-essentials-hover-bg'));
	update_option('rcbcs-background-color', get_option('rcb-banner-design-bg'));
	update_option('rcbcs-primary-font-color', get_option('rcb-banner-design-font-color'));
	update_option('rcbcs-secondary-font-color', get_option('rcb-banner-body-design-teachings-font-color'));
	update_option('rcbcs-link-color', get_option('rcb-group-link-color'));
	update_option('rcbcs-link-color-hover', get_option('rcb-group-link-hover-color'));
	set_transient('rcbcs_plugin_activation', 1, 60);
}

register_activation_hook(__FILE__, 'rcbcs_activationHook');

/**
 *  Shows thank you message on reload after plugin activation
 *  
 *  This is called once, when the plugin is activated.
 *  
 *  @since 1.0.0
 *  @since 1.2.0	Disabled hook
 *  
 *  @return void
 */
function rcbcs_adminNoticePluginActivation() {
	if(get_transient('rcbcs_plugin_activation')) {
		delete_transient('rcbcs_plugin_activation');
		echo '	<div class="notice notice-success is-dismissible">';
		echo '		<p>';
						_e(
							'Thanks for using the Color schemes add on for Real Cookie Banner. '.
							'Inside the Cookie Banner panel inside the customizer there is a new section now, called Color scheme. '.
							'There you can change the colors of the cookie banner in one place.',
							RCBCS_TEXTDOMAIN
						);
		echo '		</p>';
		echo '		<button type="button" class="notice-dismiss">';
		echo '			<span class="screen-reader-text">';
							_e('Dismiss this notice', RCBCS_TEXTDOMAIN);
		echo '			</span>';
		echo '		</button>';
		echo '	</div>';
	}
}

// add_action('admin_notices', 'rcbcs_adminNoticePluginActivation');

/**
 *  Checks if plugin Real Cookie Banner is installed and activated
 *  
 *  If not, this plugin is deactivated.
 *  
 *  @since 1.0.0
 *  @since 1.1.2	Changed check of installed plugin from !is_plugin_active('real-cookie-banner/index.php')
 *  				to !defined('RCB_PATH'). Like this it is compatible with pro version either.
 *  
 *  @return void
 */
function rcbcs_adminInitCheckForRealCookieBannerPlugin() {
	if(current_user_can('activate_plugins') && !defined('RCB_PATH')) {
		add_action('admin_notices', 'rcbcs_adminNoticeRCBNotInstalled');
		delete_transient('rcbcs_plugin_activation');
		deactivate_plugins(RCBCS_PLUGIN_BASENAME);
	}
}

add_action('admin_init', 'rcbcs_adminInitCheckForRealCookieBannerPlugin');

/**
 *  Shows an error message if plugin Real Cookie Banner is deactivated
 *  
 *  @since 1.0.0
 *  
 *  @return void
 */
function rcbcs_adminNoticeRCBNotInstalled() {
	echo '	<div class="notice notice-error">';
	echo '		<p>';
	echo '			<strong>';
						_e('Error in Color schemes add on', RCBCS_TEXTDOMAIN);
	echo '			</strong><br>';
					_e(
						'Real Cookie Banner plugin is not installed. Color schemes is deactivated.<br>'.
						'Get the latest version of Real Cookie Banner Free ' .
						'<a href="https://de.wordpress.org/plugins/real-cookie-banner/" target="_blank">here</a> '.
						'or the pro version ' .
						'<a href="https://devowl.io/de/wordpress-real-cookie-banner/" target="_blank">here</a> '.
						'or just search inside the plugin installation page for Real Cookie Banner from devowl.io.',
						RCBCS_TEXTDOMAIN
					);
	echo '		</p>';
	echo '	</div>';
}

/**
 *  Loads languages
 *  
 *  @since 1.0.0
 *  
 *  @return void
 */
function rcbcs_loadTextdomain() {
    load_plugin_textdomain(RCBCS_TEXTDOMAIN, FALSE, basename(dirname(__FILE__)) . '/languages/');
}

add_action('plugins_loaded', 'rcbcs_loadTextdomain');

/**
 *  Enqueues scripts for Customizer control pane
 *  
 *  @since 1.0.0
 *  
 *  @return void
 */
function rcbcs_enqueueScripts() {
	if(RCBCS_DEV_MODE) $script = 'customize-controls.js';
	else $script = 'customize-controls.min.js';
	wp_enqueue_script('rcbcs-customizer-js', RCBCS_PLUGIN_URL . 'assets/js/' . $script, array('wp-i18n', 'jquery'));
}

add_action('customize_controls_enqueue_scripts', 'rcbcs_enqueueScripts');

/**
 *  Handles customizer objects
 *  
 *  There is a new section added to the Cookie Banner panel. It is called "Color schemes".
 *  With this it is possible to set up the colors in groups. It is not neccessary to setup every
 *  color any more.
 *  
 *  @since 1.0.0
 *  @since 1.2.0	Added option for handling secondary color like primary color
 *  
 *  @param object $wp_customize WP_Customize_Manager object
 *  @return void
 */
function rcbcs_customizeRegister($wp_customize) {
	// set_transient('wwz', '<pre>'.print_r($wp_customize->get_panel('real-cookie-banner-banner')->print_template(), true).'</pre>');
	
	// Add our section inside the Real Cookie Banner panel
	$wp_customize->add_section(
		'rcb-color-schemes',
		array(
			'title'			=>	__('Color scheme', RCBCS_TEXTDOMAIN),
			'description'	=>	__('Change colors for cookie banner in groups. You won\'t have to go trough all settings anymore, to change the colors. You can change single color settings afterwards anyway.', RCBCS_TEXTDOMAIN),
			'panel'			=>	'real-cookie-banner-banner',
			'priority'		=>	10,
			'capability'	=>	RCBCS_CAP,
		)
	);
	
	// Primary color
	$wp_customize->add_setting(
		'rcbcs-primary-color',
		array(
			'type'				=>	'option',
			'capability'		=>	RCBCS_CAP,
			'default'			=>	'#15779b',
			'transport'			=>	'postMessage',
			'sanitize_callback' =>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'rcbcs-primary-color',
			array(
				'label'    => __('Primary color', RCBCS_TEXTDOMAIN),
				'section'  => 'rcb-color-schemes',
				'settings' => 'rcbcs-primary-color',
				'priority' => 10,
			)
		)
	);
	
	// Primary color hover
	$wp_customize->add_setting(
		'rcbcs-primary-color-hover',
		array(
			'type'				=>	'option',
			'capability'		=>	RCBCS_CAP,
			'default'			=>	'#11607d',
			'transport'			=>	'postMessage',
			'sanitize_callback' =>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'rcbcs-primary-color-hover',
			array(
				'label'    => __('Primary color on mouse over', RCBCS_TEXTDOMAIN),
				'section'  => 'rcb-color-schemes',
				'settings' => 'rcbcs-primary-color-hover',
				'priority' => 20,
			)
		)
	);

	// Secondary Color like primary color
	$wp_customize->add_setting(
		'rcbcs-secondary-like-primary',
		array(
			'type'				=>	'option',
			'capability'		=>	RCBCS_CAP,
			'default'			=>	get_option('rcb-banner-body-design-btn-accept-essentials-use-accept-all'),
			'transport'			=>	'postMessage',
		)
	);
	$wp_customize->add_control(
		'rcbcs-secondary-like-primary',
		array(
			'label'		=>	__('Secondary color like primary', RCBCS_TEXTDOMAIN),
			'section'	=>	'rcb-color-schemes',
			'settings'	=>	'rcbcs-secondary-like-primary',
			'type'		=>	'checkbox',
			'priority'	=>	25,
		)
	);
	
	// Secondary color
	$wp_customize->add_setting(
		'rcbcs-secondary-color',
		array(
			'type'				=>	'option',
			'capability'		=>	RCBCS_CAP,
			'default'			=>	'#efefef',
			'transport'			=>	'postMessage',
			'sanitize_callback' =>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'rcbcs-secondary-color',
			array(
				'label'    => __('Secondary color', RCBCS_TEXTDOMAIN),
				'section'  => 'rcb-color-schemes',
				'settings' => 'rcbcs-secondary-color',
				'priority' => 30,
			)
		)
	);
	
	// Secondary color hover
	$wp_customize->add_setting(
		'rcbcs-secondary-color-hover',
		array(
			'type'				=>	'option',
			'capability'		=>	RCBCS_CAP,
			'default'			=>	'#e8e8e8',
			'transport'			=>	'postMessage',
			'sanitize_callback' =>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'rcbcs-secondary-color-hover',
			array(
				'label'    => __('Secondary color on mouse over', RCBCS_TEXTDOMAIN),
				'section'  => 'rcb-color-schemes',
				'settings' => 'rcbcs-secondary-color-hover',
				'priority' => 40,
			)
		)
	);
	
	// Banner background color
	$wp_customize->add_setting(
		'rcbcs-background-color',
		array(
			'type'				=>	'option',
			'capability'		=>	RCBCS_CAP,
			'default'			=>	'#ffffff',
			'transport'			=>	'postMessage',
			'sanitize_callback' =>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'rcbcs-background-color',
			array(
				'label'    => __('Banner background color', RCBCS_TEXTDOMAIN),
				'section'  => 'rcb-color-schemes',
				'settings' => 'rcbcs-background-color',
				'priority' => 50,
			)
		)
	);
	
	// Primary font color
	$wp_customize->add_setting(
		'rcbcs-primary-font-color',
		array(
			'type'				=>	'option',
			'capability'		=>	RCBCS_CAP,
			'default'			=>	'#2b2b2b',
			'transport'			=>	'postMessage',
			'sanitize_callback' =>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'rcbcs-primary-font-color',
			array(
				'label'    => __('Primary font color', RCBCS_TEXTDOMAIN),
				'section'  => 'rcb-color-schemes',
				'settings' => 'rcbcs-primary-font-color',
				'priority' => 60,
			)
		)
	);

	// Secondary font color
	$wp_customize->add_setting(
		'rcbcs-secondary-font-color',
		array(
			'type'				=>	'option',
			'capability'		=>	RCBCS_CAP,
			'default'			=>	'#7c7c7c',
			'transport'			=>	'postMessage',
			'sanitize_callback' =>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'rcbcs-secondary-font-color',
			array(
				'label'    => __('Secondary font color', RCBCS_TEXTDOMAIN),
				'section'  => 'rcb-color-schemes',
				'settings' => 'rcbcs-secondary-font-color',
				'priority' => 70,
			)
		)
	);

	// Link color
	$wp_customize->add_setting(
		'rcbcs-link-color',
		array(
			'type'				=>	'option',
			'capability'		=>	RCBCS_CAP,
			'default'			=>	'#7c7c7c',
			'transport'			=>	'postMessage',
			'sanitize_callback' =>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'rcbcs-link-color',
			array(
				'label'    => __('Link color', RCBCS_TEXTDOMAIN),
				'section'  => 'rcb-color-schemes',
				'settings' => 'rcbcs-link-color',
				'priority' => 80,
			)
		)
	);
	
	// Link color hover
	$wp_customize->add_setting(
		'rcbcs-link-color-hover',
		array(
			'type'				=>	'option',
			'capability'		=>	RCBCS_CAP,
			'default'			=>	'#2b2b2b',
			'transport'			=>	'postMessage',
			'sanitize_callback' =>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'rcbcs-link-color-hover',
			array(
				'label'    => __('Link color on mouse over', RCBCS_TEXTDOMAIN),
				'section'  => 'rcb-color-schemes',
				'settings' => 'rcbcs-link-color-hover',
				'priority' => 80,
			)
		)
	);

	// Save button Color like primary color
	$wp_customize->add_setting(
		'rcbcs-save-like-primary',
		array(
			'type'				=>	'option',
			'capability'		=>	RCBCS_CAP,
			'default'			=>	get_option('rcb-save-button-use-accept-all'),
			'transport'			=>	'postMessage',
		)
	);
	$wp_customize->add_control(
		'rcbcs-save-like-primary',
		array(
			'label'		=>	__('Save button color like primary', RCBCS_TEXTDOMAIN),
			'section'	=>	'rcb-color-schemes',
			'settings'	=>	'rcbcs-save-like-primary',
			'type'		=>	'checkbox',
			'priority'	=>	90,
		)
	);
	
}

add_action('customize_register', 'rcbcs_customizeRegister', 20);

?>