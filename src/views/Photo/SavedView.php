<?php 
$title = "Zapisane"; $pageId = 2;
include __DIR__.'/../Layout/header.php'; ?>

<div class="gallery">
    <?php foreach($model->saved as $savedData): 
        $photo = $savedData['photo'];
        ?>
        <div class="gallery-photo card">
            <div class="card-content">
                <h2><?php echo $photo->title; ?></h2>
                <h4>Autor: <?php echo $photo->author; ?></h4>
            </div>
            <img class="card-img" src="<?php echo $savedData['thumbnail']; ?>" onclick="savedData('<?php echo $photoData['watermark'] ?>')">
        </div>
    <?php endforeach ?>
</div>




<?php include __DIR__.'/../Layout/footer.php'; ?>