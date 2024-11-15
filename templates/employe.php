<div class="container">
    <h2 class="text-center mt-5">Liste des Animaux</h2>
    <div id="animal-list" class="row">
        <!-- La liste des animaux sera injectée ici par `ZooApp.js` -->
    </div>
    <div class="mt-4 text-center">
        <!-- Onglet général "Historique" -->
        <a href="/ZooArcadia/historique_nourriture" class="btn btn-secondary">Historique des repas</a>
    </div>
</div>

<!-- Inclure le script -->
<script src="/ZooArcadia/scripts/ZooApp.js"></script>
<script>
    // Ajouter les boutons "Nourrir" pour chaque animal
    function fetchAnimalsWithNourrir() {
        fetch('/ZooArcadia/api/animal/list')
            .then(response => response.json())
            .then(data => {
                const animalList = document.getElementById('animal-list');
                animalList.innerHTML = '';
                if (data.success) {
                    data.data.forEach(animal => {
                        const animalCard = document.createElement('div');
                        animalCard.classList.add('col-md-4', 'mb-4');

                        animalCard.innerHTML = `
                            <div class="card">
                                <img src="/ZooArcadia/photos/${animal.image_animal}" class="card-img-top" alt="${animal.prenom}">
                                <div class="card-body">
                                    <h5 class="card-title">${animal.prenom}</h5>
                                    <p class="card-text">Race : ${animal.race}</p>
                                    <p class="card-text">Habitat : ${animal.habitat_nom}</p>
                                    <a href="/ZooArcadia/nourrir?animal_id=${animal.animal_id}" class="btn btn-primary">Nourrir</a>
                                </div>
                            </div>
                        `;
                        animalList.appendChild(animalCard);
                    });
                } else {
                    animalList.innerHTML = '<p>Aucun animal trouvé.</p>';
                }
            })
            .catch(error => console.error('Erreur de réseau ou de parsing :', error));
    }

    // Charger les animaux avec les boutons "Nourrir"
    document.addEventListener('DOMContentLoaded', fetchAnimalsWithNourrir);
</script>
