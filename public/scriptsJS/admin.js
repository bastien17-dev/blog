const postSubmit = document.querySelector('.post-submit');
const title = document.querySelector('.title');
const content = document.querySelector('.content');

const elToListen = [title, content];

elToListen.forEach(el => {
    el.addEventListener('input', () => {
        title.value.length > 0 && content.value.length > 0 ? postSubmit.disabled = false : postSubmit.disabled = true;
    })
});