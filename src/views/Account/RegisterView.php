<?php include __DIR__.'/../Layout/header.php'; ?>

<form method="POST" enctype="multipart/form-data">
    <?php echo $model->message; ?>
    <input type="text" name="login" placeholder="Login"  required/>
    <input type="email" name="email" placeholder="Adres email"  required/>
    <input type="password" name="password" placeholder="Hasło" required/>
    <button type="submit" name="submit">Zarejestruj się</button>
</form>

<?php include __DIR__.'/../Layout/footer.php'; ?>