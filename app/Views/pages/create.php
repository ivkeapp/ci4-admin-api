<h1>Create New Page</h1>
<form action="<?= site_url('/pages/store') ?>" method="post">
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
    </div>
    <!-- user_created is handled programmatically, so no input field is needed -->
    <div>
        <label for="is_active">Is Active:</label>
        <select id="is_active" name="is_active">
            <option value="1" selected>Yes</option>
            <option value="0">No</option>
        </select>
    </div>
    <div>
        <label for="url_slug">URL Slug:</label>
        <input type="text" id="url_slug" name="url_slug" required>
    </div>
    <div>
        <label for="content">Content:</label>
        <textarea id="content" name="content" rows="4" required></textarea>
    </div>
    <!-- datetime_created, datetime_updated, and user_updated are typically handled programmatically (e.g., set to the current time or user on save) -->
    <button type="submit">Create Page</button>
</form>