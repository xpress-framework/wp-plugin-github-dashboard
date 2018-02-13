<?php
/**
 * XPress Github API Wrapper
 * To be included in all models that queries the Github API.
 *
 * @package    XPress
 * @subpackage MVC
 * @author     Trasgo Furioso
 * @license    GPLv2
 * @since      0.1.0
 */

trait XPress_Github_API_Wrapper {
	/**
	 * Make a request to Github API.
	 *
	 * @since 0.1.0
	 *
	 * @return array Response as associative array.
	 */
	static function make_request( $url, $params=array() ) {
		$request_args = wp_parse_args( $params, array(
			'method'      => 'GET',
			'httpversion' => '1.1',
			'compress'    => true,
			'decompress'  => true,
			'timeout'     => 10,
			'body'        => null,
			'headers'     => array(
				'Authorization' => 'Basic ' . base64_encode( GITHUB_AUTH_USER . ':' . GITHUB_AUTH_TOKEN ),
				'Accept'        => 'application/vnd.github.inertia-preview+json',
				'Content-Type'  => 'application/json',
			),
		) );

		// var_dump($url);
		// var_dump($request_args);

		$response = wp_safe_remote_request( $url, $request_args );
		$code = wp_remote_retrieve_response_code( $response );
		$headers = wp_remote_retrieve_headers( $response );
		$body = wp_remote_retrieve_body( $response );

		// var_dump($code);
		// var_dump($headers);
		// var_dump($body);

		if ( $code >= 200 && $code < 300 ) {
			if ( 204 === $code ) {
				// An empty array confuses delete method.
				$json = array( '204 No Content' );
			} else {
				$json = json_decode( $body, true );
			}
		}
		elseif ( 404 === $code ) {
			$json = array();
		} else {
			$json = false;
		}

		return $json;
	}

	/**
	 * Construct the request url for Github.
	 *
	 * @since 0.1.0
	 *
	 * @return string Url for request.
	 */
	static function construct_url( ...$parts ) {
		array_unshift( $parts, 'https://api.github.com' );
		return join( '/', $parts );
	}
}
