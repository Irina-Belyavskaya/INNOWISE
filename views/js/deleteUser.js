const deleteBtn = document.querySelectorAll('.delete-btn');
const closeModalBtn = document.getElementById('close-modal');
let dataToSend = 0;

// Content activation id="modal" as modal window
const modal = new bootstrap.Modal(document.querySelector('#modal'));

deleteBtn.forEach(btn => btn.addEventListener('click',() => {
    dataToSend = btn.dataset.id;
    modal.show();
}));

closeModalBtn.addEventListener('click',() => {
    if (dataToSend !== 0) {
        document.location.replace(document.location.pathname + 'delete' + '?id=' + dataToSend) ;
    }
});



