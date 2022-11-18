const changeBtn = document.querySelectorAll('.change-btn');
const sourceSelect = document.querySelector('.selectpicker-source');

changeBtn.forEach(btn => btn.addEventListener('click',() => {
    document.location.replace(document.location.pathname + 'change' + '?id=' + btn.dataset.id + '&source=' + sourceSelect.value) ;
}));