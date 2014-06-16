<?php
namespace JPry;

/**
 *
 */
class Forecast_IO {

	/**
	 * The API key.
	 *
	 * @var string
	 */
	private $api_key;
	
	/**
	 *
	 */
	const API_URL = 'https://api.forecast.io/';
	
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
	
	/**
	 * Constructor.
	 * 
	 * Set up the API Key
	 * 
	 * @since 1.0
	 * 
	 * @param string $api_key The API Key to use when requesting data.
	 */
	protected function __construct( $api_key ) {
		$this->api_key = $api_key;
	}
	
	
	private function request( $latitude, $longitude, $time = null, $options = array() ) {
		
		$request_url = self::API_URL
			. $this->api_key
			. '/'
			. $latitude
			. ','
			. $longitude
			. ( is_null( $time ) ) ? '' : ",${time}";
			
		if ( ! empty( $options ) ) {
			$request_url .= "?" . http_build_query( $options );	
		}
		
		$response = json_decode(  );
	}

}
