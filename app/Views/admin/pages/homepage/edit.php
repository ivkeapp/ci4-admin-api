<?= $this->extend('header') ?>

<?= $this->section('content') ?>
<div class="container">
    <h2>Edit Homepage</h2>
    <form action="/homepage/update" method="post" enctype="multipart/form-data">
        <!-- SEO Meta Data -->
        <h3>SEO Meta Data</h3>
        <div class="form-group">
            <label for="meta_title">Meta Title</label>
            <input type="text" class="form-control" id="meta_title" name="meta_title" value="<?= esc($homepage['meta_title']) ?>" required>
        </div>
        <div class="form-group">
            <label for="meta_description">Meta Description</label>
            <textarea class="form-control" id="meta_description" name="meta_description" rows="3" required><?= esc($homepage['meta_description']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="meta_keywords">Meta Keywords</label>
            <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="3" required><?= esc($homepage['meta_keywords']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="slug">URL Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" value="<?= esc($homepage['slug']) ?>" required>
        </div>

        <!-- Hero Section -->
        <h3>Hero Section</h3>
        <div class="form-group">
            <label for="hero_image">Background Image</label>
            <?php if (!empty($sections[0]['image'])): ?>
                <img src="<?= base_url($sections[0]['image']) ?>" alt="Hero Section Image 1" class="img-thumbnail mb-2">
            <?php else: ?>
                <p>No image uploaded.</p>
            <?php endif; ?>
            <input type="file" class="form-control" id="hero_image" name="sections[<?= esc($sections[0]['id']) ?>][image]">
        </div>
        <div class="form-group">
            <label for="hero_title">Title</label>
            <input type="text" class="form-control" id="hero_title" name="sections[<?= esc($sections[0]['id']) ?>][title]" value="<?= esc($sections[0]['title']) ?>" required>
        </div>
        <div class="form-group">
            <label for="hero_subtitle">Subtitle</label>
            <input type="text" class="form-control" id="hero_subtitle" name="sections[<?= esc($sections[0]['id']) ?>][subtitle]" value="<?= esc($sections[0]['subtitle']) ?>" required>
        </div>
        <div class="form-group">
            <label for="hero_button_text">Button Text</label>
            <input type="text" class="form-control" id="hero_button_text" name="sections[<?= esc($sections[0]['id']) ?>][button_text]" value="<?= esc($sections[0]['button_text']) ?>" required>
        </div>
        <div class="form-group">
            <label for="hero_button_link">Button Link</label>
            <input type="text" class="form-control" id="hero_button_link" name="sections[<?= esc($sections[0]['id']) ?>][button_link]" value="<?= esc($sections[0]['button_link']) ?>" required>
        </div>

        <!-- Sliders Section -->
        <h3>Sliders</h3>
        <?php foreach ($sliders as $slider): ?>
            <?= $this->setVar('slider', $slider)->setVar('allProducts', $allProducts)->include('components/slider_editor') ?>
        <?php endforeach; ?>

        <!-- Two Column Section -->
        <h3>Two Column Section</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="two_col_image_1">Background Image 1</label>
                    <?php if (!empty($sections[1]['image'])): ?>
                        <img src="<?= base_url($sections[1]['image']) ?>" alt="Two Colum Section Image 1" class="img-thumbnail mb-2">
                    <?php else: ?>
                        <p>No image uploaded.</p>
                    <?php endif; ?>
                    <input type="file" class="form-control" id="two_col_image_1" name="sections[<?= esc($sections[1]['id']) ?>][image]">
                </div>
                <div class="form-group">
                    <label for="two_col_title_1">Title 1</label>
                    <input type="text" class="form-control" id="two_col_title_1" name="sections[<?= esc($sections[1]['id']) ?>][title]" value="<?= esc($sections[1]['title']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="two_col_button_text_1">Button Text 1</label>
                    <input type="text" class="form-control" id="two_col_button_text_1" name="sections[<?= esc($sections[1]['id']) ?>][button_text]" value="<?= esc($sections[1]['button_text']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="two_col_button_link_1">Button Link 1</label>
                    <input type="text" class="form-control" id="two_col_button_link_1" name="sections[<?= esc($sections[1]['id']) ?>][button_link]" value="<?= esc($sections[1]['button_link']) ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="two_col_image_2">Background Image 2</label>
                    <?php if (!empty($sections[2]['image'])): ?>
                        <img src="<?= base_url($sections[2]['image']) ?>" alt="Two Colum Section Image 2" class="img-thumbnail mb-2">
                    <?php else: ?>
                        <p>No image uploaded.</p>
                    <?php endif; ?>
                    <input type="file" class="form-control" id="two_col_image_2" name="sections[<?= esc($sections[2]['id']) ?>][image]">
                </div>
                <div class="form-group">
                    <label for="two_col_title_2">Title 2</label>
                    <input type="text" class="form-control" id="two_col_title_2" name="sections[<?= esc($sections[2]['id']) ?>][title]" value="<?= esc($sections[2]['title']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="two_col_button_text_2">Button Text 2</label>
                    <input type="text" class="form-control" id="two_col_button_text_2" name="sections[<?= esc($sections[2]['id']) ?>][button_text]" value="<?= esc($sections[2]['button_text']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="two_col_button_link_2">Button Link 2</label>
                    <input type="text" class="form-control" id="two_col_button_link_2" name="sections[<?= esc($sections[2]['id']) ?>][button_link]" value="<?= esc($sections[2]['button_link']) ?>" required>
                </div>
            </div>
        </div>

        <!-- Fourth Section (similar to Hero Section) -->
        <h3>Fourth Section</h3>
        <div class="form-group">
            <label for="fourth_image">Background Image</label>
            <?php if (!empty($sections[3]['image'])): ?>
                <img src="<?= base_url($sections[3]['image']) ?>" alt="Two Colum Section Image 2" class="img-thumbnail mb-2">
            <?php else: ?>
                <p>No image uploaded.</p>
            <?php endif; ?>
            <input type="file" class="form-control" id="fourth_image" name="sections[<?= esc($sections[3]['id']) ?>][image]">
        </div>
        <div class="form-group">
            <label for="fourth_title">Title</label>
            <input type="text" class="form-control" id="fourth_title" name="sections[<?= esc($sections[3]['id']) ?>][title]" value="<?= esc($sections[3]['title']) ?>" required>
        </div>
        <div class="form-group">
            <label for="fourth_subtitle">Subtitle</label>
            <input type="text" class="form-control" id="fourth_subtitle" name="sections[<?= esc($sections[3]['id']) ?>][subtitle]" value="<?= esc($sections[3]['subtitle']) ?>" required>
        </div>
        <div class="form-group">
            <label for="fourth_button_text">Button Text</label>
            <input type="text" class="form-control" id="fourth_button_text" name="sections[<?= esc($sections[3]['id']) ?>][button_text]" value="<?= esc($sections[3]['button_text']) ?>" required>
        </div>
        <div class="form-group">
            <label for="fourth_button_link">Button Link</label>
            <input type="text" class="form-control" id="fourth_button_link" name="sections[<?= esc($sections[3]['id']) ?>][button_link]" value="<?= esc($sections[3]['button_link']) ?>" required>
        </div>

        <!-- Fifth Section (Two Rows of Two Columns) -->
        <h3>Fifth Section</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fifth_image_1">Background Image 1</label>
                    <?php if (!empty($sections[4]['image'])): ?>
                        <img src="<?= base_url($sections[4]['image']) ?>" alt="Fifth Section Image 1" class="img-thumbnail mb-2">
                    <?php else: ?>
                        <p>No image uploaded.</p>
                    <?php endif; ?>
                    <input type="file" class="form-control" id="fifth_image_1" name="sections[<?= esc($sections[4]['id']) ?>][image]">
                </div>
                <div class="form-group">
                    <label for="fifth_title_1">Title 1</label>
                    <input type="text" class="form-control" id="fifth_title_1" name="sections[<?= esc($sections[4]['id']) ?>][title]" value="<?= esc($sections[4]['title']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="fifth_button_text_1">Button Text 1</label>
                    <input type="text" class="form-control" id="fifth_button_text_1" name="sections[<?= esc($sections[4]['id']) ?>][button_text]" value="<?= esc($sections[4]['button_text']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="fifth_button_link_1">Button Link 1</label>
                    <input type="text" class="form-control" id="fifth_button_link_1" name="sections[<?= esc($sections[4]['id']) ?>][button_link]" value="<?= esc($sections[4]['button_link']) ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fifth_image_2">Background Image 2</label>
                    <?php if (!empty($sections[5]['image'])): ?>
                        <img src="<?= base_url($sections[5]['image']) ?>" alt="Fifth Section Image 2" class="img-thumbnail mb-2">
                    <?php else: ?>
                        <p>No image uploaded.</p>
                    <?php endif; ?>
                    <input type="file" class="form-control" id="fifth_image_2" name="sections[<?= esc($sections[5]['id']) ?>][image]">
                </div>
                <div class="form-group">
                    <label for="fifth_title_2">Title 2</label>
                    <input type="text" class="form-control" id="fifth_title_2" name="sections[<?= esc($sections[5]['id']) ?>][title]" value="<?= esc($sections[5]['title']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="fifth_button_text_2">Button Text 2</label>
                    <input type="text" class="form-control" id="fifth_button_text_2" name="sections[<?= esc($sections[5]['id']) ?>][button_text]" value="<?= esc($sections[5]['button_text']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="fifth_button_link_2">Button Link 2</label>
                    <input type="text" class="form-control" id="fifth_button_link_2" name="sections[<?= esc($sections[5]['id']) ?>][button_link]" value="<?= esc($sections[5]['button_link']) ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fifth_image_3">Background Image 3</label>
                    <?php if (!empty($sections[6]['image'])): ?>
                        <img src="<?= base_url($sections[6]['image']) ?>" alt="Fifth Section Image 3" class="img-thumbnail mb-2">
                    <?php else: ?>
                        <p>No image uploaded.</p>
                    <?php endif; ?>
                    <input type="file" class="form-control" id="fifth_image_3" name="sections[<?= esc($sections[6]['id']) ?>][image]">
                </div>
                <div class="form-group">
                    <label for="fifth_title_3">Title 3</label>
                    <input type="text" class="form-control" id="fifth_title_3" name="sections[<?= esc($sections[6]['id']) ?>][title]" value="<?= esc($sections[6]['title']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="fifth_button_text_3">Button Text 3</label>
                    <input type="text" class="form-control" id="fifth_button_text_3" name="sections[<?= esc($sections[6]['id']) ?>][button_text]" value="<?= esc($sections[6]['button_text']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="fifth_button_link_3">Button Link 3</label>
                    <input type="text" class="form-control" id="fifth_button_link_3" name="sections[<?= esc($sections[6]['id']) ?>][button_link]" value="<?= esc($sections[6]['button_link']) ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fifth_image_4">Background Image 4</label>
                    <?php if (!empty($sections[7]['image'])): ?>
                        <img src="<?= base_url($sections[7]['image']) ?>" alt="Fifth Section Image 4" class="img-thumbnail mb-2">
                    <?php else: ?>
                        <p>No image uploaded.</p>
                    <?php endif; ?>
                    <input type="file" class="form-control" id="fifth_image_4" name="sections[<?= esc($sections[7]['id']) ?>][image]">
                </div>
                <div class="form-group">
                    <label for="fifth_title_4">Title 4</label>
                    <input type="text" class="form-control" id="fifth_title_4" name="sections[<?= esc($sections[7]['id']) ?>][title]" value="<?= esc($sections[7]['title']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="fifth_button_text_4">Button Text 4</label>
                    <input type="text" class="form-control" id="fifth_button_text_4" name="sections[<?= esc($sections[7]['id']) ?>][button_text]" value="<?= esc($sections[7]['button_text']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="fifth_button_link_4">Button Link 4</label>
                    <input type="text" class="form-control" id="fifth_button_link_4" name="sections[<?= esc($sections[7]['id']) ?>][button_link]" value="<?= esc($sections[7]['button_link']) ?>" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="/pages" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script>
    $('input[type="file"]').change(function(e) {
        var input = e.target;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imgPreview = $(input).closest('.form-group').find('img');
                if (imgPreview.length) {
                    imgPreview.attr('src', e.target.result);
                } else {
                    $(input).closest('.form-group').prepend('<img src="' + e.target.result + '" alt="Image Preview" class="img-thumbnail mb-2">');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    });
</script>
<?= $this->endSection() ?>