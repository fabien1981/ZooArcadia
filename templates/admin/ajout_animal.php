<div class="container">
    <h1>Ajouter un animal</h1>

    <!-- Zone d'alerte pour afficher le message de succès ou d'erreur -->
    <div id="response-message" class="alert" role="alert" style="display: none;"></div>

    <!-- Formulaire pour ajouter un animal -->
    <form id="animal-form">
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom de l'animal</label>
            <input type="text" class="form-control" id="prenom" name="prenom" required>
        </div>
        <div class="mb-3">
            <label for="race" class="form-label">Race de l'animal</label>
            <input type="text" class="form-control" id="race" name="race" required>
        </div>
        <div class="mb-3">
            <label for="etat" class="form-label">État de l'animal</label>
            <select id="etat" name="etat" class="form-select" required>
                <option value="">Sélectionnez l'état</option>
                <option value="Fatigué">Fatigué</option>
                <option value="Correct">Correct</option>
                <option value="Bon">Bon</option>
                <option value="En super forme">En super forme</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="habitat" class="form-label">Habitat de l'animal</label>
            <select name="habitat" id="habitat" class="form-select" required>
                <option value="">Sélectionnez l'habitat</option>
                <option value="Savane">Savane</option>
                <option value="Jungle">Jungle</option>
                <option value="Marais">Marais</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="image_animal" class="form-label">Image de l'animal</label>
            <input type="text" class="form-control" id="image_animal" name="image_animal">
        </div>
         
        <button type="submit" class="btn btn-primary">Ajouter l'animal</button>
    </form>
</div>

<!-- Inclusion de api.js pour la gestion des requêtes API -->
<script src="/811/scripts/api.js"></script>

<!-- Script pour gérer la soumission du formulaire via JavaScript -->
<script>
    document.getElementById('animal-form').addEventListener('submit', function (e) {
        e.preventDefault(); // Empêche la soumission classique du formulaire

        // Récupération des données du formulaire
        const animalData = {
            prenom: document.getElementById('prenom').value,
            race: document.getElementById('race').value,
            etat: document.getElementById('etat').value,
            habitat: document.getElementById('habitat').value,
            image_animal: document.getElementById('image_animal').value,
        };

        // Appel à la fonction createAnimal de api.js pour l'envoi
        createAnimal(animalData);
    });
</script>
<script src="/811/scripts/connexion.js"></script>
