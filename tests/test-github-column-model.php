<?php
/**
 * Github Column Model Test
 *
 * @package    XPress
 * @subpackage MVC
 * @author     Trasgo Furioso
 * @license    GPLv2
 * @since      0.1.0
 */

class XPress_Github_Column_Model_Test extends WP_UnitTestCase {
	/**
	 * Test suite setup.
	 */
	function setUp() {
		if ( ! defined( 'GITHUB_AUTH_USER' ) ) {
			define( 'GITHUB_AUTH_USER', getenv( 'GITHUB_AUTH_USER' ) );
		}
		if ( ! defined( 'GITHUB_AUTH_TOKEN' ) ) {
			define( 'GITHUB_AUTH_TOKEN', getenv( 'GITHUB_AUTH_TOKEN' ) );
		}
	}

	/**
	 * Create an instance.
	 */
	function test_new_instance() {
		$this->assertInstanceOf( XPress_Github_Column_Model::class, XPress_Github_Column_Model::new() );
	}

	/**
	 * Get a list of columns for a project.
	 * Columns should be XPress_Github_Column_Model instances.
	 */
	function test_find() {
		$columns = XPress_Github_Column_Model::find( array(
			'project_id' => '1275863',
		) );

		$this->assertInternalType( 'array', $columns );
		$this->assertCount( 3, $columns );
		$this->assertInstanceOf( XPress_Github_Column_Model::class, $columns[0] );
	}

	/**
	 * No matching criteria should return empty array.
	 */
	function test_find_404() {
		$projects = XPress_Github_Column_Model::find( array(
			'project_id' => '0',
		) );

		$this->assertInternalType( 'array', $projects );
		$this->assertCount( 0, $projects );
	}
}
