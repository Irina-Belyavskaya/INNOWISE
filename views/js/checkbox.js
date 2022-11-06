$(document).ready(function() {
    let isChecked = false;
    const checkboxes = $('.checkbox-btn');
    const deleteAllBtn = $('.delete-all-btn');
    const closeModalBtn = $('#close-modal');
    const modal = new bootstrap.Modal($('#modal'));

    checkboxes.each(function() {
        $(this).on('click', () => {
            if ($(this).is(':checked'))
                deleteAllBtn.removeClass('disabled');
            checkCheckboxes();
        });
    });

    $('.check-all-btn').on('click', () => {
        checkboxes.each(function() {
            $(this).prop("checked", true);
        });
        deleteAllBtn.removeClass('disabled');
    });

    $('.remove-all-btn').on('click', () => {
        checkboxes.each(function() {
            $(this).prop("checked", false);
        });
        deleteAllBtn.addClass('disabled');
    });

    closeModalBtn.on('click',() => {
        let data = getCheckedBoxes();
        $('.info-hidden').val(data);
        $( "#deleteAllForm" ).submit();
    });

    deleteAllBtn.on('click', (event) => {
        event.preventDefault();
        modal.show();
    });

    function getCheckedBoxes() {
        let data = [];
        checkboxes.each(function() {
            if ($(this).is(':checked'))
                data.push($(this).data("id"));
        });
        return data;
    }

    function checkCheckboxes() {
        checkboxes.each(function() {
            if ($(this).is(':checked')) {
                isChecked = true;
                return false;
            }
            isChecked = false;
        });
        if (!isChecked) {
            deleteAllBtn.addClass('disabled');
        }
    }
});


