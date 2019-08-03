require('../css/kittens.scss');

const $ = require('jquery');

function imageHeader() {
    var headerImage = document.getElementById('header-image');
    if(headerImage.offsetWidth > 768)
        headerImage.style.backgroundPositionY = '-7vw';
    else
        headerImage.style.backgroundPositionY = '0';
}

$(window).resize(imageHeader);