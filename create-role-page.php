<?php
/*
Template Name: Create Role Page
*/
get_header(); // Include WordPress header

// Include necessary WordPress files
require_once ABSPATH . 'wp-includes/pluggable.php';

// WordPress core capabilities
$core_capabilities = [
    'switch_themes', 'edit_themes', 'activate_plugins', 'edit_plugins', 'edit_users', 'edit_files', 'manage_options',
    'moderate_comments', 'manage_categories', 'manage_links', 'upload_files', 'import', 'unfiltered_html',
    'edit_posts', 'edit_others_posts', 'edit_published_posts', 'publish_posts', 'edit_pages', 'read',
    'level_10', 'level_9', 'level_8', 'level_7', 'level_6', 'level_5', 'level_4', 'level_3', 'level_2', 'level_1', 'level_0',
    'edit_others_pages', 'edit_published_pages', 'publish_pages', 'delete_pages', 'delete_others_pages', 'delete_published_pages',
    'delete_posts', 'delete_others_posts', 'delete_published_posts', 'delete_private_posts', 'edit_private_posts', 'read_private_posts',
    'delete_private_pages', 'edit_private_pages', 'read_private_pages', 'delete_users', 'create_users', 'unfiltered_upload',
    'edit_dashboard', 'update_plugins', 'delete_plugins', 'install_plugins', 'update_themes', 'install_themes',
    'update_core', 'list_users', 'remove_users', 'promote_users', 'edit_theme_options', 'delete_themes', 'export'
];

// WooCommerce capabilities
$woocommerce_capabilities = [
    'manage_woocommerce', 'view_woocommerce_reports', 'edit_product', 'read_product', 'delete_product',
    'edit_products', 'edit_others_products', 'publish_products', 'read_private_products', 'read',
    'read_private_orders', 'edit_shop_orders', 'edit_others_shop_orders', 'publish_shop_orders',
    'read_private_shop_orders', 'read_shop_order', 'delete_shop_order', 'delete_shop_orders',
    'delete_published_shop_orders', 'manage_product_terms'
];

// BuddyPress capabilities
$buddypress_capabilities = [
    'bp_moderate', 'bp_create_groups', 'bp_join_groups', 'bp_delete_groups', 'bp_invite_anyone',
    'bp_send_invitations', 'bp_send_messages', 'bp_moderate', 'bp_moderate', 'bp_upload_files',
    'bp_delete_topics', 'bp_edit_topics', 'bp_move_topics', 'bp_split_merge_topics', 'bp_delete_replies',
    'bp_edit_replies', 'bp_vote_polls', 'bp_access_admin_features'
];

// Merge all capabilities
$all_capabilities = array_merge($core_capabilities, $woocommerce_capabilities, $buddypress_capabilities);

// Fetch roles and their descriptions
$roles = wp_roles()->roles;

// Check if the form is submitted
if (isset($_POST['add_role'])) {
    $new_role_name = sanitize_text_field($_POST['new_role_name']);
    $new_role_description = sanitize_text_field($_POST['new_role_description']);
    $new_role_capabilities = isset($_POST['new_role_capabilities']) ? $_POST['new_role_capabilities'] : [];
    $new_role_priority = isset($_POST['new_role_priority']) ? intval($_POST['new_role_priority']) : 0;

    // Check if the role name is not empty
    if (!empty($new_role_name)) {
        // Create the new role
        add_role(
            $new_role_name,
            $new_role_name,
            array_combine($new_role_capabilities, array_fill(0, count($new_role_capabilities), true)),
            $new_role_description,
            $new_role_priority
        );
        echo '<p class="success-message">New role added successfully!</p>';
    } else {
        echo '<p class="error-message">Role name is required!</p>';
    }
}
?>

<div class="container">
    <h1>Create New Role</h1>
    <form method="post">
        <div class="form-group">
            <label for="new_role_name">Role Name:</label>
            <input type="text" id="new_role_name" name="new_role_name" required>
        </div>
        <div class="form-group">
            <label for="new_role_description">Role Description:</label>
            <textarea id="new_role_description" name="new_role_description"></textarea>
        </div>
        <div class="form-group">
            <label for="new_role_capabilities">Role Capabilities:</label><br>
            <div class="capabilities-list">
                <?php foreach ($all_capabilities as $capability) : ?>
                    <div class="capability">
                        <input type="checkbox" name="new_role_capabilities[]" value="<?php echo esc_attr($capability); ?>">
                        <label><?php echo esc_html($capability); ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="form-group">
            <label for="new_role_priority">Role Priority:</label>
            <input type="number" id="new_role_priority" name="new_role_priority" min="0" value="0">
        </div>
        <button type="submit" name="add_role">Add Role</button>
    </form>
</div>

<?php get_footer(); // Include WordPress footer ?>
