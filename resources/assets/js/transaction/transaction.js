document.addEventListener('turbo:load', loadTransaction)

function loadTransaction () {

}

listenClick('.transaction-statusbar', function (event) {
    let recordId = $(event.currentTarget).attr('data-id')
    let acceptPaymentUserId = currentLoginUserId

    $.ajax({
        type: 'PUT',
        url: route('transaction.status'),
        data: { id: recordId, acceptPaymentUserId: acceptPaymentUserId },
        success: function (result) {

            if (result.success) {
                livewire.emit('refresh')
                displaySuccessMessage(result.message)
            }
        },
        error: function error (result) {
            displayErrorMessage(result.responseJSON.message)
        },
    })
})
