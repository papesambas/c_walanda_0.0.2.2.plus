
// Gestion du rechargement de la page
function handlePageReload() {
    console.log('Gestion du rechargement de la page année scolaire');

    const urlParams = new URLSearchParams(window.location.search);
    const shouldReload = urlParams.get('reload') === 'true';

    if (shouldReload) {
        console.log('Page new d\'année');
        sessionStorage.removeItem('pageReloaded'); // Nettoyer l'indicateur
        window.history.replaceState({}, document.title, window.location.pathname); // Nettoyer l'URL
        location.reload(); // Recharger la page
    } else {
        initializePage(); // Initialiser la page sans rechargement
    }
}

// Initialisation de la page après rechargement
function initializePage() {
    //console.log('Script chargé');

    const creerAnneePrecedenteBtn = document.getElementById('creerAnneePrecedente');
    const anneeDebutInput = document.getElementById('annee_scolaires_anneedebut');
    const anneeFinInput = document.getElementById('annee_scolaires_anneeFin');

    if (creerAnneePrecedenteBtn && anneeDebutInput && anneeFinInput) {
        //console.log('Éléments trouvés');
        initializeYearFields(anneeDebutInput, anneeFinInput);
        setupYearButton(creerAnneePrecedenteBtn, anneeDebutInput, anneeFinInput);
    } else {
        console.log('Éléments non trouvés : cette page ne nécessite pas leur initialisation.');
    }
}

// Remplissage automatique des champs d'année
function initializeYearFields(anneeDebutInput, anneeFinInput) {
    const currentYear = new Date().getFullYear();
    const currentMonth = new Date().getMonth() + 1;
    const defaultAnneeDebut = currentMonth >= 8 ? currentYear : currentYear - 1;
    const defaultAnneeFin = defaultAnneeDebut + 1;

    if (!anneeDebutInput.value) anneeDebutInput.value = defaultAnneeDebut;
    if (!anneeFinInput.value) anneeFinInput.value = defaultAnneeFin;

    anneeDebutInput.addEventListener('input', () => {
        const anneeDebut = parseInt(anneeDebutInput.value);
        if (!isNaN(anneeDebut)) anneeFinInput.value = anneeDebut + 1;
    });
}

// Gestion du bouton "Créer année précédente"
function setupYearButton(button, anneeDebutInput, anneeFinInput) {
    button.addEventListener('click', () => {
        //console.log('Bouton cliqué');
        anneeDebutInput.removeAttribute('readonly');
        const nouvelleAnneeDebut = parseInt(anneeDebutInput.value) - 1;
        anneeDebutInput.value = nouvelleAnneeDebut;
        anneeFinInput.value = nouvelleAnneeDebut + 1;
    });
}

// Gestion du bouton "Créer nouveau"
function setupNewButton() {
    const creerNewBtn = document.querySelector('#creerNlleAnnee');
    if (creerNewBtn) {
        creerNewBtn.addEventListener('click', (event) => {
            event.preventDefault(); // Empêcher la redirection immédiate
            sessionStorage.setItem('pageReloaded', 'true');

            let url = new URL(creerNewBtn.href, window.location.origin);
            url.searchParams.set('reload', 'true'); // Ajoute `reload=true` sans doublon

            window.location.href = url.toString(); // Redirige proprement
        });
    } else {
        console.log('Bouton "Créer nouveau" non trouvé.');
    }
}

// Démarrage
handlePageReload();
setupNewButton();

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form[name="annee_scolaires"]'); // Sélection du formulaire
    
    if (!form) return; // Vérifie si le formulaire existe

    // Détection de l'appui sur Entrée
    form.addEventListener('keydown', function (event) {
        if (event.key === 'Enter' && !event.shiftKey) { // Vérifie que shift+Enter ne pose pas problème
            event.preventDefault(); 
    
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.click(); // Simule le clic seulement si le bouton existe
            } else {
                console.warn('Aucun bouton de soumission trouvé.');
            }
        }
    });

    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Empêcher l'envoi classique

        let formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Indique qu'il s'agit d'une requête AJAX
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Rediriger si tout s'est bien passé
                window.location.href = '/annee/scolaires';
            } else {
                // Afficher les erreurs
                displayFormErrors(data.errors);
            }
        })
        .catch(error => console.error('Erreur lors de la requête AJAX', error));
    });
});

/**
 * Fonction pour afficher les erreurs du formulaire
 */
function displayFormErrors(errors) {
    document.querySelectorAll('.text-danger').forEach(el => el.remove()); // Supprimer les erreurs précédentes

    for (let field in errors) {
        let input = document.querySelector(`#annee_scolaires_${field}`);
        if (input) {
            let errorDiv = document.createElement('div');
            errorDiv.classList.add('text-danger');
            errorDiv.innerHTML = errors[field].join('<br>'); // Afficher tous les messages d'erreur
            input.parentNode.appendChild(errorDiv);
        }
    }
}
