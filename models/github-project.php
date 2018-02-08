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
	);

	/**
	 * Return a model instance for a specific item.
	 *
	 * @since 0.2.0
	 *
	 * @return XPress_Github_Model instance.
	 */
	static function get( $id ) {
		$json = json_decode( '{
		"id": 1002604,
	    "name": "Projects Documentation",
	    "body": "Developer documentation project for the developer site.",
	    "state": "open"
		}' );

		$project = XPress_Github_Project_Model::new( $json );

		return $project;
	}

	/**
	 * Return a model instance collection filtered by the params.
	 *
	 * @since 0.2.0
	 *
	 * @return array XPress_Github_Model instance collection.
	 */
	static function find( $params ) {
		$json = json_decode( '[{
		"id": 1002604,
	    "name": "Projects Documentation",
	    "body": "Developer documentation project for the developer site.",
	    "state": "open"
		}]' );

		$result = array();

		foreach ( $json as $value ) {
			$result[] = XPress_Github_Project_Model::new( $value );
		}

		return $result;
	}

	/**
	 * Persists the current model instance.
	 *
	 * @since 0.2.0
	 *
	 * @return XPress_Github_Model instance.
	 */
	public function save() {}

	/**
	 * Deleted the current model instance.
	 *
	 * @since 0.2.0
	 *
	 * @return XPress_Github_Model instance.
	 */
	public function delete() {}
}
