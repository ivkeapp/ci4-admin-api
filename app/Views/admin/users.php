<!-- app/Views/admin/users.php -->

<?= $this->extend('header') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>User Management</h2>
            <hr>
            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addUserModal" data-groups='<?= json_encode($groups) ?>'>Add User</a>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Mobile Phone</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= $user->id ?></td>
                            <td><?= $user->username ?></td>
                            <td><?= $user->email ?></td>
                            <td><?= $user->first_name ?></td>
                            <td><?= $user->last_name ?></td>
                            <td><?= $user->mobile_phone ?></td>
                            <td><?= $user->address ?></td>
                            <td>
                            <button class="btn btn-primary btn-sm" onclick="editUserModal(<?= $user->id ?>, '<?= $user->username ?>', '<?= $user->email ?>', '<?= $user->first_name ?>', '<?= $user->last_name ?>', '<?= $user->mobile_phone ?>', '<?= $user->address ?>')">Edit</button>
                                <a href="<?= site_url('admin/remove-user/' . $user->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Include Edit User Modal -->
<?= $this->include('admin/edit_user') ?>

<?= $this->section('modals') ?>
<!-- Include Add User Modal -->
<?= $this->include('admin/add_user_modal') ?>
<?= $this->endSection() ?>

<script>
    // Handle edit user form submission with AJAX
    $('#editUserForm').submit(function (e) {
        e.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    $('#editUserModal').modal('hide');
                    alert('User updated successfully.');
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function () {
                alert('Something went wrong.');
            }
        });
    });

    $('#addUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var groups = button.data('groups'); // Extract info from data-* attributes

        // Update the modal's content.
        var modal = $(this);
        var select = modal.find('.modal-body select[name="group"]');
        select.empty();

        $.each(groups, function (i, group) {
            select.append($('<option>', {
                value: group.id,
                text : group.name
            }));
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Handle delete user button click
        document.querySelectorAll('.delete-user').forEach(button => {
            button.addEventListener('click', function () {
                const userId = this.getAttribute('data-userid');
                if (confirm('Are you sure you want to delete this user?')) {
                    fetch(`<?= site_url('admin/remove-user/') ?>${userId}`, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert('User deleted successfully.');
                            window.location.reload();
                        } else {
                            alert('Failed to delete user: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the user.');
                    });
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>
