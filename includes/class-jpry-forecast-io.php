<?php

/**
 * A class for interacting with the Forecast.IO API.
 */
class JPry_Forecast_IO {

	/**
	 * The API Key to use with the request.
	 *
	 * @var string
	 */
	protected $api_key;

	/**
	 * The API URL.
	 *
	 * This should include the API Key.
	 *
	 * @var string
	 */
	protected $api_url;

	/**
	 * Constructor.
	 *
	 * @param string $api_key The API Key to use with requests.
	 */
	public function __construct( $api_key ) {
		$this->api_key = $api_key;
		$this->api_url = 'https://api.forecast.io/forecast/' . $api_key;
	}

	/**
	 * Get the forecast for a specific latitude and longitude.
	 *
	 * @param string|float $latitude  The location's latitude.
	 * @param string|float $longitude The location's longitude.
	 *
	 * @return array The array of data from the API.
	 * @throws Exception When any of the parameters are not numeric.
	 */
	public function get( $latitude, $longitude ) {
		$this->check_numeric( $latitude, $longitude );
		$url = $this->get_url( $latitude, $longitude );

		return $this->get_response( $url );
	}

	/**
	 * Check to ensure a set of numbers are numeric.
	 *
	 * @throws Exception When any of the given args is not numeric.
	 */
	protected function check_numeric() {
		// Grab all of the args passed in
		$args = func_get_args();

		// Check each one, and throw an exception if not numeric
		foreach ( $args as $arg ) {
			if ( ! is_numeric( $arg ) ) {
				throw new \Exception( "You must pass a numeric value." );
			}
		}
	}

	/**
	 * Get the URL based on latitude, longitude, and time.
	 *
	 * @param string|float $latitude  The latitude.
	 * @param string|float $longitude The longitude.
	 * @param string|int   $time      The time.
	 *
	 * @return string The URL.
	 */
	protected function get_url( $latitude, $longitude, $time = null ) {

		// Ensure the latitude and longitude values are floats
		$latitude  = (float) $latitude;
		$longitude = (float) $longitude;

		// Generate the URL for the request
		$url = sprintf( '%s/%f,%f', $this->api_url, $latitude, $longitude );

		// If we have a time value, use that too
		if ( isset( $time ) ) {
			$time = (int) $time;
			$url .= ",{$time}";
		}

		return $url;
	}

	/**
	 * Get a response from a given URL, and handle any errors.
	 *
	 * @param string $url The URL where we're making the request.
	 *
	 * @return array The array of data from the response.
	 * @throws Exception When there is a WP_Error is generated.
	 * @throws Exception When the API response cannot be decoded, or is empty.
	 */
	protected function get_response( $url ) {
		$response = wp_remote_get( $url );

		if ( is_wp_error( $response ) ) {
			throw new \Exception( $response->get_error_message() );
		}

		$data = json_decode( $response, true );
		if ( is_null( $data ) ) {
			throw new \Exception( "Unable to decode API response." );
		}

		return $data;
	}

	/**
	 * Get the forecast for a specific longitude, latitude, and time.
	 *
	 * @param string|float $latitude  The location's latitude.
	 * @param string|float $longitude The location's longitude.
	 * @param string|int   $time      The time.
	 *
	 * @return array The array of data from the API.
	 * @throws Exception When any of the parameters are not numeric.
	 */
	public function get_time( $latitude, $longitude, $time ) {
		$this->check_numeric( $latitude, $longitude, $time );
		$url = $this->get_url( $latitude, $longitude, $time );

		return $this->get_response( $url );
	}
}
