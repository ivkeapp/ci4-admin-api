<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addUserForm" method="post" action="<?= site_url('admin/add-user') ?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="mobile_phone">Mobile Phone</label>
                        <input type="text" class="form-control" id="mobile_phone" name="mobile_phone" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="user_image">User Image</label>
                        <input type="file" class="form-control" id="user_image" name="user_image">
                    </div>
                    <div class="form-group">
                        <label for="group">Group</label>
                        <select class="form-control" id="group" name="group">
                            <option value="" selected>Choose a group (optional)</option>
                            <!-- Assuming you have a variable $groups which is an array of groups -->
                            <?php foreach ($groups as $groupName => $groupDetails): ?>
                                <?php if ($groupName !== 'superadmin'): ?>
                                    <option value="<?= $groupName ?>"><?= $groupDetails['title'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Handle form submission with AJAX
    $('#addUserForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this); // Create a FormData object passing the form
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === 'success') {
                    $('#addUserModal').modal('hide');
                    alert('User added successfully.');
                    location.reload(); // Refresh the page or update the user list
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Something went wrong.');
            }
        });
    });
</script>
