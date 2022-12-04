<h1>Galeria zdjęć</h1>

<?php foreach($model->photos as $photo): ?>
    <div class="photo">
        <h2><?php echo $photo->title; ?></h2>
        <h3><?php echo $photo->author; ?></h3>
        <?php echo $photo->extension ?>
        <img src="<?php echo $model->basePath . $photo->id . '.' . $photo->extension ?>" alt="<?php echo $photo->title; ?>">
    </div>
<?php endforeach ?>