$(document).ready(function() {
    let isChecked = false;
    const checkboxes = $('.checkbox-btn');

    checkboxes.each(function() {
        $(this).on('click', () => {
            if ($(this).is(':checked'))
                $('.delete-all-btn').removeClass('disabled');
            checkCheckboxes();
        });
    });

    $('.check-all-btn').on('click', () => {
        $('.checkbox-btn').each(function() {
            $(this).prop("checked", true);
        });
        $('.delete-all-btn').removeClass('disabled');
    });

    $('.remove-all-btn').on('click', () => {
        $('.checkbox-btn').each(function() {
            $(this).prop("checked", false);
        });
        $('.delete-all-btn').addClass('disabled');
    });

    function checkCheckboxes() {
        checkboxes.each(function() {
            if ($(this).is(':checked')) {
                isChecked = true;
                return false;
            }
            isChecked = false;
        });
        if (!isChecked) {
            $('.delete-all-btn').addClass('disabled');
        }
    }
});


