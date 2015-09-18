<?php

/**
 * Main plugin class.
 *
 * If you need to access methods in this class, use the get_instance() method.
 *
 * @since 0.1.0
 * @var string $version  Plugin version
 * @var string $basename Plugin basename
 * @var string $url      Plugin URL
 * @var string $path     Plugin Path
 */
class JPry_WP_Weather {

	/**
	 * Plugin basename.
	 *
	 * @var string
	 * @since 0.1.0
	 */
	protected $basename = '';

	/**
	 * The forecast object.
	 *
	 * @var JPry_Forecast_IO
	 */
	protected $forecast = null;

	/**
	 * Path of plugin directory.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	protected $path = '';

	/**
	 * Singleton instance of plugin.
	 *
	 * @since 0.1.0
	 * @var JPry_WP_Weather
	 */
	protected static $single_instance = null;

	/**
	 * URL of plugin directory.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	protected $url = '';

	/**
	 * The plugin version.
	 *
	 * @var string
	 */
	protected $version;

	/**
	 * Sets up our plugin.
	 *
	 * @since 0.1.0
	 *
	 * @param string $file The full path to the main plugin file.
	 */
	protected function __construct( $file ) {
		$this->basename = plugin_basename( $file );
		$this->url      = plugin_dir_url( $file );
		$this->path     = plugin_dir_path( $file );

		register_activation_hook( $file, array( $this, '_activate' ) );
		register_deactivation_hook( $file, array( $this, '_deactivate' ) );

		$data = get_file_data( $file, array( 'version' => 'Version' ) );
		$this->version = $data['version'];

		$this->plugin_classes();
	}

	/**
	 * Attach other plugin classes to the base plugin class.
	 *
	 * @since 0.1.0
	 */
	function plugin_classes() {
		// Attach other plugin classes to the base plugin class.
	}


	public function get_forecaster() {
		if ( is_null( $this->forecast ) ) {
			// TODO: Include the API key from somewhere
			$this->forecast = new JPry_Forecast_IO('');
		}

		return $this->forecast;
	}

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since 0.1.0
	 *
	 * @param string $file The full path to the main plugin file.
	 *
	 * @return JPry_WP_Weather A single instance of this class.
	 * @throws \Exception When creating a new instance and no file parameter is passed.
	 */
	public static function get_instance( $file = null ) {
		if ( null === self::$single_instance ) {
			if ( is_null( $file ) ) {
				throw new \Exception( "File is needed to create new class instance." );
			}
			self::$single_instance = new self( $file );
		}

		return self::$single_instance;
	}

	/**
	 * Add hooks and filters.
	 *
	 * @since 0.1.0
	 */
	public function hooks() {
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Activate the plugin
	 *
	 * @since 0.1.0
	 */
	function _activate() {

	}

	/**
	 * Deactivate the plugin.
	 *
	 * Uninstall routines should be in uninstall.php.
	 *
	 * @since 0.1.0
	 */
	function _deactivate() {

	}

	/**
	 * Init hooks.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		if ( $this->check_requirements() ) {
			load_plugin_textdomain( 'wp-weather', false, dirname( $this->basename ) . '/languages/' );
		}
	}

	/**
	 * Check if the plugin meets requirements and disable it if they are not present.
	 *
	 * @since 0.1.0
	 * @return bool result of meets_requirements
	 */
	public function check_requirements() {
		if ( ! $this->meets_requirements() ) {

			// Add a dashboard notice
			add_action( 'all_admin_notices', array( $this, 'requirements_not_met_notice' ) );

			// Deactivate our plugin
			deactivate_plugins( $this->basename );

			return false;
		}

		return true;
	}

	/**
	 * Check that all plugin requirements are met.
	 *
	 * @since 0.1.0
	 * @return bool
	 */
	public static function meets_requirements() {
		// Do checks for required classes / functions
		// function_exists('') & class_exists('')

		// We have met all requirements
		return true;
	}

	/**
	 * Adds a notice to the dashboard if the plugin requirements are not met.
	 *
	 * @since 0.1.0
	 */
	public function requirements_not_met_notice() {
		// Output our error
		echo '<div id="message" class="error">';
		echo '<p>' . sprintf( __( 'WP Weather is missing requirements and has been <a href="%s">deactivated</a>. Please make sure all requirements are available.', 'wp-weather' ), admin_url( 'plugins.php' ) ) . '</p>';
		echo '</div>';
	}

	/**
	 * Magic getter for our object.
	 *
	 * @since 0.1.0
	 *
	 * @param string $field
	 *
	 * @throws Exception When the field is invalid.
	 * @return mixed
	 */
	public function __get( $field ) {
		switch ( $field ) {
			case 'version':
			case 'basename':
			case 'url':
			case 'path':
				return $this->$field;
			default:
				throw new Exception( 'Invalid ' . __CLASS__ . ' property: ' . $field );
		}
	}
}
