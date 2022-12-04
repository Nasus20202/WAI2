<?php include __DIR__.'/../Layout/header.php'; ?>

<?php echo $model->message; ?>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title" />
    <input type="text" name="author" placeholder="Author" />
    <input type="file" name="image" id="image" />
    <input type="submit" value="Upload" />
</form>

<?php include __DIR__.'/../Layout/footer.php'; ?>