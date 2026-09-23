//'use strict';

/*const menuButton = document.querySelector('.menu-button');
const menuOverlay = document.querySelector('.menu-overlay');
const backgroundOverlay = document.querySelector('.background-overlay');

menuButton.addEventListener('click', function() {
    menuButton.classList.toggle('active');
    menuOverlay.classList.toggle('open');
    backgroundOverlay.classList.toggle('bg-overlay');
});*/



$(document).on('click', '.menu-button, .background-overlay.bg-overlay', function () {
        $('.menu-button').toggleClass('active');
		$('.menu-overlay').toggleClass('open');
		$('.background-overlay').toggleClass('bg-overlay');
});
