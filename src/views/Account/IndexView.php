<?php
$message = "";
switch ($model->status) {
    case 1:
        $message = "Użytkownik nie istnieje"; break;
    case 2:
        $message = "Błędne hasło"; break;
}
$title = "Zaloguj się"; $pageId = 4;
include __DIR__.'/../Layout/header.php';
?>

<form method="POST" enctype="multipart/form-data" class="form">
    <h1><?php echo $title; ?></h1>
    <?php echo $message; ?>
    <input type="text" name="login" title="Login" placeholder="Login"  required/>
    <input type="password" name="password" title="Hasło" placeholder="Hasło" required/>
    <button type="submit" name="submit">Zaloguj się</button>
</form>

<?php include __DIR__.'/../Layout/footer.php'; ?>