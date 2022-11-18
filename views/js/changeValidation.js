import {inputValid, submitValid} from "./funcForValidation.js";

const formChange = document.querySelector('.form-change');
const inputName = document.getElementById('name');
const inputEmail = document.getElementById('email');
const genderSelect = document.getElementById('gender');
const statusSelect = document.getElementById('status');

inputValid(inputName,inputEmail, genderSelect, statusSelect);

formChange.onsubmit = function (evt) {
    evt.preventDefault();

    if (!submitValid (inputName,inputEmail, genderSelect, statusSelect))
        return;

    const searchString = new URLSearchParams(window.location.search);
    let source = searchString.get('source');
    formChange.action = formChange.action + '?source=' + source;
    HTMLFormElement.prototype.submit.call(formChange);
}