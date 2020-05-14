const submit = document.querySelector('.comment-submit');
const pseudo = document.querySelector('.pseudo');
const content = document.querySelector('.content');

const elToListen = [pseudo, content];

elToListen.forEach(el => {
    el.addEventListener('input', () => {
        pseudo.value.length > 0 && content.value.length > 0 ? submit.disabled = false : submit.disabled = true;
    })
});