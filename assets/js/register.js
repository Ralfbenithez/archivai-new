// Fonction pour vérifier la force du mot de passe
function checkPasswordStrength(password) {
    // Si le mot de passe est vide, réinitialiser tout
    if (!password) {
        // Réinitialiser tous les critères
        document.querySelectorAll('.criteria-item').forEach(item => {
            item.classList.remove('valid');
            item.classList.add('invalid');
        });
        
        // Réinitialiser la barre de force
        const strengthBar = document.getElementById('strength-bar');
        if (strengthBar) {
            strengthBar.style.width = '0%';
            strengthBar.style.backgroundColor = 'var(--error-color)';
        }
        
        // Réinitialiser le label
        const strengthLabel = document.getElementById('strength-label');
        if (strengthLabel) {
            strengthLabel.textContent = 'Faible';
            strengthLabel.style.color = 'var(--error-color)';
        }
        
        return;
    }
    
    // Récupération des données du formulaire
    const nom = document.getElementById('nom')?.value.toLowerCase() || '';
    const prenom = document.getElementById('prenom')?.value.toLowerCase() || '';
    const email = document.getElementById('email')?.value.toLowerCase() || '';
    const emailUsername = email.split('@')[0].toLowerCase();
    
    // Vérification des critères de base
    const constraints = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        number: /\d/.test(password),
        special: /[@$!%*?&=#_-]/.test(password)
    };

    // Log pour déboguer
    console.log("Contraintes vérifiées:", constraints);

    // Mise à jour des indicateurs visuels pour chaque critère
    Object.keys(constraints).forEach(key => {
        const element = document.getElementById(key);
        if (element) {
            if (constraints[key]) {
                element.classList.add('valid');
                element.classList.remove('invalid');
            } else {
                element.classList.add('invalid');
                element.classList.remove('valid');
            }
        } else {
            console.error(`Élément avec ID '${key}' non trouvé`);
        }
    });

    // Calcul du score de base (0-4) basé sur les contraintes satisfaites
    let strength = Object.values(constraints).filter(Boolean).length;
    
    // Pénalités pour les faiblesses supplémentaires
    const lowercasePassword = password.toLowerCase();
    let penalties = 0;
    
    // Pénalité si le mot de passe contient le nom ou prénom
    if (nom && nom.length > 2 && lowercasePassword.includes(nom)) {
        penalties++;
    }
    if (prenom && prenom.length > 2 && lowercasePassword.includes(prenom)) {
        penalties++;
    }
    if (emailUsername && emailUsername.length > 2 && lowercasePassword.includes(emailUsername)) {
        penalties++;
    }
    
    // Pénalité pour les répétitions excessives
    if (password.length >= 4) {
        const repeatedChars = /(.)\1{2,}/g; // 3 caractères identiques ou plus consécutifs
        if (repeatedChars.test(password)) {
            penalties++;
        }
    }

    // Pénalité pour les séquences évidentes
    const sequences = ['123', '234', '345', '456', '567', '678', '789', 'abc', 'bcd', 'cde', 'def', 'efg'];
    for (const seq of sequences) {
        if (lowercasePassword.includes(seq)) {
            penalties++;
            break;
        }
    }
    
    // Ajustement du score final (ne pas descendre en dessous de 0)
    const finalStrength = Math.max(0, strength - Math.min(penalties, strength));
    
    console.log("Force finale:", finalStrength);
    
    // Mise à jour de la barre de force
    const strengthBar = document.getElementById('strength-bar');
    if (strengthBar) {
        // Définir la largeur en fonction de la force
        strengthBar.style.width = `${(finalStrength/4)*100}%`;
        
        // Déterminer la couleur et le message
        let color, message;
        switch(finalStrength) {
            case 0:
            case 1:
                color = '#ef4444'; // Rouge - utiliser valeur directe
                message = 'Faible';
                break;
            case 2:
                color = '#f59e0b'; // Orange - utiliser valeur directe
                message = 'Moyen';
                break;
            case 3:
                color = '#3b82f6'; // Bleu - utiliser valeur directe
                message = 'Normal';
                break;
            case 4:
                color = '#10b981'; // Vert - utiliser valeur directe
                message = 'Robuste';
                break;
        }
        
        console.log("Application de la couleur:", color);
        
        // Appliquer la couleur et le message
        strengthBar.style.backgroundColor = color;
        
        const strengthLabel = document.getElementById('strength-label');
        if (strengthLabel) {
            strengthLabel.textContent = message;
            strengthLabel.style.color = color;
        }
    } else {
        console.error("Élément strength-bar non trouvé");
    }
}

// Fonction pour basculer la visibilité du mot de passe
function togglePasswordVisibility(inputId, buttonId) {
    const input = document.getElementById(inputId);
    const button = document.getElementById(buttonId);
    const icon = button.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Fonction pour vérifier si les mots de passe correspondent
function checkPasswordsMatch() {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const feedback = document.getElementById('confirm-feedback');
    
    if (!password || !confirmPassword || !feedback) {
        console.error("Des éléments nécessaires sont manquants");
        return;
    }
    
    if (confirmPassword.value.length === 0) {
        feedback.textContent = '';
        feedback.className = 'feedback';
        return;
    }
    
    const match = confirmPassword.value === password.value;
    feedback.textContent = match ? 'Les mots de passe correspondent' : 'Les mots de passe ne correspondent pas';
    feedback.className = 'feedback ' + (match ? 'success' : 'error');
}

// Initialisation des événements au chargement de la page
document.addEventListener('DOMContentLoaded', function () {
    const togglePasswordBtn = document.getElementById('toggle-password');
    if (togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', function () {
            togglePasswordVisibility('password', 'toggle-password');
        });
    }

    const toggleConfirmBtn = document.getElementById('toggle-confirm');
    if (toggleConfirmBtn) {
        toggleConfirmBtn.addEventListener('click', function () {
            togglePasswordVisibility('confirm_password', 'toggle-confirm');
        });
    }

    console.log("DOM chargé, initialisation des événements...");
    
    // Test des sélecteurs pour déboguer
    const elements = {
        password: document.getElementById('password'),
        confirmPassword: document.getElementById('confirm_password'),
        togglePassword: document.getElementById('toggle-password'),
        toggleConfirm: document.getElementById('toggle-confirm'),
        strengthBar: document.getElementById('strength-bar'),
        strengthLabel: document.getElementById('strength-label'),
        lengthCriteria: document.getElementById('length'),
        uppercaseCriteria: document.getElementById('uppercase'),
        numberCriteria: document.getElementById('number'),
        specialCriteria: document.getElementById('special')
    };
    
    // Vérifier quels éléments sont trouvés
    Object.entries(elements).forEach(([name, element]) => {
        console.log(`Élément '${name}' ${element ? 'trouvé' : 'NON TROUVÉ'}`);
    });
    
    // Ajout de l'événement sur le champ de mot de passe pour vérifier sa force
    const passwordField = document.getElementById('password');
    if (passwordField) {
        console.log("Ajout de l'événement input sur le champ password");
        passwordField.addEventListener('input', function() {
            console.log("Événement input sur password détecté");
            checkPasswordStrength(this.value);
        });
    }
    
    // Vérification des mots de passe correspondants
    const confirmPasswordField = document.getElementById('confirm_password');
    if (confirmPasswordField) {
        console.log("Ajout de l'événement input sur le champ confirm_password");
        confirmPasswordField.addEventListener('input', checkPasswordsMatch);
    }
    
    // Force l'exécution d'une vérification initiale pour s'assurer que l'interface est cohérente
    if (passwordField && passwordField.value) {
        checkPasswordStrength(passwordField.value);
    }
    
    if (confirmPasswordField && confirmPasswordField.value) {
        checkPasswordsMatch();
    }
});