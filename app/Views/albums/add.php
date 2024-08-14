<?= $this->extend('header') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="h3 mb-2 text-gray-800"><?= esc($title) ?></h1>
    <form action="<?= site_url('albums/store') ?>" method="post">
        <div class="form-group">
            <label for="album_id">Select Album</label>
            <select name="album_id" id="album_id" class="form-control">
                <option value="">Select an album</option>
                <?php foreach ($albums as $album): ?>
                    <option value="<?= esc($album['id']) ?>"><?= esc($album['title']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="cards">My duplicates</label>
            <div id="cards-container"></div>
        </div>
        <div class="form-group">
            <label for="needed_cards">Needed Cards</label>
            <div id="needed-cards-container"></div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    <a href="<?= site_url('my-collection') ?>" class="btn btn-secondary mt-3">Back to Collection</a>
</div>

<script>
    $(document).ready(function() {
        $('#album_id').change(function() {
            var albumId = $(this).val();
            if (albumId) {
                $.ajax({
                    url: '<?= site_url('albums/get-cards') ?>/' + albumId,
                    type: 'GET',
                    success: function(response) {
                        var cardsContainer = $('#cards-container');
                        var neededCardsContainer = $('#needed-cards-container');
                        cardsContainer.empty();
                        neededCardsContainer.empty();

                        response.forEach(function(card) {
                            var cardHtml = '<div class="form-check">' +
                                '<input type="checkbox" name="cards[]" value="' + card.id + '" class="form-check-input" id="card' + card.id + '">' +
                                '<label class="form-check-label" for="card' + card.id + '">Card ID: ' + card.id + '</label>' +
                                '</div>';
                            cardsContainer.append(cardHtml);

                            var neededCardHtml = '<div class="form-check">' +
                                '<input type="checkbox" name="needed_cards[]" value="' + card.id + '" class="form-check-input" id="neededCard' + card.id + '">' +
                                '<label class="form-check-label" for="neededCard' + card.id + '">Card ID: ' + card.id + '</label>' +
                                '</div>';
                            neededCardsContainer.append(neededCardHtml);
                        });
                    },
                    error: function() {
                        alert('An error occurred while fetching the cards.');
                    }
                });
            }
        });
    });
</script>

<?= $this->endSection() ?>