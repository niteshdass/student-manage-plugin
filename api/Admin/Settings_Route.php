<?php
namespace WPVK\Api\Admin;
use WPVK\Api\Admin\Add_Student;

use WP_REST_Controller;

class Settings_Route extends WP_REST_Controller  {
    public $students;
    public $users;
    public $subject;
    protected $namespace;
    protected $rest_base;

    public function __construct() {
        $studentadd = new Students();
        $this->namespace = 'wpvk/v1';
        $this->rest_base = 'settings';
        $this->students = new Students();
        $this->subject = new Subject($studentadd);
        $this->users = new User($studentadd);
    }

    /**
     * Register Routes
     */
    public function register_routes() {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            [
                [
                    'methods'              => \WP_REST_Server::READABLE,
                     'callback'            => [ $this->students, 'get_items'],
                     'permission_callback' => [ $this, 'get_items_permission_check_for_both'],
                ],
                [
                    'methods'             => \WP_REST_Server::CREATABLE,
                    'callback'            => [ $this->students, 'create_items' ],
                    'permission_callback' => [ $this, 'get_items_permission_check_for_both' ],
                ]
            ]
        );
        register_rest_route(
            $this->namespace,
            '/subjects/' . $this->rest_base,
            [
                [
                    'methods'             => \WP_REST_Server::CREATABLE,
                    'callback'            => [ $this->subject, 'create_subjects' ],
                    'permission_callback' => [ $this, 'get_items_permission_check' ],
                ],
                [
                    'methods'              => \WP_REST_Server::READABLE,
                    'callback'            => [ $this->subject, 'get_subjects'],
                    'permission_callback' => [ $this, 'get_items_permission_check'],
                ]

            ]     
        );
        register_rest_route(
            $this->namespace,
            '/user/' . $this->rest_base,
            [
                [
                     'methods'              => \WP_REST_Server::READABLE,
                     'callback'            => [ $this->users, 'get_items'],
                     'permission_callback' => [ $this, 'get_items_permission_check'],
                ],
                [
                    'methods'             => \WP_REST_Server::CREATABLE,
                    'callback'            => [ $this->users, 'create_user' ],
                    'permission_callback' => [ $this, 'get_items_permission_check' ],
                ],
                'schema' => [$this, 'get_item_schema']
            ]
        );

        register_rest_route(
            $this->namespace,
            '/user/' . $this->rest_base . '/(?P<email>\S+)/(?P<user>[\d]+)',
            [
                'methods'             => \WP_REST_Server::DELETABLE,
                'callback'            => [ $this->students, 'delete_item' ],
                'permission_callback' => [ $this, 'get_items_permission_check' ],
            ],
        );
        register_rest_route(
            $this->namespace,
            '/subject/' . $this->rest_base . '/(?P<id>[\d]+)/(?P<name>\S+)',
            [
                'methods'             => \WP_REST_Server::DELETABLE,
                'callback'            => [ $this->subject, 'delete_subject' ],
                'permission_callback' => [ $this, 'get_items_permission_check' ],
            ],
        );

    }
    /**
     * Check admin
     */

    function is_admin() {
        $user = wp_get_current_user();
        if(empty($user)) {
            return false;
        }
        return true;
    }

    /**
     * Check user login
     */

    function is_user_logged_in() {
        $user = wp_get_current_user();
        if(empty($user)) {
            return false;
        }
        return true;
    }

    /**
     * Get items permission check
     */
    public function get_items_permission_check( $request ) {
        return $this->is_admin() ? true : false;
    }

    public function get_items_permission_check_for_both($request) {
        return $this->is_user_logged_in() ? true : false;
    }


    /**
     * Create item response
     */

}