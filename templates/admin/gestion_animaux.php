<div class="container">
    <h1>Gestion des animaux</h1>
    <div class="d-flex justify-content-between">
        <button class="btn btn-primary mb-3" onclick="ouvrirFormulaireAnimal()">Ajouter un animal</button>
        <a href="/ZooArcadia/admin/display" class="btn btn-secondary mb-3">Retour à l'admin</a>
    </div>

    <!-- Barre de recherche par nom -->
    <input type="text" id="barre-recherche" placeholder="Rechercher un animal par nom" onkeyup="filtrerAnimaux()" class="form-control mb-3">
    
    <!-- Filtre par habitat -->
    <select id="filtre-habitat" onchange="filtrerParHabitat()" class="form-select mb-3">
        <option value="">Tous les habitats</option>
    </select>

    <div class="d-flex">
        <!-- Liste des animaux -->
        <div id="liste-animaux" style="width: 50%; max-height: 500px; overflow-y: auto;"></div>

        <!-- Fiche de l'animal sélectionné -->
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

        <!-- Formulaire d'ajout/modification d'animal -->
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
                        <input type="file" id="image_animal" class="form-control" accept="image/*" onchange="apercuImage(event)">
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

<script src="/ZooArcadia/scripts/zooApp.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        chargerAnimaux();  // Chargement de la liste des animaux
        chargerHabitats();  // Chargement des habitats pour le formulaire et le filtre
    });

    function chargerAnimaux() {
        fetch('/ZooArcadia/api/animal/list')
            .then(response => response.json())
            .then(data => {
                const listeAnimaux = document.getElementById('liste-animaux');
                listeAnimaux.innerHTML = '';
                if (data.success) {
                    data.data.forEach(animal => {
                        const ligneAnimal = document.createElement('div');
                        ligneAnimal.classList.add('animal-row', 'mb-3', 'p-2', 'border', 'rounded');
                        ligneAnimal.setAttribute('data-habitat', animal.habitat_id);
                        ligneAnimal.innerHTML = `
                            <p>${animal.prenom} (${animal.race}) - État: ${animal.etat}</p>
                            <button class="btn btn-info me-2" onclick="selectionnerAnimal(${animal.animal_id})">Sélectionner</button>
                            <button class="btn btn-secondary me-2" onclick="modifierAnimal(${animal.animal_id})">Modifier</button>
                            <button class="btn btn-danger" onclick="supprimerAnimal(${animal.animal_id})">Supprimer</button>
                        `;
                        listeAnimaux.appendChild(ligneAnimal);
                    });
                } else {
                    listeAnimaux.innerText = 'Aucun animal trouvé';
                }
            })
            .catch(error => console.error('Erreur de réseau ou de parsing :', error));
    }

    function chargerHabitats() {
        fetch('/ZooArcadia/api/animal/habitats')
            .then(response => response.json())
            .then(data => {
                const selectHabitat = document.getElementById('habitat');
                const filterHabitat = document.getElementById('filtre-habitat');
                selectHabitat.innerHTML = '<option value="">Sélectionner un habitat</option>';
                filterHabitat.innerHTML = '<option value="">Tous les habitats</option>';

                if (data.success) {
                    data.data.forEach(habitat => {
                        const optionForm = document.createElement('option');
                        const optionFilter = document.createElement('option');
                        optionForm.value = optionFilter.value = habitat.habitat_id;
                        optionForm.textContent = optionFilter.textContent = habitat.nom;
                        selectHabitat.appendChild(optionForm);
                        filterHabitat.appendChild(optionFilter);
                    });
                }
            })
            .catch(error => console.error('Erreur de réseau:', error));
    }

    function filtrerAnimaux() {
        const recherche = document.getElementById('barre-recherche').value.toLowerCase();
        const animaux = document.querySelectorAll('.animal-row');
        animaux.forEach(animal => {
            const nom = animal.textContent.toLowerCase();
            animal.style.display = nom.includes(recherche) ? '' : 'none';
        });
    }

    function filtrerParHabitat() {
        const habitatSelectionne = document.getElementById('filtre-habitat').value;
        const animaux = document.querySelectorAll('.animal-row');
        animaux.forEach(animal => {
            const habitat = animal.getAttribute('data-habitat');
            animal.style.display = habitatSelectionne === '' || habitatSelectionne === habitat ? '' : 'none';
        });
    }

    function selectionnerAnimal(id) {
        fetch(`/ZooArcadia/api/animal/show/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('details-animal').style.display = 'block';
                    document.getElementById('nom-animal').textContent = data.data.prenom;
                    document.getElementById('etat-animal').textContent = data.data.etat;
                    document.getElementById('race-animal').textContent = data.data.race;
                    document.getElementById('habitat-animal').textContent = data.data.habitat_nom;
                    document.getElementById('image-animal').src = data.data.image_animal ? `/ZooArcadia/photos/${data.data.image_animal}` : '/ZooArcadia/photos/logo zoo.png';
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Erreur de réseau:', error));
    }

    function modifierAnimal(id) {
        fetch(`/ZooArcadia/api/animal/show/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('id-animal').value = id;
                    document.getElementById('prenom').value = data.data.prenom;
                    document.getElementById('etat').value = data.data.etat;
                    document.getElementById('race').value = data.data.race;
                    document.getElementById('image_animal').value = ''; // Reset de l'image
                    document.getElementById('habitat').value = data.data.habitat; 
                    document.getElementById('titre-formulaire').textContent = 'Modifier un animal';
                    document.getElementById('formulaire-animal').style.display = 'block';
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Erreur de réseau:', error));
    }

    function supprimerAnimal(id) {
        if (confirm('Voulez-vous vraiment supprimer cet animal ?')) {
            fetch(`/ZooArcadia/api/animal/delete/${id}`, { method: 'DELETE' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Animal supprimé avec succès');
                        chargerAnimaux();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Erreur de réseau:', error));
        }
    }

    function soumettreFormulaireAnimal(event) {
        event.preventDefault();
        const id = document.getElementById('id-animal').value;
        const animalData = {
            prenom: document.getElementById('prenom').value,
            etat: document.getElementById('etat').value,
            race: document.getElementById('race').value,
            image_animal: document.getElementById('image_animal').files[0] ? document.getElementById('image_animal').files[0].name : '',
            habitat: document.getElementById('habitat').value
        };

        const url = id ? `/ZooArcadia/api/animal/edit/${id}` : '/ZooArcadia/api/animal/create';
        const method = id ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(animalData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(id ? 'Animal modifié avec succès' : 'Animal ajouté avec succès');
                fermerFormulaireAnimal();
                chargerAnimaux();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Erreur de réseau:', error));
    }

    function ouvrirFormulaireAnimal() {
        document.getElementById('titre-formulaire').textContent = 'Ajouter un animal';
        document.getElementById('formulaire-animal').style.display = 'block';
        document.getElementById('formulaireAnimal').reset();
        document.getElementById('id-animal').value = '';
    }

    function fermerFormulaireAnimal() {
        document.getElementById('formulaire-animal').style.display = 'none';
    }
</script>
