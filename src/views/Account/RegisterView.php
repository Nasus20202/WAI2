<?php
$message = "";
switch ($model->status) {
    case 1:
        $message = "Login jest już zajęty";
        break;
    case 2:
        $message = "Adres email jest już zajęty";
        break;
    case 3:
        $message = "Adres email jest niepoprawny";
        break;
    case 4:
        $message = "Hasło musi mieć co najmniej 8 znaków";
        break;
    case 5:
        $message = "Hasła nie są takie same";
        break;
}
$title = "Zarejestruj się"; $pageId = 4;
include __DIR__.'/../Layout/header.php';
?>

<form method="POST" enctype="multipart/form-data" class="form">
    <h1><?php echo $title; ?></h1>
    <?php echo $message; ?>
    <input type="text" name="login" title="Login" placeholder="Login" required/>
    <input type="email" name="email" title="Adres email" placeholder="Adres email"  required/>
    <input type="password" name="password" title="Hasło" placeholder="Hasło" required/>
    <input type="password" name="passwordRepeat" title="Powtórz hasło" placeholder="Powtórz hasło" required/>
    <button type="submit" name="submit">Zarejestruj się</button>
</form>

<?php include __DIR__.'/../Layout/footer.php'; ?>