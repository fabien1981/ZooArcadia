<div class="container mt-5">
    <h1>Ajouter un service</h1>
    <form action="/ZooArcadia/admin/add_service" method="POST">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <div class="input-group">
                <input type="text" class="form-control" id="image" name="image" readonly required>
                <button type="button" class="btn btn-secondary" onclick="openImageSelector()">Choisir une image</button>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
    </form>
</div>

<!-- Modale pour sélectionner une image -->
<div class="modal fade" id="imageSelectorModal" tabindex="-1" aria-labelledby="imageSelectorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageSelectorModalLabel">Choisir une image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                    $imagesDir = $_SERVER['DOCUMENT_ROOT'] . '/ZooArcadia/photos/';
                    $images = array_diff(scandir($imagesDir), ['.', '..']); // Exclut les répertoires '.' et '..'
                    foreach ($images as $image):
                        $imagePath = "/ZooArcadia/photos/" . htmlspecialchars($image);
                    ?>
                        <div class="col-md-3 mb-3 text-center">
                            <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($image) ?>" class="img-fluid img-thumbnail" style="cursor: pointer;" onclick="selectImage('<?= $image ?>')">
                            <p><?= htmlspecialchars($image) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openImageSelector() {
        const modal = new bootstrap.Modal(document.getElementById('imageSelectorModal'));
        modal.show();
    }

    function selectImage(imageName) {
        document.getElementById('image').value = imageName;
        const modal = bootstrap.Modal.getInstance(document.getElementById('imageSelectorModal'));
        modal.hide();
    }
</script>
