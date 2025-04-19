<?= $this->extend('header') ?>

<?= $this->section('content') ?>
    <style>
        ul.tree, ul.tree ul {
            list-style-type: none;
            position: relative;
        }

        ul.tree ul {
            margin-left: 20px;
        }

        ul.tree:before, ul.tree ul:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            border-left: 1px solid #ccc;
            bottom: 0;
        }

        ul.tree li {
            margin: 0;
            padding: 10px 5px;
            position: relative;
        }

        ul.tree li:before {
            content: '';
            position: absolute;
            top: 10px;
            left: -20px;
            width: 20px;
            height: 0;
            border-top: 1px solid #ccc;
        }

        .category-node {
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #f1f1f1;
            display: inline-block;
        }
    </style>
    <div class="container mt-5">
        <h3>Product Category Tree</h3>
        <div id="category-tree" class="mt-4"></div>
    </div>
    <script>
        $(document).ready(function () {
            $.getJSON("<?= site_url('category/tree') ?>", function (data) {
                let $tree = buildTree(data);
                $('#category-tree').append($tree);
            });

            function buildTree(categories) {
                let $ul = $('<ul class="tree"></ul>');
                categories.forEach(cat => {
                    let $li = $('<li></li>');
                    $li.append('<span class="category-node">' + cat.name + '</span>');
                    if (cat.children.length > 0) {
                        $li.append(buildTree(cat.children));
                    }
                    $ul.append($li);
                });
                return $ul;
            }
        });
    </script>
<?= $this->endSection() ?>