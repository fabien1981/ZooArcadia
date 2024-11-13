// Sélectionne les éléments du formulaire
const inputEmail = document.getElementById("EmailInput");
const inputPassword = document.getElementById("PasswordInput");
const btnValidation = document.getElementById("btn-validation-connexion");

// Vérifie que les éléments existent avant d’ajouter des événements
if (inputEmail && inputPassword && btnValidation) {
    // Activation des événements sur les champs pour validation en temps réel
    inputEmail.addEventListener("keyup", validateForm);
    inputPassword.addEventListener("keyup", validateForm);

    // Fonction principale de validation du formulaire
    function validateForm() {
        const emailOk = validateMail(inputEmail);
        const passwordOk = validatePassword(inputPassword);
        btnValidation.disabled = !(emailOk && passwordOk);
    }

    // Fonction pour valider le champ Email
    function validateMail(input) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (input.value.match(emailRegex)) {
            input.classList.add("is-valid");
            input.classList.remove("is-invalid");
            return true;
        } else {
            input.classList.remove("is-valid");
            input.classList.add("is-invalid");
            return false;
        }
    }

    // Fonction pour valider le champ Password
    function validatePassword(input) {
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/;
        if (input.value.match(passwordRegex)) {
            input.classList.add("is-valid");
            input.classList.remove("is-invalid");
            return true;
        } else {
            input.classList.remove("is-valid");
            input.classList.add("is-invalid");
            return false;
        }
    }
} else {
    console.warn("Les éléments du formulaire de connexion sont introuvables sur cette page.");
}
