<?php include __DIR__.'/../Layout/header.php'; ?>

<?php echo $model->message; ?>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Tytuł"  required/>
    <input type="text" name="author" placeholder="Autor" required/>
    <input type="file" name="image" id="image" required/>
    <input type="submit" value="Upload" />
</form>

<?php include __DIR__.'/../Layout/footer.php'; ?>