<div class="gallery">
    <?php if(count($model->result) == 0): ?>
        <h2>Brak wyników</h2>
    <?php endif ?>
    <?php foreach($model->result as $photoData): 
        $photo = $photoData['photo'];
        ?>
        <div class="gallery-photo card">
            <div class="card-content">
                <h2><?php echo $photo->title; ?></h2>
                <h4>Autor: <?php echo $photo->author; ?></h4>
            </div>
            <img class="card-img" src="<?php echo $photoData['thumbnail']; ?>" onclick="showPhoto('<?php echo $photoData['watermark'] ?>')">
        </div>
    <?php endforeach ?>
</div>