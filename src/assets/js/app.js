require('../css/app.scss');

const $ = require('jquery');
require('webpack-jquery-ui');



const hamburger = document.querySelector(".hamburger");
hamburger.addEventListener("click", function() {
    hamburger.classList.toggle("is-active");
    $('#mobile-menu').toggle("slide", { direction: "right" }, 500);
});

