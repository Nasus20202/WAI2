<?php
$message = "";
switch ($model->status) {
    case 1:
    case 3:
        $message = "Plik jest za duży"; break;
    case 2:
        $message = "Niepoprawny format pliku"; break;
}
$title = "Wyślij zdjęcie"; $pageId = 1;
include __DIR__.'/../Layout/header.php';
?>

<form method="POST" enctype="multipart/form-data">
    <h1><?php echo $title; ?></h1>
    <?php echo $message; ?>
    <input type="text" name="title" placeholder="Tytuł"  required/>
    <input type="text" name="author" placeholder="Autor" value="<?php echo ucfirst($model->username) ?>" required/>
    <input type="text" name="watermark" placeholder="Znak wodny" required/>
    <?php if($model->userLoggedIn): ?>
    <span>
        <input type="checkbox" name="private" id="private"/>
        <label for="private">Prywatne</label>
    </span>
    <?php endif; ?>
    <input type="file" name="image" id="image" required/>
    <button type="submit">Wyślij</button>
</form>

<?php include __DIR__.'/../Layout/footer.php'; ?>