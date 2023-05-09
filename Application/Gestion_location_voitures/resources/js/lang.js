/**
 * Permet de récuperer la valeur du selecteur de langue
 * Pour l'intégrer dans l'url de la route LANG
 */
const selectPrincipal = document.getElementById('langChangePrincipal');
selectPrincipal.addEventListener('change', function handleChange(event) {
    window.location.href = "/lang/?lang="+ event.target.value;
});
