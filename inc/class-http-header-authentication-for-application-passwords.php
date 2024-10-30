<?php
/**
 * Main plugin file
 *
 * @package http-header-authentication-for-application-passwords
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Main plugin class
 *
 * @since 1.0.0
 */
class HTTP_Header_Authentication_For_Application_Passwords {

	/**
	 * Creates a singleton instance of the plugin class.
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {
		static $inst = null;
		if ( null === $inst ) {
			$inst = new self();
		}
		return $inst;
	}

	/**
	 * Class constructor
	 */
	public function __construct() {
		$this->bootstrap();
	}

	/**
	 * Set up the plugin
	 *
	 * @since 1.0.0
	 */
	public function bootstrap() {
		$this->hooks();
	}

	/**
	 * Add initial hooks
	 *
	 * @since 1.0.0
	 */
	public function hooks() {
		add_filter( 'determine_current_user', array( $this, 'validate_application_password' ), 19 );
		add_filter( 'wp_is_site_protected_by_basic_auth', array( $this, 'allow_adding_application_passwords' ) );
	}

	/**
	 * Validates the application password credentials passed via HTTP headers.
	 * Required as some sites are already protected by Basic Auth and therefore won't work out of the box
	 *
	 * @since 1.0.0
	 *
	 * @param int|false $input_user User ID if one has been determined, false otherwise.
	 * @return int|false The authenticated user ID if successful, false otherwise.
	 */
	public function validate_application_password( $input_user ) {
		// Don't authenticate twice.
		if ( ! empty( $input_user ) ) {
			return $input_user;
		}

		if ( ! wp_is_application_passwords_available() ) {
			return $input_user;
		}

		// Both username and password must be set in order to attempt authentication.
		if ( ! isset( $_SERVER['HTTP_X_WP_USERNAME'], $_SERVER['HTTP_X_WP_PASSWORD'] ) ) {
			return $input_user;
		}

		// Seeing as this isn't sanitized in core it's safe to ignore here.
		$authenticated = wp_authenticate_application_password( null, $_SERVER['HTTP_X_WP_USERNAME'], $_SERVER['HTTP_X_WP_PASSWORD'] ); // phpcs:ignore

		if ( $authenticated instanceof WP_User ) {
			return $authenticated->ID;
		}

		// If it wasn't a user what got returned, just pass on what we had received originally.
		return $input_user;
	}

	/**
	 * Trick WordPress into thinking that the site isn't behind basic auth on the edit user screen so passwords can actually be created.
	 *
	 * @since 1.0.1
	 *
	 * @param bool $is_protected Whether the site is protected by Basic Auth.
	 * @return bool
	 */
	public function allow_adding_application_passwords( $is_protected ) {
		$screen = get_current_screen();
		if ( 'profile' === $screen->id ) {
			$is_protected = false;
		}
		return $is_protected;
	}

}
