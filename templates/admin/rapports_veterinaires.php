<div class="container mt-5">
    <h1 class="text-center">Liste des rapports vétérinaires</h1>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>Date</th>
                    <th>Animal</th>
                    <th>État</th>
                    <th>Nourriture</th>
                    <th>Grammage</th>
                    <th>Détail</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['reports'])): ?>
                    <?php foreach ($data['reports'] as $report): ?>
                        <tr>
                            <td><?= htmlspecialchars($report['date']) ?></td>
                            <td><?= htmlspecialchars($report['prenom']) ?></td>
                            <td><?= htmlspecialchars($report['etat']) ?></td>
                            <td><?= htmlspecialchars($report['nourriture']) ?></td>
                            <td><?= htmlspecialchars($report['grammage']) ?></td>
                            <td><?= htmlspecialchars($report['detail']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Aucun rapport vétérinaire trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="admin/display" class="btn btn-primary mt-3">Retour au tableau de bord</a>
</div>
