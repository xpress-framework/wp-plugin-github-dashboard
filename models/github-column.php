<?php
/**
 * XPress Github Column Model Class
 *
 * @package    XPress
 * @subpackage MVC
 * @author     Trasgo Furioso
 * @license    GPLv2
 * @since      0.1.0
 */

class XPress_Github_Column_Model extends XPress_MVC_Model {
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
		'project_id' => array(
			'description' => 'Project Id',
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
		'url' => array(
			'description' => 'Url',
			'type'        => 'string',
		),
		'project_url' => array(
			'description' => 'Project url',
			'type'        => 'string',
		),
		'cards_url' => array(
			'description' => 'Cards url',
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

		$url = static::construct_url( 'projects', $params['project_id'], 'columns' );

		unset( $params['project_id'] );

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
	}

	/**
	 * Deleted the current model instance.
	 *
	 * @since 0.1.0
	 *
	 * @return XPress_Github_Model instance.
	 */
	public function delete() {
	}
}
