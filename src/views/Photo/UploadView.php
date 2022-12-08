<?php
$message = "";
switch ($model->status) {
    case 1:
    case 4:
        $message = "Plik jest zbyt duży";
        break;
    case 2:
        $message = "Plik jest za duży oraz ma niepoprawny format";
        break;
    case 3:
        $message = "Plik ma niepoprawny format";
        break;
}
$title = "Wyślij zdjęcie"; $pageId = 1;
include __DIR__.'/../Layout/header.php';
?>

<form method="POST" enctype="multipart/form-data" class="form">
    <h1><?php echo $title; ?></h1>
    <?php echo $message; ?>
    <input type="text" name="title" title="Tytuł" placeholder="Tytuł"  required/>
    <input type="text" name="author" title="Autor" placeholder="Autor" value="<?php echo ucfirst($model->username) ?>" required/>
    <input type="text" name="watermark" title="Znak wodny" placeholder="Znak wodny" required/>
    <?php if($model->userLoggedIn): ?>
    <span>
        <input type="radio" name="visibility" value="public" checked/>Publiczne
        <input type="radio" name="visibility" value="private"/>Prywatne
    </span>
    <?php endif; ?>
    <input type="file" name="image" id="image" required/>
    <button type="submit">Wyślij</button>
</form>

<?php include __DIR__.'/../Layout/footer.php'; ?>