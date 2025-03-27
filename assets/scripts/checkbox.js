$(document).ready(function () {
    // Fonction pour gérer la case "Handicap" et le champ associé
    function isHandicapFunction() {
        let inputField = $('#eleves_natureHandicape');
        let checkbox = $('#eleves_isHandicap');
        let message = $('#eleves_natureHandicape');
        inputField.prop('required', false); // Ne pas rendre le champ obligatoire

        // Vérifier si les éléments existent
        if (checkbox.length && message.length) {
            checkbox.on('change', function () {
                if (checkbox.prop('checked')) {
                    message.show(); // Afficher le champ
                    inputField.prop('required', true); // Rendre le champ obligatoire
                } else {
                    message.hide(); // Masquer le champ
                    inputField.prop('required', false); // Ne pas rendre le champ obligatoire
                }
            }).trigger('change'); // Déclencher l'événement pour initialiser l'état
        }
    }

    // Fonction pour gérer la logique des cases "Actif" et "Admis"
    function handleCheckboxLogic() {
        let checkboxActif = $('#eleves_isActif');
        let checkboxAdmis = $('#eleves_isAdmis');
        let checkboxAllowed = $('#eleves_isAllowed');
        checkboxActif.prop('required', false); // Ne pas rendre le champ obligatoire

        let departContainer = $('#departs-container');
        let departsCollection = $("#departs");
        let form = $("form");
        //let checkboxActif = $('#{{ form.isActif.vars.id }}'); // Récupération de l'ID du champ actif
        //let checkboxAdmis = $('#{{ form.isAdmis.vars.id }}'); // Récupération de l'ID du champ admis

        function toggleDepartContainer() {
            if (!checkboxActif.prop('checked') && !checkboxAdmis.prop('checked')) {
                departContainer.show(); // Afficher le conteneur
            } else {
                departContainer.hide(); // Cacher le conteneur
                //departsCollection.empty(); // Supprimer les entrées existantes
            }
        }

        function validateDepartCollection(event) {
            if (!checkboxActif.prop("checked") && !checkboxAdmis.prop("checked")) {
                let totalDeparts = departsCollection.children(".col-12").length; // Vérifier les entrées ajoutées

                if (totalDeparts === 0) {
                    event.preventDefault(); // Bloquer la soumission
                    alert("Vous devez ajouter au moins le motif du départ et l'école de destinantion !");
                }
            }
        }

        // Vérifier au chargement initial
        toggleDepartContainer();

        // Ajouter un écouteur d'événement sur les cases à cocher
        checkboxActif.on('change', toggleDepartContainer);
        checkboxAdmis.on('change', toggleDepartContainer);

        // Vérifier avant soumission du formulaire
        form.on("submit", validateDepartCollection);

        // Récupérer les rôles de l'utilisateur depuis l'attribut data
        /*let userRoles = checkboxAdmis.data('user-roles') ? checkboxAdmis.data('user-roles').split(',') : [];

        // Vérifier si l'utilisateur a les droits nécessaires
        let isAuthorized = userRoles.includes('ROLE_ADMIN') || userRoles.includes('ROLE_DIRECTION');

        // Afficher les rôles dans la console pour vérification
        //console.log("Rôles de l'utilisateur connecté :", userRoles);

        // Désactiver la case "Admis" si l'utilisateur n'est pas autorisé
        if (!isAuthorized) {
            checkboxAdmis.prop('disabled', true);
            checkboxAllowed.prop('disabled', true);
        }*/

        // Désactiver "Actif" si "Admis" n'est pas coché
        checkboxActif.prop('disabled', !checkboxAdmis.prop('checked'));
        checkboxAllowed.prop('disabled', !checkboxActif.prop('checked')).prop('checked', false);

        // Si "Actif" est coché alors que "admis" ne l'est pas, décocher "Actif"
        if (checkboxActif.prop('checked') && !checkboxAdmis.prop('checked')) {
            checkboxActif.prop('checked', false);
            checkboxAllowed.prop('checked', false);
            alert("Vous devez d'abord cocher 'Admis' pour pouvoir cocher 'Actif'.");

        }


        /*if (checkboxAdmis.prop('checked') && checkboxActif.prop('checked')) {
            // Log des états des cases
            $.ajax({
                url: '/frais/scolarites/new',
                method: 'GET',
                success: function (response) {
                    console.log('Réponse AJAX :', response);
                },
                error: function (error) {
                    console.error('Erreur AJAX :', error);
                }
            });
        }*/
    }

    // Appliquer la logique au chargement de la page
    isHandicapFunction(); // Initialiser la gestion de la case "Handicap"
    handleCheckboxLogic(); // Initialiser la logique des cases "Actif" et "Admis"

    // Gérer les changements sur les cases "Actif" et "Admis"
    $('#eleves_isActif, #eleves_isAdmis').on('change', handleCheckboxLogic);
});