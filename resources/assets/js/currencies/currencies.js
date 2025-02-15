listenClick('#createCurrency', function () {
    $('#createCurrencyModal').modal('show').appendTo('body')
})

listenHiddenBsModal('#createCurrencyModal', function (e) {
    $('#createCurrencyForm')[0].reset()
    livewire.emit('refresh')
})

listenClick('.currencies-edit-btn', function (event) {
    let editCurrencyId = $(event.currentTarget).attr('data-id')
    renderData(editCurrencyId)
})

function renderData (id) {
    $.ajax({
        url: route('currencies.edit', id),
        type: 'GET',
        success: function (result) {
            $('#currencyID').val(result.data.id)
            $('#editCurrency_Name').val(result.data.currency_name)
            $('#editCurrency_Icon').val(result.data.currency_icon)
            $('#editCurrency_Code').val(result.data.currency_code)

            $('#editCurrencyModal').modal('show')
        },
    })
}

listenSubmit('#createCurrencyForm', function (e) {
    e.preventDefault()
    $.ajax({
        url: route('currencies.store'),
        type: 'POST',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                $('#createCurrencyModal').modal('hide')
                livewire.emit('refresh')
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
        },
    })
})

listenSubmit('#editCurrencyForm', function (e) {
    e.preventDefault()
    let updateCurrencyId = $('#currencyID').val()
    $.ajax({
        url: route('currencies.update', updateCurrencyId),
        type: 'PUT',
        data: $(this).serialize(),
        success: function (result) {
            $('#editCurrencyModal').modal('hide')
            displaySuccessMessage(result.message)
            livewire.emit('refresh')
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
        },
        complete: function () {
        },
    })
})

listenClick('.currencies-delete-btn', function (event) {
    let recordId = $(event.currentTarget).attr('data-id')
    deleteItem(route('currencies.destroy', recordId), 'Currencies')
})
