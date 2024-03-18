<?php
/*
Template Name: Create Role Page
*/
get_header(); // Include WordPress header

// Include necessary WordPress files
require_once ABSPATH . 'wp-includes/pluggable.php';

// Function to fetch data from the custom table
function custom_user_roles_fetch_data() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_user_roles';

    $data = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

    return $data;
}

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
    // Process and save the submitted data
    $new_role_name = isset($_POST['new_role_name']) ? $_POST['new_role_name'] : '';
    $new_role_description = isset($_POST['new_role_description']) ? $_POST['new_role_description'] : '';
    $new_role_capabilities = isset($_POST['new_role_capabilities']) ? $_POST['new_role_capabilities'] : [];
    $new_role_priority = isset($_POST['new_role_priority']) ? $_POST['new_role_priority'] : 0;

    // Save the data to the database (replace this with your database logic)
    // For example:
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_roles';
    $wpdb->insert(
        $table_name,
        array(
            'role_name' => $new_role_name,
            'description' => $new_role_description,
            'capabilities' => implode(', ', $new_role_capabilities),
            'priority' => $new_role_priority
        )
    );

    // Display a success message
    echo '<p class="success-message">New role added successfully!</p>';
}

?>

<div class="container">
    <div class="addrole clearfix">
        <form method="post" class="horizontal-form">
            <div class="form-group">
                <label for="new_role_name">Role Name:</label>
                <input type="text" id="new_role_name" name="new_role_name" required>
            </div>
            <div class="form-group">
                <label for="new_role_description">Role Description:</label>
                <input type="text" id="new_role_description" name="new_role_description" required>
            </div>
            <div class="form-group">
                <label for="new_role_capabilities">Role Capabilities:</label><br>
                <div class="capabilities-list-containers">
                    <div class="capabilities-lists">
                        <?php foreach ($all_capabilities as $capability) : ?>
                            <div class="capabilitys">
                                <input type="checkbox" name="new_role_capabilities[]" value="<?php echo esc_attr($capability); ?>">
                                <label><?php echo esc_html($capability); ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="new_role_priority">Role Priority:</label>
                <input type="number" id="new_role_priority" name="new_role_priority" min="0" value="0">
            </div>
            <div class="form-group">
                <button type="submit" name="add_role">Add Role</button>
            </div>
        </form>
    </div>

    <!-- Display data table using the WordPress plugin -->
    <div class="role-table">
        <?php echo do_shortcode('[table id=1 /]'); ?>
    </div>

    <!-- Data Table -->
    <div class="datatable-container">
        <table id="roleDataTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Role Name</th>
                    <th>Description</th>
                    <th>Capabilities</th>
                    <th>Priority</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch data from custom table
                $roles_data = custom_user_roles_fetch_data();

                // Display the data in table rows
                if ($roles_data) {
                    foreach ($roles_data as $role) {
                        echo '<tr>';
                        echo '<td>' . esc_html($role['role_name']) . '</td>';
                        echo '<td>' . esc_html($role['description']) . '</td>';
                        echo '<td>' . esc_html($role['capabilities']) . '</td>';
                        echo '<td>' . esc_html($role['priority']) . '</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php get_footer(); // Include WordPress footer ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#roleDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo admin_url('admin-ajax.php?action=fetch_roles'); ?>",
                "type": "GET"
            }
        });
    });
</script>
