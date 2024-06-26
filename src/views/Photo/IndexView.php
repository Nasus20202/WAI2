<?php 
$title = "Galeria zdjęć"; $pageId = 0;
$totalPages = ceil($model->total / $model->amount);
include __DIR__.'/../Layout/header.php'; ?>

<?php if($model->userLoggedIn) { ?>
    <h1>Witaj, <?php echo ucfirst($model->username) ?>!</h1>
<?php } ?>

Znaleziono <?php echo $model->total; ?> zdjęć

<form class="gallery" method="POST" action="/saved">
    <?php foreach($model->photos as $photoData): 
        $photo = $photoData['photo'];
        ?>
        <div class="gallery-photo card">
            <div class="card-content">
                <h2><?php echo $photo->title; ?></h2>
                <h4>Autor: <?php echo $photo->author; ?></h4>
                <input type="checkbox" name="saved[]" <?php if(in_array($photo->id, $model->saved)) echo 'checked disabled'; ?> value="<?php echo $photo->id; ?>">
                <label">Zapisz</label>
                <?php if($model->userLoggedIn && $photo->ownerId == $model->userId): ?>
                    <input type="checkbox" name="private" <?php if($photo->private) echo 'checked'; ?> onchange="changeVisibility('<?php echo $photo->id ?>')">
                    <label>Prywatne</label>
                <?php endif ?>
            </div>
            <img class="card-img" src="<?php echo $photoData['thumbnail']; ?>" onclick="showPhoto('<?php echo $photoData['watermark'] ?>')">
        </div>
    <?php endforeach ?>
    <input type="submit" id="savePhotos" value="Zapisz"/>
</form>


<div class="pagination">
    <?php if($model->page > 0): ?>
        <a href="?page=<?php echo $model->page - 1; ?>&amount=<?php echo $model->amount?>">Poprzednia &laquo;</a>
    <?php endif ?>
    Strona <?php echo $model->page + 1; ?> z <?php echo $totalPages; ?>
    <?php if($model->page < $totalPages - 1): ?>
        <a href="?page=<?php echo $model->page + 1; ?>&amount=<?php echo $model->amount?>"> Następna &raquo;</a>
    <?php endif ?>
</div>
<div class="imagesPerPage">
    Zdjęć na stronę: 
    <?php foreach([10, 20, 50, 100] as $i): ?>
        <a href="?amount=<?php echo $i?>"><?php echo $i; ?></a>
    <?php endforeach ?>
</div>



<div id="modal" class="modal" onclick="closeModal()">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modal-img" alt="modal">
</div>

<?php include __DIR__.'/../Layout/footer.php'; ?>