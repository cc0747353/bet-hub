document.addEventListener('turbo:load', loadWithdrawTransaction)

function loadWithdrawTransaction () {
    
}
listenChange('#withdrawMethod', function () {
    if ($('#withdrawMethod').val() == 1) {
        $('.confirmEmail').addClass('d-none');
        $('#confirmEmail').prop('required',false);
    }
    if ($('#withdrawMethod').val() == 2) {
        $('.confirmEmail').removeClass('d-none');
        $('#confirmEmail').prop('required',true);
    }
})

listenHiddenBsModal('#withdrawRequestModal', function (e) {
    $('#withdrawRequestForm')[0].reset()
    livewire.emit('refresh')
})

listenHiddenBsModal('#adminWithdrawRequestModal', function (e) {
    $('#adminWithdrawRequestForm')[0].reset()
    livewire.emit('refresh')
})

listenHiddenBsModal('#adminWithdrawRejectRequestModal', function (e) {
    $('#adminWithdrawRejectRequestForm')[0].reset()
    livewire.emit('refresh')
})

listenClick('.withdrawRequestBtn', function () {
    $('#withdrawRequestModal').modal('show').appendTo('body')
    $('#withdrawMethod').select2({
        dropdownParent: '#withdrawRequestModal'
    });
})


listenSubmit('#withdrawRequestForm', function (e) {
    e.preventDefault()
    $('#withdrawRequestAddBtn').prop('disabled', true)
    $.ajax({
        url: route('user.withdraw-request.store'),
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                livewire.emit('refresh')
                $('#withdrawRequestModal').modal('hide')
                $('#withdrawRequestAddBtn').prop('disabled', false)
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('#withdrawRequestAddBtn').prop('disabled', false)
        },
    })
})

listenClick('.withdraw-request-btn' , function(){
    $('.withdrawRequestId').val($(this).attr('data-id'));
    $('#adminWithdrawRequestModal').modal('show')
})

listenClick('.withdraw-request-reject-btn' , function(){
    $('.withdrawRequestId').val($(this).attr('data-id'));
    $('#adminWithdrawRejectRequestModal').modal('show')
})

listenClick('#approveWithdrawRequestBtn' , function(){
    if ($('#acceptNotes').val().trim() == '')
    {
        displayErrorMessage('Notes field is required.')
        return false
    }
    $.ajax({
        url: route('admin.withdraw_request_update'),
        type: 'POST',
        data:  new FormData($('#adminWithdrawRequestForm')[0]),
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                livewire.emit('refresh')
                $('#adminWithdrawRequestModal').modal('hide')
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('.withdrawRequestBtn').prop('disabled', false)
        },
    })
})

listenClick('#rejectWithdrawRequestBtn' , function(){
    if ($('#rejectNotes').val().trim() == '')
    {
        displayErrorMessage('Notes field is required.')
        return false
    }
    $.ajax({
        url: route('admin.withdraw_request_update'),
        type: 'POST',
        data:  new FormData($('#adminWithdrawRejectRequestForm')[0]),
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                livewire.emit('refresh')
                $('#adminWithdrawRejectRequestModal').modal('hide')
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('.withdrawRequestBtn').prop('disabled', false)
        },
    })
})
