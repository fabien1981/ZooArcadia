<!-- Barre de recherche -->
<div id="search-bar">
    <input type="text" id="searchName" placeholder="Prénom">
    <input type="text" id="searchRace" placeholder="Race">
    <input type="text" id="searchState" placeholder="État">
    <input type="text" id="searchHabitat" placeholder="Habitat">
    <button onclick="searchAnimals()">Rechercher</button>
</div>

<!-- Div pour afficher les résultats -->
<div id="results"></div>

<!-- Inclure le fichier api.js -->
<script src="/public/js/api.js"></script>
