<?php
    namespace WPVK\Includes\Frontend;
    use WPVK\Includes\Frontend\Ajax;


    class Student {
        function __construct() {
            add_shortcode('student-add-form', [$this, 'n_auth_render_shortcode_enquery']);
        }

        public function n_auth_render_shortcode_enquery($alts, $context = '') {
            $ajaxx = new Ajax();
            if(is_user_logged_in(  )) {
                $user = wp_get_current_user();
                $student = $ajaxx->n_auth_get_student($user->data->user_email);
            }
            wp_enqueue_style('wpvk-student-new-style');
            wp_enqueue_script('wpvk-student-new-script');
            $subjects = n_auth_get_subjects();
            ob_start();
            include __DIR__ . '/views/student-add.php';
            return ob_get_clean();
        }
    }

?>