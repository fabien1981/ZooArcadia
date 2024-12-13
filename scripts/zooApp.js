// Fonction pour afficher la liste des animaux
function fetchAnimals() {
    fetch('/api/animal/list')
        .then(response => response.json())
        .then(data => {
            const animalList = document.getElementById('animal-list');
            if (!animalList) {
                console.error("L'élément avec l'ID 'animal-list' est introuvable.");
                return;
            }
            animalList.innerHTML = ''; // Réinitialise la liste avant de l'afficher

            if (data.success) {
                data.data.forEach(animal => {
                    const animalRow = document.createElement('div');
                    animalRow.classList.add('animal-row', 'mb-3', 'p-2', 'border', 'rounded');
                    animalRow.innerHTML = `
                        <p>${animal.prenom} (${animal.race}) - État: ${animal.etat} - Habitat: ${animal.habitat_nom}</p>
                        <button 
                            class="btn btn-info me-2" 
                            onclick="incrementAnimalConsultation(${animal.animal_id}, '${animal.prenom}', '${animal.habitat_nom}'); window.location.href='/animals/details/${animal.animal_id}'">
                            Voir Détails
                        </button>
                        <button class="btn btn-secondary me-2" onclick="editAnimal(${animal.animal_id})">Modifier</button>
                        <button class="btn btn-danger" onclick="deleteAnimal(${animal.animal_id})">Supprimer</button>
                    `;
                    animalList.appendChild(animalRow); // Ajoute l'élément à la liste
                });
            } else {
                animalList.innerText = 'Aucun animal trouvé';
            }
        })
        .catch(error => console.error('Erreur de réseau ou de parsing :', error));
}


// Fonction pour ouvrir le formulaire d'ajout d'un nouvel animal
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
    fetch(`/api/animal/show/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('animalId').value = id;
                document.getElementById('prenom').value = data.data.prenom;
                document.getElementById('etat').value = data.data.etat;
                document.getElementById('race').value = data.data.race;
                document.getElementById('habitat').value = data.data.habitat;
                document.getElementById('animal-form').style.display = 'block';
                document.getElementById('form-title').textContent = 'Modifier un animal';
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Erreur de réseau:', error));
}

// Fonction pour supprimer un animal
function deleteAnimal(id) {
    if (confirm('Voulez-vous vraiment supprimer cet animal ?')) {
        fetch(`/api/animal/delete/${id}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchAnimals(); // Rafraîchit la liste des animaux
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Erreur de réseau:', error));
    }
}

function chargerAnimauxParHabitat(habitatId) {
    const url = habitatId ? `/api/animal/habitat/${habitatId}` : '/api/animal/list';

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const listeAnimaux = document.getElementById('liste-animaux');
            listeAnimaux.innerHTML = ''; // Réinitialise la liste

            if (data.success) {
                data.data.forEach(animal => {
                    // Crée une ligne pour chaque animal
                    const ligneAnimal = document.createElement('div');
                    ligneAnimal.classList.add('animal-row', 'mb-3', 'p-2', 'border', 'rounded');
                    ligneAnimal.innerHTML = `
                        <p>${animal.prenom} (${animal.race}) - État: ${animal.etat}</p>
                        <button class="btn btn-info me-2" onclick="selectionnerAnimal(${animal.animal_id})">Sélectionner</button>
                        <button class="btn btn-secondary me-2" onclick="modifierAnimal(${animal.animal_id})">Modifier</button>
                        <button class="btn btn-danger" onclick="supprimerAnimal(${animal.animal_id})">Supprimer</button>
                    `;
                    listeAnimaux.appendChild(ligneAnimal);
                });
            } else {
                listeAnimaux.innerHTML = '<p>Aucun animal trouvé pour cet habitat.</p>';
            }
        })
        .catch(error => console.error('Erreur de réseau:', error));
}

// Fonction pour charger les habitats disponibles depuis l'API
function loadHabitats() {
    fetch('/ZooArcadia/api/animal/habitats')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const habitatSelect = document.getElementById('habitat');
                
                habitatSelect.innerHTML = '<option value="">Sélectionnez un habitat</option>';
                data.data.forEach(habitat => {
                    const option = document.createElement('option');
                    option.value = habitat.habitat_id;
                    option.textContent = habitat.nom;
                    habitatSelect.appendChild(option);
                });
            } else {
                console.error('Erreur lors du chargement des habitats :', data.message);
            }
        })
        .catch(error => console.error('Erreur de réseau:', error));
}

// Chargement des habitats et des animaux lors du chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    loadHabitats();
    fetchAnimals();
});

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

    const url = id ? `/api/animal/edit/${id}` : '/api/animal/create';
    const method = id ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(animalData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeAnimalForm();
            fetchAnimals();
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Erreur de réseau:', error));
}

// Associer le formulaire au gestionnaire de soumission
document.getElementById('animalForm').addEventListener('submit', handleAnimalFormSubmit);

// Fonction pour incrémenter les consultations d'un animal
function incrementAnimalConsultation(animalId, animalName, habitatName) {
    fetch('/ZooArcadia/api/consultation/increment', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ animal_id: animalId, animal_name: animalName, habitat_name: habitatName }),
    })
        .then(response => response.json())
        .then(data => {
            //onsole.log('Réponse API:', data); // Log de la réponse
            if (!data.success) {
                alert('Erreur lors de l\'incrémentation: ' + data.message);
            }
        })
        .catch(error => console.error('Erreur réseau ou serveur :', error));
}


function incrementAnimalClicks(animalId, animalName, habitatName) {
    if (!animalId || !animalName || !habitatName) {
        console.error("Paramètres manquants pour incrementAnimalClicks");
        return;
    }

    fetch('/ZooArcadia/api/consultation/increment', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            animal_id: animalId,
            animal_name: animalName,
            habitat_name: habitatName,
        }),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau ou serveur');
            }
            return response.json();
        })
        .then(data => {
            if (!data.success) {
                console.error('Erreur API:', data.message);
            } else {
                console.log('Clics enregistrés avec succès:', data);
            }
        })
        .catch(error => {
            console.error('Erreur réseau ou serveur :', error);
        });
}

function chargerAnimaux() {
    fetch('/ZooArcadia/api/animal/list')
        .then(response => response.json())
        .then(data => {
            const listeAnimaux = document.getElementById('liste-animaux');
            if (!listeAnimaux) {
                console.error("L'élément avec l'ID 'liste-animaux' est introuvable.");
                return;
            }
            listeAnimaux.innerHTML = '';
            if (data.success) {
                data.data.forEach(animal => {
                    const ligneAnimal = document.createElement('div');
                    ligneAnimal.classList.add('animal-row', 'mb-3', 'p-2', 'border', 'rounded');
                    ligneAnimal.innerHTML = `
                        <p>${animal.prenom} (${animal.race}) - État: ${animal.etat}</p>
                        <button 
                            class="btn btn-info me-2" 
                             onclick="incrementAnimalConsultation(${animal.animal_id}, '${animal.prenom}', '${animal.habitat_nom}'); window.location.href='/ZooArcadia/animals/details/${animal.animal_id}'">
                             Voir Détails
                        </button>

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



