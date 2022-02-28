<?php
    namespace WPVK\Includes\Frontend;

class Ajax {
    function __construct()
    {

        add_action('wp_ajax_n_auth_delete_student', [$this, 'n_auth_delete_student']);
        add_action('wp_ajax_n_auth_delete_subject', [$this, 'n_auth_delete_subject']);
        add_action('wp_ajax_n_auth_get_student', [$this, 'n_auth_get_student']);
        add_action('wp_ajax_n_auth_get_students', [$this, 'n_auth_get_students']);

        add_action('wp_ajax_wpvk_new_student', [$this, 'wpvk_new_student']);

        // frontend
        add_action('wp_ajax_nopriv_wpvk_new_student', [$this, 'wpvk_new_student']);

    }

    function n_auth_add_student( $args = []) { 
        global $wpdb;

        if(empty($args['name'])) {
            return new \WP_Error('name', __('Name required', 'nitesh-auth'));
         }

         if(empty($args['gmail'])) {
            return new \WP_Error('gmail', __('Gmail required', 'nitesh-auth'));
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
        if(isset($data['id']) && $data['id']) {
            $id = $data['id'];
            $data['password'] = md5('12345678');
            unset($data['id']);
            $updated = $wpdb->update(
                "{$wpdb->prefix}n_auth_students",
                $data,
                ['id' => $id],
                [
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s'
                ],
                ['%d']
            );
    
            if(!$updated) {
                return new WP_Error('failed-to-update', __('Failed to update data', 'wedevs-academy'));
            }
    
            return $data;
        } else {
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

    }

    public function wpvk_new_student()
    {

        $args = $_POST['data'];

        $subject = $args['subject'] ? implode(',',$args['subject']) : '';
        $name = $args['name'] ? $args['name'] : '';
        $registration = $args['registration'] ? $args['registration'] : '';
        $dept = isset($args['dept']) ? $args['dept'] : '';
        $phone = $args['phone'] ? $args['phone'] : '';
        $gmail = isset($args['gmail']) ? $args['gmail'] : '';
        $id = isset($args['id']) ? $args['id'] : '';

        
  
          $data = [
              'name' => $name,
              'phone'  => $phone,
              'subject'     => $subject,
              'registration' => $registration,
              'dept'        => $dept,
              'gmail'       => $gmail,
          ];
          if($id) {
            $data['id'] = $id;
          }
          $response = $this->n_auth_add_student($data);

          if(!is_wp_error($response)) {
            wp_send_json_success('hello');
          } else {
            wp_send_json_error('mori geche');
          }
    }

    public function n_auth_delete_subject() {
        global $wpdb;
        $d_id = (int)$_POST['delete_id'];
        $delete_data = $wpdb->delete(
            'wp_n_auth_subjects',
            ['id' => $d_id],
            ['%d']
        );

        if($delete_data) {
            wp_send_json_success('hello');
        } else {
            wp_send_json_error('mori geche');
        }
    }

    public function n_auth_delete_student()
    {
        // vdd('eloo');
        global $wpdb;
        $d_id = (int)$_POST['delete_id'];
        $delete_data = $wpdb->delete(
            'wp_n_auth_students',
            ['id' => $d_id],
            ['%d']
        );

        if($delete_data) {
            wp_send_json_success('hello');
        } else {
            wp_send_json_error('mori geche');
        }
    }

    function n_auth_get_student($gmail, $table_name = 'n_auth_students') {
        global $wpdb;
        return $wpdb->get_row(
           $wpdb->prepare("SELECT * FROM {$wpdb->prefix}$table_name WHERE gmail = %s", $gmail)
        );
    }

    function n_auth_get_students( $args = []) {
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
                "SELECT * FROM {$wpdb->prefix}n_auth_students
                ORDER BY {$args['orderby']} {$args['order']}
                LIMIT %d, %d",
                $args['offset'], $args['number']
            )
        );

        if(!empty($items)) {
            wp_send_json_success($items);
        } 
       
     }
  
}