// Permet de changer en tout temps la langue du site
const selectPrincipal = document.getElementById('langChangePrincipal');
selectPrincipal.addEventListener('change', function handleChange(event) {
    window.location.href = "/lang/?lang="+ event.target.value;
});

const selectSecondaire = document.getElementById('langChangeSecondaire');
if (selectSecondaire !== null)
{
    selectSecondaire.addEventListener('change', function handleChange(event) {
        window.location.href = "/lang/?lang="+ event.target.value;
    });
}
