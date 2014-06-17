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
	 * API constants.
	 */
	const API_SCHEME = 'https';
	const API_DOMAIN = 'api.forecast.io';
	const API_PATH   = '/forecast/';

	/* Public Methods
	-----------------------------------------------*/
	
	/**
	 * Get the single instance of this class.
	 *
	 * @since 0.1.0
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
	 * Get data from the API.
	 *
	 * @since 0.1.0
	 *
	 * @param string $latitude  The latitude of weather information to request
	 * @param string $longitude The longitude of weather information to request
	 * @param string $time      (Optional) The timestamp of weather information to request
	 * @return stdClass The weather data object
	 */
	public function get( $latitude, $longitude, $time = null ) {
		return $this->curl_request( 'get', $latitude, $longitude, $time );
	}

	/**
	 * Get data from the API
	 *
	 * Allows additional options to be sent in addition to the normal settings.
	 *
	 * @since 0.1.0
	 *
	 * @param string $latitude  The latitude of weather information to request
	 * @param string $longitude The longitude of weather information to request
	 * @param string $options   Options to send with the request.
	 * @param string $time      (Optional) The timestamp of weather information to request
	 * @return stdClass
	 */
	public function post( $latitude, $longitude, $options, $time = null ) {
		return $this->curl_request( 'post', $latitude, $longitude, $time, $options );
	}

	/* Protected Methods
	-----------------------------------------------*/
	
	/**
	 * Constructor.
	 * 
	 * Set up the API Key
	 * 
	 * @since 0.1.0
	 * 
	 * @param string $api_key The API Key to use when requesting data.
	 */
	protected function __construct( $api_key ) {
		$this->api_key = $api_key;
	}

	/* Private methods
	-----------------------------------------------*/

	/**
	 * Send a request to the API using CURL.
	 *
	 * @since 0.1.0
	 *
	 * @param string $method    The method to use when connecting to the server. Valid methods are 'get' or 'post'
	 * @param string $latitude  The latitude of weather information to request
	 * @param string $longitude The longitude of weather information to request
	 * @param string $time      (Optional) The timestamp of weather information to request
	 * @param array  $options   (Optional) Options to send with the request.
	 * @return stdClass The weather data object
	 */
	private function curl_request( $method, $latitude, $longitude, $time = null, $options = array() ) {

		// Build the URL
		$url = "${self::API_SCHEME}://${self::API_DOMAIN}${self::API_PATH}{$this->api_key}/{$latitude},{$longitude}";

		if ( null !== $time ) {
			$url .= ",{$time}";
		}

		// Set up curl
		$c = curl_init( $url );
		curl_setopt( $c, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, 15 );
		curl_setopt( $c, CURLOPT_TIMEOUT, 20 );

		// Handle POST
		if ( 'post' == $method ) {

		}

		// Send the request
		$response = curl_exec( $c );

		return json_decode( $response );
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
