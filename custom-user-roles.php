<?php 
/*
Plugin Name: Custom User Roles
Plugin URI: https://nayanray.com
Description: Adds custom user roles to WordPress.
Version: 1.0
Author: Nayan Ray
Author URI: https://yourwebsite.com
*/

// Function to create database table during plugin activation
function custom_user_roles_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_user_roles';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        role_name varchar(100) NOT NULL,
        role_description text NOT NULL,
        role_capabilities text NOT NULL,
        role_priority int(11) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}

// Hook to create table on plugin activation
register_activation_hook(__FILE__, 'custom_user_roles_create_table');


// Function to add admin menus and pages
function custom_user_roles_admin_menu() {
    add_menu_page(
        'Custom User Roles', // Page title
        'User Roles', // Menu title
        'manage_options', // Capability required to access
        'custom-user-roles-dashboard', // Menu slug
        'custom_user_roles_dashboard', // Callback function
        'dashicons-admin-users', // Icon
        20 // Position
    );

    // Add submenu pages
    $submenu_pages = array(
        array(
            'title' => 'Create New Role',
            'slug' => 'custom-user-roles-create-role',
            'callback' => 'custom_user_roles_create_role'
        ),
        array(
            'title' => 'Custom Code System',
            'slug' => 'custom-user-roles-custom-code',
            'callback' => 'custom_user_roles_custom_code'
        )
    );

    
    foreach ($submenu_pages as $submenu) {
        add_submenu_page(
            'custom-user-roles-dashboard', // Parent slug
            $submenu['title'], // Page title
            $submenu['title'], // Menu title
            'manage_options', // Capability required to access
            $submenu['slug'], // Menu slug
            $submenu['callback'] // Callback function
        );
    }
}

// Callback function to display the dashboard
function custom_user_roles_dashboard() {
    include_once(plugin_dir_path(__FILE__) . 'dashboard-page.php');
}

// Callback function for create role page
function custom_user_roles_create_role() {
    include_once(plugin_dir_path(__FILE__) . 'create-role-page.php');
}

// Callback function for custom code system page
function custom_user_roles_custom_code() {
    include_once(plugin_dir_path(__FILE__) . 'custom-code-page.php');
}

// Hook to add admin menus and pages
add_action('admin_menu', 'custom_user_roles_admin_menu');

// Function to restrict access to the dashboard based on user capabilities
function custom_user_roles_dashboard_access() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
}

// Hook to restrict access to the dashboard
add_action('admin_init', 'custom_user_roles_dashboard_access');

// Add CSS for styling
function custom_user_roles_admin_styles() {
    wp_enqueue_style('custom-user-roles-admin-style', plugins_url('style.css', __FILE__));
}

// Hook to enqueue styles
add_action('admin_enqueue_scripts', 'custom_user_roles_admin_styles');
