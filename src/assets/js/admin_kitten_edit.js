const $ = require('jquery');

$(document).ready(function () {
    toggleFields();
    $(".litter").change(function () {
        toggleFields();
    });

});
// this toggles the visibility of other server
function toggleFields() {
    if ($(".litter").val() == -1){

        //$(".newLitter").show();
        $('.newLitter').css('position', 'relative');
        $('.newLitter').css('opacity', 1);
        $('.newLitter').attr('required', true);
    }
    else {
        //$(".newLitter").hide();
        $('.newLitter').css('position', 'absolute');
        $('.newLitter').css('opacity', 0);
        $('.newLitter').attr('required', false);
    }

}