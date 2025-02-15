document.addEventListener('turbo:load', loadSmsTemplatesData)

function loadSmsTemplatesData () {

}

listenClick('.sms-template-status', function (event) {
    let smsTemplateID = $(event.currentTarget).attr('data-id')
    $.ajax({
        type: 'PUT',
        url: route('sms-template.status', smsTemplateID),
        data: { id: smsTemplateID },
        success: function (result) {
            livewire.emit('refresh')
            displaySuccessMessage(result.message)
        },
    })
})

listenClick('.template-delete-btn', function (event) {
    let smsTemplateID = $(event.currentTarget).attr('data-id')
    deleteItem(route('sms-template.destroy', smsTemplateID),
        'SMS Template')
})
