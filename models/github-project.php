<?php
/**
 * XPress Github Projects Model Class
 *
 * @package    XPress
 * @subpackage MVC
 * @author     Trasgo Furioso
 * @license    GPLv2
 * @since      0.1.0
 */

class XPress_Github_Project_Model extends XPress_MVC_Model {
	/**
	 * Model schema.
	 *
	 * @since 0.1.0
	 * @var array
	 */
	static protected $schema = array(
		'owner' => array(
			'description' => 'Owner',
			'type'        => 'string',
			'required'    => true,
		),
		'repo' => array(
			'description' => 'Repository',
			'type'        => 'string',
			'required'    => true,
		),
		'id' => array(
			'description' => 'Id',
			'type'        => 'number',
		),
		'name' => array(
			'description' => 'Name',
			'type'        => 'string',
			'required'    => true,
		),
		'body' => array(
			'description' => 'Name',
			'type'        => 'string',
		),
		'state' => array(
			'description' => 'State',
			'type'        => 'string',
		),
		'owner_url' => array(
			'description' => 'Owner url',
			'type'        => 'string',
		),
		'url' => array(
			'description' => 'Url',
			'type'        => 'string',
		),
		'html_url' => array(
			'description' => 'Html url',
			'type'        => 'string',
		),
		'columns_url' => array(
			'description' => 'Columns url',
			'type'        => 'string',
		),
		'number' => array(
			'description' => 'Number',
			'type'        => 'string',
		),
		'creator' => array(
			'description' => 'Creator',
			'type'        => 'string',
		),
		'created_at' => array(
			'description' => 'Created at',
			'type'        => 'string',
		),
		'updated_at' => array(
			'description' => 'Updated at',
			'type'        => 'string',
		),
	);

	/**
	 * Return a model instance for a specific item.
	 *
	 * @since 0.1.0
	 *
	 * @return XPress_Github_Model instance.
	 */
	static function get( $id ) {
		$url = XPress_Github_Project_Model::construct_url( 'projects', $id );

		$json = XPress_Github_Project_Model::make_request( $url );

		$project = empty( $json ) ? null : XPress_Github_Project_Model::new( $json );

		return $project;
	}

	/**
	 * Return a model instance collection filtered by the params.
	 *
	 * @since 0.1.0
	 *
	 * @return array XPress_Github_Model instance collection.
	 */
	static function find( $params ) {
		$result = array();

		$url = XPress_Github_Project_Model::construct_url( 'repos', $params['owner'], $params['repo'], 'projects' );

		unset( $params['owner'] );
		unset( $params['repo'] );

		$json = XPress_Github_Project_Model::make_request( $url, array(
			'body' => $params,
		) );

		foreach ( $json as $value ) {
			$result[] = XPress_Github_Project_Model::new( $value );
		}

		return $result;
	}

	/**
	 * Persists the current model instance.
	 *
	 * @since 0.1.0
	 *
	 * @return XPress_Github_Model instance.
	 */
	public function save() {
		if ( $this->is_valid() ) {
			$url = XPress_Github_Project_Model::construct_url( 'repos', $this->owner, $this->repo, 'projects' );
			$json = XPress_Github_Project_Model::make_request( $url, array(
				'method' => 'POST',
				'body'   => json_encode( array(
					'name' => $this->name,
					'body' => $this->body,
				) ),
			) );

			if ( empty( $json ) ) {
				$project = null;
			} else {
				$this->update( $json );
				$project = $this;
			}
		} else {
			$project = false;
		}

		return $project;
	}

	/**
	 * Deleted the current model instance.
	 *
	 * @since 0.1.0
	 *
	 * @return XPress_Github_Model instance.
	 */
	public function delete() {
		$url = XPress_Github_Project_Model::construct_url( 'projects', $this->id );

		$response = XPress_Github_Project_Model::make_request( $url, array(
			'method' => 'DELETE',
		) );

		return false === $response ? false : true;
	}

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
				'Authorization' => 'Basic ' . base64_encode( 'lavmeiker:86c6609a71dffb3c93d812f829a19984f4a0fe27' ),
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
			$json = json_decode( $body, true );
			return $json;
		} else {
			return false;
		}
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
