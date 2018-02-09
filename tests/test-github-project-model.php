<?php
/**
 * Github Project Model Test
 *
 * @package    XPress
 * @subpackage MVC
 * @author     Trasgo Furioso
 * @license    GPLv2
 * @since      0.1.0
 */

class XPress_Github_Project_Model_Test extends WP_UnitTestCase {
	/**
	 * Create an instance.
	 */
	function test_new_instance() {
		$this->assertInstanceOf( XPress_Github_Project_Model::class, XPress_Github_Project_Model::new() );
	}

	/**
	 * Get a list of projects.
	 */
	function test_find() {
		$projects = XPress_Github_Project_Model::find( array(
			'owner' => 'xpress-framework',
			'repo'  => 'wp-plugin-github-dashboard',
			'state' => 'open',
		) );

		$this->assertInternalType( 'array', $projects );
		$this->assertCount( 1, $projects );
		$this->assertInstanceOf( XPress_Github_Project_Model::class, $projects[0] );
	}

	/**
	 * Get a single project by id.
	 */
	function test_get() {
		$project = XPress_Github_Project_Model::get( 1275863 );

		$this->assertInstanceOf( XPress_Github_Project_Model::class, $project );
	}


}
