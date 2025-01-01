<div class="container mt-5">
    <h1 class="text-center">Espace Vétérinaire</h1>

    <!-- Onglets -->
    <ul class="nav nav-tabs" id="veterinaireTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="animaux-tab" data-bs-toggle="tab" data-bs-target="#animaux" type="button" role="tab" aria-controls="animaux" aria-selected="true">Animaux</button>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/ZooArcadia/veterinaire/showReports" class="nav-link" id="rapports-tab">Rapports vétérinaires</a>
    </li>
</ul>


    <div class="tab-content mt-4">
        <!-- Tab Animaux -->
        <div class="tab-pane fade show active" id="animaux" role="tabpanel" aria-labelledby="animaux-tab">
            <!-- Barre de recherche -->
            <input type="text" id="barre-recherche" class="form-control mb-4" placeholder="Rechercher par nom, race ou habitat..." onkeyup="filtrerAnimaux()">

            <!-- Liste des animaux -->
            <div id="liste-animaux" class="row">
                <p id="loading" class="text-center">Chargement des animaux...</p>
            </div>
        </div>

        <!-- Tab Rapports -->
        <div class="tab-pane fade" id="rapports" role="tabpanel" aria-labelledby="rapports-tab">
            <div id="liste-rapports" class="row">
                <p id="loading-rapports" class="text-center">Chargement des rapports...</p>
            </div>
            <div id="rapport-details" class="card mt-4" style="display: none;">
                <div class="card-body">
                    <h4 id="rapport-titre"></h4>
                    <p><strong>Date :</strong> <span id="rapport-date"></span></p>
                    <p><strong>État :</strong> <span id="rapport-etat"></span></p>
                    <p><strong>Nourriture :</strong> <span id="rapport-nourriture"></span></p>
                    <p><strong>Grammage :</strong> <span id="rapport-grammage"></span></p>
                    <p><strong>Détails :</strong> <span id="rapport-detail"></span></p>
                    <button class="btn btn-secondary" onclick="fermerRapportDetails()">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        chargerListeAnimaux();
        chargerListeRapports();
    });

    // Charger la liste des animaux
    function chargerListeAnimaux() {
        fetch('/ZooArcadia/api/animal/list')
            .then(response => response.json())
            .then(data => {
                const listeAnimaux = document.getElementById('liste-animaux');
                listeAnimaux.innerHTML = '';

                if (data.success) {
                    data.data.forEach(animal => {
                        const card = document.createElement('div');
                        card.classList.add('col-md-4', 'mb-4');
                        card.innerHTML = `
                            <div class="card veterinaire_card">
                                <div class="card-body">
                                    <h5 class="card-title">${animal.prenom}</h5>
                                    <p class="card-text">
                                        <strong>Race:</strong> ${animal.race}<br>
                                        <strong>Habitat:</strong> ${animal.habitat_nom}<br>
                                        <strong>État:</strong> ${animal.etat}
                                    </p>
                                    <a href="/ZooArcadia/veterinaire/createReport?animal_id=${animal.animal_id}" class="btn btn-primary">Créer un rapport</a>
                                </div>
                            </div>
                        `;
                        card.setAttribute('data-nom', animal.prenom.toLowerCase());
                        card.setAttribute('data-race', animal.race.toLowerCase());
                        card.setAttribute('data-habitat', animal.habitat_nom.toLowerCase());
                        listeAnimaux.appendChild(card);
                    });
                } else {
                    listeAnimaux.innerHTML = '<p class="text-center">Aucun animal trouvé.</p>';
                }
            })
            .catch(error => console.error('Erreur lors du chargement des animaux:', error));
    }

    // Charger la liste des rapports
    function chargerListeRapports() {
        fetch('/ZooArcadia/api/veterinaire/reports')
            .then(response => response.json())
            .then(data => {
                const listeRapports = document.getElementById('liste-rapports');
                listeRapports.innerHTML = '';

                if (data.success) {
                    data.data.forEach(rapport => {
                        const card = document.createElement('div');
                        card.classList.add('col-md-6', 'mb-4');
                        card.innerHTML = `
                            <div class="card veterinaire_card" style="cursor: pointer;" onclick="afficherRapportDetails(${rapport.rapport_veterinaire_id})">
                                <div class="card-body">
                                    <h5 class="card-title">Rapport pour ${rapport.prenom}</h5>
                                    <p><strong>Date :</strong> ${rapport.date}</p>
                                    <p><strong>État :</strong> ${rapport.etat}</p>
                                </div>
                            </div>
                        `;
                        listeRapports.appendChild(card);
                    });
                } else {
                    listeRapports.innerHTML = '<p class="text-center">Aucun rapport trouvé.</p>';
                }
            })
            .catch(error => console.error('Erreur lors du chargement des rapports:', error));
    }

    // Afficher les détails d'un rapport
    function afficherRapportDetails(id) {
        fetch(`/ZooArcadia/api/veterinaire/showReport/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const rapport = data.data;
                    document.getElementById('rapport-titre').textContent = `Rapport pour ${rapport.prenom}`;
                    document.getElementById('rapport-date').textContent = rapport.date;
                    document.getElementById('rapport-etat').textContent = rapport.etat;
                    document.getElementById('rapport-nourriture').textContent = rapport.nourriture;
                    document.getElementById('rapport-grammage').textContent = rapport.grammage;
                    document.getElementById('rapport-detail').textContent = rapport.detail;

                    document.getElementById('rapport-details').style.display = 'block';
                } else {
                    alert('Erreur lors du chargement du rapport.');
                }
            })
            .catch(error => console.error('Erreur lors du chargement des détails du rapport:', error));
    }

    // Fermer les détails du rapport
    function fermerRapportDetails() {
        document.getElementById('rapport-details').style.display = 'none';
    }

    // Barre de recherche pour filtrer les animaux
    function filtrerAnimaux() {
        const recherche = document.getElementById('barre-recherche').value.toLowerCase();
        const animaux = document.querySelectorAll('#liste-animaux .col-md-4');

        animaux.forEach(animal => {
            const nom = animal.getAttribute('data-nom') || '';
            const race = animal.getAttribute('data-race') || '';
            const habitat = animal.getAttribute('data-habitat') || '';

            if (nom.includes(recherche) || race.includes(recherche) || habitat.includes(recherche)) {
                animal.style.display = '';
            } else {
                animal.style.display = 'none';
            }
        });
    }
</script>
