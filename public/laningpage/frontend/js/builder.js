const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

let formData = new FormData();
formData.append('_token', csrfToken);

fetch('/builder/all', {method: 'POST', body: formData})
    .then(response => response.json())
    .then(data => {
        document.querySelectorAll('[data-key]').forEach(item => {
            if (data.hasOwnProperty(item.dataset.key)) {
                if (item.tagName.toLowerCase() === 'img') {
                    item.src = data[item.dataset.key];
                    if (item.dataset.scroll) {
                        item.dataset.scroll = data[item.dataset.key];
                    } else if (item.dataset.onload) {
                        item.dataset.onload = data[item.dataset.key];
                    }
                    item.onload = function () {
                        item.style.visibility = 'visible';
                    };
                    item.onerror = function () {
                        item.style.visibility = 'visible';
                    };
                } else {
                    if (data[item.dataset.key]) {
                        item.innerText = data[item.dataset.key];
                    } else {
                        item.innerHTML = '&nbsp;';
                    }
                    item.style.visibility = 'visible';
                }
            } else {
                item.style.visibility = 'visible';
            }
        });
    });


function loadImage() {
    document.querySelectorAll('img').forEach(item => {
        if (item.dataset.load) {
            item.setAttribute('src', item.dataset.load);
        }
    });
}

window.onload = loadImage;

let fired = false;
window.addEventListener("scroll", function () {
    if (fired === false && (document.documentElement.scrollTop != 0 || document.body.scrollTop != 0)) {
        document.querySelectorAll('img').forEach(item => {
            if (item.dataset.scroll) {
                item.setAttribute('src', item.dataset.scroll);
            }
        });
        fired = true;
    }
}, true);
