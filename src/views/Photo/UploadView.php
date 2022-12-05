<?php include __DIR__.'/../Layout/header.php'; ?>

<form method="POST" enctype="multipart/form-data">
    <?php echo $model->message; ?>
    <input type="text" name="title" placeholder="Tytuł"  required/>
    <input type="text" name="author" placeholder="Autor" required/>
    <input type="file" name="image" id="image" required/>
    <button type="submit">Wyślij</button>
</form>

<?php include __DIR__.'/../Layout/footer.php'; ?>