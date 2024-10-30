<?php
/**
 * Plugin Name: HTTP Header Authentication for Application Passwords
 * Description: Allows sending application passwords using HTTP headers instead of basic authentication
 * Author: Cameron Jones
 * Author URI: https://cameronjonesweb.com.au
 * Version: 1.0.1
 * License: GPLv2
 *
 * @package http-header-authentication-for-application-passwords
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Pulls in the main plugin class.
 */
require_once 'inc/class-http-header-authentication-for-application-passwords.php';

HTTP_Header_Authentication_For_Application_Passwords::get_instance();
