document.addEventListener('turbo:load', loadPhoneNumberCountryCodeData);

function loadPhoneNumberCountryCodeData() {
    loadPhoneNumberCountryCode()
    userCreateForm()
    editUserForm()
    vcardEditForm()
    createSetting()
    setEditCountryId()
}

function loadPhoneNumberCountryCode() {

    if (!$('#phoneNumber').length) {
        return false
    }

    let input = document.querySelector('#phoneNumber'),
        errorMsg = document.querySelector('#error-msg'),
        validMsg = document.querySelector('#valid-msg')

    let errorMap = [
        Lang.get('messages.invalid_number'),
        Lang.get('messages.invalid_country_number'),
        Lang.get('messages.too_short'),
        Lang.get('messages.too_long'),
        Lang.get('messages.invalid_number')]

    // initialise plugin
    let intl = window.intlTelInput(input, {
        initialCountry: defaultCountryCodeValue,
        separateDialCode: true,
        geoIpLookup: function (success, failure) {
            $.get('https://ipinfo.io', function () {
            }, 'jsonp').always(function (resp) {
                var countryCode =
                    (resp && resp.country)
                        ? resp.country
                        : ''
                success(countryCode)
            })
        },
        utilsScript: '../../public/assets/js/inttel/js/utils.min.js',
    })

    let reset = function () {
        input.classList.remove('error')
        errorMsg.innerHTML = ''
        errorMsg.classList.add('d-none')
        validMsg.classList.add('d-none')
    }

    input.addEventListener('blur', function () {
        reset()
        if (input.value.trim()) {
            if (intl.isValidNumber()) {
                validMsg.classList.remove('d-none')
            } else {
                input.classList.add('error')
                var errorCode = intl.getValidationError()
                errorMsg.innerHTML = errorMap[errorCode]
                errorMsg.classList.remove('d-none')
            }
        }
    })

    // on keyup / change flag: reset
    input.addEventListener('change', reset)
    input.addEventListener('keyup', reset)

    if (typeof phoneNo != 'undefined' && phoneNo !== '') {
        setTimeout(function () {
            $('#phoneNumber').trigger('change')
        }, 500)
    }

    $('#phoneNumber').on('blur keyup change countrychange', function () {
        if (typeof phoneNo != 'undefined' && phoneNo !== '') {
            intl.setNumber('+' + phoneNo)
            phoneNo = ''
        }
        let getCode = intl.selectedCountryData['dialCode']
        $('#prefix_code').val(getCode)
    })

    let getCode = intl.selectedCountryData['dialCode']
    $('#prefix_code').val(getCode)

    let getPhoneNumber = $('#phoneNumber').val()
    let removeSpacePhoneNumber = getPhoneNumber.replace(/\s/g, '')
    $('#phoneNumber').val(removeSpacePhoneNumber)

    $('#phoneNumber').focus();
    $('#phoneNumber').trigger('blur');

}
$(document).on('click', '.iti__country', function (){
    let flagClass = $('.iti__selected-flag>.iti__flag').attr('class')
    flagClass = flagClass.split(/\s+/)[1]
    let dialCodeVal = $('.iti__selected-dial-code').text()
    window.localStorage.setItem('flagClassLocal', flagClass)
    window.localStorage.setItem('dialCodeValLocal', dialCodeVal)
})

function userCreateForm() {
    if (!$('#userCreateForm').length) {
        return false
    }

    $('#userCreateForm').submit(function () {
        if ($('#error-msg').text() !== '') {
            $('#phoneNumber').focus()
            displayErrorMessage(`Contact number is ` + $('#error-msg').text())
            return false
        }
    })
}

function vcardEditForm() {
    if (!$('#editForm').length) {
        return false
    }

    $('#editForm').submit(function () {
        if ($('#error-msg').text() !== '') {
            $('#phoneNumber').focus()
            return false
        }
    })
}

function createSetting() {
    if (!$('#createSetting').length) {
        return false
    }

    $('#createSetting').submit(function () {
        if ($('#error-msg').text() !== '') {
            $('#phoneNumber').focus()
            return false
        }
    })
}

function editUserForm() {
    if (!$('#editUserForm').length) {
        return false
    }

    $('#editUserForm').submit(function () {
        if ($('#error-msg').text() !== '') {
            $('#phoneNumber').focus()
            displayErrorMessage(`Contact number is ` + $('#error-msg').text())
            return false
        }
    })
}

function setEditCountryId() {
    if ($('#countryId').val()) {
        $('#countryId').val($('#countryId').val()).trigger('change');
    }
}
