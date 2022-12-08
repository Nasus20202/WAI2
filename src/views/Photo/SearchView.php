<?php 
$title = "Wyszukiwarka"; $pageId = 3;
include __DIR__.'/../Layout/header.php'; ?>

<h1>Wyszukiwarka zdjęć</h1>
<input type="text" id="search" placeholder="Wpisz frazę do wyszukania" onkeyup="search()" />

<div id="search-result"></div>

<div id="modal" class="modal" onclick="closeModal()">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modal-img" alt="modal">
</div>

<?php include __DIR__.'/../Layout/footer.php'; ?>