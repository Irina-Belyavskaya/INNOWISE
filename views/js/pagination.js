const btnNavLeft = document.querySelector('.btn-nav-left');
const btnNavRight = document.querySelector('.btn-nav-right');

const hiddenData = document.getElementById('count');

const limitNumOfPages = Number(hiddenData.dataset.count);
const currentPage = hiddenData.dataset.current;

let page = Number(currentPage);

if (page === limitNumOfPages) {
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

        // Send checked ids  and page number
        sendCheckedIds(page);
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

        // Send checked ids  and page number
        sendCheckedIds(page);
    }
    if (page < limitNumOfPages) {
        btnNavRight.classList.remove('isDisabled');
        btnNavRight.href = "#";
    }
});

function getCheckedBoxes() {
    const checkboxes = document.querySelectorAll('.checkbox-btn');
    const previousCheckedId = document.querySelector('.info-hidden-previous');
    let data = [];

    // Get all previous checked ids
    if (!(previousCheckedId.value === '-1' || previousCheckedId.value === ''))
        data = previousCheckedId.value.split(',');

    // Add new checked ids
    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked && !data.includes(checkbox.dataset.id))
            data.push(checkbox.dataset.id);
    });
    return data;
}

function sendCheckedIds(page) {

    // Get all checked ids and write them to the hidden input
    const formPagination = document.getElementById('paginationForm');
    const info = document.querySelector('.info-hidden-arrow');
    info.value = getCheckedBoxes();

    // Make url with parameter page number
    formPagination.action = document.location.pathname + '?page=' + page;
    HTMLFormElement.prototype.submit.call(formPagination);
}

