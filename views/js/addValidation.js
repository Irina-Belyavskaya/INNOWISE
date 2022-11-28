import {inputValid, submitValid} from "./funcForValidation.js";

const formAdd = document.querySelector('.form-add');
const inputName = document.getElementById('name');
const inputEmail = document.getElementById('email');
const genderSelect = document.getElementById('gender');
const statusSelect = document.getElementById('status');

inputValid (inputName,inputEmail, genderSelect, statusSelect);

formAdd.onsubmit = function (evt) {
    evt.preventDefault();

    if (!submitValid (inputName,inputEmail, genderSelect, statusSelect))
        return;

    const searchString = new URLSearchParams(window.location.search);
    let source = searchString.get('source');
    formAdd.action = formAdd.action + '?source=' + source;
    HTMLFormElement.prototype.submit.call(formAdd);
}