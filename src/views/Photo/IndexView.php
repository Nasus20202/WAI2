<?php include __DIR__.'/../Layout/header.php'; ?>

<?php foreach($model->photos as $photo): ?>
    <div class="photo">
        <h2><?php echo $photo->title; ?></h2>
        <h3><?php echo $photo->author; ?></h3>
        <?php echo $photo->extension ?>
        <img src="<?php echo $model->basePath . $photo->id . '.' . $photo->extension ?>" alt="<?php echo $photo->title; ?>">
    </div>
<?php endforeach ?>

<?php include __DIR__.'/../Layout/footer.php'; ?>