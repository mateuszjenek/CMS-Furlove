const $ = require('jquery');


function isAllToDelete() {
    var isAllChecked = true;

    $('.edit-checkbox').find('input').each(function () {
        if (!$(this).prop( 'checked' )) {
            isAllChecked = false;
        }
        console.log($(this).prop( 'checked' ))
    });

    if (isAllChecked) {
        $('.img-upload').attr('required', true);
        console.log('true');
    } else {
        $('.img-upload').attr('required', false);
        console.log('false');
    }
}

$(document).ready(function () {
    isAllToDelete();
    $('.edit-checkbox').find('input').change(function () {
        isAllToDelete();
    });

});