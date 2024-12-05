<div class="slider-editor">
    <h4><?= esc($slider['title']) ?></h4>
    <div class="form-group">
        <label for="slider_title_<?= esc($slider['id']) ?>">Title</label>
        <input type="text" class="form-control" id="slider_title_<?= esc($slider['id']) ?>" name="slider_title_<?= esc($slider['id']) ?>" value="<?= esc($slider['title']) ?>" required>
    </div>
    <div class="form-group">
        <label for="slider_link_<?= esc($slider['id']) ?>">"See more" Link</label>
        <input type="url" class="form-control" id="slider_link_<?= esc($slider['id']) ?>" name="slider_link_<?= esc($slider['id']) ?>" value="<?= esc($slider['link']) ?>" required>
    </div>
    <div class="form-group">
        <label for="slider_products_<?= esc($slider['id']) ?>">Products</label>
        <select multiple class="form-control" id="slider_products_<?= esc($slider['id']) ?>" name="slider_products_<?= esc($slider['id']) ?>[]">
            <?php foreach ($products as $product): ?>
                <option value="<?= esc($product['id']) ?>" <?= in_array($product['id'], $slider['products']) ? 'selected' : '' ?>><?= esc($product['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="slider_is_active_<?= esc($slider['id']) ?>">Show Slider</label>
        <select class="form-control" id="slider_is_active_<?= esc($slider['id']) ?>" name="slider_is_active_<?= esc($slider['id']) ?>">
            <option value="1" <?= $slider['is_active'] ? 'selected' : '' ?>>Yes</option>
            <option value="0" <?= !$slider['is_active'] ? 'selected' : '' ?>>No</option>
        </select>
    </div>
</div>