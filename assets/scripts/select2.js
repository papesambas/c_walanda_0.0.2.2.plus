// Initialisation de Select2
$(document).ready(function() {
    $('.select-profession').select2({
        tags: true,
        tokenSeparators: [',', '  '],
        placeholder: 'Sélectionnez ou entrez une Professions... ',
        allowClear: true,
        minimumResultsForSearch: -1 // Pour toujours afficher la recherche même si peu de résultats
    });
});