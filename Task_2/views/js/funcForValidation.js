import {ValidationClass} from "./ValidationClass.js";

export function inputValid (inputName,inputEmail, genderSelect, statusSelect) {
    const valid = new ValidationClass();

    inputName.addEventListener('input',() => {
        if (!valid.checkName(inputName.value))
            inputName.classList.add('error');
        else
            inputName.classList.remove('error');
    });

    inputEmail.addEventListener('input',() => {
        if (!valid.checkEmail(inputEmail.value))
            inputEmail.classList.add('error');
        else
            inputEmail.classList.remove('error');
    });

    genderSelect.addEventListener('click',() => {
        if (!valid.checkGender(genderSelect.value)) {
            genderSelect.classList.remove('btn-primary');
            genderSelect.classList.add('btn-danger');
        } else {
            genderSelect.classList.remove('btn-danger');
            genderSelect.classList.add('btn-primary');
        }
    });

    statusSelect.addEventListener('click',() => {
        if (!valid.checkStatus(statusSelect.value)) {
            statusSelect.classList.remove('btn-primary');
            statusSelect.classList.add('btn-danger');
        } else {
            statusSelect.classList.remove('btn-danger');
            statusSelect.classList.add('btn-primary');
        }
    });
}

export function submitValid (inputName,inputEmail, genderSelect, statusSelect) {
    const valid = new ValidationClass();

    let isErrors = false;

    if (!valid.checkName(inputName.value)) {
        inputName.classList.add('error');
        isErrors = true;
    } else {
        inputName.classList.remove('error');
    }

    if (!valid.checkEmail(inputEmail.value)) {
        inputEmail.classList.add('error');
        isErrors = true;
    } else {
        inputEmail.classList.remove('error');
    }

    if (!valid.checkGender(genderSelect.value)) {
        genderSelect.classList.remove('btn-primary');
        genderSelect.classList.add('btn-danger');
        isErrors = true;
    } else {
        genderSelect.classList.remove('btn-danger');
        genderSelect.classList.add('btn-primary');
    }

    if (!valid.checkStatus(statusSelect.value)) {
        statusSelect.classList.remove('btn-primary');
        statusSelect.classList.add('btn-danger');
        isErrors = true;
    } else {
        statusSelect.classList.remove('btn-danger');
        statusSelect.classList.add('btn-primary');
    }

    return !isErrors;
}