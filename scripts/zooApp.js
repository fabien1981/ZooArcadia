// Fonction pour afficher la liste des animaux
function fetchAnimals() {
    fetch('/811/api/animal/list')
        .then(response => response.json())
        .then(data => {
            const animalList = document.getElementById('animal-list');
            animalList.innerHTML = '';
            if (data.success) {
                data.data.forEach(animal => {
                    const animalRow = document.createElement('div');
                    animalRow.classList.add('animal-row');
                    animalRow.innerHTML = `
                        <p>${animal.prenom} (${animal.race}) - État: ${animal.etat}</p>
                        <button class="btn btn-secondary" onclick="editAnimal(${animal.id})">Modifier</button>
                        <button class="btn btn-danger" onclick="deleteAnimal(${animal.id})">Supprimer</button>
                    `;
                    animalList.appendChild(animalRow);
                });
            } else {
                animalList.innerText = 'Aucun animal trouvé';
            }
        })
        .catch(error => {
            console.error('Erreur de réseau ou de parsing :', error);
            alert('Erreur de réseau. Veuillez réessayer.');
        });
}

// Fonction pour afficher le formulaire pour ajouter un nouvel animal
function openAnimalForm() {
    document.getElementById('form-title').textContent = 'Ajouter un animal';
    document.getElementById('animal-form').style.display = 'block';
    document.getElementById('animalForm').reset();
    document.getElementById('animalId').value = '';
}

// Fonction pour fermer le formulaire
function closeAnimalForm() {
    document.getElementById('animal-form').style.display = 'none';
}

// Fonction pour afficher le formulaire de modification d'un animal
function editAnimal(id) {
    fetch(`/811/api/animal/show/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('animalId').value = id;
                document.getElementById('prenom').value = data.data.prenom;
                document.getElementById('etat').value = data.data.etat;
                document.getElementById('race').value = data.data.race;
                document.getElementById('image_animal').value = data.data.image_animal;
                document.getElementById('habitat').value = data.data.habitat;
                document.getElementById('animal-form').style.display = 'block';
                document.getElementById('form-title').textContent = 'Modifier un animal';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erreur de réseau:', error);
            alert('Erreur de réseau. Veuillez réessayer.');
        });
}

// Fonction pour supprimer un animal
function deleteAnimal(id) {
    if (confirm('Voulez-vous vraiment supprimer cet animal ?')) {
        fetch(`/811/api/animal/delete/${id}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Animal supprimé');
                    fetchAnimals(); // Rafraîchit la liste des animaux
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Erreur de réseau:', error));
    }
}

// Fonction pour charger les habitats disponibles depuis l'API
function loadHabitats() {
    fetch('/811/api/habitat/list')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Ajouter les options dans la barre de recherche et le formulaire d'ajout/modification
                const habitatSelectForm = document.getElementById('habitatSelectForm');
                const habitatSelectSearch = document.getElementById('habitatSelectSearch');
                
                habitatSelectForm.innerHTML = '';
                habitatSelectSearch.innerHTML = '<option value="">Tous les habitats</option>';

                data.data.forEach(habitat => {
                    const optionForm = document.createElement('option');
                    optionForm.value = habitat.habitat_id;
                    optionForm.textContent = habitat.nom;

                    const optionSearch = optionForm.cloneNode(true);
                    
                    habitatSelectForm.appendChild(optionForm);
                    habitatSelectSearch.appendChild(optionSearch);
                });
            } else {
                console.error('Erreur lors du chargement des habitats :', data.message);
            }
        })
        .catch(error => console.error('Erreur de réseau:', error));
}


// Fonction pour gérer la soumission du formulaire pour ajout/modification
function handleAnimalFormSubmit(event) {
    event.preventDefault();
    const id = document.getElementById('animalId').value;
    const animalData = {
        prenom: document.getElementById('prenom').value,
        etat: document.getElementById('etat').value,
        race: document.getElementById('race').value,
        image_animal: document.getElementById('image_animal').value,
        habitat: document.getElementById('habitat').value
    };

    const url = id ? `/811/api/animal/edit/${id}` : '/811/api/animal/create';
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
            closeAnimalForm();
            fetchAnimals();
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Erreur de réseau:', error));
}
