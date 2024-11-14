<div class="container">
    <h1>Gestion des horaires d'ouverture</h1>
    <button class="btn btn-primary mb-3" onclick="ouvrirFormulaireHoraire()">Ajouter un horaire</button>
    <a href="/ZooArcadia/admin/display" class="btn btn-secondary mb-3">Retour à l'admin</a>

    <div id="liste-horaires" class="mb-3"></div>

    <div id="formulaire-horaire" class="card p-3" style="display: none;">
        <h2 id="titre-formulaire">Ajouter/Modifier un horaire</h2>
        <form id="formulaireHoraire" onsubmit="soumettreFormulaireHoraire(event)">
            <input type="hidden" id="horaireId">
            <div class="mb-3">
                <label for="periode" class="form-label">Période</label>
                <input type="text" id="periode" class="form-control" placeholder="ex : 01/11/2024 – 19/01/2025" required>
            </div>
            <div class="mb-3">
                <label for="fermeture_caisses" class="form-label">Fermeture des caisses</label>
                <input type="text" id="fermeture_caisses" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="fermeture_parc_pied" class="form-label">Fermeture du parc à pied</label>
                <input type="text" id="fermeture_parc_pied" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Enregistrer</button>
            <button type="button" class="btn btn-secondary" onclick="fermerFormulaireHoraire()">Annuler</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        chargerListeHoraires();
    });

    function ouvrirFormulaireHoraire() {
        document.getElementById('formulaire-horaire').style.display = 'block';
        document.getElementById('titre-formulaire').textContent = 'Ajouter un horaire';
        document.getElementById('formulaireHoraire').reset();
        document.getElementById('horaireId').value = '';
    }

    function chargerListeHoraires() {
        fetch('/ZooArcadia/api/hours/list')
            .then(response => response.json())
            .then(data => {
                const listeHoraires = document.getElementById('liste-horaires');
                listeHoraires.innerHTML = '';
                if (data.success) {
                    data.data.forEach(horaire => {
                        const horaireDiv = document.createElement('div');
                        horaireDiv.classList.add('horaire-item', 'mb-3', 'p-2', 'border', 'rounded');
                        horaireDiv.innerHTML = `
                            <p>${horaire.period} - Caisses: ${horaire.closing_cashier}, Parc à pied: ${horaire.closing_foot_park}</p>
                            <button class="btn btn-secondary me-2" onclick="modifierHoraire(${horaire.id})">Modifier</button>
                            <button class="btn btn-danger" onclick="supprimerHoraire(${horaire.id})">Supprimer</button>
                        `;
                        listeHoraires.appendChild(horaireDiv);
                    });
                } else {
                    listeHoraires.textContent = 'Aucun horaire trouvé';
                }
            })
            .catch(error => console.error('Erreur de réseau:', error));
    }

    function soumettreFormulaireHoraire(event) {
        event.preventDefault();
        const id = document.getElementById('horaireId').value;
        const url = id ? `/ZooArcadia/api/hours/edit/${id}` : '/ZooArcadia/api/hours/create';
        const methode = id ? 'PUT' : 'POST';
        const formData = {
            period: document.getElementById('periode').value,
            closing_cashier: document.getElementById('fermeture_caisses').value,
            closing_foot_park: document.getElementById('fermeture_parc_pied').value
        };

        fetch(url, {
            method: methode,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Horaire enregistré avec succès');
                chargerListeHoraires();
                fermerFormulaireHoraire();
            } else {
                alert('Erreur lors de l\'enregistrement de l\'horaire');
            }
        })
        .catch(error => console.error('Erreur de réseau:', error));
    }

    function modifierHoraire(id) {
        fetch(`/ZooArcadia/api/hours/show/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('horaireId').value = id;
                    document.getElementById('periode').value = data.data.period;
                    document.getElementById('fermeture_caisses').value = data.data.closing_cashier;
                    document.getElementById('fermeture_parc_pied').value = data.data.closing_foot_park;
                    document.getElementById('titre-formulaire').textContent = 'Modifier un horaire';
                    document.getElementById('formulaire-horaire').style.display = 'block';
                } else {
                    alert('Erreur lors du chargement de l\'horaire');
                }
            })
            .catch(error => console.error('Erreur de réseau:', error));
    }

    function supprimerHoraire(id) {
        if (confirm('Voulez-vous vraiment supprimer cet horaire ?')) {
            fetch(`/ZooArcadia/api/hours/delete/${id}`, { method: 'DELETE' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Horaire supprimé');
                        chargerListeHoraires();
                    } else {
                        alert('Erreur lors de la suppression de l\'horaire');
                    }
                })
                .catch(error => console.error('Erreur de réseau:', error));
        }
    }

    function fermerFormulaireHoraire() {
        document.getElementById('formulaire-horaire').style.display = 'none';
    }
</script>
