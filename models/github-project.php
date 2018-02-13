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
	 * Common methods for querying Github API.
	 *
	 * @since 0.1.0
	 */
	use XPress_Github_API_Wrapper;

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
		$url = static::construct_url( 'projects', $id );

		$json = static::make_request( $url );

		$project = empty( $json ) ? null : static::new( $json );

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

		$url = static::construct_url( 'repos', $params['owner'], $params['repo'], 'projects' );

		unset( $params['owner'] );
		unset( $params['repo'] );

		$json = static::make_request( $url, array(
			'body' => $params,
		) );

		foreach ( $json as $value ) {
			$result[] = static::new( $value );
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
			$url = static::construct_url( 'repos', $this->owner, $this->repo, 'projects' );
			$json = static::make_request( $url, array(
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
		$url = static::construct_url( 'projects', $this->id );

		$response = static::make_request( $url, array(
			'method' => 'DELETE',
		) );

		return empty( $response ) ? false : true;
	}
}
