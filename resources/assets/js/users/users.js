listenClick('.user-delete-btn', function (event) {
    let roleRecordId = $(event.currentTarget).attr('data-id')
    deleteItem(route('users.destroy', roleRecordId), Lang.get('messages.user.user'))
})

var userStatus = 2;
listenClick('.userStatusApply', function () {
    userStatus = $('#userStatus').val()
    window.livewire.emit('changeStatusFilter', userStatus)
})

listenClick('#userStatusResetFilter', function () {
    window.livewire.emit('changeStatusFilter', 2)
    userStatus = 2
})

listenClick('#filterBtn',function (){
    $('#userStatus').val(userStatus).trigger('change')
})

listenClick('#changePassword', function () {
    $('#changePasswordForm')[0].reset()
    $('.pass-check-meter div.flex-grow-1').removeClass('active')
    $('#changePasswordModal').modal('show').appendTo('body')
})

listenHiddenBsModal('#changePasswordModal', function (e) {
    $('#changePasswordForm')[0].reset()
})

listenClick('#passwordChangeBtn', function () {
    $.ajax({
        url: route('user.changePassword'),
        type: 'PUT',
        data: $('#changePasswordForm').serialize(),
        success: function (result) {
            $('#changePasswordModal').modal('hide')
            $('#changePasswordForm')[0].reset()
            displaySuccessMessage(result.message)
            setTimeout(function () {
                location.reload()
            }, 1000)
        },
        error: function error (result) {
            displayErrorMessage(result.responseJSON.message)
        },
    })
})

listenClick('.twoauth-enable', function () {
    $.ajax({
        url: route('user.twofactor.auth.enable'),
        type: 'GET',
        success: function (result) {
            displaySuccessMessage(result.message)
            setTimeout(function () {
                location.reload()
            }, 1000)
        },
        error: function error (result) {
            displayErrorMessage(result.responseJSON.message)
        },
    })
})

listenClick('.twoauth-disable', function () {

    $('#disable2faModal').modal('show').appendTo('body')
})

listenSubmit('#disable2faForm', function (e) {
    e.preventDefault()

    $.ajax({
        url: route('user.twofactor.auth.disable'),
        type: 'POST',
        data: $('#disable2faForm').serialize(),
        success: function (result) {
            displaySuccessMessage(result.message)
            setTimeout(function () {
                location.reload()
            }, 3000)
        },
        error: function error (result) {
            displayErrorMessage(result.responseJSON.message)
        },
    })
})

listenClick('.user-email-verified', function (event) {
    let userID = $(event.currentTarget).attr('data-id')
    $.ajax({
        type: 'PUT',
        url: route('users.email.verified', userID),
        success: function (result) {
            livewire.emit('refresh')
            displaySuccessMessage(result.message)
        },
    })
})
listenClick('.user-status', function (event) {
    let userID = $(event.currentTarget).attr('data-id')
    $.ajax({
        type: 'PUT',
        url: route('users.change.status', userID),
        success: function (result) {
            livewire.emit('refresh')
            displaySuccessMessage(result.message)
        },
    })
})

listenClick('.copy-referral-url', function () {
    let temp = $('<input>')
    let url = $('.url').attr('title')

    $('body').append(temp)
    temp.val(url).select()
    document.execCommand('copy')
    temp.remove()
    displaySuccessMessage('URL copied!')
})

listenChange('#countryId', function () {
    let countryId = $(this).val();
    $.ajax({
        url: route('get-state'),
        type: 'get',
        dataType: 'json',
        data: {
            country_id: countryId,
        },
        success: function (data) {
            $('#stateId').empty()
            if (data.data.length != 0) {
                $.each(data.data, function (i, v) {
                    $('#stateId').
                        append($('<option></option>').attr('value', i).text(v));
                });
            } else {
                $('#stateId').
                    append(
                        $('<option value=""></option>').text(Lang.get('messages.common.select_state')));
            }
            $('#stateId').trigger('change');
        },
    })
})

listenChange('#stateId', function () {
    let stateId = $(this).val();
    let countryId = $('#countryId').val()
    
    $.ajax({
        url: route('get-city'),
        type: 'get',
        dataType: 'json',
        data: {
            state_id: stateId,
            country_id: countryId,
        },
        success: function (data) {
            $('#cityId').empty()
            if (data.data.length != 0) {
                $.each(data.data, function (i, v) {
                    $('#cityId').
                        append($('<option></option>').
                            attr('value', i).
                            text(v));
                });
            } else {
                $('#cityId').
                    append(
                        $('<option value=""></option>').
                            text(Lang.get('messages.common.select_city')));
            }
           
            $('#cityId').trigger('change');
        },
    })
})
