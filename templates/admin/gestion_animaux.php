<div class="container">
    <h1>Gestion des animaux</h1>
    <div class="d-flex justify-content-between">
        <button class="btn btn-primary mb-3" onclick="openAnimalForm()">Ajouter un animal</button>
        <a href="/811/admin" class="btn btn-secondary mb-3">Retour à l'admin</a>
    </div>

    <!-- Barre de recherche par nom -->
    <input type="text" id="search-bar" placeholder="Rechercher un animal par nom" onkeyup="filterAnimals()" class="form-control mb-3">
    
    <!-- Filtre par habitat -->
    <select id="filter-habitat" onchange="filterByHabitat()" class="form-select mb-3">
        <option value="">Tous les habitats</option>
    </select>

    <div class="d-flex">
        <!-- Liste des animaux -->
        <div id="animal-list" style="width: 50%; max-height: 500px; overflow-y: auto;"></div>

        <!-- Fiche de l'animal sélectionné -->
        <div id="animal-details" class="card ms-3" style="width: 25%; display: none;">
            <div class="card-body">
                <h3 id="animal-name"></h3>
                <img id="animal-image" src="/811/photos/logo zoo.png" alt="Image de l'animal" class="img-fluid mb-3">
                <p><strong>État :</strong> <span id="animal-state"></span></p>
                <p><strong>Race :</strong> <span id="animal-race"></span></p>
                <p><strong>Habitat :</strong> <span id="animal-habitat"></span></p>
                <a href="#" id="veterinary-reports-link" class="btn btn-info">Voir rapports vétérinaires</a>
            </div>
        </div>

        <!-- Formulaire d'ajout/modification d'animal -->
        <div id="animal-form" class="card ms-3" style="width: 25%; display: none;">
            <div class="card-body">
                <h2 id="form-title">Ajouter/Modifier un animal</h2>
                <form id="animalForm" onsubmit="handleAnimalFormSubmit(event)">
                    <input type="hidden" id="animalId">
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
                        <input type="file" id="image_animal" class="form-control" accept="image/*" onchange="previewImage(event)">
                    </div>
                    <div class="mb-3">
                        <label for="habitat" class="form-label">Habitat</label>
                        <select id="habitat" class="form-select" required></select>
                    </div>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                    <button type="button" class="btn btn-secondary" onclick="closeAnimalForm()">Annuler</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/811/scripts/zooApp.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        fetchAnimals();  // Chargement de la liste des animaux
        loadHabitats();  // Chargement des habitats disponibles pour le formulaire
        populateHabitatFilter(); // Charger les habitats pour le filtre
    });

    function fetchAnimals() {
        fetch('/811/api/animal/list')
            .then(response => response.json())
            .then(data => {
                const animalList = document.getElementById('animal-list');
                animalList.innerHTML = '';
                if (data.success) {
                    data.data.forEach(animal => {
                        const animalRow = document.createElement('div');
                        animalRow.classList.add('animal-row', 'mb-3', 'p-2', 'border', 'rounded');
                        
                        // Ajouter l'attribut data-habitat pour le filtrage par habitat
                        animalRow.setAttribute('data-habitat', animal.habitat_id);

                        animalRow.innerHTML = `
                            <p>${animal.prenom} (${animal.race}) - État: ${animal.etat}</p>
                            <button class="btn btn-info me-2" onclick="selectAnimal(${animal.animal_id})">Sélectionner</button>
                            <button class="btn btn-secondary me-2" onclick="editAnimal(${animal.animal_id})">Modifier</button>
                            <button class="btn btn-danger" onclick="deleteAnimal(${animal.animal_id})">Supprimer</button>
                        `;
                        animalList.appendChild(animalRow);
                    });
                } else {
                    animalList.innerText = 'Aucun animal trouvé';
                }
            })
            .catch(error => console.error('Erreur de réseau ou de parsing :', error));
    }

    // Charger les habitats dans le formulaire et le filtre
    function loadHabitats() {
        fetch('/811/api/animal/habitats')
            .then(response => response.json())
            .then(data => {
                const habitatSelect = document.getElementById('habitat');
                habitatSelect.innerHTML = '<option value="">Sélectionner un habitat</option>'; 
                if (data.success) {
                    data.data.forEach(habitat => {
                        const option = document.createElement('option');
                        option.value = habitat.habitat_id;
                        option.textContent = habitat.nom;
                        habitatSelect.appendChild(option);
                    });
                } else {
                    alert('Aucun habitat trouvé');
                }
            })
            .catch(error => console.error('Erreur de réseau:', error));
    }

    function populateHabitatFilter() {
        const filterHabitat = document.getElementById('filter-habitat');
        filterHabitat.innerHTML = '<option value="">Tous les habitats</option>';
        fetch('/811/api/animal/habitats')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    data.data.forEach(habitat => {
                        const option = document.createElement('option');
                        option.value = habitat.habitat_id;
                        option.textContent = habitat.nom;
                        filterHabitat.appendChild(option);
                    });
                }
            })
            .catch(error => console.error('Erreur de réseau:', error));
    }

    function filterByHabitat() {
        const selectedHabitat = document.getElementById('filter-habitat').value;
        const animals = document.querySelectorAll('.animal-row');
        animals.forEach(animal => {
            const habitat = animal.getAttribute('data-habitat');
            animal.style.display = selectedHabitat === '' || selectedHabitat === habitat ? '' : 'none';
        });
    }

    // Prévisualiser l'image sélectionnée
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const img = document.getElementById('animal-image');
            img.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function selectAnimal(id) {
        fetch(`/811/api/animal/show/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('animal-name').textContent = data.data.prenom;
                    document.getElementById('animal-state').textContent = data.data.etat;
                    document.getElementById('animal-race').textContent = data.data.race;
                    document.getElementById('animal-habitat').textContent = data.data.habitat_nom;
                    document.getElementById('animal-image').src = data.data.image_animal ? `/811/photos/${data.data.image_animal}` : '/811/photos/logo zoo.png';
                    document.getElementById('animal-details').style.display = 'block';
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Erreur de réseau:', error));
    }
</script>
