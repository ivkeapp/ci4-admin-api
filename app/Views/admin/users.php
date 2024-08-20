<!-- app/Views/admin/users.php -->

<?= $this->extend('header') ?>

<?= $this->section('custom_styles') ?>
<link rel="stylesheet" href="/css/user-profile.css">
<?= $this->endSection() ?>

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
                            <tr id="user-row-<?= $user->id ?>">
                                <td><?= $user->id ?></td>
                                <td><?= $user->username ?></td>
                                <td><?= $user->email ?></td>
                                <td><?= $user->first_name ?></td>
                                <td><?= $user->last_name ?></td>
                                <td><?= $user->mobile_phone ?></td>
                                <td><?= $user->address ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="editUserModal(<?= $user->id ?>, '<?= $user->username ?>', '<?= $user->email ?>', '<?= $user->first_name ?>', '<?= $user->last_name ?>', '<?= $user->mobile_phone ?>', '<?= $user->address ?>')">Edit</button>
                                    <a href="#" data-user-id="<?= $user->id ?>" class="btn btn-danger btn-sm delete-user-btn">Delete</a>
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
                    infoMessage(response.message, 'success');
                    location.reload();
                } else {
                    infoMessage('Error: ' + response.message, 'danger');
                }
            },
            error: function () {
                infoMessage('Something went wrong.', 'danger');
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
    $(document).ready(function() {
        $('.delete-user-btn').on('click', function(e) {
            e.preventDefault();
            
            if (!confirm('Are you sure you want to delete this user?')) {
                return;
            }

            var userId = $(this).data('user-id');
            var row = $('#user-row-' + userId);

            $.ajax({
                url: '<?= site_url('admin/remove-user/') ?>' + userId,
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        infoMessage(response.message, response.status);
                        row.remove();
                    } else {
                        infoMessage('Error: ' + response.message, 'danger');
                    }
                },
                error: function() {
                    infoMessage('Error occurred while deleting user.', 'danger');
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>
