<?php

/**
 * This class is intended to manage the options associated with this plugin.
 */
class JPry_Weather_Options {

	/**
	 * The name of the options in the DB.
	 *
	 * @var string
	 */
	protected $option_name = 'wp_weather_options';

	/**
	 * The array of options retrieved from the DB.
	 *
	 * @var array
	 */
	protected $options = array();

	/**
	 * Whether the options have been updated.
	 *
	 * @var bool
	 */
	protected $updated = false;

	/**
	 *
	 */
	public function __construct() {

	}

	/**
	 * Destructor.
	 *
	 * Saves options to the database if needed.
	 */
	public function __destruct() {
		$this->save_to_db();
	}


	public function add( $key, $value ) {
		if ( isset( $this->options[ $key ] ) ) {
			return;
		}

		$this->options[ $key ] = $value;
		$this->updated = true;
	}

	/**
	 * Create our options in the database.
	 */
	public function create() {
		$defaults = array(
			'apikey' => '',
		);

		add_option( $this->option_name, $defaults );
	}

	/**
	 * Get an option by name, or all of the options if no name is given.
	 *
	 * @param string $key (optional) The option name to retrieve.
	 *
	 * @return mixed The option value, or all of the options.
	 */
	public function get( $key = null ) {
		if ( empty( $this->options ) ) {
			$this->get_from_db();
		}

		if ( ! is_null( $key ) ) {
			$value = isset( $this->options[ $key ] ) ? $this->options[ $key ] : null;
		} else {
			$value = $this->options;
		}

		return $value;
	}

	/**
	 * Load our options from the database.
	 */
	protected function get_from_db() {
		if ( empty( $this->options ) ) {
			$this->options = get_option( $this->option_name );
		}
	}

	/**
	 * Save the options to the Database.
	 */
	public function save_to_db() {
		if ( $this->updated ) {
			update_option( $this->option_name, $this->options );
			$this->updated = false;
		}
	}

	/**
	 * Update an option.
	 *
	 * @param string $key   The option name to update.
	 * @param mixed  $value The option value.
	 */
	public function update( $key, $value ) {
		// If the option doesn't exist, send to the add() method.
		if ( ! isset( $this->options[ $key ] ) ) {
			$this->add( $key, $value );
			return;
		}

		// If the option is being set to its current value, bail early.
		if ( $this->options[ $key ] === $value ) {
			return;
		}

		$this->options[ $key ] = $value;
		$this->updated = true;
	}
}
