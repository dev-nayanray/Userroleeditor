<div class="wrap">
    <h1>Create New User Role</h1>
    
    <div class="dashboard-section">
        <h2>Role Details</h2>
        <p>Use the form below to create a new custom user role:</p>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="create_new_role">
            <label for="role_name">Role Name:</label>
            <input type="text" id="role_name" name="role_name" required>
            <label for="role_capabilities">Capabilities:</label>
            <textarea id="role_capabilities" name="role_capabilities" required></textarea>
            <input type="submit" class="button button-primary" value="Create Role">
        </form>
    </div>
</div>
