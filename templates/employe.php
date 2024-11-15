
<div class="hero-scene text-center text-white "></div>
    <div class="hero-scene-content  ">
        <p>Espace employé</p>
    </div>
    </div>
<h2>Enregistrement de la nourriture des animaux</h2>

<form action="/add-nourriture" method="POST">
    <input type="hidden" name="animal_id" value="ID_de_l_animal">
    <label for="date_time">Date et Heure:</label>
    <input type="datetime-local" id="date_time" name="date_time" required>
    
    <label for="type_nourriture">Type de Nourriture:</label>
    <input type="text" id="type_nourriture" name="type_nourriture" required>
    
    <label for="quantite">Quantité:</label>
    <input type="number" id="quantite" name="quantite" required>

    <button type="submit">Enregistrer</button>
</form>

<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <p style="color: green;">La nourriture a été enregistrée avec succès !</p>
<?php endif; ?>
