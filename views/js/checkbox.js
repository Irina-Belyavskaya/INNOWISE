$(document).ready(function() {
    let isChecked = false;
    const checkboxes = $('.checkbox-btn');
    const deleteAllBtn = $('.delete-all-btn');
    const closeModalBtn = $('#close-modal');
    const infoHiddenPrevious = $('.info-hidden-previous');
    const modal = new bootstrap.Modal($('#modal'));

    let isDeleteAll = false;

    // Check if any checkboxes have been checked before
    checkboxes.each(function() {
        if ($(this).is(':checked')) {
            deleteAllBtn.removeClass('disabled');
        }
    });

    checkboxes.each(function() {
        $(this).on('click', () => {

            // Make available button "Delete all"
            if ($(this).is(':checked')) {
                deleteAllBtn.removeClass('disabled');
            }

            // Delete unchecked ids from array of previous ids
            if (!$(this).is(':checked')) {
                let previousCheckedIds = infoHiddenPrevious.val();
                previousCheckedIds = previousCheckedIds.split(",");
                let index = previousCheckedIds.indexOf(String($(this).data("id")));
                previousCheckedIds.splice(index, 1);
                infoHiddenPrevious.val(previousCheckedIds.join());
            }

            // Check if all checkboxes unchecked then make unpressed button "Delete all"
            checkCheckboxes();
        });
    });

    // Make all checkboxes checked on current page
    $('.check-all-btn').on('click', () => {
        checkboxes.each(function() {
            $(this).prop("checked", true);
        });
        deleteAllBtn.removeClass('disabled');
    });

    // Make all checkboxes unchecked on all pages
    $('.remove-all-btn').on('click', () => {

        // Delete all checked users id
        $('.info-hidden-previous').val('');

        // Remove attribute "checked" from all checkboxes
        checkboxes.each(function() {
            $(this).prop("checked", false);
        });
        deleteAllBtn.addClass('disabled');
    });

    // Send post request for deletion on event when user pressed button "Confirm"
    closeModalBtn.on('click',() => {
        if (isDeleteAll) {
            let data = getCheckedBoxes();
            $('.info-hidden').val(data);
            $("#deleteAllForm").submit();
        }
    });

    // Show modal window for agreement to deletion
    deleteAllBtn.on('click', (event) => {
        event.preventDefault();
        isDeleteAll = true;
        modal.show();
    });

    // Get all checked ids
    function getCheckedBoxes() {
        let data = [];
        let previousCheckedIds = infoHiddenPrevious.val();
        previousCheckedIds = previousCheckedIds.split(",");
        checkboxes.each(function() {
            if ($(this).is(':checked') && !previousCheckedIds.includes(String($(this).data("id"))))
                data.push($(this).data("id"));
        });
        data = data.concat(previousCheckedIds);
        return data;
    }

    // Check if all checkboxes unchecked then make unpressed button "Delete all"
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


