document.addEventListener('turbo:load', loadBlogData)
let blogQuillData = null
let editBlogQuillData = null

function loadBlogData () {
    
    listen('keyup', '#blogTitle', function () {
        var Text = $.trim($(this).val())
        Text = Text.toLowerCase()
        Text = Text.replace(/[^a-zA-Z0-9]+/g, '-')
        $('#blogSlug').val(Text)
        $('#slugHidden').val(Text)
    })

    if (!$('#addBlogForm').length && !$('#editBlogForm').length) {
        return
    }

    if ($('#editBlogQuillData').length) {
        editBlogQuillData = new Quill(
            '#editBlogQuillData', {
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
                placeholder: 'Description',
                theme: 'snow',
            })
    }

    if ($('#blogQuillData').length) {
        blogQuillData = new Quill(
            '#blogQuillData', {
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

                        [{ 'color': ['rgb(136 136 136)'] }, { 'background': [] }],
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
                placeholder: 'Description',
                theme: 'snow',
            })
    }

    if ($('#editBlogForm').length && editBlogQuillData) {
        editBlogQuillData.on('text-change', function (delta, oldDelta, source) {
            if (editBlogQuillData.getText().trim().length === 0) {
                editBlogQuillData.setContents([{ insert: '' }])
            }
        })
    }

    if ($('#addBlogForm').length && blogQuillData) {
        blogQuillData.on('text-change', function (delta, oldDelta, source) {
            if (blogQuillData.getText().trim().length === 0) {
                blogQuillData.setContents([{ insert: '' }])
            }
        })
    }
}

if ($('#editBlogForm').length && editBlogQuillData) {
    let element = document.createElement('textarea')
    element.innerHTML = JSON.parse($('#editBlogBody').val())
    editBlogQuillData.root.innerHTML = element.value
}

listenSubmit('#editBlogForm', (e) => {
    let blogEditorContent = editBlogQuillData.root.innerHTML
    if (editBlogQuillData.getText().trim().length === 0) {
        displayErrorMessage('Description field is required.')
        return false
    }

    $('#editBlogDescription').val(blogEditorContent)
})

listenSubmit('#addBlogForm', (e) => {

    let blogEditorContent = blogQuillData.root.innerHTML
    if (blogQuillData.getText().trim().length === 0) {
        displayErrorMessage('Description field is required.')
        return false
    }

    $('#blogDescription').val(blogEditorContent)
})

listenClick('.blog-delete-btn', function (event) {
    let blogID = $(event.currentTarget).attr('data-id')
    deleteItem(route('blog.destroy', blogID), 'Blog')
})

