const checkboxes = document.querySelectorAll('.checkbox-btn');
const deleteAllBtn = document.querySelector('.delete-all-btn');
const checkAllBtn = document.querySelector('.check-all-btn');
const removeAllBtn = document.querySelector('.remove-all-btn');
let isChecked = false;

checkboxes.forEach(checkbox => checkbox.addEventListener('click',() => {
    if (checkbox.checked)
        deleteAllBtn.classList.remove('disabled');
    checkCheckboxes();
}));

checkAllBtn.addEventListener('click', () => {
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
    deleteAllBtn.classList.remove('disabled');
});

removeAllBtn.addEventListener('click', () => {
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    deleteAllBtn.classList.add('disabled');
});

function checkCheckboxes() {
    for (let i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            isChecked = true;
            break;
        }
        isChecked = false;
    }
    if (!isChecked) {
        deleteAllBtn.classList.add('disabled');
    }
}
