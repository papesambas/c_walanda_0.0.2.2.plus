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
        if (scolarite2Id) {
            $.ajax({
                url: '/eleves/redoublement1-by-scolarite2/' + scolarite2Id,
                type: 'GET',
                success: function (data) {
                    $('#eleves_redoublement1').html(data);
                    $('#eleves_redoublement2').html('<option value="">Choisir un remboursement</option>');
                    $('#eleves_redoublement3').html('<option value="">Choisir un remboursement</option>');
        
                }
            });
        } else {
            $('#eleves_redoublement1').html('<option value="">Choisir un remboursement</option>');
            $('#eleves_redoublement2').html('<option value="">Choisir un remboursement</option>');
            $('#eleves_redoublement3').html('<option value="">Choisir un remboursement</option>');

        }
    });

    //Gérer le chargement de redoublement2
    $('#eleves_redoublement1').change(function () {
        let redoublement1Id = $(this).val();
        if (redoublement1Id) {
            $.ajax({
                url: '/eleves/redoublement2-by-redoublement1/' + redoublement1Id,
                type: 'GET',
                success: function (data) {
                    $('#eleves_redoublement2').html(data);
                    $('#eleves_redoublement3').html('<option value="">Choisir un remboursement</option>');
                }
            });
        } else {
            $('#eleves_redoublement2').html('<option value="">Choisir un remboursement</option>');
            $('#eleves_redoublement3').html('<option value="">Choisir un remboursement</option>');
        }
    });

    //Gérer le chargement de redoublement3
    $('#eleves_redoublement2').change(function () {
        let redoublement2Id = $(this).val();
        if (redoublement2Id) {
            $.ajax({
                url: '/eleves/redoublement3-by-redoublement2/' + redoublement2Id,
                type: 'GET',
                success: function (data) {
                    $('#eleves_redoublement3').html(data);
                }
            });
        } else {
            $('#eleves_redoublement3').html('<option value="">Choisir un remboursement</option>');
        }
    });


});