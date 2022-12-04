function showPhoto(url) {
    var modal = document.getElementById('modal');
    var modalImg = document.getElementById("modal-img");
    if (modal == null || modalImg == null) {
        return;
    }
    modalImg.src = url;
    modal.style.display = "block";
}

function closeModal() {
    var modal = document.getElementById('modal');
    if (modal == null) {
        return;
    }
    modal.style.display = "none";
}

addEventListener('scroll', function (event) {
    var stickyNavbar = document.getElementById('sticky-navbar');
    if (stickyNavbar == null)
        return;
    if (window.scrollY > 0) {
        stickyNavbar.classList.add('pinned');
    }
    else {
        stickyNavbar.classList.remove('pinned');
    }
});

function toggleTheme() {
    var theme = localStorage.getItem('theme');
    if (theme == null || theme == 'light') {
        localStorage.setItem('theme', 'dark');
    }
    else {
        localStorage.setItem('theme', 'light');
    }
    updateTheme();
}

function updateTheme() {
    var body = document.getElementsByTagName('body')[0];
    var themeToggler = document.getElementById('theme-toggler');
    if (themeToggler == null || body == null)
        return;
    var theme = localStorage.getItem('theme');
    if (theme == null || theme == 'light') {
        body.classList.remove('dark');
        localStorage.setItem('theme', 'light');
        themeToggler.innerHTML = "&#127769;";
    }
    else {
        body.classList.add('dark');
        localStorage.setItem('theme', 'dark');
        themeToggler.innerHTML = "&#9728;&#65039;";
    }
}

document.addEventListener('DOMContentLoaded', function () {
    updateTheme();
}, false);