<div class="container visitor-feedback mt-5">
        <h2>Avis des visiteurs</h2>
        <form id="feedbackForm">
            <div class="mb-3">
                <label for="pseudo" class="form-label">Pseudonyme</label>
                <input type="text" id="pseudo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="avis" class="form-label">Avis</label>
                <textarea id="avis" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Note (1 à 5 étoiles)</label>
                <select id="rating" class="form-select" required>
                    <option value="1">1 étoile</option>
                    <option value="2">2 étoiles</option>
                    <option value="3">3 étoiles</option>
                    <option value="4">4 étoiles</option>
                    <option value="5">5 étoiles</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
</div>