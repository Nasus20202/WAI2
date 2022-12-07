<?php 
$title = "Galeria zdjęć"; $pageId = 0;
$totalPages = ceil($model->total / $model->amount);
include __DIR__.'/../Layout/header.php'; ?>

<?php if($model->userLoggedIn) { ?>
    <h1>Witaj, <?php echo ucfirst($model->username) ?>!</h1>
<?php } ?>

Znaleziono <?php echo $model->total; ?> zdjęć

<div class="gallery">
    <?php foreach($model->photos as $photo): 
        $link = $model->basePath . $photo->id . '.' . $photo->extension;
        $watermarkLink = $model->basePath . $photo->id . '-wm.' . $photo->extension;
        $thumbnailLink = $model->basePath . $photo->id . '-min.' . $photo->extension;
        ?>
        <div class="gallery-photo card">
            <div class="card-content">
                <h2><?php echo $photo->title; ?></h2>
                <h4>Autor: <?php echo $photo->author; echo $photo->private ? " (Plik prywatny)" : ""?></h4>
            </div>
            <img class="card-img" src="<?php echo $thumbnailLink; ?>" onclick="showPhoto('<?php echo $watermarkLink ?>')">
        </div>
    <?php endforeach ?>
</div>

<div class="pagination">
    <?php if($model->page > 0): ?>
        <a href="/photo/index?page=<?php echo $model->page - 1; ?>&amount=<?php echo $model->amount?>">Poprzednia &laquo;</a>
    <?php endif ?>
    Strona <?php echo $model->page + 1; ?> z <?php echo $totalPages; ?>
    <?php if($model->page < $totalPages - 1): ?>
        <a href="/photo/index?amount=<?php echo $model->amount?>"> Nestępna &raquo;</a>
    <?php endif ?>
</div>
<div class="imagesPerPage">
    Zdjęć na stronę: 
    <?php foreach([10, 20, 50, 100] as $i): ?>
        <a href="/photo/index?amount=<?php echo $i?>"><?php echo $i; ?></a>
    <?php endforeach ?>
</div>

<div id="modal" class="modal" onclick="closeModal()">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modal-img" src="assets/img/logo.png" alt="modal">
</div>

<?php include __DIR__.'/../Layout/footer.php'; ?>