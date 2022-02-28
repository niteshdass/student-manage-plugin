<?php
    namespace WPVK\Includes;
    class Installer {
        function run () {
            $this->add_version();
            $this->create_subject_tables();
            $this->create_tables();
        }
        public function add_version() {
            $is_installed = get_option( 'wpvk_is_installed' );

            if( ! $is_installed ) {
                update_option( 'wpvk_is_installed', time() );
            }
    
            update_option( 'wpvk_is_installed', WPVK_VERSION );
        }

        public function create_tables () {
            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();
            $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}n_auth_students` (
               `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
               `registration` int(11) DEFAULT NULL,
               `name` varchar(100) NOT NULL,
               `dept` varchar(255) DEFAULT NULL,
               `gmail` varchar(255) NOT NULL UNIQUE,
               `password` varchar(255) DEFAULT '12345678' NULL,
               `subject` varchar(255) DEFAULT NULL,
               `phone` varchar(30) DEFAULT NULL,
               `created_by` bigint(20) unsigned NOT NULL,
               `created_at` datetime NOT NULL,
               PRIMARY KEY(`id`)
            ) $charset_collate";
            if(!function_exists('dbDelta')) {
                 require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            }
            dbDelta($schema);
          }

          public function create_subject_tables () {
            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();
            $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}n_auth_subjects` (
               `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
               `name` varchar(100) NOT NULL,
               `dept` varchar(255) DEFAULT NULL,
               `created_by` bigint(20) unsigned NOT NULL,
               `created_at` datetime NOT NULL,
               PRIMARY KEY(`id`)
            ) $charset_collate";
            if(!function_exists('dbDelta')) {
                 require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            }
            dbDelta($schema);
          }
    }