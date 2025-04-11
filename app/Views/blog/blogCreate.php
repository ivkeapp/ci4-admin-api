<?= $this->extend('header') ?>

<?= $this->section('content') ?>
<?php helper('form'); ?>
<div class="d-flex justify-content-center">Create New Blog</div>


<form method="POST" <?= form_open_multipart(url_to('blogStore')) ?>>
    <div class="container">
        <?php if (session()->getFlashdata('message')):  ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif  ?>

        <div class="mb-3 mt-3">
            <label for="seo_title" class="form-label">SEO Title</label>
            <input type="text" class="form-control" id="seo_title" name="seo_title" placeholder="Enter search optimized title" value="<?= old('seo_title') ?>">
            <?php if (validation_show_error('seo_title')):  ?>
                <div class="text-danger mt-1 ml-1">
                    <?= validation_show_error('seo_title') ?>
                </div>
            <?php endif  ?>

        </div>
        <div class="mb-3 mt-3">
            <label for="seo_description" class="form-label">SEO Description</label>
            <input type="text" class="form-control" id="seo_description" name="seo_description" placeholder="Enter SEO Description" value="<?= old('seo_description') ?>">
            <?php if (validation_show_error('seo_description')):  ?>
                <div class="text-danger mt-1 ml-1">
                    <?= validation_show_error('seo_description') ?>
                </div>
            <?php endif  ?>
        </div>
        <div class="mb-3 mt-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter The Title" value="<?= old('title') ?>">
            <?php if (validation_show_error('title')):  ?>
                <div class="text-danger mt-1 ml-1">
                    <?= validation_show_error('title') ?>
                </div>
            <?php endif  ?>
        </div>
        <div class="mb-3 mt-3">
            <label for="subtitle" class="form-label">Subtitle</label>
            <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Enter The Subtitle" value="<?= old('subtitle') ?>">
            <?php if (validation_show_error('subtitle')):  ?>
                <div class="text-danger mt-1 ml-1">
                    <?= validation_show_error('subtitle') ?>
                </div>
            <?php endif  ?>
        </div>
        <div class="mb-3 mt-3">
            <label for="content" class="form-label">Blog Content</label>
            <input type="text" class="form-control" id="content" name="content" placeholder="Enter The Blog Content" value="<?= old('content') ?>">
            <?php if (validation_show_error('content')):  ?>
                <div class="text-danger mt-1 ml-1">
                    <?= validation_show_error('content') ?>
                </div>
            <?php endif  ?>
        </div>
        <div class="mb-3 mt-3">
            <label for="image" class="form-label">Blog Picture</label>
            <input type="file" class="form-control" id="image" name="image" placeholder="Upload The Picture For The Blog" value="<?= old('image') ?>">
            <?php if (validation_show_error('image')):  ?>
                <div class="text-danger mt-1 ml-1">
                    <?= validation_show_error('image') ?>
                </div>
            <?php endif  ?>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="mb-3 mt-3 btn btn-primary w-100">Submit the new blog</button>
        </div>
    </div>
</form>

<?= $this->endSection() ?>