require('../css/admin_base.scss');

const $ = require('jquery');
require('webpack-jquery-ui');

const hamburger = document.querySelector(".hamburger");
hamburger.addEventListener("click", function() {
    hamburger.classList.toggle("is-active");
    $('#c-navbar').toggle("slide", { direction: "right" }, 500);
});

$(window).resize(function () {
    if ($( window ).width() >= 768)
        $('#c-navbar').show();
});