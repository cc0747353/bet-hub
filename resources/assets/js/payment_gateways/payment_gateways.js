document.addEventListener('turbo:load', loadPaymentGatewaysData)

function loadPaymentGatewaysData () {
    if (isEmpty($('#fixedCharge').val())) {
        $('.fixedDiv').addClass('d-none')
        $('#percentChargeRadio').attr('checked', true)
        $('#percentCharge').prop('required', true)
    } else {
        $('.percentDiv').addClass('d-none')
        $('#fixedChargeRadio').attr('checked', true)
        $('#fixedCharge').prop('required', true)
    }
}

listenClick('#fixedChargeRadio', function () {
    $('.fixedDiv').removeClass('d-none')
    $('.percentDiv').addClass('d-none')
    $('#fixedCharge').prop('required', true)
    $('#percentCharge').prop('required', false)
})

listenClick('#percentChargeRadio', function () {
    $('.percentDiv').removeClass('d-none')
    $('.fixedDiv').addClass('d-none')
    $('#percentCharge').prop('required', true)
    $('#fixedCharge').prop('required', false)
})

listenKeyup($('#percentCharge'), function () {
    if ($('#percentCharge').val() > 100) {
        $('#percentCharge').val(100)
    }
})

listenClick('.paymentGatewaysBtn', function () {
    if ($('input[name=\'charge_type\']:checked').val() == 0) {
        $('#percentCharge').val('')
    } else {
        $('#fixedCharge').val('')
    }
})

listenClick('.paymentGateway-change-status', function (event) {
    let paymentID = $(event.currentTarget).attr('data-id')
    $.ajax({
        type: 'PUT',
        url: route('payment-list.change-status', paymentID),
        success: function (result) {
            livewire.emit('refresh')
            displaySuccessMessage(result.message)
        },
    })
})

listenKeyup('.rangeAmount', function (e){
    if(event.key == "-") {
        $('.rangeAmount').val(1);
    }
});

listenSubmit('#editPaymentGatewaysForm', function (e){
    e.preventDefault()
    if($('.rangeAmount:first').val() > $('.rangeAmount:last').val()){
        displayErrorMessage('Please Enter Valid Amount Range.')
        return false;
    }
    var result = true
    if (!$('#manualPayment').length){
        $('.credentials').each(function(){
            if($.trim($(this).val()) == ''){
                displayErrorMessage('Key and secret fields required')
                result = false
                return false
            }
            return result;
        })
    }
    if(!result){
        return false
    }
    
    $(this)[0].submit()
});
