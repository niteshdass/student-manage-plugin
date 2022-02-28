<?php
namespace WPVK\Api\Admin;

class Subject
{
    public  $studentadd;
    function __construct($studentadd) {
        $this->studentadd = $studentadd;
    
    }

    public function get_subjects( $request ) {
        $contacts = $this->studentadd->n_auth_get_students([], 'n_auth_subjects');
        return $contacts;
    }

      /**
     * Database request for ctrate subject
     */

    public function n_auth_create_subject($args = []) {
        global $wpdb;

        if(empty($args['name'])) {
           return new WP_Error('no-name', __('Name required', 'nitesh-auth'));
        }

        if(empty($args['dept'])) {
            return new WP_Error('no-dept', __('Dept required', 'nitesh-auth'));
         }

        $default = [
            'dept'    => '',
            'name'       => '',
            'created_at' => current_time('mysql'),
         ];
         $data = wp_parse_args($args, $default);

         $inserted = $wpdb->insert(
            "{$wpdb->prefix}n_auth_subjects",
            $data,
            [
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
     *  Subject create
     */

    public function create_subjects( $request ) {
        $name = isset( $request['name'] ) ? sanitize_text_field( $request['name'] ): '';
        $phone  = isset( $request['dept'] ) ? sanitize_text_field( $request['dept'] )  : '';

        $data = [
            'name' => $name,
            'dept'  => $phone
        ];

        $response = $this->n_auth_create_subject($data);

        if(!is_wp_error($response)) {
            return rest_ensure_response( $response );
        } else {
            return rest_ensure_response( $response );
        }

     }

    /**
     * Delete subject
     * Also delete subject from student list if has.
     */

    public function delete_subject( $request ) {
        global $wpdb;
        $id = $request['id'];
        $name = $request['name'];
        $delete_subject = $wpdb->delete(
            $wpdb->prefix . 'n_auth_subjects',
            ['id' => $id],
            ['%d']
        );

        if(!is_wp_error($delete_subject)) {
            $stds =  $this->studentadd->n_auth_get_students([], 'n_auth_students');
            for ($i = 0;  $i < count($stds); $i++) {
                if(str_contains($stds[$i]->subject, $name)) {
                    str_replace($name, "", $stds[$i]->subject);
                    $replace_string = ['subject' => str_replace($name, "", $stds[$i]->subject)];
                    $wpdb->update(
                        "{$wpdb->prefix}n_auth_students",
                        $replace_string,
                        ['id' => $stds[$i]->id],
                        [
                        '%s'
                        ],
                        ['%d']
                    );
                }
            }
            return rest_ensure_response( $delete_subject );

        } else {
            return rest_ensure_response( $delete_subject );
        }


    }
     
}