document.addEventListener('turbo:load', initAllFrontComponents)
function initAllFrontComponents () {

    $('li.has-ul').click(function () {
        $(this).children('.sub-ul').slideToggle(500);
        $(this).toggleClass('active');
        // event.preventDefault();
    });
    
    window.scrollTo(0,0);
    
    window.onscroll = function () {
        headerSetFunction();
    };
    var header = document.getElementById("myHeader");
    var sticky = null;
    if (header){
         sticky = header.offsetTop;
    }
    function headerSetFunction() {
        if (window.pageYOffset > sticky) {
            header.classList.add("fixed");
        } else {
            header.classList.remove("fixed");
        }
    }

    $(".slick-slider").slick({
        slidesToShow: 6,
        infinite: true,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        dots: false,
        arrows: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
        ],
    });

    $(".slick-slider2").slick({
        arrows: true,
        dots: false,
        infinite: true,
        slidesToShow: 3.3,
        slidesToScroll: 1,
        autoplay: true,
        prevArrow:'<button class="slide-arrow prev-arrow"><i class="fs-14 fa-solid fa-arrow-left"></i></button>',
        nextArrow:'<button class="slide-arrow next-arrow"><i class="fs-14 fa-solid fa-arrow-right"></i></button>',
        autoplaySpeed: 2500,
        responsive: [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 1.3,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 575,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    });

    loadCaptchaRegisterPage()
}

listenSubmit('#subscriberForm',function (e) {
    e.preventDefault();
    $.ajax({
        url: route('subscribe.store'),
        type: 'POST',
        data: {email : $('.subscriber-email').val()},
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                $('#subscriberForm').trigger('reset')
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
        },
    })
})

function loadCaptchaRegisterPage(){
    let captchaContainer = document.getElementById('gRecaptchaContainer');

    if (!captchaContainer) {
        return false;
    }

    captchaContainer.innerHTML = ''
    let recaptcha = document.createElement('div')

    // setTimeout(function () {
    grecaptcha.render(recaptcha, {
        'sitekey': siteKey,
    })
    captchaContainer.appendChild(recaptcha)
    // }, 500)
}
