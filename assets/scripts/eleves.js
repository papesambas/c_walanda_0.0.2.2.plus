// assets/js/eleves.js

$(document).ready(function () {
    // Gérer le changement de région
    $('#eleves_region').change(function () {
        let regionId = $(this).val();
        if (regionId) {
            $.ajax({
                url: '/eleves/cercles-by-region/' + regionId,
                type: 'GET',
                success: function (data) {
                    $('#eleves_cercle').html(data);
                    $('#eleves_commune').html('<option value="">Choisir une commune</option>');
                    $('#eleves_lieuNaissance').html('<option value="">Choisir un lieu de naissance</option>');
                }
            });
        } else {
            $('#eleves_cercle').html('<option value="">Choisir un cercle</option>');
            $('#eleves_commune').html('<option value="">Choisir une commune</option>');
            $('#eleves_lieuNaissance').html('<option value="">Choisir un lieu de naissance</option>');
        }
    });

    // Gérer le changement de cercle
    $('#eleves_cercle').change(function () {
        let cercleId = $(this).val();
        if (cercleId) {
            $.ajax({
                url: '/eleves/communes-by-cercle/' + cercleId,
                type: 'GET',
                success: function (data) {
                    $('#eleves_commune').html(data);
                    $('#eleves_lieuNaissance').html('<option value="">Choisir un lieu de naissance</option>');
                }
            });
        } else {
            $('#eleves_commune').html('<option value="">Choisir une commune</option>');
            $('#eleves_lieuNaissance').html('<option value="">Choisir un lieu de naissance</option>');
        }
    });

    // Gérer le changement de commune
    $('#eleves_commune').change(function () {
        let communeId = $(this).val();
        if (communeId) {
            $.ajax({
                url: '/eleves/lieux-by-commune/' + communeId,
                type: 'GET',
                success: function (data) {
                    $('#eleves_lieuNaissance').html(data);
                }
            });
        } else {
            $('#eleves_lieuNaissance').html('<option value="">Choisir un lieu de naissance</option>');
        }
    });

    //Gérer le chargement de la classe
    $('#eleves_niveau').change(function () {
        let niveauId = $(this).val();
        if (niveauId) {
            $.ajax({
                url: '/eleves/classes-by-niveau/' + niveauId,
                type: 'GET',
                success: function (data) {
                    $('#eleves_classe').html(data);
                }
            });
        } else {
            $('#eleves_classe').html('<option value="">Choisir une classe</option>');
        }
    });

    //Gérer le chargement du statut
    $('#eleves_niveau').change(function () {
        let niveauId = $(this).val();
        if (niveauId) {
            $.ajax({
                url: '/eleves/statuts-by-niveau/' + niveauId,
                type: 'GET',
                success: function (data) {
                    $('#eleves_statut').html(data);
                }
            });
        } else {
            $('#eleves_statut').html('<option value="">Choisir un statut</option>');
        }
    });

    //Gérer le chargement du scolarites1
    $('#eleves_niveau').change(function () {
        let niveauId = $(this).val();
        if (niveauId) {
            $.ajax({
                url: '/eleves/scolarites1-by-niveau/' + niveauId,
                type: 'GET',
                success: function (data) {
                    $('#eleves_scolarite1').html(data);
                }
            });
        } else {
            $('#eleves_scolarite1').html('<option value="">Choisir une scolarite</option>');
        }
    });

    //Gérer le chargement du scolarites2
    $('#eleves_scolarite1').change(function () {
        let scolarite1Id = $(this).val();
        if (scolarite1Id) {
            $.ajax({
                url: '/eleves/scolarites2-by-scolarite1/' + scolarite1Id,
                type: 'GET',
                success: function (data) {
                    $('#eleves_scolarite2').html(data);
                }
            });
        } else {
            $('#eleves_scolarite2').html('<option value="">Choisir une scolarite</option>');
        }
    });

    //Gérer le chargement de redoublement1
    $('#eleves_scolarite2').change(function () {
        let scolarite2Id = $(this).val();
        let $redoublement1 = $('#eleves_redoublement1');
        let $redoublement2 = $('#eleves_redoublement2');
        let $redoublement3 = $('#eleves_redoublement3');

        $redoublement1.prop('required', false);
        $redoublement1.addClass('required-field');
        $redoublement2.prop('required', false);
        $redoublement2.removeClass('required-field');
        $redoublement3.prop('required', false);
        $redoublement3.removeClass('required-field');

        if (scolarite2Id) {
            $.ajax({
                url: '/eleves/redoublement1-by-scolarite2/' + scolarite2Id,
                type: 'GET',
                dataType: 'json', // Important pour interpréter la réponse JSON
                success: function (data) {
                    // Mettre à jour les options
                    $redoublement1.html(data.html);

                    // Gérer l'attribut required
                    if (data.has_redoublements) {
                        $redoublement1.prop('required', true);
                        $redoublement1.addClass('required-field');
                    } else {
                        $redoublement1.prop('required', false);
                        $redoublement1.removeClass('required-field');
                    }

                    // Réinitialiser les champs suivants
                    $('#eleves_redoublement2, #eleves_redoublement3').html(
                        '<option value="">Choisir un redoublement</option>'
                    );
                }
            });
        } else {
            // Réinitialiser tous les champs
            $redoublement1.html('<option value="">Choisir un redoublement</option>')
                .prop('required', false)
                .removeClass('required-field');

            $('#eleves_redoublement2, #eleves_redoublement3').html(
                '<option value="">Choisir un redoublement</option>'
            );
        }
    });

    //Gérer le chargement de redoublement2
    $('#eleves_redoublement1').change(function () {
        let redoublement1Id = $(this).val();
        let $redoublement2 = $('#eleves_redoublement2');
        $redoublement2.prop('required', false);
        $redoublement2.removeClass('required-field');

        if (redoublement1Id) {
            $.ajax({
                url: '/eleves/redoublement2-by-redoublement1/' + redoublement1Id,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Mettre à jour les options
                    $redoublement2.html(data.html);

                    // Gérer l'attribut required
                    if (data.has_redoublement2s) {
                        $redoublement2.prop('required', true);
                        $redoublement2.addClass('required-field');
                    } else {
                        $redoublement2.prop('required', false);
                        $redoublement2.removeClass('required-field');
                    }

                    // Réinitialiser le champ suivant
                    $('#eleves_redoublement3').html('<option value="">Choisir un redoublement</option>');
                }
            });
        } else {
            // Réinitialiser les champs suivants
            $redoublement2.html('<option value="">Choisir un redoublement</option>')
                .prop('required', false)
                .removeClass('required-field');

            $('#eleves_redoublement3').html('<option value="">Choisir un redoublement</option>');
        }
    });

    //Gérer le chargement de redoublement3
    $('#eleves_redoublement2').change(function () {
        let redoublement2Id = $(this).val();
        let $redoublement3 = $('#eleves_redoublement3');
        $redoublement3.prop('required', false);
        $redoublement3.removeClass('required-field');

        if (redoublement2Id) {
            $.ajax({
                url: '/eleves/redoublement3-by-redoublement2/' + redoublement2Id,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $redoublement3.html(data.html);

                    if (data.has_redoublement3s) {
                        $redoublement3.prop('required', true);
                        $redoublement3.addClass('required-field');
                    } else {
                        $redoublement3.prop('required', false);
                        $redoublement3.removeClass('required-field');
                    }
                }
            });
        } else {
            $redoublement3.html('<option value="">Choisir un redoublement</option>')
                .prop('required', false)
                .removeClass('required-field');
        }
    });

    document.getElementById('eleves_dateNaissance').addEventListener('change', function() {
        const input = this;
        
        // Récupération des paramètres
        const minDate = new Date(input.min);
        const maxDate = new Date(input.max);
        const selectedDate = new Date(input.value);
        
        // Validation de base (HTML5)
        if (selectedDate < minDate || selectedDate > maxDate) {
            input.setCustomValidity(`La date doit être entre ${minDate.toLocaleDateString()} et ${maxDate.toLocaleDateString()}`);
            input.classList.add('is-invalid');
        } else {
            input.setCustomValidity('');
            input.classList.remove('is-invalid');
        }
        
        input.reportValidity();
    });

    document.getElementById('eleves_dateExtrait').addEventListener('change', function() {
        const input = this;
        
        // Récupération des paramètres
        const minDate = new Date(input.min);
        const maxDate = new Date(input.max);
        const selectedDate = new Date(input.value);
        
        // Validation de base (HTML5)
        if (selectedDate < minDate || selectedDate > maxDate) {
            input.setCustomValidity(`La date doit être entre ${minDate.toLocaleDateString()} et ${maxDate.toLocaleDateString()}`);
            input.classList.add('is-invalid');
        } else {
            input.setCustomValidity('');
            input.classList.remove('is-invalid');
        }
        
        input.reportValidity();
    });

    document.getElementById('eleves_dateRecrutement').addEventListener('change', function() {
        const input = this;
        
        // Récupération des paramètres
        const minDate = new Date(input.min);
        const maxDate = new Date(input.max);
        const selectedDate = new Date(input.value);
        
        // Validation de base (HTML5)
        if (selectedDate < minDate || selectedDate > maxDate) {
            input.setCustomValidity(`La date doit être entre ${minDate.toLocaleDateString()} et ${maxDate.toLocaleDateString()}`);
            input.classList.add('is-invalid');
        } else {
            input.setCustomValidity('');
            input.classList.remove('is-invalid');
        }
        
        input.reportValidity();
    });

    document.getElementById('eleves_dateInscription').addEventListener('change', function() {
        const input = this;
        
        // Récupération des paramètres
        const minDate = new Date(input.min);
        const maxDate = new Date(input.max);
        const selectedDate = new Date(input.value);
        
        // Validation de base (HTML5)
        if (selectedDate < minDate || selectedDate > maxDate) {
            input.setCustomValidity(`La date doit être entre ${minDate.toLocaleDateString()} et ${maxDate.toLocaleDateString()}`);
            input.classList.add('is-invalid');
        } else {
            input.setCustomValidity('');
            input.classList.remove('is-invalid');
        }
        
        input.reportValidity();
    });
});