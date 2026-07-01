const hamburguer = document.getElementById('hamburguer');
const menu = document.getElementById('menu');

if (hamburguer && menu) {
    hamburguer.addEventListener('click', () => {
        menu.classList.toggle('active');
    });

    menu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            menu.classList.remove('active');
        });
    });
}
