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
}
$title = "Zarejestruj się"; $pageId = 3;
include __DIR__.'/../Layout/header.php';
?>

<form method="POST" enctype="multipart/form-data">
    <h1><?php echo $title; ?></h1>
    <?php echo $message; ?>
    <input type="text" name="login" placeholder="Login"  required/>
    <input type="email" name="email" placeholder="Adres email"  required/>
    <input type="password" name="password" placeholder="Hasło" required/>
    <button type="submit" name="submit">Zarejestruj się</button>
</form>

<?php include __DIR__.'/../Layout/footer.php'; ?>