<?php 
$title = "Zapisane"; $pageId = 2;
include __DIR__.'/../Layout/header.php'; ?>

<h1>Zapisane zdjęcia</h1>

<?php if(count($model->saved) == 0)
    echo "Brak zapisanych zdjęć";
?>

<form class="gallery" method="POST" action="/photo/saved/remove">
    <?php foreach($model->saved as $savedData): 
        $photo = $savedData['photo'];
        ?>
        <div class="gallery-photo card">
            <div class="card-content">
                <h2><?php echo $photo->title; ?></h2>
                <h4>Autor: <?php echo $photo->author; ?></h4>
                <input type="checkbox" name="saved[]" value="<?php echo $photo->id; ?>">
                <label">Usuń</label>
            </div>
            <img class="card-img" src="<?php echo $savedData['thumbnail']; ?>" onclick="savedData('<?php echo $photoData['watermark'] ?>')">
        </div>
    <?php endforeach ?>
    <input type="submit" id="savePhotos" value="Usuń wybrane"/>
</form>




<?php include __DIR__.'/../Layout/footer.php'; ?>