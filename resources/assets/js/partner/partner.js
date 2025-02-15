document.addEventListener('turbo:load', loadPartnerSectionData)

function loadPartnerSectionData () {

    if (!$('#addPartnerModalBtn').length && !$('#editCategoryForm').length) {
        return
    }
}

listenHiddenBsModal('#addPartnerModal', function (e) {
    $('#addPartnerForm')[0].reset()
    $('#partnerInputImage').
        css('background-image', 'url(' + defaultImage + ')')
    livewire.emit('refresh')
})

listenClick('#addPartnerModalBtn', function () {
    $('#addPartnerModal').modal('show').appendTo('body')
})

listenSubmit('#addPartnerForm', function (e) {
    e.preventDefault()
    if ($('#partnerImage').val() == ''){
        displayErrorMessage(Lang.get('validation.required', {'attribute': 'Image'}))
        return false;
    }
    
    $('#partnerAddBtn').prop('disabled', true)
    $.ajax({
        url: route('partner.store'),
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                livewire.emit('refresh')
                $('#addPartnerModal').modal('hide')
                $('#partnerAddBtn').prop('disabled', false)
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('#partnerAddBtn').prop('disabled', false)
        },
    })
})

listenClick('.partner-edit-btn', function (event) {
    let editPartnerId = $(event.currentTarget).attr('data-id')
    renderPartnerData(editPartnerId)
})

function renderPartnerData (id) {
    $.ajax({
        url: route('partner.edit', id),
        type: 'GET',
        success: function (result) {
            let partner = result.data
            $('#partnerId').val(partner.id)
            $('#editPartnerName').val(partner.name)
            $('#editPartnerName').val(partner.name)
            $('#editPartnerImagePreview').
                css('background-image',
                    'url("' + result.data.image + '")')
            $('#editPartnerModal').modal('show')
        },
    })
}

listenSubmit('#editPartnerForm', function (event) {
    event.preventDefault()
    $('#editPartnerFormBtn').prop('disabled', true)
    let partnerId = $('#partnerId').val()
    $.ajax({
        url: route('partner.update', partnerId),
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                $('#editPartnerModal').modal('hide')
                Livewire.emit('refresh')
                $('#editPartnerFormBtn').prop('disabled', false)
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('#editPartnerFormBtn').prop('disabled', false)
        },
    })
})

listenClick('.partner-delete-btn', function (event) {
    let recordId = $(event.currentTarget).attr('data-id')
    deleteItem(route('partner.destroy', recordId), 'Partner')
})
