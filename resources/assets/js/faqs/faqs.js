document.addEventListener('turbo:load', loadFaqsData)

function loadFaqsData () {

}

listenHiddenBsModal('#addFaqModal', function (e) {
    $('#addFaqForm')[0].reset()
    livewire.emit('refresh')
})

listenClick('#addFaqModalBtn', function () {
    $('#addFaqModal').modal('show').appendTo('body')
})

listenSubmit('#addFaqForm', function (e) {
    e.preventDefault()
    $('#faqAddBtn').prop('disabled', true)
    $.ajax({
        url: route('faqs.store'),
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                livewire.emit('refresh')
                $('#addFaqModal').modal('hide')
                $('#faqAddBtn').prop('disabled', false)
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('#faqAddBtn').prop('disabled', false)
        },
    })
})

listenClick('.faq-edit-btn', function (event) {
    let editFaqId = $(event.currentTarget).attr('data-id')
    renderFaqData(editFaqId)
})

function renderFaqData (editFaqId) {
    $.ajax({
        url: route('faqs.edit', editFaqId),
        type: 'GET',
        success: function (result) {
            let faq = result.data
            $('#faqId').val(faq.id)
            $('#editFaqQuestion').val(faq.question)
            $('#editFaqAnswer').val(faq.answer)
            if (faq.status == 1) {
                $('#editFaqStatus').prop('checked', true)
            } else {
                $('#editFaqStatus').prop('checked', false)
            }
            $('#editFaqModal').modal('show')
        },
    })
}

listenSubmit('#editFaqForm', function (event) {
    event.preventDefault()
    $('#editFaqFormBtn').prop('disabled', true)
    let faqId = $('#faqId').val()
    $.ajax({
        url: route('faqs.update', faqId),
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                $('#editFaqModal').modal('hide')
                Livewire.emit('refresh')
                $('#editFaqFormBtn').prop('disabled', false)
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('#editFaqFormBtn').prop('disabled', false)
        },
    })
})

listenClick('.faq-change-status', function (event) {
    let faqId = $(event.currentTarget).attr('data-id')
    $.ajax({
        type: 'PUT',
        url: route('faqs.change-status', faqId),
        success: function (result) {
            livewire.emit('refresh')
            displaySuccessMessage(result.message)
        },
    })
})

listenClick('.faq-delete-btn', function (event) {
    let recordId = $(event.currentTarget).attr('data-id')
    deleteItem(route('faqs.destroy', recordId), 'FAQ')
})
