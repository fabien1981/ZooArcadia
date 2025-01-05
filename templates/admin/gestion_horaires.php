<div class="container">
    <h1>Gestion des horaires d'ouverture</h1>
    <button class="btn btn-primary mb-3" onclick="ouvrirFormulaireHoraire()">Ajouter un horaire</button>
    <a href="/admin/display" class="btn btn-secondary mb-3">Retour à l'admin</a>

    <!-- Liste des horaires -->
    <div id="liste-horaires" class="mb-3"></div>

    <!-- Formulaire pour ajouter/modifier un horaire -->
    <div id="formulaire-horaire" class="card p-3" style="display: none;">
        <h2 id="titre-formulaire">Ajouter/Modifier un horaire</h2>
        <form id="formulaireHoraire" onsubmit="soumettreFormulaireHoraire(event)">
            <input type="hidden" id="horaireId">
            <div class="mb-3">
                <label for="periode" class="form-label">Période</label>
                <input type="text" id="periode" class="form-control" placeholder="Ex : 01/11/2024 – 19/01/2025" required>
            </div>
            <div class="mb-3">
                <label for="fermeture_caisses" class="form-label">Fermeture des caisses</label>
                <input type="time" id="fermeture_caisses" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="fermeture_parc_pied" class="form-label">Fermeture du parc à pied</label>
                <input type="time" id="fermeture_parc_pied" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Enregistrer</button>
            <button type="button" class="btn btn-secondary" onclick="fermerFormulaireHoraire()">Annuler</button>
        </form>
    </div>
</div>

<script>
    // Charger la liste des horaires au chargement de la page
    document.addEventListener('DOMContentLoaded', () => {
        chargerListeHoraires();
    });

    /**
     * Fonction pour ouvrir le formulaire pour ajouter un horaire
     */
    function ouvrirFormulaireHoraire() {
        document.getElementById('formulaire-horaire').style.display = 'block';
        document.getElementById('titre-formulaire').textContent = 'Ajouter un horaire';
        document.getElementById('formulaireHoraire').reset();
        document.getElementById('horaireId').value = '';
    }

    /**
     * Charger la liste des horaires depuis l'API
     */
    function chargerListeHoraires() {
        fetch('/api/hours/list')
            .then(response => response.json())
            .then(data => {
                const listeHoraires = document.getElementById('liste-horaires');
                listeHoraires.innerHTML = '';
                if (data.success) {
                    if (data.data.length === 0) {
                        listeHoraires.textContent = 'Aucun horaire trouvé.';
                        return;
                    }
                    data.data.forEach(horaire => {
                        const horaireDiv = document.createElement('div');
                        horaireDiv.classList.add('horaire-item', 'mb-3', 'p-2', 'border', 'rounded');
                        horaireDiv.innerHTML = `
                            <p><strong>Période :</strong> ${horaire.periode} <br>
                            <strong>Fermeture caisses :</strong> ${horaire.fermeture_caisses} <br>
                            <strong>Fermeture parc à pied :</strong> ${horaire.fermeture_parc_pied}</p>
                            <button class="btn btn-secondary me-2" onclick="modifierHoraire(${horaire.id})">Modifier</button>
                            <button class="btn btn-danger" onclick="supprimerHoraire(${horaire.id})">Supprimer</button>
                        `;
                        listeHoraires.appendChild(horaireDiv);
                    });
                } else {
                    listeHoraires.textContent = 'Erreur lors de la récupération des horaires.';
                }
            })
            .catch(error => console.error('Erreur réseau :', error));
    }

    /**
     * Soumettre le formulaire pour ajouter ou modifier un horaire
     */
    function soumettreFormulaireHoraire(event) {
        event.preventDefault();
        const id = document.getElementById('horaireId').value;
        const url = id ? `/api/hours/edit/${id}` : '/api/hours/create';
        const methode = id ? 'PUT' : 'POST';

        const formData = {
            periode: document.getElementById('periode').value,
            fermeture_caisses: document.getElementById('fermeture_caisses').value,
            fermeture_parc_pied: document.getElementById('fermeture_parc_pied').value
        };

        fetch(url, {
            method: methode,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(id ? 'Horaire modifié avec succès' : 'Horaire ajouté avec succès');
                chargerListeHoraires();
                fermerFormulaireHoraire();
            } else {
                alert(data.message || 'Erreur lors de l\'enregistrement de l\'horaire.');
            }
        })
        .catch(error => console.error('Erreur réseau :', error));
    }

    /**
     * Modifier un horaire existant
     */
    function modifierHoraire(id) {
    fetch(`/api/hours/show/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erreur HTTP : ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('horaireId').value = id;
                document.getElementById('periode').value = data.data.periode;
                document.getElementById('fermeture_caisses').value = data.data.fermeture_caisses;
                document.getElementById('fermeture_parc_pied').value = data.data.fermeture_parc_pied;
                document.getElementById('titre-formulaire').textContent = 'Modifier un horaire';
                document.getElementById('formulaire-horaire').style.display = 'block';
            } else {
                alert(data.message || 'Erreur lors du chargement de l\'horaire.');
            }
        })
        .catch(error => console.error('Erreur réseau ou API :', error));
}


    /**
     * Supprimer un horaire existant
     */
    function supprimerHoraire(id) {
        if (confirm('Voulez-vous vraiment supprimer cet horaire ?')) {
            fetch(`/api/hours/delete/${id}`, { method: 'DELETE' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Horaire supprimé avec succès.');
                        chargerListeHoraires();
                    } else {
                        alert(data.message || 'Erreur lors de la suppression de l\'horaire.');
                    }
                })
                .catch(error => console.error('Erreur réseau :', error));
        }
    }

    /**
     * Fermer le formulaire
     */
    function fermerFormulaireHoraire() {
        document.getElementById('formulaire-horaire').style.display = 'none';
    }
</script>
