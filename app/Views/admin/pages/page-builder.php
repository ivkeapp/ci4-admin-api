<?= $this->extend('header') ?>


<?= $this->section('content') ?>
<style>
    body {
        background-color: #f8f9fa;
    }
    .navbar-nav {
        display: none;
    }
    .navbar-expand {
        display: none;
    }
    #content-wrapper {
        margin-left: 0!important;
    }
    #toolbox {
        background-color: #ffffff;
        border-right: 1px solid #ddd;
        padding: 10px;
        z-index: 2;
    }

    #toolbox h4 {
        margin-top: 20px;
    }

    #page-canvas {
        background-color: #fff;
        min-height: 80vh;
        border: 1px dashed #ccc;
        padding: 20px;
        position: relative;
    }
    #block-properties {
        background-color: #ffffff;
        border-right: 1px solid #ddd;
        padding: 10px;
        z-index: 2;
    }
    .section {
        border: 2px solid #ddd;
        margin-bottom: 20px;
        padding: 20px;
        background-color: #fff;
    }

    .block {
        margin: 10px 0;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #f8f9fa;
    }

    .block img {
        max-width: 100%;
        height: auto;
    }

    .block-title {
        font-weight: bold;
    }

    .block-subtitle {
        color: #6c757d;
    }

    #blocks {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 10px;
    }

    .block-item {
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        margin-bottom: 10px;
        padding: 20px;
        background-color: #e9ecef;
        border-radius: 4px;
        text-align: center;
        cursor: pointer;
    }

    .block-item:hover {
        background-color: #d3d9df;
    }

    .block-item i {
        font-size: 24px;
        margin-bottom: 10px;
    }

    /* .add-section-btn {
        margin-top: 20px;
        display: block;
        width: 100%;
        text-align: center;
        cursor: pointer;
        background-color: #007bff;
        color: white;
        padding: 10px;
        border-radius: 4px;
    }

    .add-section-btn:hover {
        background-color: #0056b3;
    } */
    .column {
        text-align: center;
    }
    .section-content {
        height: 160px;
        width: 100%;
        font-size: 48px;
        border: 1px solid #c3c3c3;
        border-radius: 10px;
        color: #c3c3c3;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: all .4s ease;
        cursor: pointer;
    }
    .section-content:hover {
        border: 1px solid #dddddd;
        color: #b7b7b7;
        background-color: #f3f3f3;
    }
    .block p, .block img, .block textarea {
        /* pointer-events: none; */
    }
    .image-placeholder-container {

    }

    .image-placeholder {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 4px;
    }

    .image-input-hidden {
        display: none; /* Fully hide the input */
        position: absolute; /* Ensure it's out of layout flow */
        z-index: -1; /* Push it behind all other elements */
    }
    .empty-section {
        border: 2px solid #ddd;
        margin-bottom: 20px;
        padding: 20px;
        background-color: #fff;
        cursor: pointer;
        transition: all .4s ease;
    }
    .empty-section:hover {
        color: #fff;
        background-color: #ddd;
    }
    .add-empty-section {
        height: 160px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 42px;
        font-weight: 300;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <!-- Toolbox -->
        <div id="toolbox" class="col-md-2">
            <h4>Blocks</h4>
            <div id="blocks">
                <div class="block-item" data-type="image">
                    <i class="fas fa-image"></i>
                    Image
                </div>
                <div class="block-item" data-type="image-title">
                    <i class="fas fa-photo-video"></i>
                    Image with Title
                </div>
                <div class="block-item" data-type="text">
                    <i class="fas fa-font"></i>
                    Text
                </div>
                <div class="block-item" data-type="title-text">
                    <i class="fas fa-heading"></i>
                    Title, Subtitle & Text
                </div>
                <div class="block-item" data-type="slider">
                    <i class="fas fa-sliders-h"></i>
                    Slider
                </div>
                <div class="block-item" data-type="hero">
                    <i class="fas fa-photo-video"></i>
                    Hero Image
                </div>
                <div class="block-item" data-type="card">
                    <i class="fas fa-id-card"></i>
                    Card
                </div>
                <div class="block-item" data-type="button">
                    <i class="fas fa-hand-pointer"></i>
                    Button
                </div>
                <div class="block-item" data-type="tinymce">
                    <i class="fas fa-edit"></i>
                    TinyMCE
                </div>
            </div>
        </div>
        <!-- Page Canvas -->
        <div id="page-canvas" class="col-md-8">
            <div class="empty-section add-section-btn" id="empty-section"><div class="add-empty-section">+</div></div>
        </div>
        <div id="block-properties" class="col-md-2">
            <!-- Inputs will be appended here -->
        </div>
        <button class="add-section-btn">+ Add Section</button>
    </div>
</div>

<!-- Add Section Modal -->
<div class="modal fade" id="sectionModal" tabindex="-1" aria-labelledby="sectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sectionModalLabel">Add Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="columns" class="form-label">Select number of columns:</label>
                <select id="columns" class="form-select">
                    <option value="1">1 Column</option>
                    <option value="2">2 Columns</option>
                    <option value="3">3 Columns</option>
                    <option value="4">4 Columns</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="addSectionBtn">Add Section</button>
            </div>
        </div>
    </div>
</div>

<script>
    // CONSTANTS
    const blockPreview = {
        image: `
            <div class="block-item" data-type="image">
                <i class="fas fa-image"></i>
                Image
            </div>`,
        imageTitle: `
            <div class="block-item" data-type="image">
                <i class="fas fa-photo-video"></i>
                Image with Title
            </div>`,
        text: `
            <div class="block-item" data-type="image">
                <i class="fas fa-font"></i>
                Text
            </div>`,
        titleText: `
            <div class="block-item" data-type="image">
                <i class="fas fa-heading"></i>
                Title, Subtitle & Text
            </div>`,
        slider: `
            <div class="block-item" data-type="image">
                <i class="fas fa-sliders-h"></i>
                Slider
            </div>`,
        slider: `
            <div class="block-item" data-type="image">
                <i class="fas fa-sliders-h"></i>
                Slider
            </div>`,
        hero: `
            <div class="block-item" data-type="image">
                <i class="fas fa-photo-video"></i>
                Hero Image
            </div>`,
        card: `
            <div class="block-item" data-type="image">
                <i class="fas fa-id-card"></i>
                Card
            </div>`,
        button: `
            <div class="block-item" data-type="image">
                <i class="fas fa-hand-pointer"></i>
                Button
            </div>`,
        tinymce: `
            <div class="block-item" data-type="image">
                <i class="fas fa-edit"></i>
                TinyMCE
            </div>`,
    };
    // ON DOC READY
    $(document).ready(function () {
        let currentColumns = 1;

        // Show section modal
        $('.add-section-btn').click(function () {
            $('#sectionModal').modal('show');
        });

        // Add section
        $('#addSectionBtn').click(function () {
            currentColumns = $('#columns').val();
            const section = $('<div class="section"><div class="row"></div></div>');

            for (let i = 0; i < currentColumns; i++) {
                section.find('.row').append(`<div class="col column"><div class="section-content"><i class="fas fa-plus"></i></div></div>`);
            }

            $('#page-canvas').append(section);
            appendEmptySection();

            // Make the new section droppable
            $('.column').droppable({
                accept: ".block-item",
                over: function (event, ui) {
                    // Highlight the drop target
                    $(this).addClass('drop-target').attr('data-selected', 'true').css('border', '2px solid blue');
                },
                out: function (event, ui) {
                    // Remove highlight when the block leaves the drop target
                    $(this).removeClass('drop-target').removeAttr('data-selected').css('border', '');
                },
                drop: function (event, ui) {
                    const blockType = ui.helper.data('type');
                    let blockInputs;
                    console.log(blockType, 'blockType');
                    
                    const block = addBlock(blockType);

                    // Append block to the dropped section
                    $('#block-properties').html(block.blockInputs);
                    $(this).html(block.blockPreview);

                    // Cleanup: Ensure only the dropped column is highlighted
                    $(this).addClass('drop-target').attr('data-selected', 'true').attr('data-target', 'true').attr('data-type', blockType).css('border', '2px solid blue');
                    $('.column').not(this).removeClass('drop-target').removeAttr('data-selected').css('border', '');    
                }
            });

            
            $('#sectionModal').modal('hide');
        });

        // Make blocks draggable
        $('#blocks .block-item').draggable({
            helper: "clone"
        });
    });

    // FUNCTIONS
    function addBlock(blockType) {
        let preview = '';
        switch (blockType) {
            case "image":
                preview = blockPreview.image;
                const uniqueId = `image-input-${Date.now()}`;
                blockInputs = `
                    <div class="block image-block">
                        <label>Image:</label>
                        <img id="${uniqueId}-preview" src="img/placeholder.png" alt="Click to upload" 
                            class="image-placeholder">
                        <input type="file" id="${uniqueId}" name="image_file" class="form-control image-input-hidden" accept="image/*" onchange="previewImage(event, '${uniqueId}-preview')">
                    </div>`;
                break;
            case "image-title":
                preview = blockPreview.imageTitle;
                blockInputs = `
                    <div class="block image-title-block">
                        <label>Image: 
                            <div class="image-placeholder">
                                <input type="file" name="image_file" class="form-control image-input" accept="image/*" onchange="previewImage(event, 'image-preview')">
                                <img id="image-preview" src="img/placeholder.png" alt="Image Placeholder" class="image-preview">
                            </div>
                        </label>
                        <label>Title: <input type="text" name="image_title" class="form-control"></label>
                        <label>Subtitle: <input type="text" name="image_subtitle" class="form-control"></label>
                    </div>`;
                break;
            case "text":
                preview = blockPreview.text;
                blockInputs = `
                    <div class="block text-block">
                        <label>Text Content: <textarea name="text_content" class="form-control"></textarea></label>
                    </div>`;
                break;
            case "title-text":
                preview = blockPreview.titleText;
                blockInputs = `
                    <div class="block title-text-block">
                        <label>Title: <input type="text" name="title" class="form-control"></label>
                        <label>Subtitle: <input type="text" name="subtitle" class="form-control"></label>
                        <label>Text: <textarea name="text_content" class="form-control"></textarea></label>
                    </div>`;
                break;
            case "slider":
                preview = blockPreview.slider;
                blockInputs = `
                    <div class="block slider-block">
                        <label>Slider Images (comma-separated URLs): 
                            <textarea name="slider_images" class="form-control"></textarea>
                        </label>
                        <label>Title: <input type="text" name="slider_title" class="form-control"></label>
                        <label>"See More" Link: <input type="text" name="slider_link" class="form-control"></label>
                        <label>Show Slider: 
                            <input type="checkbox" name="show_slider" class="form-control">
                        </label>
                    </div>`;
                break;
            case "hero":
                preview = blockPreview.hero;
                blockInputs = `
                    <div class="block hero-block">
                        <label>Hero Image: 
                            <div class="image-placeholder">
                                <input type="file" name="hero_image" class="form-control image-input" accept="image/*" onchange="previewImage(event, 'hero-image-preview')">
                                <img id="hero-image-preview" src="https://via.placeholder.com/150" alt="Hero Image Placeholder" class="image-preview">
                            </div>
                        </label>
                        <label>Title: <input type="text" name="hero_title" class="form-control"></label>
                        <label>Subtitle: <input type="text" name="hero_subtitle" class="form-control"></label>
                        <label>Button Text: <input type="text" name="hero_button_text" class="form-control"></label>
                        <label>Button Link: <input type="text" name="hero_button_link" class="form-control"></label>
                    </div>`;
                break;
            case "card":
                preview = blockPreview.card;
                blockInputs = `
                    <div class="block card-block">
                        <label>Card Image: 
                            <div class="image-placeholder">
                                <input type="file" name="card_image" class="form-control image-input" accept="image/*" onchange="previewImage(event, 'card-image-preview')">
                                <img id="card-image-preview" src="https://via.placeholder.com/150" alt="Card Image Placeholder" class="image-preview">
                            </div>
                        </label>
                        <label>Title: <input type="text" name="card_title" class="form-control"></label>
                        <label>Subtitle: <input type="text" name="card_subtitle" class="form-control"></label>
                        <label>Text: <textarea name="card_text" class="form-control"></textarea></label>
                        <label>Button Text: <input type="text" name="card_button_text" class="form-control"></label>
                        <label>Button Link: <input type="text" name="card_button_link" class="form-control"></label>
                    </div>`;
                break;
            case "button":
                preview = blockPreview.button;
                blockInputs = `
                    <div class="block button-block">
                        <label>Button Text: <input type="text" name="button_text" class="form-control"></label>
                        <label>Button Link: <input type="text" name="button_link" class="form-control"></label>
                    </div>`;
                break;
            case "tinymce":
                preview = blockPreview.tinymce;
                blockInputs = `
                    <div class="block tinymce-block">
                        <label>Content: <textarea class="tinymce-editor"></textarea></label>
                    </div>`;
                tinymce.init({ selector: '.tinymce-editor' });
                break;
            default:
                preview = `<div class="block"><p>Unknown block type.</p></div>`;
                blockInputs = `<div class="block"><p>Unknown block type.</p></div>`;
                break;
        }
        return {
            "blockPreview": preview,
            "blockInputs": blockInputs
        }
    }

    function previewImage(event, previewId) {
        const input = event.target;
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById(previewId).src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
    function triggerFileInput(inputId) {
        console.log(inputId, 'inputId');
        document.getElementById(inputId).click();
    }
    function appendEmptySection() {
        $('#empty-section').remove();
        const section = $('<div class="empty-section add-section-btn" id="empty-section"><div class="add-empty-section">+</div></div>');
        $(section).click(function () {
            $('#sectionModal').modal('show');
        });
        $('#page-canvas').append(section);
    }

    // EVENT LISTENERS
    $(document).on('click', '.image-placeholder', function (e) { 
        e.stopPropagation(); // Prevent interference with parent clicks
        console.log('test');
        
        const inputElement = $(this).siblings('input[type="file"]'); // Use siblings to find the input
        if (inputElement.length > 0) {
            const inputId = inputElement.attr('id');
            console.log(inputId, 'inputId');
            if (inputId) {
                triggerFileInput(inputId);
            }
        } else {
            console.error('No file input found for the clicked image placeholder');
        }
    });
    $(document).on('click', '.column', function (e) {
        if($(this).attr('data-target')) {
            // todo
        }
        if($(this).attr('data-type')) {
            const block = addBlock($(this).attr('data-type'));
            // Append block to the dropped section
            $('#block-properties').html(block.blockInputs);
        } else {
            infoMessage('Drag block onto column to add!', 'info')
        }
        // Remove selection from all columns
        $('.column').removeClass('selected-column').removeAttr('data-selected').css('border', '');

        // Add selection to the clicked column
        $(this).addClass('selected-column').attr('data-selected', 'true').css('border', '2px solid blue');
        
        // Log the selected column for debugging
        console.log('Selected column:', $(this));
    });
</script>
<?= $this->endSection(); ?>
