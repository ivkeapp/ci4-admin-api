<form method="post" action="/admin/assign">
    <select name="user_id">
        <?php foreach ($users as $user): ?>
            <option value="<?= $user->id ?>"><?= $user->username ?></option>
        <?php endforeach; ?>
    </select>

    <select name="group">
        <option value="superadmin">Super Admin</option>
        <option value="admin">Admin</option>
        <option value="developer">Developer</option>
        <option value="user">User</option>
        <option value="editor">Editor</option>
    </select>

    <button type="submit">Assign</button>
</form>