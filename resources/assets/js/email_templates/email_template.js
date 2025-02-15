document.addEventListener('turbo:load', loadEmailTemplatesData)
let emailTemplateEditBodyQuill
let emailTemplateAddBodyQuill

function loadEmailTemplatesData () {
    if (!$('#addEmailTemplateForm').length &&
        !$('#editEmailTemplateForm').length) {
        return
    }

    if ($('#editEmailTemplateForm').length) {
        emailTemplateEditBodyQuill = new Quill(
            '#emailTemplateEditBodyQuillData', {
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],

                        [{ 'header': 1 }, { 'header': 2 }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'script': 'sub' }, { 'script': 'super' }],
                        [{ 'indent': '-1' }, { 'indent': '+1' }],
                        [{ 'direction': 'rtl' }],

                        [{ 'size': ['small', false, 'large', 'huge'] }],
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'font': [] }],
                        [{ 'align': [] }],
                        ['link', 'image', 'video'],
                        ['clean'],
                    ],
                    keyboard: {
                        bindings: {
                            tab: 'disabled',
                        },
                    },
                },
                placeholder: 'Enter Body',
                theme: 'snow',
            })
    }

    if ($('#addEmailTemplateForm').length) {
        emailTemplateAddBodyQuill = new Quill(
            '#emailTemplateAddBodyQuillData', {
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],

                        [{ 'header': 1 }, { 'header': 2 }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'script': 'sub' }, { 'script': 'super' }],
                        [{ 'indent': '-1' }, { 'indent': '+1' }],
                        [{ 'direction': 'rtl' }],

                        [{ 'size': ['small', false, 'large', 'huge'] }],
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'font': [] }],
                        [{ 'align': [] }],
                        ['link', 'image', 'video'],
                        ['clean'],
                    ],
                    keyboard: {
                        bindings: {
                            tab: 'disabled',
                        },
                    },
                },
                placeholder: 'Enter Body',
                theme: 'snow',
            })
    }

    if ($('#editEmailTemplateForm').length) {
        emailTemplateEditBodyQuill.on('text-change',
            function (delta, oldDelta, source) {
                if (emailTemplateEditBodyQuill.getText().trim().length === 0) {
                    emailTemplateEditBodyQuill.setContents([{ insert: '' }])
                }
            })
    }

    if ($('#addEmailTemplateForm').length) {
        emailTemplateAddBodyQuill.on('text-change',
            function (delta, oldDelta, source) {
                if (emailTemplateAddBodyQuill.getText().trim().length === 0) {
                    emailTemplateAddBodyQuill.setContents([{ insert: '' }])
                }
            })
    }
}

if ($('#editEmailTemplateForm').length) {
    let element = document.createElement('textarea')
    element.innerHTML = JSON.parse($('#editEmailBody').val())
    emailTemplateEditBodyQuill.root.innerHTML = element.value
}

listenSubmit('#editEmailTemplateForm', (e) => {
    let addEmailTemplateEditorContent = emailTemplateEditBodyQuill.root.innerHTML
    if (emailTemplateEditBodyQuill.getText().trim().length === 0) {
        displayErrorMessage('Message field is required.')
        return false
    }

    $('#editTemplateDescription').val(addEmailTemplateEditorContent)
})

listenSubmit('#addEmailTemplateForm', (e) => {

    let addEmailTemplateEditorContent = emailTemplateAddBodyQuill.root.innerHTML
    if (emailTemplateAddBodyQuill.getText().trim().length === 0) {
        displayErrorMessage('Message field is required.')
        return false
    }

    $('#addTemplateDescription').val(addEmailTemplateEditorContent)
})

listenClick('.email-template-status', function (event) {
    let emailTemplateID = $(event.currentTarget).attr('data-id')

    $.ajax({
        type: 'PUT',
        url: route('email.template.status', emailTemplateID),
        success: function (result) {
            livewire.emit('refresh')
            displaySuccessMessage(result.message)
        },
    })
})

