<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#F5CB5C">
  <title><?php echo $model->pageTitle ?></title>
  <link rel="stylesheet" href="/static/css/style.css">
  <script src="/static/js/main.js"></script>
</head>
<body>
  <div id="theme-toggler" onclick="toggleTheme()"></div>
  <header>
      <div class="center">
        <span class="title">Galeria zdjęć</span>
      </div>
    </header>
    <div class="container">
      <nav id="sticky-navbar">
        <a href="/" class="navitem currentNav">Galeria</a>
        <a href="/upload" class="navitem">Wyślij zdjęcie</a>
        <a href="/saved" class="navitem">Zapamiętane</a>
        <div class="dropdown">
          <div class="dropbtn">Konto</div>
          <div class="dropdown-content">
            <a class="dropdown-link" href="/account/login">Zaloguj się</a>
            <a class="dropdown-link" href="/account/register">Załóż konto</a>
          </div>
        </div>
      </nav>