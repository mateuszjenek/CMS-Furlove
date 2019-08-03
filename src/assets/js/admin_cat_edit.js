const $ = require('jquery');

$(document).ready(function () {
    toggleFields();
    $(".isOur").change(function () {
        toggleFields();
    });

});
// this toggles the visibility of other server
function toggleFields() {
    if ($(".isOur")[0].checked)
        $(".breeding").hide();
    else
        $(".breeding").show();
}