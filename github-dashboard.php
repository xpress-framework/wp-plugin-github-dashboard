<?php
/**
 * Plugin Name: XPress MVC Github Dashboard
 * Version: 0.1.0
 * Plugin URI: https://github.com/xpress-framework/wp-plugin-github-dashboard
 * Description: Github API model to automate Github operations.
 * Author: Juan Manuel Arias
 * Author URI: https://github.com/xpress-framework
 * Requires at least: 4.8
 * Tested up to: 4.8.1
 * License: GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Text Domain: xpress-github-dashboard
 * Domain Path: /lang/
 *
 * @package    XPress
 * @subpackage MVC
 */

// Require necessary classes.
require_once 'models/github-project.php';
require_once 'models/github-column.php';
