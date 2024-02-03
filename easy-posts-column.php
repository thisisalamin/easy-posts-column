<?php
/**
 * Plugin Name: Easy Posts Column
 * Plugin URI: https://github.com/thisisalamin/easy-posts-column
 * Description: Easy Posts Column is a WordPress plugin that allows you to add a custom column to the posts, pages, and custom post types admin page.
 * Version: 1.0.0
 * Author: Mohamed Alamin
 * Author URI: https://www.linkedin.com/in/thisismdalamin/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: easy-posts-column
 * Domain Path: /languages
 * Requires at least: 5.2
 * Requires PHP: 7.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define the plugin path
define( 'EPC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

class Easy_Posts_Column {
    /**
     * Constructor method for the Easy_Posts_Column class.
     * Initializes the plugin by adding an action hook to the 'init' event.
     */
    public function __construct(){
        add_action( 'init', array( $this, 'init' ) );
    }
    
    /**
     * Initialization method for the plugin.
     * Requires the necessary files and initializes the required classes.
     */
    public function init() {
        require_once( EPC_PLUGIN_PATH . 'query-data.php' );
        new Query_Data();
        require_once( EPC_PLUGIN_PATH . 'custom-column.php' );
        new Custom_Column();
    }

}

new Easy_Posts_Column();
