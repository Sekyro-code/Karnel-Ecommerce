import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

const myModal = document.getElementById('myModal')
const myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', () => {
    myInput.focus()
})

// document.addEventListener('DOMContentLoaded', function () {
//     console.log('DOM entièrement chargé et analysé');

//     // Fonction pour ajouter la classe 'show-alert' aux alertes
//     function showAlerts() {
//         var successAlerts = document.querySelectorAll('.success-alert');
//         var errorAlerts = document.querySelectorAll('.error-alert');

//         setTimeout(function () {
//             successAlerts.forEach(function (alert) {
//                 alert.classList.add('show-alert');
//             });
//             errorAlerts.forEach(function (alert) {
//                 alert.classList.add('show-alert');
//             });
//             console.log('Classes show-alert ajoutées');
//         }, 100); // Delay of 100 milliseconds
//     }

//     // Écouter l'événement personnalisé pour afficher les alertes
//     document.addEventListener('showAlerts', showAlerts);

//     // Vérifier si des alertes sont présentes au chargement de la page
//     if (localStorage.getItem('showAlerts') === 'true') {
//         localStorage.removeItem('showAlerts');
//         var event = new Event('showAlerts');
//         document.dispatchEvent(event);
//     }

//     // Ajouter un écouteur d'événement pour le clic sur le bouton "Ajouter au panier"
//     var addToCartButton = document.querySelector('.btn-primary');
//     if (addToCartButton) {
//         addToCartButton.addEventListener('click', function () {
//             localStorage.setItem('showAlerts', 'true');
//         });
//     }
// });


