<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
    <title><?= esc($title) ?></title>
    <meta name="description" content="<?= esc($description) ?>">
    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('vendor/datatables/dataTables.bootstrap4.css') ?>" rel="stylesheet" type="text/css">
    <script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('vendor/tinymce/tinymce.min.js') ?>" referrerpolicy="origin"></script>
<?= $this->endSection() ?>