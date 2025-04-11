<?= $this->extend('header') ?>

<?= $this->section('content') ?>
<?php helper('form'); ?>

<div class="text-center">
    <div><?= esc($description) ?></div>
    <?php if (session()->getFlashdata('message')):  ?>
        <div class="alert alert-info" role="alert">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif  ?>
</div>


<div class="d-flex justify-content-center mb-3">
    <div class="card w-75 ">
        <img src="<?= base_url('assets/img/blogsImages/' . $blog['image']) ?>" alt="Blog image" class="card-img-top">
        <div class="card-body ">
            <h5 class="card-title text-center display-5"><?= $blog['title']  ?></h5>
            <h5 class="card-title text-center"><?= $blog['subtitle']  ?></h5>
            <p class="card-text text-center"> <?= $blog['content']  ?></p>

            <!-- if the user is the author this is shown -->
            <?php if ($userId == $blog['author_id']): ?>
                <div class="d-flex justify-content-center">
                    <a href="<?= url_to('blogUpdate', $blog['id']) ?>" class="btn btn-primary w-50 mx-1">Edit the blog</a>
                    <a class="btn btn-warning w-50 mx-1" onclick="document.getElementById('<?= 'deleteDiv' . $blog['id'] ?>').style.display='block'">Delete the blog</a>
                </div>
                <div style="display:none" id="<?= 'deleteDiv' . $blog['id'] ?>">
                    <form method="POST" action="<?= url_to('blogDelete', $blog['id']) ?>" class="d-flex justify-content-center my-1">
                        <button type="submit" class="btn btn-danger w-50 mx-1">Confirm the delete</button>
                        <div class="btn btn-info w-50 mx-1" onclick="document.getElementById('<?= 'deleteDiv' . $blog['id'] ?>').style.display='none'">Cancel</div>
                    </form>
                </div>

            <?php endif ?>
        </div>
    </div>
</div>



<?= $this->endSection() ?>