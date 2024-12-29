<div class="container">
    <h1>Gestion des animaux</h1>
    <div class="d-flex justify-content-between">
        <button class="btn btn-primary mb-3" onclick="ouvrirFormulaireAnimal()">Ajouter un animal</button>
        <a href="/ZooArcadia/admin/display" class="btn btn-secondary mb-3">Retour à l'admin</a>
    </div>

    <!-- Barre de recherche -->
    <form onsubmit="return filtrerAnimaux(event)" class="mb-3">
        <div class="input-group">
            <input type="text" id="barre-recherche" placeholder="Rechercher un animal par nom" class="form-control">
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </div>
    </form>

    <div class="d-flex">
        <!-- Liste des animaux -->
        <div id="liste-animaux" style="width: 50%; max-height: 500px; overflow-y: auto;">
            <p id="loading">Chargement des animaux...</p>
        </div>

        <!-- Détails de l'animal sélectionné -->
        <div id="details-animal" class="card ms-3" style="width: 25%; display: none;">
            <div class="card-body">
                <h3 id="nom-animal"></h3>
                <img id="image-animal" src="/ZooArcadia/photos/logo zoo.png" alt="Image de l'animal" class="img-fluid mb-3">
                <p><strong>État :</strong> <span id="etat-animal"></span></p>
                <p><strong>Race :</strong> <span id="race-animal"></span></p>
                <p><strong>Habitat :</strong> <span id="habitat-animal"></span></p>
                <a href="#" id="lien-rapports-veto" class="btn btn-info">Voir rapports vétérinaires</a>
            </div>
        </div>

        <!-- Formulaire d'ajout/modification -->
        <div id="formulaire-animal" class="card ms-3" style="width: 25%; display: none;">
            <div class="card-body">
                <h2 id="titre-formulaire">Ajouter/Modifier un animal</h2>
                <form id="formulaireAnimal" onsubmit="soumettreFormulaireAnimal(event)">
                    <input type="hidden" id="id-animal">
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" id="prenom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="etat" class="form-label">État</label>
                        <select id="etat" class="form-select" required>
                            <option value="Fatigué">Fatigué</option>
                            <option value="Correct">Correct</option>
                            <option value="Bon">Bon</option>
                            <option value="En super forme">En super forme</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="race" class="form-label">Race</label>
                        <input type="text" id="race" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="image_animal" class="form-label">Image</label>
                        <input type="file" id="image_animal" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="habitat" class="form-label">Habitat</label>
                        <select id="habitat" class="form-select" required></select>
                    </div>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                    <button type="button" class="btn btn-secondary" onclick="fermerFormulaireAnimal()">Annuler</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        chargerAnimaux();  // Charger la liste des animaux
        chargerHabitats(); // Charger les habitats pour le formulaire
    });

    function chargerAnimaux() {
        fetch('/ZooArcadia/api/animal/list')
            .then(response => response.json())
            .then(data => {
                const listeAnimaux = document.getElementById('liste-animaux');
                listeAnimaux.innerHTML = ''; // Efface le contenu actuel
                if (data.success) {
                    if (data.data.length === 0) {
                        listeAnimaux.innerHTML = '<p>Aucun animal trouvé.</p>';
                        return;
                    }

                    data.data.forEach(animal => {
                        const ligneAnimal = document.createElement('div');
                        ligneAnimal.classList.add('animal-row', 'mb-3', 'p-2', 'border', 'rounded');
                        ligneAnimal.setAttribute('data-habitat', animal.habitat_id);
                        ligneAnimal.innerHTML = `
                            <p>${animal.prenom} (${animal.race}) - État: ${animal.etat}</p>
                            <button class="btn btn-info me-2" onclick="window.location.href='/ZooArcadia/animals/details/${animal.animal_id}'">Voir Détails</button>
                            <button class="btn btn-secondary me-2" onclick="modifierAnimal(${animal.animal_id})">Modifier</button>
                            <button class="btn btn-danger" onclick="supprimerAnimal(${animal.animal_id})">Supprimer</button>
                        `;
                        listeAnimaux.appendChild(ligneAnimal);
                    });
                } else {
                    listeAnimaux.innerHTML = `<p>Erreur : ${data.message}</p>`;
                }
            })
            .catch(error => {
                console.error('Erreur de réseau ou de parsing :', error);
                document.getElementById('liste-animaux').innerHTML = '<p>Erreur lors du chargement des animaux.</p>';
            });
    }

    function filtrerAnimaux(event) {
        event.preventDefault();
        const recherche = document.getElementById('barre-recherche').value.toLowerCase();
        const animaux = document.querySelectorAll('.animal-row');
        animaux.forEach(animal => {
            const nom = animal.textContent.toLowerCase();
            animal.style.display = nom.includes(recherche) ? '' : 'none';
        });
        return false; // Empêche le rechargement de la page
    }

    function chargerHabitats() {
        fetch('/ZooArcadia/api/animal/habitats')
            .then(response => response.json())
            .then(data => {
                const selectHabitat = document.getElementById('habitat');
                selectHabitat.innerHTML = ''; // Réinitialise les options
                if (data.success) {
                    data.data.forEach(habitat => {
                        const option = document.createElement('option');
                        option.value = habitat.habitat_id;
                        option.textContent = habitat.nom;
                        selectHabitat.appendChild(option);
                    });
                } else {
                    console.error('Erreur lors du chargement des habitats :', data.message);
                }
            })
            .catch(error => console.error('Erreur de réseau ou de parsing :', error));
    }

    // Les fonctions `modifierAnimal`, `supprimerAnimal`, etc., restent inchangées
</script>
