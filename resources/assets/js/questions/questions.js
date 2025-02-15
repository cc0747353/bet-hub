document.addEventListener('turbo:load', loadQuestions)

function loadQuestions () {

}

listenHiddenBsModal('#addQuestionModal', function () {
    $('#addQuestionForm')[0].reset()
    livewire.emit('refresh')
})

listenClick('#addQuestionModalBtn', function () {
    $('#addQuestionModal').modal('show').appendTo('body')
})

listenSubmit('#addQuestionForm', function (e) {
    e.preventDefault()
    $('#matchAddBtn').prop('disabled', true)
    $.ajax({
        url: route('question.store'),
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                livewire.emit('refresh')
                $('#addQuestionModal').modal('hide')
                $('#questionAddBtn').prop('disabled', false)
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('#questionAddBtn').prop('disabled', false)
        },
    })
})

listenClick('.question-edit-btn', function (event) {
    let editQuestionId = $(event.currentTarget).attr('data-id')
    renderQuestionData(editQuestionId)
})

function renderQuestionData (id) {
    $.ajax({
        url: route('question.edit', id),
        type: 'GET',
        success: function (result) {
            let questionData = result.data
            $('#questionId').val(questionData.id)
            $('#editQuestion').val(questionData.question)
            if (questionData.status == 1) {
                $('#editQuestionStatus').prop('checked', true)
            } else {
                $('#editQuestionStatus').prop('checked', false)
            }

            if (questionData.is_locked == 1) {
                $('#editLockedStatus').prop('checked', true)
            } else {
                $('#editLockedStatus').prop('checked', false)
            }

            $('#editQuestionModal').modal('show')
        },
    })
}

listenSubmit('#editQuestionForm', function (event) {
    event.preventDefault()
    $('#editQuestionFormBtn').prop('disabled', true)
    let questionId = $('#questionId').val()
    $.ajax({
        url: route('question.update', questionId),
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                $('#editQuestionModal').modal('hide')
                Livewire.emit('refresh')
                $('#editQuestionFormBtn').prop('disabled', false)
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('#editQuestionFormBtn').prop('disabled', false)
        },
    })
})

listenClick('.question-change-status', function (event) {
    let questionID = $(event.currentTarget).attr('data-id')
    $.ajax({
        type: 'PUT',
        url: route('question-status-change', questionID),
        data: { id: questionID },
        success: function (result) {
            livewire.emit('refresh')
            displaySuccessMessage(result.message)
        },
    })
})

listenClick('.question-locked-change-status', function (event) {
    let questionID = $(event.currentTarget).attr('data-id')
    $.ajax({
        type: 'PUT',
        url: route('question-locked-status-change', questionID),
        data: { id: questionID },
        success: function (result) {
            livewire.emit('refresh')
            displaySuccessMessage(result.message)
        },
    })
})

listenClick('.question-delete-btn', function (event) {
    let recordId = $(event.currentTarget).attr('data-id')
    deleteItem(route('question.destroy', recordId), 'Question')
})
