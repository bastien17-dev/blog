const searchArea = document.querySelector('.search-area');
const search = document.querySelector('.search');
const list = document.querySelector('.list');


search.addEventListener('input', (e) => {
    list.innerHTML = '';
    if(e.target.value.length > 0) {
        let data = {searchValue: e.target.value};
        fetch('http://localhost:8888/cours-OC-php/tp_blog/public/api/getSearchResults.php', {
            method: 'POST',
            body: JSON.stringify(data)
        }).then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    data.forEach(el => {
                        let liElt = document.createElement('li');
                        liElt.innerHTML = `<a href="http://localhost:8888/cours-OC-php/tp_blog/public/index.php?blog=${el.id_user}">${el.pseudo}</a>`;
                        list.appendChild(liElt)
                    });
                }
            }).catch(() => {
            list.innerHTML = '';
            })
    } else {
        list.innerHTML = '';
    }
});