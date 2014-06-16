<?php
namespace JPry;

/**
 *
 */
class Forecast_IO {

	private $api_key;
	const API_URL;
	
	/**
	 * Get the single instance of this class.
	 *
	 * @since 1.0
	 *
	 * @return Forecast_IO The class object.
	 */
	public static function get_instance( $api_key = null ) {
		static $instance = null;
		if ( null === $instance ) {
			if ( null === $api_key ) {
				return false;
			}
			$instance = new static( $api_key );
		}
		return $instance;
	}
	
	protected function __construct( $api_key ) {
		$this->api_key = $api_key;
	}

}
