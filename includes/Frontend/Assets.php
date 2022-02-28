<?php

namespace WPVK\Includes\Frontend;

/**
 * Assets handlers class
 */
class Assets {

    /**
     * Class constructor
     */
    function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );
    }

    /**
     * All available scripts
     *
     * @return array
     */
    public function get_scripts() {
        return [
            'wpvk-student-list-script' => [
                'src'     => WPVK_AUTH_ASSETS . '/js/list-student.js',
                'version' => filemtime( WPVK_AUTH_PATH . '/assets/js/list-student.js' ),
                'deps'    => [ 'jquery' ]
            ],
            'wpvk-student-new-script' => [
                'src'     => WPVK_AUTH_ASSETS . '/js/new-student.js',
                'version' => filemtime( WPVK_AUTH_PATH . '/assets/js/new-student.js' ),
                'deps'    => [ 'jquery' ]
            ]
        ];
    }

    /**
     * All available styles
     *
     * @return array
     */
    public function get_styles() {
        return [
            'wpvk-student-list-style' => [
                'src'     => WPVK_AUTH_ASSETS . '/css/list-student.css',
                'version' => filemtime( WPVK_AUTH_PATH . '/assets/css/list-student.css')
            ],
            'wpvk-student-new-style' => [
                'src'     => WPVK_AUTH_ASSETS . '/css/new-student.css',
                'version' => filemtime( WPVK_AUTH_PATH . '/assets/css/new-student.css')
            ]
        ];
    }

    /**
     * Register scripts and styles
     *
     * @return void
     */
    public function register_assets() {
        $scripts = $this->get_scripts();
        $styles  = $this->get_styles();

        foreach ( $scripts as $handle => $script ) {
            $deps = isset( $script['deps'] ) ? $script['deps'] : false;

            wp_register_script( $handle, $script['src'], $deps, $script['version'], true );
        }

        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;

            wp_register_style( $handle, $style['src'], $deps, $style['version'] );
        }
        
        wp_localize_script('wpvk-student-list-script', 'ajax_url', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'n_auth_frontend_nonce' => wp_create_nonce('n_auth_ajax_frontend_nonce')
        ));
        wp_localize_script('wpvk-student-new-script', 'ajax_url_new_student', array(
            'ajax_url_new_student' => admin_url('admin-ajax.php'),
            'n_auth_new_student_nonce' => wp_create_nonce('n_auth_ajax_new_student_nonce')
        ));
    }

}