document.addEventListener('turbo:load', loadSettingData)

function loadSettingData () {

    listenChange('#show_captcha', function () {
        if (($(this).prop('checked'))) {
            $('.captchaOptions').removeClass('d-none')
        } else {
            $('.captchaOptions').addClass('d-none')
        }
    })
}
