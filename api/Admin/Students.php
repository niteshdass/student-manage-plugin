<?php
namespace WPVK\Api\Admin;


class Students
{
/**
 * Student update after create user
 */
    function n_auth_update_student($gmail) {
        global $wpdb;
        $data = ['created_by' => 1];
        $updated = $wpdb->update(
            "{$wpdb->prefix}n_auth_students",
            $data,
            ['gmail' => $gmail],
            [
              '%d',
            ],
            ['%s']
        );

        if(!$updated) {
            return new \WP_Error('failed-to-update', __('Failed to update data', 'wedevs-academy'));
        }

        return $updated;
    }

    /**
     * Student add and update action method
     */

    function n_auth_add_student( $args = []) { 
        global $wpdb;

        if(empty($args['gmail'])) {
           return new WP_Error('no-name', __('Name required', 'nitesh-auth'));
        }

        if(empty($args['gmail'])) {
            return new WP_Error('no-gmail', __('Name required', 'nitesh-auth'));
         }

  
        $default = [
           'registration'    => '',
           'name'       => '',
           'dept'      => '',
           'gmail'      => '',
           'password'      => '12345678',
           'subject'    => '',
           'phone'      => '',
           'created_at' => current_time('mysql'),
        ];
        $data = wp_parse_args($args, $default);
        $inserted = $wpdb->insert(
           "{$wpdb->prefix}n_auth_students",
           $data,
           [
               '%d',
               '%s',
               '%s',
               '%s',
               '%s',
               '%s',
               '%d',
               '%s'
           ]
       );
       if(!$inserted) {
           return new \WP_Error('failed-to-insert', __('Failed to insert data', 'wedevs-academy'));
       }

       return $wpdb->insert_id;
    }

    /**
     * Create student response
     */
 
    public function create_items( $request ) {
        // Data validation
        $name = isset( $request['name'] ) ? sanitize_text_field( $request['name'] ): '';
        $phone  = isset( $request['phone'] ) ? sanitize_text_field( $request['phone'] )  : '';
        $subject     = isset( $request['subject'] ) ? sanitize_text_field( $request['subject'] ) : '';
        $registration     = isset( $request['registration'] ) ? sanitize_text_field( $request['registration'] ) : '';
        $dept     = isset( $request['dept'] ) ? sanitize_text_field( $request['dept'] ) : '';
        $gmail     = isset( $request['gmail'] ) ? sanitize_text_field( $request['gmail'] ) : '';



        $data = [
            'name' => $name,
            'phone'  => $phone,
            'subject'     => $subject,
            'registration' => $registration,
            'dept'        => $dept,
            'gmail'       => $gmail
        ];

        $response = $this->n_auth_add_student($data);
        if(!is_wp_error($response)) {
            return rest_ensure_response( $response );
        } else {
            return rest_ensure_response( $response );
        }
        
    }

    /**
     * Make action for get student
     * @ Return students array
     */

    function n_auth_get_students( $args = [], $tableName) {
        global $wpdb;
        $defaults = [
            'number'  => 20,
            'offset'  => 0,
            'orderby' => 'id',
            'order'   => 'ASC'
        ];
        $args = wp_parse_args($args, $defaults);
    
        $items = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}$tableName
                ORDER BY {$args['orderby']} {$args['order']}
                LIMIT %d, %d",
                $args['offset'], $args['number']
            )
        );
    
        return $items;
    }

    /**
     * Get students response
     */
    public function get_items( ) {
        $contacts = $this->n_auth_get_students([], 'n_auth_students');
        return $contacts;
    }

    /**
     * Student delete
     * User delete, If has account
     */

    public function delete_item( $request ) {
        global $wpdb;
        $gmail = $request['email'];
        $user = $request['user'];
        $delete_student = $wpdb->delete(
            $wpdb->prefix . 'n_auth_students',
            ['gmail' => $gmail],
            ['%s']
        );
        if($delete_student) {
            if($user === '1') {
                $delete_user = $wpdb->delete(
                    'wp_users',
                    ['user_email' => $gmail],
                    ['%s']
                );
                if(!$delete_user) {
                    return new \WP_Error('failed-to-delete_user', __('Failed to delete data', 'wedevs-academy'));
                }
            }
        } else {
            return new \WP_Error('failed-to-delete_student', __('Failed to delete data', 'wedevs-academy'));
        }



        $data = [
            'deleted'  => true,
        ];

        $response = rest_ensure_response( $data );

        return $response;
    }

}