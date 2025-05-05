// Afficher/masquer le mot de passe
document.getElementById('toggle-password').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const icon = this.querySelector('i');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // Éléments du DOM
    const loginForm = document.querySelector('.auth-form');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const togglePasswordBtn = document.getElementById('toggle-password');
    const rememberMeCheckbox = document.getElementById('remember_me');
    const submitButton = document.querySelector('button[type="submit"]');
    const notificationMessages = document.querySelectorAll('.success-message, .error-message, .info-message, .warning-message');

    // Initialisation
    if (emailInput) {
        // Mettre le focus sur le champ email au chargement si vide
        if (!emailInput.value) {
            emailInput.focus();
        }
    }

    // Gestion des notifications
    if (notificationMessages.length > 0) {
        // Auto-masquer les messages de notification après 7 secondes
        setTimeout(() => {
            notificationMessages.forEach(message => {
                message.style.opacity = '0';
                message.style.transform = 'translateY(-10px)';
                message.style.transition = 'opacity 0.5s ease, transform 0.5s ease';

                // Supprimer complètement après la transition
                setTimeout(() => {
                    message.style.display = 'none';
                }, 500);
            });
        }, 7000);
    }

    // Validation du formulaire avant soumission
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            let isValid = true;

            // Vérifier si l'email est vide
            if (!emailInput.value.trim()) {
                isValid = false;
                showError(emailInput, 'Veuillez entrer votre adresse email.');
            } else if (!validateEmail(emailInput.value.trim())) {
                isValid = false;
                showError(emailInput, 'Veuillez entrer une adresse email valide.');
            } else {
                clearError(emailInput);
            }

            // Vérifier si le mot de passe est vide
            if (!passwordInput.value.trim()) {
                isValid = false;
                showError(passwordInput, 'Veuillez entrer votre mot de passe.');
            } else {
                clearError(passwordInput);
            }

            // Si le formulaire n'est pas valide, empêcher la soumission
            if (!isValid) {
                e.preventDefault();
            }
        });
    }

    // Fonction pour valider l'email
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }

    // Fonction pour afficher une erreur
    function showError(input, message) {
        const formGroup = input.closest('.form-group');
        if (formGroup) {
            let errorElement = formGroup.querySelector('.error-message');
            if (!errorElement) {
                errorElement = document.createElement('div');
                errorElement.className = 'error-message';
                formGroup.appendChild(errorElement);
            }
            errorElement.textContent = message;
            input.classList.add('input-error');
        }
    }

    // Fonction pour effacer une erreur
    function clearError(input) {
        const formGroup = input.closest('.form-group');
        if (formGroup) {
            const errorElement = formGroup.querySelector('.error-message');
            if (errorElement) {
                errorElement.remove();
            }
            input.classList.remove('input-error');
        }
    }
});