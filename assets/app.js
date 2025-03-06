// Importations communes
import 'bootstrap/dist/css/bootstrap.min.css'; // Import du CSS de Bootstrap
import 'bootstrap'; // Import du JavaScript de Bootstrap
import '@popperjs/core'; // Import de Popper.js (requis par Bootstrap)

// Initialisation de Select2
$(document).ready(function() {
    $('.select2').select2();
});

// Initialisation de Bootstrap (si nécessaire)
import { Alert, Dropdown } from 'bootstrap';
import * as bootstrap from 'bootstrap'; // Importation complète de Bootstrap

// Exemple d'utilisation de Bootstrap
document.addEventListener('DOMContentLoaded', () => {
    // Initialiser un dropdown Bootstrap
    const dropdownElementList = document.querySelectorAll('.dropdown-toggle');
    const dropdownList = [...dropdownElementList].map(dropdownToggleEl => new bootstrap.Dropdown(dropdownToggleEl));
});

// Highlight.js (optionnel)
import hljs from 'highlight.js/lib/core';
import javascript from 'highlight.js/lib/languages/javascript';

hljs.registerLanguage('javascript', javascript);
hljs.highlightAll();

// Import des styles Sass (optionnel)
import './styles/app.scss';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');