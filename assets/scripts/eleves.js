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
});