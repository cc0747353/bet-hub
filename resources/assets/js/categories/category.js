document.addEventListener('turbo:load', loadCategory)

function loadCategory () {
    iconPicker('#categoryIconPicker')
    iconPicker('#editCategoryIconPicker')
    if (!$('#addCategoryModalBtn').length && !$('#editCategoryForm').length) {
        return
    }
}

listenHiddenBsModal('#addCategoryModal', function (e) {
    $('#addCategoryForm')[0].reset()
    $('#iconValue').val('')
    $('.iconpicker-popover a').removeClass('bg-primary').removeClass('iconpicker-selected')
    livewire.emit('refresh')
})

listenClick('#addCategoryModalBtn', function () {
    $('#addCategoryModal').modal('show').appendTo('body')
})

listenSubmit('#addCategoryForm', function (e) {
    e.preventDefault()
    if (!$('a.iconpicker-selected').length) {
        displayErrorMessage('Please enter valid icon')
        return false
    }
    $('#categoryAddBtn').prop('disabled', true)
    $.ajax({
        url: route('categories.store'),
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                livewire.emit('refresh')
                $('#addCategoryModal').modal('hide')
                $('#categoryAddBtn').prop('disabled', false)
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('#categoryAddBtn').prop('disabled', false)
        },
    })
})

listenClick('.category-edit-btn', function (event) {
    let editCategoryId = $(event.currentTarget).attr('data-id')
    renderData(editCategoryId)
})

function renderData (id) {
    $.ajax({
        url: route('categories.edit', id),
        type: 'GET',
        success: function (result) {
            let category = result.data
            $('#categoryId').val(category.id)
            $('#editCategoryName').val(category.name)
            $('#editCategoryIconPicker').val(category.icon)
            $('.iconpicker-popover a').removeClass('bg-primary').removeClass('iconpicker-selected')
            $('#editCategoryModal .iconpicker-item[title=".'+ category.icon +'"]').addClass('iconpicker-selected bg-primary')
            if (category.status == 1) {
                $('#editCategoryStatus').prop('checked', true)
            } else {
                $('#editCategoryStatus').prop('checked', false)
            }
            $('#editCategoryModal').modal('show')
        },
    })
}

listenSubmit('#editCategoryForm', function (event) {
    event.preventDefault()
    
    if (!$('a.iconpicker-selected').length) {
        displayErrorMessage('Please enter valid icon')
        return false
    }
    
    $('#editCategoryFormBtn').prop('disabled', true)
    let categoryId = $('#categoryId').val()
    $.ajax({
        url: route('categories.update', categoryId),
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                $('#editCategoryModal').modal('hide')
                Livewire.emit('refresh')
                $('#editCategoryFormBtn').prop('disabled', false)
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('#editCategoryFormBtn').prop('disabled', false)
        },
    })
})

listenClick('.category-change-status', function (event) {
    let categoryID = $(event.currentTarget).attr('data-id')
    $.ajax({
        type: 'PUT',
        url: route('categories.change.status', categoryID),
        success: function (result) {
            livewire.emit('refresh')
            displaySuccessMessage(result.message)
        },
    })
})

listenClick('.category-delete-btn', function (event) {
    let recordId = $(event.currentTarget).attr('data-id')
    deleteItem(route('categories.destroy', recordId), 'Category')
})
