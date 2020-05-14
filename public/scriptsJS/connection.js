const submitConnexion = document.querySelector('.connection-submit');
const pseudo = document.querySelector('.pseudo');
const passWord = document.querySelector('.pass');

const elToListen1 = [pseudo, passWord];

elToListen1.forEach(el => {
    el.addEventListener('input', () => {
        pseudo.value.length > 0 && passWord.value.length > 0 ? submitConnexion.disabled = false : submitConnexion.disabled = true;
    })
});