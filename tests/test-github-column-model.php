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
}
