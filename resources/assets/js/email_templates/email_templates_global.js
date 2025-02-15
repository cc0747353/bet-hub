document.addEventListener('turbo:load', loadEmailTemplatesGlobalData)

function loadEmailTemplatesGlobalData () {
    if (!$('#editEmailTemplateGlobalForm').length) {
        return
    }

    let emailTemplateGlobalBodyQuill = new Quill(
        '#emailTemplateGlobalBodyQuillData', {
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
    emailTemplateGlobalBodyQuill.on('text-change',
        function (delta, oldDelta, source) {

            if (emailTemplateGlobalBodyQuill.getText().trim().length === 0) {
                emailTemplateGlobalBodyQuill.setContents([{ insert: '' }])
            }
        })

    let element = document.createElement('textarea')
    element.innerHTML = JSON.parse($('#editEmailBody').val())
    emailTemplateGlobalBodyQuill.root.innerHTML = element.value

    listenSubmit('#editEmailTemplateGlobalForm', function () {
        let element = document.createElement('textarea')
        let editor_content_1 = emailTemplateGlobalBodyQuill.root.innerHTML
        element.innerHTML = editor_content_1

        let input = JSON.stringify(editor_content_1)
        $('#editTemplateGlobalDescription').val(input.replace(/"/g, ''))
    })
}
