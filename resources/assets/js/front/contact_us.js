listenSubmit('#contactUsForm', function (event) {
    event.preventDefault()

    $.ajax({
        url: route('contact-us.store'),
        type: 'POST',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                $('#contactUsForm')[0].reset()
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
        },
    })
})
