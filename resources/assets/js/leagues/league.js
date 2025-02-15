document.addEventListener('turbo:load', loadLeague)

function loadLeague () {
    iconPicker('#leagueIconPicker')
    iconPicker('#editLeagueIconPicker')
}

listenShownBsModal('#addLeagueModal', function () {
    $('#categoryDropdown').select2({
        dropdownParent: '#addLeagueModal',
    })
})

listenShownBsModal('#editLeagueModal', function () {
    $('#editCategoryDropdown').select2({
        dropdownParent: '#editLeagueModal',
    })
})

listenHiddenBsModal('#addLeagueModal', function (e) {
    $('#addLeagueForm')[0].reset()
    $('#iconValue').val('')
    $('.iconpicker-popover a').
        removeClass('bg-primary').
        removeClass('iconpicker-selected')
    livewire.emit('refresh')
    if ($('#categoryDropdown').hasClass('select2-hidden-accessible')) {
        $('.select2-container').remove()
    }
})

listenHiddenBsModal('#editLeagueModal', function (e) {
    livewire.emit('refresh')
    if ($('#editCategoryDropdown').hasClass('select2-hidden-accessible')) {
        $('.select2-container').remove()
    }
})

listenClick('#addLeagueModalBtn', function () {
    $('#addLeagueModal').modal('show').appendTo('body')
})

listenSubmit('#addLeagueForm', function (e) {
    e.preventDefault()

    if (!$('a.iconpicker-selected').length) {
        displayErrorMessage('Please enter valid icon')
        return false
    }

    $('#leagueAddBtn').prop('disabled', true)
    $.ajax({
        url: route('leagues.store'),
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                livewire.emit('refresh')
                $('#addLeagueModal').modal('hide')
                $('#leagueAddBtn').prop('disabled', false)
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('#leagueAddBtn').prop('disabled', false)
        },
    })
})

listenClick('.league-edit-btn', function (event) {
    let editLeagueId = $(event.currentTarget).attr('data-id')
    renderData(editLeagueId)
})

function renderData (id) {
    $.ajax({
        url: route('leagues.edit', id),
        type: 'GET',
        success: function (result) {
            let league = result.data
            $('#leagueId').val(league.id)
            $('#editLeagueName').val(league.name)
            $('#editLeagueIconPicker').val(league.icon)
            $('.iconpicker-popover a').
                removeClass('bg-primary').
                removeClass('iconpicker-selected')
            $('#editLeagueModal .iconpicker-item[title=".' + league.icon +
                '"]').addClass('iconpicker-selected bg-primary')
            if (league.category_id) {
                $('#editCategoryDropdown').
                    val(league.category_id).
                    trigger('change')
            }
            if (league.status == 1) {
                $('#editLeagueStatus').prop('checked', true)
            } else {
                $('#editLeagueStatus').prop('checked', false)
            }
            $('#editLeagueModal').modal('show')
        },
    })
}

listenSubmit('#editLeagueForm', function (event) {
    event.preventDefault()

    if (!$('a.iconpicker-selected').length) {
        displayErrorMessage('Please enter valid icon')
        return false
    }

    $('#editLeagueFormBtn').prop('disabled', true)
    let categoryId = $('#leagueId').val()
    $.ajax({
        url: route('leagues.update', categoryId),
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                $('#editLeagueModal').modal('hide')
                Livewire.emit('refresh')
                $('#editLeagueFormBtn').prop('disabled', false)
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('#editLeagueFormBtn').prop('disabled', false)
        },
    })
})

listenClick('.league-change-status', function (event) {
    let categoryID = $(event.currentTarget).attr('data-id')
    $.ajax({
        type: 'PUT',
        url: route('leagues.change.status', categoryID),
        success: function (result) {
            livewire.emit('refresh')
            displaySuccessMessage(result.message)
        },
    })
})

listenClick('.league-delete-btn', function (event) {
    let recordId = $(event.currentTarget).attr('data-id')
    deleteItem(route('leagues.destroy', recordId), 'League')
})
