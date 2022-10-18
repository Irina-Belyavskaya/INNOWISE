const changeBtn = document.querySelectorAll('.change-btn');

changeBtn.forEach(btn => btn.addEventListener('click',() => {
    document.location.replace(document.location.pathname + 'change' + '?id_user=' + btn.dataset.id) ;
}));