<?php
namespace WPVK\Api\Admin;

class User
{
    public  $studentadd;
    function __construct($studentadd) {
        $this->studentadd = $studentadd;
    
    }
    /**
     * Get user by gmail
     * Check user alraedy exist
     */
    function n_auth_get_user($gmail) {
        global $wpdb;
        return $wpdb->get_row(
           $wpdb->prepare("SELECT * FROM {$wpdb->prefix}users WHERE user_email = %s", $gmail)
        );
    }
    /**
     * Create user action
     */
    
    function n_auth_add_user( $args = []) { 
        global $wpdb;

        if(empty($args['user_login']) || empty($args['user_pass']) || empty($args['user_nicename'])) {
           return new \WP_Error('all-field-require', __('All field required', 'nitesh-auth'));
        }

        $default = [
           'user_login'       => '',
           'user_pass'      => md5('12345678'),
           'user_nicename'      => '',
           'user_email'      => ''
        ];
        $data = wp_parse_args($args, $default);

        if($this->n_auth_get_user($args['user_email'])) {
            return new \WP_Error('user-already-insert', __('User already inserted', 'wedevs-academy'));
        }
        $inserted = $wpdb->insert(
           "{$wpdb->prefix}users",
           $data,
           [
               '%s',
               '%s',
               '%s',
               '%s'
           ]
       );

       if(!$inserted) {
           return new \WP_Error('failed-to-insert', __('Failed to insert data', 'wedevs-academy'));
       }

       return $wpdb->insert_id;
    }

    /**
     * Create user response
     */

    public function create_user( $request ) {

        // Data validation
        $name = isset( $request['name'] ) ? sanitize_text_field( $request['name'] ): '';
        $gmail  = isset( $request['gmail'] ) ? sanitize_text_field( $request['gmail'] )  : '';
        $pass     = isset( $request['password'] ) ? sanitize_text_field( $request['password'] ) : '';
        $password = md5($pass);

        $data = [
            'user_login' => $name,
            'user_pass'  => $password,
            'user_nicename' => $name,
            'user_email'     => $gmail
        ];
        $response = $this->n_auth_add_user($data);

        if(!is_wp_error($response)) {
            $this->studentadd->n_auth_update_student($gmail);
            return rest_ensure_response( $response );
        } else {
            return rest_ensure_response( $response );
        }
        
    }

}