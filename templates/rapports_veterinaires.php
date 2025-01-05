<div class="container mt-5">
    <h1 class="text-center">Liste des rapports vétérinaires</h1>

    <!-- Barre de recherche -->
    <div class="mb-3">
        <input type="text" id="search-bar" class="form-control" placeholder="Rechercher dans les rapports">
    </div>

    <!-- Bouton pour retourner à l'espace vétérinaire -->
    <div class="mb-3">
        <a href="/ZooArcadia/veterinaire/display" class="btn btn-primary">Retour à l'espace vétérinaire</a>
    </div>

    <!-- Tableau des rapports -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th onclick="sortTable(0)">Date</th>
                    <th onclick="sortTable(1)">Animal</th>
                    <th onclick="sortTable(2)">État</th>
                    <th onclick="sortTable(3)">Nourriture</th>
                    <th onclick="sortTable(4)">Grammage</th>
                    <th>Détail</th>
                </tr>
                <tr>
                    <th><input type="text" id="filter-date" class="form-control" placeholder="Filtrer par date"></th>
                    <th><input type="text" id="filter-animal" class="form-control" placeholder="Filtrer par animal"></th>
                    <th><input type="text" id="filter-etat" class="form-control" placeholder="Filtrer par état"></th>
                    <th><input type="text" id="filter-nourriture" class="form-control" placeholder="Filtrer par nourriture"></th>
                    <th><input type="text" id="filter-grammage" class="form-control" placeholder="Filtrer par grammage"></th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="reports-body">
                <!-- Contenu des rapports -->
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        fetchReports();

        // Ajouter des gestionnaires d'événements pour les filtres
        ['filter-date', 'filter-animal', 'filter-etat', 'filter-nourriture', 'filter-grammage'].forEach(id => {
            document.getElementById(id).addEventListener('input', filterTable);
        });

        document.getElementById('search-bar').addEventListener('input', filterTable);
    });

    function fetchReports() {
    fetch('/ZooArcadia/api/veterinaire/reports')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('reports-body');
            tbody.innerHTML = ''; // Réinitialiser le tableau

            if (data.success) {
                data.data.forEach(report => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${report.date}</td>
                        <td>${report.prenom}</td>
                        <td>${report.etat}</td>
                        <td>${report.nourriture}</td>
                        <td>${report.grammage}</td>
                        <td>${report.detail}</td>
                    `;
                    tbody.appendChild(row);
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="6">Aucun rapport trouvé</td></tr>';
            }
        })
        .catch(error => console.error('Erreur lors du chargement des rapports:', error));
}


    function filterTable() {
        const filters = {
            date: document.getElementById('filter-date').value.toLowerCase(),
            animal: document.getElementById('filter-animal').value.toLowerCase(),
            etat: document.getElementById('filter-etat').value.toLowerCase(),
            nourriture: document.getElementById('filter-nourriture').value.toLowerCase(),
            grammage: document.getElementById('filter-grammage').value.toLowerCase(),
            search: document.getElementById('search-bar').value.toLowerCase()
        };

        const rows = document.querySelectorAll('#reports-body tr');
        rows.forEach(row => {
            const cells = row.getElementsByTagName('td');
            const [date, animal, etat, nourriture, grammage] = [
                cells[0]?.textContent.toLowerCase(),
                cells[1]?.textContent.toLowerCase(),
                cells[2]?.textContent.toLowerCase(),
                cells[3]?.textContent.toLowerCase(),
                cells[4]?.textContent.toLowerCase()
            ];

            const isMatch = Object.values(filters).every(filter =>
                !filter ||
                date.includes(filter) ||
                animal.includes(filter) ||
                etat.includes(filter) ||
                nourriture.includes(filter) ||
                grammage.includes(filter)
            );

            row.style.display = isMatch ? '' : 'none';
        });
    }

    function sortTable(columnIndex) {
        const table = document.querySelector('.table tbody');
        const rows = Array.from(table.rows);

        const isAscending = table.getAttribute('data-sort') === 'asc';
        table.setAttribute('data-sort', isAscending ? 'desc' : 'asc');

        rows.sort((a, b) => {
            const aText = a.cells[columnIndex].textContent.trim();
            const bText = b.cells[columnIndex].textContent.trim();

            return isAscending
                ? aText.localeCompare(bText)
                : bText.localeCompare(aText);
        });

        rows.forEach(row => table.appendChild(row));
    }
</script>
