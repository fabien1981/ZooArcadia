<div class="container mt-5">
    <h1>Gestion des services</h1>
    <a href="/ZooArcadia/admin/add_service" class="btn btn-success">Ajouter un service</a>
 


    <?php if (!empty($services)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                   
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $service): ?>
                    <tr>
                     
                        <td><?= htmlspecialchars($service['nom']) ?></td>
                        <td><?= htmlspecialchars($service['description']) ?></td>
                        <td>
                            <a href="/ZooArcadia/admin/edit_service/<?= htmlspecialchars($service['service_id']) ?>" class="btn btn-warning">Modifier</a>
                            <a href="/ZooArcadia/admin/delete_service/<?= htmlspecialchars($service['service_id']) ?>" class="btn btn-danger" onclick="return confirm('Confirmer la suppression ?');">Supprimer</a>
                        </td>
                    </tr>
                    
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun service trouvé.</p>
    <?php endif; ?>
    <div>
    <a href="/ZooArcadia/admin/display" class="btn btn-primary" style="margin-bottom: 15px;">⬅ Retour au tableau de bord</a>
</div>
</div>

