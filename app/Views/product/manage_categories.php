<?= $this->extend('header') ?>
<?= $this->section('custom_styles') ?>
<link rel="stylesheet" href="/css/categories.css">
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h1><?= $title ?></h1>
    <p><?= $description ?></p>

    <button class="btn btn-primary mb-3 addNewCategory">Add New Category</button>

    <table class="table table-bordered table-hover table-sm categoryTable">
        <thead>
        <tr>
            <th>Name</th>
            <th>Parent</th>
            <th>Slug</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr class="add-category-row" style="display: none;">
            <td><input type="text" class="form-control input-sm" name="acName" placeholder="Enter category name"></td>
            <td>
                <select name="parent_id" class="form-control input-sm">
                    <option value="">None</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td><input type="text" class="form-control input-sm" name="slug" placeholder="Enter slug"></td>
            <td><input type="text" class="form-control input-sm" name="description" placeholder="Enter description"></td>
            <td>
                <a class="add addCategory" title="Save" data-toggle="tooltip"><i class="fas fa-check"></i></a>
                <a class="cancel cancelNewCategory" title="Cancel" data-toggle="tooltip"><i class="fas fa-times"></i></a>
            </td>
        </tr>
        <?php foreach ($categories as $category): ?>
            <tr data-id="<?= $category['id'] ?>" data-parent-id="<?= $category['parent_id'] ?>">
                <td><?= $category['name'] ?></td>
                <td><?= isset($categoryMap[$category['parent_id']]) ? $categoryMap[$category['parent_id']]['name'] : 'None' ?></td>
                <td><?= $category['slug'] ?></td>
                <td><?= $category['description'] ?></td>
                <td>
                    <a class="edit editCategory" title="Edit" data-toggle="tooltip"><i class="fas fa-pen"></i></a>
                    <a class="delete deleteCategory" title="Delete" data-toggle="tooltip"><i class="fas fa-trash-alt"></i></a>
                    <a class="save saveCategory" title="Save" data-toggle="tooltip" style="display: none;"><i class="fas fa-check"></i></a>
                    <a class="cancel cancelCategory" title="Cancel" data-toggle="tooltip" style="display: none;"><i class="fas fa-times"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    var categories = <?= json_encode($categories) ?>;
    $(document).ready(function() {
        function updateCategories() {
            $.ajax({
                url: '/products/get-categories',
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    // let parentOptions = '<option value="">None</option>';
                    categories = result;
                },
                error: function(xhr, status, error) {
                    alert("An error occurred while fetching categories. Please try again.");
                }
            });
        }
        function calculateLevel(parentId) {
            let level = 1;
            while (parentId) {
                let parentCategory = categories.find(category => category.id == parentId);
                if (parentCategory) {
                    level++;
                    parentId = parentCategory.parent_id;
                } else {
                    break;
                }
            }
            return level;
        }
        $('[data-toggle="tooltip"]').tooltip();
        // Show add new category row
        $('.addNewCategory').on('click', function() {
            $('.add-category-row').show();
            $('.add-category-row .add, .add-category-row .cancel').show();
            $(this).attr("disabled", "disabled");
        });

        // Add new category
        $(document).on("click", ".addCategory", function(){
            let $contextRef = $(this);
            let row = $($contextRef).closest("tr");
            let acName = row.find('input[name="acName"]').val();
            let parent_id = row.find('select[name="parent_id"]').val();
            let level = calculateLevel(parent_id);
            let slug = row.find('input[name="slug"]').val();
            let description = row.find('input[name="description"]').val();
            let empty = false;

            if(!acName) {
                row.find('input[name="acName"]').addClass("error");
                empty = true;
            } else {
                row.find('input[name="acName"]').removeClass("error");
            }

            if(!empty) {
                $.ajax({
                    url: '/products/save-category',
                    data: {
                        name: acName,
                        parent_id: parent_id,
                        level: level,
                        slug: slug,
                        description: description
                    },
                    dataType: 'json',
                    type: 'POST',
                    success: function(result) {
                        if(result.status === 'success') {
                            infoMessage(result.message, 'success');
                            // Add new row to the table
                            let newRow = `<tr data-id="${result.data.id}" data-parent-id="${result.data.parent_id}">
                                <td>${result.data.name}</td>
                                <td>${result.data.parent_name}</td>
                                <td>${result.data.slug}</td>
                                <td>${result.data.description}</td>
                                <td>
                                    <a class="edit editCategory" title="Edit" data-toggle="tooltip"><i class="fas fa-pen"></i></a>
                                    <a class="delete deleteCategory" title="Delete" data-toggle="tooltip"><i class="fas fa-trash-alt"></i></a>
                                    <a class="save saveCategory" title="Save" data-toggle="tooltip" style="display: none;"><i class="fas fa-check"></i></a>
                                    <a class="cancel cancelCategory" title="Cancel" data-toggle="tooltip" style="display: none;"><i class="fas fa-times"></i></a>
                                </td>
                            </tr>`;
                            $('.categoryTable tbody').append(newRow);
                            $('.add-category-row').hide();
                            $('.addNewCategory').removeAttr("disabled");
                            updateCategories();
                        } else {
                            infoMessage('An error occurred. Please try again.', 'danger');
                        }
                    },
                    error: function (xhr, status, error) {
                        infoMessage('An error occurred. Please try again.', 'danger');
                    }
                });
            }
        });

        // Cancel adding new category
        $(document).on("click", ".cancelNewCategory", function(){
            $('.add-category-row').hide();
            $('.addNewCategory').removeAttr("disabled");
        });

        // Edit category
        $(document).on("click", ".editCategory", function(){
            let row = $(this).closest("tr");
            let nameElem = row.find("td:nth-child(1)");
            let currentName = nameElem.text();
            nameElem.html('<input type="text" class="form-control" name="acName" value="' + currentName + '" placeholder="Enter category name">');

            let parentElem = row.find("td:nth-child(2)");
            let currentParentId = row.data('parent-id');
            let parentSelect = '<select name="parent_id" class="form-control input-sm"><option value="">None</option>';
            categories.forEach(function(category) {
                parentSelect += `<option value="${category.id}" ${currentParentId == category.id ? 'selected' : ''}>${category.name}</option>`;
            });
            parentSelect += '</select>';
            parentElem.html(parentSelect);

            // let levelElem = row.find("td:nth-child(3)");
            // let currentLevel = levelElem.text();
            // levelElem.html('<input type="number" class="form-control" name="level" value="' + currentLevel + '" placeholder="Enter level">');

            let slugElem = row.find("td:nth-child(3)");
            let currentSlug = slugElem.text();
            slugElem.html('<input type="text" class="form-control" name="slug" value="' + currentSlug + '" placeholder="Enter slug">');

            let descriptionElem = row.find("td:nth-child(4)");
            let currentDescription = descriptionElem.text();
            descriptionElem.html('<input type="text" class="form-control" name="description" value="' + currentDescription + '" placeholder="Enter description">');

            row.find(".edit, .delete").hide();
            row.find(".saveCategory, .cancelCategory").show();
        });

        // Save edited category
        $(document).on("click", ".saveCategory", function(){
            let row = $(this).closest("tr");
            let id = row.data('id');
            let acName = row.find('input[name="acName"]').val();
            let parent_id = row.find('select[name="parent_id"]').val();
            let level = calculateLevel(parent_id);
            let slug = row.find('input[name="slug"]').val();
            let description = row.find('input[name="description"]').val();

            $.ajax({
                url: '/products/save-category',
                data: {
                    id: id,
                    name: acName,
                    parent_id: parent_id,
                    level: level,
                    slug: slug,
                    description: description
                },
                dataType: 'json',
                type: 'POST',
                success: function(result) {
                    if(result.status === 'success') {
                        infoMessage(result.message, 'success');
                        // Update the row with new data
                        row.find("td:nth-child(1)").text(result.data.name);
                        row.find("td:nth-child(2)").text(result.data.parent_name);
                        row.find("td:nth-child(3)").text(result.data.slug);
                        row.find("td:nth-child(4)").text(result.data.description);
                        row.data('parent-id', result.data.parent_id);
                        row.find(".edit, .delete").show();
                        row.find(".saveCategory, .cancelCategory").hide();
                        updateCategories();
                    } else {
                        infoMessage('An error occurred. Please try again.', 'danger');
                    }
                },
                error: function (xhr, status, error) {
                    infoMessage('An error occurred. Please try again.', 'danger');
                }
            });
        });

        // Delete category
        $(document).on("click", ".deleteCategory", function(){
            const row = $(this).closest("tr");
            const id = row.data('id');
            if (confirm('Are you sure you want to delete this category?')) {
                $.ajax({
                    url: '/products/delete-category/' + id,
                    type: 'DELETE',
                    success: function(result) {
                        if(result.status === 'success') {
                            row.remove();
                            infoMessage(result.message, 'success');
                            updateCategories();
                        } else {
                            infoMessage('An error occurred. Please try again.', 'danger');
                        }
                    },
                    error: function (xhr, status, error) {
                        infoMessage('An error occurred. Please try again.', 'danger');
                    }
                });
            }
        });

        // Cancel editing category
        $(document).on("click", ".cancelCategory", function(){
            let row = $(this).closest("tr");
            row.find(".edit, .delete").show();
            row.find(".saveCategory, .cancelCategory").hide();
            row.find("td:nth-child(1)").text(row.find('input[name="acName"]').val());
            row.find("td:nth-child(2)").text(row.find('select[name="parent_id"] option:selected').text());
            row.find("td:nth-child(3)").text(row.find('input[name="slug"]').val());
            row.find("td:nth-child(4)").text(row.find('input[name="description"]').val());
        });
    });
</script>

<?= $this->endSection() ?>