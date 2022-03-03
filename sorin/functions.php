<?php
/**
 * Sorin functions and definitions
 * *
 * @package WordPress
 * @subpackage Sorin
 * @since 1.0
 */

define('SORIN_THEME_VERSION','1.0.0');
define('SORIN_THEME_DIR', get_template_directory());
define('SORIN_THEME_URL', get_template_directory_uri());

/**
 * init theme
 */
function initTheme()
{
	/*include theme config*/
	$config = require_once SORIN_THEME_DIR.'/includes/Config.php';
	$GLOBALS['config'] = $config;
	/*include theme options*/
	require_once SORIN_THEME_DIR.'/includes/Theme.php';
	$GLOBALS['themeContent'] = new \Sorin\Theme();

}
add_action('after_setup_theme','initTheme');

/**
 * Set theme options global variable
 */
add_action('wp_loaded',function(){
	global $config;
	/**
     * global $themeOptions variable name .
     * @object
     **/
	$GLOBALS['themeOptions'] = (object)get_option($config->optionName);


});

require_once SORIN_THEME_DIR.'/includes/template-tags.php';
require_once SORIN_THEME_DIR.'/includes/breadcumbs.php';
require_once SORIN_THEME_DIR.'/includes/class-paginations.php';



