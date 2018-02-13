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
		$this->assertInstanceOf( XPress_Github_Project_Model::class, XPress_Github_Project_Model::new() );
	}

	/**
	 * Get a list of projects.
	 * Projects should be XPress_Github_Project_Model instances.
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
		// $this->assertEquals( 'owner', $projects[0] );
	}

	/**
	 * No matching criteria should return empty array.
	 */
	function test_find_404() {
		$projects = XPress_Github_Project_Model::find( array(
			'owner' => 'xpress-framework',
			'repo'  => 'wp-plugin-github-dashboard',
			'state' => 'closed',
		) );

		$this->assertInternalType( 'array', $projects );
		$this->assertCount( 0, $projects );
	}

	/**
	 * Get a single project by id.
	 */
	function test_get() {
		$project = XPress_Github_Project_Model::get( 1275863 );

		$this->assertInstanceOf( XPress_Github_Project_Model::class, $project );
	}

	/**
	 * Id not found should return empty response.
	 */
	function test_get_404() {
		$project = XPress_Github_Project_Model::get( 0 );

		$this->assertEmpty( $project );
	}

	/**
	 * Create a project should return the created project object.
	 * Create a project should update the project instance with the values returned by the API.
	 * Delete a project should return true/false.
	 */
	function test_create_delete_project() {
		$project = XPress_Github_Project_Model::new( array(
			'owner' => 'xpress-framework',
			'repo'  => 'wp-plugin-github-dashboard',
			'name'  => 'Dynamically Created',
			'body'  => 'This is the body.',
		) );

		$saved_project = $project->save();

		$this->assertInstanceOf( XPress_Github_Project_Model::class, $saved_project );
		$this->assertEquals( 'Dynamically Created', $saved_project->name );
		$this->assertEquals( 'This is the body.', $saved_project->body );

		// Delete project successfully, return true.
		$this->assertTrue( $project->delete() );
		// Project does not exist anymore, return false.
		$this->assertFalse( $project->delete() );
	}

	/**
	 * Return false if project is invalid and don't save.
	 */
	function test_create_invalid_project() {
		$project = XPress_Github_Project_Model::new( array(
			'name'  => 'Dynamically Created',
			'body'  => 'This is the body.',
		) );

		$this->assertFalse( $project->save() );
	}
}
