<?php 
$title = "Galeria zdjęć"; $pageId = 0;
include __DIR__.'/../Layout/header.php'; ?>

<?php if($model->userLoggedIn) { ?>
    <h1>Witaj, <?php echo ucfirst($model->username) ?>!</h1>
<?php } ?>

<div class="gallery">
    <?php foreach($model->photos as $photo): ?>
        <div class="gallery-photo card">
            <div class="card-content">
                <h2><?php echo $photo->title; ?></h2>
                <h4>Autor: <?php echo $photo->author; ?></h3>
            </div>
            <img class="card-img" src="<?php echo $model->basePath . $photo->id . '.' . $photo->extension ?>" alt="<?php echo $photo->title; ?>" onclick="showPhoto('<?php echo $model->basePath . $photo->id . '.' . $photo->extension ?>')">
        </div>
    <?php endforeach ?>
</div>

<div id="modal" class="modal" onclick="closeModal()">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modal-img" src="assets/img/logo.png" alt="modal">
</div>

<?php include __DIR__.'/../Layout/footer.php'; ?>