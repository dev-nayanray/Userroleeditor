<?php
// Include necessary WordPress files
require_once ABSPATH . 'wp-includes/pluggable.php';

// Fetch roles and their descriptions
$roles = wp_roles()->roles;

// Process search query if provided
$searchQuery = isset($_POST['searchQuery']) ? sanitize_text_field($_POST['searchQuery']) : '';

// Filter roles based on search query
$filteredRoles = [];
foreach ($roles as $role_name => $role_details) {
    if (strpos(strtolower($role_name), strtolower($searchQuery)) !== false ||
        strpos(strtolower($role_details['description']), strtolower($searchQuery)) !== false) {
        $filteredRoles[] = [
            'role_name' => $role_name,
            'description' => $role_details['description'],
            'capabilities' => implode(', ', array_keys($role_details['capabilities'])),
            'priority' => isset($role_details['priority']) ? $role_details['priority'] : ''
        ];
    }
}

// Return filtered roles as JSON
echo json_encode(['data' => $filteredRoles]);
?>
