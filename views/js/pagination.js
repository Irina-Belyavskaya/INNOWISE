const btnNavLeft = document.querySelector('.btn-nav-left');
const btnNavRight = document.querySelector('.btn-nav-right');

const hiddenData = document.getElementById('count');

const limitNumOfPages = Number(hiddenData.dataset.count);
const currentPage = hiddenData.dataset.current;

let page = Number(currentPage);

if (page === limitNumOfPages) {
    console.log('here');
    btnNavRight.classList.add('isDisabled');
    btnNavRight.href = "javascript: void(0)";
}

if (page === 1) {
    btnNavLeft.classList.add('isDisabled');
    btnNavLeft.href = "javascript: void(0)";
}

btnNavRight.addEventListener('click',() => {
    if (page >= limitNumOfPages) {
        btnNavRight.classList.add('isDisabled');
        btnNavRight.href = "javascript: void(0)";
    } else {
        page += 1;
        document.location.replace(document.location.pathname + '?page=' + page) ;
    }

    if (page > 1) {
        btnNavLeft.classList.remove('isDisabled');
        btnNavLeft.href = "#";
    }
});

btnNavLeft.addEventListener('click',() => {
    if (page <= 1) {
        btnNavLeft.classList.add('isDisabled');
        btnNavLeft.href = "javascript: void(0)";
    } else {
        page -= 1;
        document.location.replace(document.location.pathname + '?page=' + page) ;
    }
    if (page < limitNumOfPages) {
        btnNavRight.classList.remove('isDisabled');
        btnNavRight.href = "#";
    }
})