<?php 
$title = "Galeria zdjęć"; $pageId = 0;
include __DIR__.'/../Layout/header.php'; ?>

<?php if($model->userLoggedIn) { ?>
    <h1>Witaj, <?php echo ucfirst($model->username) ?>!</h1>
<?php } ?>

<div class="gallery">
    <?php foreach($model->photos as $photo): 
        $link = $model->basePath . $photo->id . '.' . $photo->extension;
        ?>
        <div class="gallery-photo card">
            <div class="card-content">
                <h2><a href="<?php echo $link ?>"><?php echo $photo->title; ?></a></h2>
                <h4>Autor: <?php echo $photo->author; ?></h3>
            </div>
            <img class="card-img" src="<?php echo $link; ?>" onclick="showPhoto('<?php echo $model->basePath . $photo->id . '.' . $photo->extension ?>')">
        </div>
    <?php endforeach ?>
</div>

<div id="modal" class="modal" onclick="closeModal()">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modal-img" src="assets/img/logo.png" alt="modal">
</div>

<?php include __DIR__.'/../Layout/footer.php'; ?>