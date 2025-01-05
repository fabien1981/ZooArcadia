<div class="container mt-5">
    <h2>Laisser un avis</h2>
    <form method="POST" action="/ZooArcadia/api/avis/create">
        <div class="mb-3">
            <label for="pseudo" class="form-label">Pseudo</label>
            <input type="text" class="form-control" id="pseudo" name="pseudo" required>
        </div>
        <div class="mb-3">
            <label for="avis" class="form-label">Votre avis</label>
            <textarea class="form-control" id="avis" name="avis" required></textarea>
        </div>
        <div class="mb-3">
            <label for="rating" class="form-label">Note (1 à 5)</label>
            <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>