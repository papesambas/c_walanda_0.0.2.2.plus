$(document).ready(function () {
    // Fonction pour gérer la case "Handicap" et le champ associé
    function isHandicapFunction() {
        let inputField = $('#eleves_natureHandicape');
        let checkbox = $('#eleves_isHandicap');
        let message = $('#eleves_natureHandicape');

        // Vérifier si les éléments existent
        if (checkbox.length && message.length) {
            checkbox.on('change', function () {
                if (checkbox.prop('checked')) {
                    message.show(); // Afficher le champ
                    inputField.prop('required', true); // Rendre le champ obligatoire
                    console.log('Case "Handicap" cochée');
                } else {
                    message.hide(); // Masquer le champ
                    inputField.prop('required', false); // Ne pas rendre le champ obligatoire
                    console.log('Case "Handicap" décochée');
                }
            }).trigger('change'); // Déclencher l'événement pour initialiser l'état
        }
    }

    // Fonction pour gérer la logique des cases "Actif" et "Admis"
    function handleCheckboxLogic() {
        let checkboxActif = $('#eleves_isActif');
        let checkboxAdmis = $('#eleves_isAdmis');

        // Récupérer les rôles de l'utilisateur depuis l'attribut data
        let userRoles = checkboxAdmis.data('user-roles') ? checkboxAdmis.data('user-roles').split(',') : [];

        // Vérifier si l'utilisateur a les droits nécessaires
        let isAuthorized = userRoles.includes('ROLE_ADMIN') || userRoles.includes('ROLE_DIRECTION');

        // Afficher les rôles dans la console pour vérification
        //console.log("Rôles de l'utilisateur connecté :", userRoles);

        // Désactiver la case "Admis" si l'utilisateur n'est pas autorisé
        if (!isAuthorized) {
            checkboxAdmis.prop('disabled', true);
        }

        // Désactiver "Actif" si "Admis" n'est pas coché
        checkboxActif.prop('disabled', !checkboxAdmis.prop('checked'));

        // Si "Actif" est coché alors que "admis" ne l'est pas, décocher "Actif"
        if (checkboxActif.prop('checked') && !checkboxAdmis.prop('checked')) {
            checkboxActif.prop('checked', false);
            alert("Vous devez d'abord cocher 'Admis' pour pouvoir cocher 'Actif'.");
        }

        if (checkboxAdmis.prop('checked') && checkboxActif.prop('checked')) {
            // Log des états des cases
            /*$.ajax({
                url: '/frais/scolarites/new',
                method: 'GET',
                success: function (response) {
                    console.log('Réponse AJAX :', response);
                },
                error: function (error) {
                    console.error('Erreur AJAX :', error);
                }
            });*/
        }
    }

    // Appliquer la logique au chargement de la page
    isHandicapFunction(); // Initialiser la gestion de la case "Handicap"
    handleCheckboxLogic(); // Initialiser la logique des cases "Actif" et "Admis"

    // Gérer les changements sur les cases "Actif" et "Admis"
    $('#eleves_isActif, #eleves_isAdmis').on('change', handleCheckboxLogic);
});