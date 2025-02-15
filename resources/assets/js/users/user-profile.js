listenClick('#changeLanguage', function () {
    $('#changeLanguageModal').modal('show').appendTo('body')
})

listenClick('#languageChangeBtn', function () {
    let language = $('#selectLanguage').val()

    $.ajax({
        url: route('change-language'),
        type: 'POST',
        data: {
            'language': language,
        },
        success: function (result) {
            $('#changeLanguageModal').modal('hide')
            displaySuccessMessage(Lang.get('messages.flash.language_update'))
            setTimeout($.proxy(function () {
                Turbo.visit(window.location.href)
            }, this), 3000)
        },
        error: function error (result) {
            displayErrorMessage(result.responseJSON.message)
        },
    })
})

listenClick('#changeLanguage', function () {
    $('.dropdown-menu').removeClass('show')
    let getLanguageUrl = route('get.all.language')
    $.ajax({
        url: getLanguageUrl,
        type: 'GET',
        success: function (result) {
            if (result.success) {
                Livewire.emit('refresh', 'refresh')
                $('#selectLanguage').empty()
                let options = []
                $.each(result.data.getAllLanguage, function (key, value) {
                    options += '<option value="' + value.iso_code + '">' +
                        value.name +
                        '</option>'
                })
                $('#selectLanguage').html(options)
                $('#selectLanguage').
                    val(result.data.currentLanguage).
                    trigger('change')

                $('#changeLanguageModal').modal('show')
            }
        },
        error: function (result) {
            displayErrorMessage(result.message)
        },
    })
})

