require('../css/posts.scss');

const $ = require('jquery');
require('../../node_modules/slick-carousel/slick/slick');
require('lightbox2');
require('iframe-lightbox');

[].forEach.call(document.getElementsByClassName("iframe-lightbox-link"), function (el) {
    el.lightbox = new IframeLightbox(el);
});


$(document).ready(function(){
    $('#carousel-md').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        dots: false
    });

    $('#carousel').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        dots: true,
        arrows: false
    });
});