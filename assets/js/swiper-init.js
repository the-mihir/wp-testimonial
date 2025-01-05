document.addEventListener('DOMContentLoaded', function () {
    var swiper = new Swiper('.swiper-container', {
        loop: true,
        slidesPerView: 3,
        spaceBetween: 15,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        breakpoints: {
            0: {
                slidesPerView: 1, 
                spaceBetween: 10, 
            },
            768: {
                slidesPerView: 1,
                spaceBetween: 15, 
            },
            1024: {
                slidesPerView: 3, 
                spaceBetween: 20,
            }
        },
        navigation: {
            nextEl: '.testimonial-right',
            prevEl: '.testimonial-left'
        },
    });

});

