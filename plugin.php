<?php
/**
 * @link            https://wp-vue-kickstart.com
 * @since           1.0.0
 * @package         WP_Vue_KickStart
 *
 * Plugin Name: Student-manage
 * Plugin URI: https://wp-vue-kickstart.com
 * Description: A wp vue starter for plugin development.
 * Version: 1.0.0
 * Author: Nitesh das
 * Author URI: https://robizstory.me
 * License: GPL v3
 * Text-Domain: textdomain
 */

if( ! defined( 'ABSPATH' ) ) exit(); // No direct access allowed

/**
 * Require Autoloader
 */
require_once 'vendor/autoload.php';

use WPVK\Api\Api;
use WPVK\Includes\Admin;
use WPVK\Includes\Frontend\Student;
use WPVK\Includes\Frontend\Assets;
use WPVK\Includes\Frontend\Ajax;


final class WP_Vue_Kickstart {

    /**
     * Define Plugin Version
     */
    const VERSION = '1.0.0';

    /**
     * Construct Function
     */
    public function __construct() {
        $this->plugin_constants();
        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );
        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Plugin Constants
     * @since 1.0.0
     */
    public function plugin_constants() {
        define( 'WPVK_VERSION', self::VERSION );
        define( 'WPVK_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
        define( 'WPVK_PLUGIN_URL', trailingslashit( plugins_url( '', __FILE__ ) ) );
        define('WPVK_AUTH_FILE', __FILE__);
        define('WPVK_AUTH_PATH', __DIR__);
        define('WPVK_AUTH_URL', plugins_url('', WPVK_AUTH_FILE));
        define('WPVK_AUTH_ASSETS', WPVK_AUTH_URL . '/assets');
        define( 'WPVK_NONCE', 'b?le*;K7.T2jk_*(+3&[G[xAc8O~Fv)2T/Zk9N:GKBkn$piN0.N%N~X91VbCn@.4' );
    }

    /**
     * Singletone Instance
     * @since 1.0.0
     */
    public static function init() {
        static $instance = false;

        if( !$instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * On Plugin Activation
     * @since 1.0.0
     */
    public function activate() {
        $install = new  WPVK\Includes\Installer;
        $install->run();
    }

    /**
     * On Plugin De-actiavtion
     * @since 1.0.0
     */
    public function deactivate() {
        // On plugin deactivation
    }

    /**
     * Init Plugin
     * @since 1.0.0
     */
    public function init_plugin() {
        // init
        new Assets();
        if(defined('DOING_AJAX') && DOING_AJAX) {
            new Ajax();
        }
        if(is_admin()) {
            new Admin();
        }
        new Student();
        new Api();
    }

}

/**
 * Initialize Main Plugin
 * @since 1.0.0
 */
function wp_vue_kickstart() {
    return WP_Vue_Kickstart::init();
}

// Run the Plugin
wp_vue_kickstart();