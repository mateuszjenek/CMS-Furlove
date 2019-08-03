require('../css/home.scss');
require('../../node_modules/slick-carousel/slick/slick');
require('bootstrap/js/src/carousel.js');
const $ = require('jquery');

function resizeLogo() {
    let logo = document.getElementById('nav-logo');
    let scrollHeight = (window.pageYOffset || document.scrollTop)  - (document.clientTop || 0);
    let carousel = document.getElementById('carousel');

    if (!$('#ref-item').is(":hidden")){
        let scale;
        if (isNaN(scrollHeight)) {
            scale = 1;
        } else if (scrollHeight > carousel.offsetHeight) {
            scale = 0
        } else {
            scale = ((carousel.offsetHeight - scrollHeight) / carousel.offsetHeight);
        }

        logo.style.width = (90 + 35 * scale) + 'px';
    } else {
        logo.style.width = '90px';
    }
}

resizeLogo();
window.addEventListener('scroll', resizeLogo, false);
$(window).resize(resizeLogo);


//////////////////////////////////
//      kittens_carousel        //
//////////////////////////////////

$(document).ready(function(){
    $('.kitten-carousel-md').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        dots: false,
        arrows: false
    });

    // language=JQuery-CSS
    $('.kitten-carousel').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        dots: false,
        arrows: false
    });
});


//////////////////////////////////
//          partners            //
//////////////////////////////////

//ScrollReveal({ reset: true });
//ScrollReveal().reveal('.headline', { duration: 1000, scale: 0.85 });