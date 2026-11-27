// Public/Assets/Js/menu-burger.js

document.addEventListener('DOMContentLoaded', () => {
    const boutonBurger = document.getElementById('bouton-burger');
    const sidebar = document.querySelector('.sidebar');

    if (!boutonBurger || !sidebar) return;

    const icone = boutonBurger.querySelector('i');

    // Fonction pour fermer le menu
    const fermerMenu = () => {
        sidebar.classList.remove('ouvert');
        boutonBurger.setAttribute('aria-expanded', 'false');
        boutonBurger.setAttribute('aria-label', 'Ouvrir le menu');
        if (icone) {
            icone.classList.remove('fa-xmark');
            icone.classList.add('fa-bars');
        }
    };

    // Ouverture / fermeture au clic sur le bouton burger
    boutonBurger.addEventListener('click', () => {
        const estOuvert = sidebar.classList.toggle('ouvert');
        boutonBurger.setAttribute('aria-expanded', String(estOuvert));
        boutonBurger.setAttribute('aria-label', estOuvert ? 'Fermer le menu' : 'Ouvrir le menu');

        if (icone) {
            icone.classList.toggle('fa-bars', !estOuvert);
            icone.classList.toggle('fa-xmark', estOuvert);
        }
    });

    // Fermeture avec la touche Échap
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && sidebar.classList.contains('ouvert')) {
            fermerMenu();
        }
    });

    // Fermeture si on clique en dehors du menu
    document.addEventListener('click', (e) => {
        if (sidebar.classList.contains('ouvert') && !sidebar.contains(e.target)) {
            fermerMenu();
        }
    });
});