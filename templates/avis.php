<div class="container visitor-feedback mt-5">
    <h2>Avis des visiteurs</h2>
    <form id="feedbackForm">
        <div class="mb-3">
            <label for="pseudo" class="form-label">Pseudonyme</label>
            <input type="text" id="pseudo" name="pseudo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="avis" class="form-label">Avis</label>
            <textarea id="avis" name="avis" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="rating" class="form-label">Note (1 à 5 étoiles)</label>
            <select id="rating" name="rating" class="form-select" required>
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
<script>
    document.getElementById('feedbackForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const data = {
            pseudo: document.getElementById('pseudo').value,
            avis: document.getElementById('avis').value,
            rating: document.getElementById('rating').value,
        };

        fetch('/api/avis/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then((response) => response.json())
        .then((result) => {
            if (result.success) {
                alert('Merci pour votre avis !');
                document.getElementById('feedbackForm').reset();
            } else {
                alert(result.message);
            }
        })
        .catch((error) => {
            console.error('Erreur :', error);
        });
    });
</script>

