document.addEventListener('turbo:load', loaSocialIconData)

function loaSocialIconData () {
    iconPicker('#socialIconPicker')
    iconPicker('#editSocialIconPicker')
    // $('#socialIconPicker').iconpicker()
    // $('#editSocialIconPicker').iconpicker()
}

listenHiddenBsModal('#addSocialIconModal', function (e) {
    $('#addSocialIconForm')[0].reset()
    $('#socialIconPicker').val('')
    $('.iconpicker-popover a').removeClass('bg-primary').removeClass('iconpicker-selected')
    livewire.emit('refresh')
})

listenClick('#addSocialIconModalBtn', function () {
    $('#addSocialIconModal').modal('show').appendTo('body')
})

// listenClick('#socialIconPicker, #editSocialIconPicker', function () {
//     if ($(window).width() <= 576) {
//         $('.popover').
//             css({
//                 'position': 'absolute',
//                 'inset': '0px auto auto 0px',
//                 'margin': '0px',
//                 'transform': 'translate3d(108.5px, 205px, 0px)',
//             })
//         $('.popover-arrow').
//             css({
//                 'position': 'absolute',
//                 'left': '0px',
//                 'transform': 'translate(118px, 0px)',
//             })
//     } else if ($(window).width() <= 768) {
//         $('.popover').
//             css({
//                 'position': 'absolute',
//                 'inset': '0px auto auto 0px',
//                 'margin': '0px',
//                 'transform': 'translate3d(413px, 427px, 0px)',
//             })
//         $('.popover-arrow').
//             css({
//                 'position': 'absolute',
//                 'left': '0px',
//                 'transform': 'translate(118px, 0px)',
//             })
//     } else if ($(window).width() <= 1024) {
//         $('.popover').
//             css({
//                 'position': 'absolute',
//                 'inset': '0px auto auto 0px',
//                 'margin': '0px',
//                 'transform': 'translate3d(532px, 427px, 0px)',
//             })
//         $('.popover-arrow').
//             css({
//                 'position': 'absolute',
//                 'left': '0px',
//                 'transform': 'translate(118px, 0px)',
//             })
//     } else if ($(window).width() <= 1440) {
//         $('.popover').
//             css({
//                 'position': 'absolute',
//                 'inset': '0px auto auto 0px',
//                 'margin': '0px',
//                 'transform': 'translate3d(740px, 427px, 0px)',
//             })
//         $('.popover-arrow').
//             css({
//                 'position': 'absolute',
//                 'left': '0px',
//                 'transform': 'translate(118px, 0px)',
//             })
//     } else if ($(window).width() >= 1440) {
//         $('.popover').
//             css({
//                 'position': 'absolute',
//                 'inset': '0px auto auto 0px',
//                 'margin': '0px',
//                 'transform': 'translate3d(970px, 427px, 0px)',
//             })
//         $('.popover-arrow').
//             css({
//                 'position': 'absolute',
//                 'left': '0px',
//                 'transform': 'translate(118px, 0px)',
//             })
//     }
// })

// listenClick('.btn-icon', function () {
//     let socialIconValue = $(this).val()
//     $('#socialIconValue').attr('value', socialIconValue)
//     $('#editSocialIcon').val(socialIconValue)
// })

listenSubmit('#addSocialIconForm', function (e) {
    e.preventDefault()

    if (!$('a.iconpicker-selected').length) {
        displayErrorMessage('Please enter valid icon')
        return false
    }

    $('#socialIconAddBtn').prop('disabled', true)
    $.ajax({
        url: route('social-icon.store'),
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                livewire.emit('refresh')
                $('#addSocialIconModal').modal('hide')
                $('#socialIconAddBtn').prop('disabled', false)
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('#socialIconAddBtn').prop('disabled', false)
        },
    })
})

listenClick('.social-icon-edit-btn', function (event) {
    let editSocialIconId = $(event.currentTarget).attr('data-id')
    renderData(editSocialIconId)
})

function renderData (id) {
    $.ajax({
        url: route('social-icon.edit', id),
        type: 'GET',
        success: function (result) {
            let social_icon = result.data
            $('#socialIconId').val(social_icon.id)
            $('#editTitle').val(social_icon.title)
            $('#editSocialIconPicker').val(social_icon.icon)
            $('.iconpicker-popover a').removeClass('bg-primary').removeClass('iconpicker-selected')
            $('#editSocialIconModal .iconpicker-item[title=".'+ social_icon.icon +'"]').addClass('iconpicker-selected bg-primary')
            $('#editUrl').val(social_icon.url)
            $('#editSocialIconModal').modal('show')
        },
    })
}

listenSubmit('#editSocialIconForm', function (event) {
    event.preventDefault()

    if (!$('a.iconpicker-selected').length) {
        displayErrorMessage('Please enter valid icon')
        return false
    }

    $('#editLeagueFormBtn').prop('disabled', true)
    let socialIconId = $('#socialIconId').val()
    $.ajax({
        url: route('social-icon.update', socialIconId),
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                $('#editSocialIconModal').modal('hide')
                Livewire.emit('refresh')
                $('#editSocialIconFormBtn').prop('disabled', false)
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('#editSocialIconFormBtn').prop('disabled', false)
        },
    })
})

listenClick('.social-icon-delete-btn', function (event) {
    let recordId = $(event.currentTarget).attr('data-id')
    deleteItem(route('social-icon.destroy', recordId), 'Social Icon')
})
