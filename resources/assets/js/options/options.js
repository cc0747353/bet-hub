document.addEventListener('turbo:load', loadOptions)

function loadOptions () {

}

listenHiddenBsModal('#addOptionsModal', function () {
    $('#addOptionForm')[0].reset()
    livewire.emit('refresh')
})

listenClick('#addOptionModalBtn', function () {
    $('#addOptionsModal').modal('show').appendTo('body')
})

listenSubmit('#addOptionForm', function (e) {
    e.preventDefault()
    $('#optionAddBtn').prop('disabled', true)
    $.ajax({
        url: route('option.store'),
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                livewire.emit('refresh')
                $('#addOptionsModal').modal('hide')
                $('#optionAddBtn').prop('disabled', false)
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('#optionAddBtn').prop('disabled', false)
        },
    })
})

listenClick('.option-edit-btn', function (event) {
    let editOptionId = $(event.currentTarget).attr('data-id')
    renderOptionData(editOptionId)
})

function renderOptionData (id) {
    $.ajax({
        url: route('option.edit', id),
        type: 'GET',
        success: function (result) {
            let optionData = result.data
            $('#optionId').val(optionData.id)
            $('#editOptionName').val(optionData.name)
            $('#editOptionDividend').val(optionData.dividend)
            $('#editOptionDivisor').val(optionData.divisor)
            if (optionData.status == 1) {
                $('#editOptionStatus').prop('checked', true)
            } else {
                $('#editOptionStatus').prop('checked', false)
            }
            $('#editOptionModal').modal('show')
        },
    })
}

listenSubmit('#editOptionForm', function (event) {
    event.preventDefault()
    $('#editOptionFormBtn').prop('disabled', true)
    let optionId = $('#optionId').val()
    $.ajax({
        url: route('option.update', optionId),
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                $('#editOptionModal').modal('hide')
                Livewire.emit('refresh')
                $('#editOptionFormBtn').prop('disabled', false)
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('#editOptionFormBtn').prop('disabled', false)
        },
    })
})

listenClick('.back-btn', function (e) {
    e.preventDefault()
    window.history.back()
})

listenClick('.option-change-status', function (event) {
    let optionId = $(event.currentTarget).attr('data-id')
    let questionId = $(event.currentTarget).data('question-id')
    $.ajax({
        type: 'PUT',
        url: route('option-status-change', { 'id': questionId , 'option':optionId}),
        data: { id: optionId },
        success: function (result) {
            livewire.emit('refresh')
            displaySuccessMessage(result.message)
        },
    })
})

listenClick('.option-make-win-btn', function (event) {
    let recordId = $(event.currentTarget).attr('data-id')
    event.preventDefault()

    swal({
        title: `Are you sure you want to declare this option as winner?`,
        icon: 'warning',
        buttons: {
            confirm: Lang.get('messages.common.yes'),
            cancel: Lang.get('messages.common.no'),
        },
        dangerMode: true,

    }).then((result) => {
        if (result) {
            makeWin(recordId)
        }
    });
})

function makeWin (recordId) {
    $.ajax({
        url: route('make-win'),
        type: 'POST',
        data: {'recordId' : recordId},
        success: function (obj) {
            if (obj.success) {
                livewire.emit('refresh')
            }
            swal({
                icon: 'success',
                title: 'Winner',
                text: 'Make winner successfully',
                timer: 2000,
            })
            if (callFunction) {
                eval(callFunction);
            }
        },
        error: function (data) {
            swal({
                title: Lang.get('messages.common.error'),
                icon: 'error',
                text: data.responseJSON.message,
                type: 'error',
                timer: 5000,
            })
        },
    })
}

listenClick('.make-loser-btn', function (event) {
    let questionId = $('.make-loser-btn').attr('data-id');
    event.preventDefault()
    swal({
        title: `Are you sure you want to declare everyone as a loser?`,
        icon: 'warning',
        buttons: {
            confirm: Lang.get('messages.common.yes'),
            cancel: Lang.get('messages.common.no'),
        },
        dangerMode: true,

    }).then((result) => {
        if (result) {
            makeEveryoneLoser(questionId)
        }
    });
})

function makeEveryoneLoser (questionId) {
    $.ajax({
        url: route('make-loser'),
        type: 'POST',
        data: {'questionId' : questionId},
        success: function (obj) {
            if (obj.success) {
                livewire.emit('refresh')
            }
            swal({
                icon: 'success',
                title: 'Loser',
                text: 'Declared everyone as loser successfully',
                timer: 2000,
            })
            if (callFunction) {
                eval(callFunction);
            }
        },
        error: function (data) {
            swal({
                title: Lang.get('messages.common.error'),
                icon: 'error',
                text: data.responseJSON.message,
                type: 'error',
                timer: 5000,
            })
        },
    })
}

listenClick('.give-refund-btn', function (event) {
    let questionId = $('.give-refund-btn').attr('data-id');
    event.preventDefault()
    swal({
        title: `Are you sure you want to give refund to everyone?`,
        icon: 'warning',
        buttons: {
            confirm: Lang.get('messages.common.yes'),
            cancel: Lang.get('messages.common.no'),
        },
        dangerMode: true,

    }).then((result) => {
        if (result) {
            giveRefund(questionId)
        }
    });
});

function giveRefund (questionId) {
    $.ajax({
        url: route('give-refund'),
        type: 'POST',
        data: {'questionId' : questionId},
        success: function (obj) {
            if (obj.success) {
                livewire.emit('refresh')
            }
            swal({
                icon: 'success',
                title: 'Refund',
                text: 'Amount refunded successfully',
                timer: 2000,
            })
            if (callFunction) {
                eval(callFunction);
            }
        },
        error: function (data) {
            swal({
                title: Lang.get('messages.common.error'),
                icon: 'error',
                text: data.responseJSON.message,
                type: 'error',
                timer: 5000,
            })
        },
    })
}
