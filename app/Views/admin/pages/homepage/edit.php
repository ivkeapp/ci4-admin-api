<?= $this->extend('header') ?>

<?= $this->section('content') ?>
<div class="container">
    <h2>Edit Homepage</h2>
    <form action="/homepage/update" method="post">
        <!-- Hero Section -->
        <h3>Hero Section</h3>
        <div class="form-group">
            <label for="hero_image">Background Image</label>
            <input type="file" class="form-control" id="hero_image" name="hero_image">
        </div>
        <div class="form-group">
            <label for="hero_title">Title</label>
            <input type="text" class="form-control" id="hero_title" name="hero_title" required>
        </div>
        <div class="form-group">
            <label for="hero_subtitle">Subtitle</label>
            <input type="text" class="form-control" id="hero_subtitle" name="hero_subtitle" required>
        </div>
        <div class="form-group">
            <label for="hero_button_text">Button Text</label>
            <input type="text" class="form-control" id="hero_button_text" name="hero_button_text" required>
        </div>
        <div class="form-group">
            <label for="hero_button_link">Button Link</label>
            <input type="url" class="form-control" id="hero_button_link" name="hero_button_link" required>
        </div>

        <!-- Sliders Section -->
        <h3>Sliders</h3>
        <?php foreach ($sliders as $slider): ?>
            <?= $this->include('partials/slider_editor', ['slider' => $slider]) ?>
        <?php endforeach; ?>

        <!-- Two Column Section -->
        <h3>Two Column Section</h3>
        <div class="form-group">
            <label for="two_col_image_1">Background Image 1</label>
            <input type="file" class="form-control" id="two_col_image_1" name="two_col_image_1">
        </div>
        <div class="form-group">
            <label for="two_col_title_1">Title 1</label>
            <input type="text" class="form-control" id="two_col_title_1" name="two_col_title_1" required>
        </div>
        <div class="form-group">
            <label for="two_col_button_text_1">Button Text 1</label>
            <input type="text" class="form-control" id="two_col_button_text_1" name="two_col_button_text_1" required>
        </div>
        <div class="form-group">
            <label for="two_col_button_link_1">Button Link 1</label>
            <input type="url" class="form-control" id="two_col_button_link_1" name="two_col_button_link_1" required>
        </div>
        <!-- Repeat for second column -->

        <!-- Fourth Section (similar to Hero Section) -->
        <h3>Fourth Section</h3>
        <!-- Repeat Hero Section fields -->

        <!-- Fifth Section (Two Rows of Two Columns) -->
        <h3>Fifth Section</h3>
        <!-- Repeat Two Column Section fields for two rows -->

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="/pages" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?= $this->endSection() ?>