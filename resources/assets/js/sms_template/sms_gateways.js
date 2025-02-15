document.addEventListener('turbo:load', loadSmsGatewaysData)

function loadSmsGatewaysData () {

    if ($('#sendSmsMethod option:selected').val() == 1) {
        $('.nexmo, .nexmoSmsTest').removeClass('d-none')
        $('#nexmoApiKey').prop('required', true)
        $('#nexmoApiSecret').prop('required', true)

        $('#accountSid').prop('required', false)
        $('#authToken').prop('required', false)
        $('#fromNumber').prop('required', false)
    }
    if ($('#sendSmsMethod option:selected').val() == 2) {
        $('.twilio, .twilioSmsTest').removeClass('d-none')
        $('#accountSid').prop('required', true)
        $('#authToken').prop('required', true)
        $('#fromNumber').prop('required', true)

        $('#nexmoApiKey').prop('required', false)
        $('#nexmoApiSecret').prop('required', false)
    }

}

listenChange('#sendSmsMethod', function () {

    let sendEmailMethod = $('#sendSmsMethod option:selected').val()

    if (sendEmailMethod == 1) {
        $('.nexmo').removeClass('d-none')
        $('.twilio').addClass('d-none')
        $('#nexmoApiKey').prop('required', true)
        $('#nexmoApiSecret').prop('required', true)

        $('#accountSid').prop('required', false)
        $('#authToken').prop('required', false)
        $('#fromNumber').prop('required', false)
    }
    if (sendEmailMethod == 2) {
        $('.twilio').removeClass('d-none')
        $('.nexmo').addClass('d-none')
        $('#accountSid').prop('required', true)
        $('#authToken').prop('required', true)
        $('#fromNumber').prop('required', true)

        $('#nexmoApiKey').prop('required', false)
        $('#nexmoApiSecret').prop('required', false)
    }
})

listenHiddenBsModal('#sendTestMessageModel', function (e) {
    $('#sendTestMessageForm')[0].reset()
    if ($('#sendTestMessageFormTwilio').length){
        $('#sendTestMessageFormTwilio')[0].reset()
    }
    livewire.emit('refresh')
})

listenClick('.sendTestSmsBtn', function () {
    $('#sendTestMessageModel').modal('show').appendTo('body')
})

listenSubmit('#sendTestMessageForm', function (e) {
    e.preventDefault()
    if ($.trim($('#phoneNumber').val()) == '' || $('#error-msg').text() !==
        '') {
        displayErrorMessage('Please Enter Valid Phone number')
        return false
    }

    $('#sendTestMessageForm')[0].submit()
})

listenSubmit('#editSmsGatewaysForm', function (e) {
    e.preventDefault()
    let sendEmailMethod = $('#sendSmsMethod option:selected').val()

    if (sendEmailMethod == 1) {
        if ($.trim($('#nexmoApiKey').val()) == '') {
            displayErrorMessage('API key is required.')
            return false
        }
        if ($.trim($('#nexmoApiSecret').val()) == '') {
            displayErrorMessage('API secret is required.')
            return false
        }
    }
    if (sendEmailMethod == 2) {
        if ($.trim($('#accountSid').val()) == '') {
            displayErrorMessage('Account SID is required.')
            return false
        }
        if ($.trim($('#authToken').val()) == '') {
            displayErrorMessage('Auth Token is required.')
            return false
        }
        if ($.trim($('#fromNumber').val()) == '') {
            displayErrorMessage('From Number is required.')
            return false
        }
    }
    $(this)[0].submit()
})
