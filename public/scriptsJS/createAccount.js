let submit = document.querySelector('.submit');
let pseudo = document.querySelector('.pseudo');
let pass = document.querySelector('.pass');
let passConfirm = document.querySelector('.passConfirm');
let alertPass = document.querySelector('.alert');

let areInputsFeed = false;
let isPassConfirmed = true;

let elToListen = [pseudo, pass, passConfirm];

const canSubmit = () => {
    areInputsFeed && isPassConfirmed ? submit.disabled = false : submit.disabled = true;
}

const alertPassVisible = () => {
    isPassConfirmed ? alertPass.style.display = 'none' : alertPass.style.display = 'block';
}

elToListen.forEach(el => {
    el.addEventListener('input', () => {
        pseudo.value.length > 0 && pass.value.length > 0 && passConfirm.value.length > 0 ? areInputsFeed = true : areInputsFeed = false;
        canSubmit();
    })

    passConfirm.addEventListener(('input'), () => {
        pass.value === passConfirm.value ? isPassConfirmed = true: isPassConfirmed = false;
        alertPassVisible();
    })
});



