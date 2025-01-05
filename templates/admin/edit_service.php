<div class="container mt-5">
    <h1>Modifier un service</h1>
    <form action="/admin/edit_service/<?= htmlspecialchars($service['service_id']) ?>" method="POST">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($service['nom']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($service['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image actuelle</label>
            <p>
                <img 
                    src="/photos/<?= htmlspecialchars($service['image'] ?? 'default.jpg') ?>" 
                    alt="Image actuelle" 
                    style="height: 150px; object-fit: cover;">
            </p>
            <label for="image" class="form-label">Changer l'image</label>
            <select class="form-control" id="image" name="image">
                <?php foreach ($photos as $photo): ?>
                    <option value="<?= htmlspecialchars($photo) ?>" 
                        <?= ($service['image'] === $photo) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($photo) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-warning">Modifier</button>
    </form>
</div>
