document.addEventListener('DOMContentLoaded', function () {
    var swiper = new Swiper('.swiper-container', {
        loop: true,
        slidesPerView: 3,
        spaceBetween: 15,
        autoplay: {
            delay: 5000, // Delay in milliseconds between slides (5 seconds)
            disableOnInteraction: false, // Keep autoplay running even when interacting with the slider
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
       
    });
});
