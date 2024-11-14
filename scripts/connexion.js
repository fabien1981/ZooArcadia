// Sélection des éléments du formulaire
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
            setValidationState(input, true, "Email valide");
            return true;
        } else {
            setValidationState(input, false, "Veuillez entrer un email valide.");
            return false;
        }
    }

    // Fonction pour valider le champ Password
    function validatePassword(input) {
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/;
        if (input.value.match(passwordRegex)) {
            setValidationState(input, true, "Mot de passe valide");
            return true;
        } else {
            setValidationState(input, false, "Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial.");
            return false;
        }
    }

    // Fonction pour définir l'état de validation et afficher les messages d'aide
    function setValidationState(input, isValid, message) {
        const feedback = input.nextElementSibling || document.createElement("div");
        feedback.className = isValid ? "valid-feedback" : "invalid-feedback";
        feedback.innerText = message;
        input.classList.toggle("is-valid", isValid);
        input.classList.toggle("is-invalid", !isValid);
        if (!input.nextElementSibling) input.after(feedback); // Ajoute le feedback si inexistant
    }
}
