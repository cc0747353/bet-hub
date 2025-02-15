listenHiddenBsModal('#addBetModal', function (e) {
    $('#addBetForm')[0].reset()
    $('#betModalLabel,#betModalQuestion,#betModalOption,#totalAmount,#userBalance').empty()
})

listenClick('#questionLockedBtn', function () {
    displayErrorMessage('You can not bet on this question.')
});
listenClick('#addBetModalBtn', function () {
    let matchTitle = $(this).attr('data-title')
    let question = $(this).attr('data-question')
    let option = $(this).attr('data-option')
    let match_id = $(this).attr('data-match_id')
    let question_id = $(this).attr('data-question_id')
    let option_id = $(this).attr('data-option_id')
    let divisor = $(this).attr('data-divisor')
    let user_balance = $('#userTotalBalance').val()
    let auth = $(this).attr('data-auth')

    $('#betModalLabel').append(matchTitle)
    $('#betModalQuestion').append(question)
    $('#betModalOption').append(option)
    $('#matchId').val(match_id)
    $('#questionId').val(question_id)
    $('#optionId').val(option_id)
    $('#divisorData').val(divisor)
    $('#userBalance').append(user_balance)

    if(isEmpty(auth)){
        $('#loginModal').modal('show').appendTo('body')
    }else {
        $('#addBetModal').modal('show').appendTo('body')
    }

    $('#totalAmount').html('0')
})

listenKeyup('#amount', function () {
    let amount = $(this).val()
    let divisor = $('#divisorData').val()

    let totalAmount = parseFloat(amount) * divisor
    $('#totalAmount').html(totalAmount)
    $('#totalAmount').css({ 'font-size':'larger', 'color':'blue'})
})

listenSubmit('#addBetForm', function (e) {
    e.preventDefault()
    let match_id = $('#matchId').val()
    let question_id = $('#questionId').val()
    let option_id = $('#optionId').val()
    let amount = parseFloat($('#amount').val())
    let win_amount = parseFloat($('#totalAmount').html())

    let minBet = $('#minBet').val()
    let maxBet = $('#maxBet').val()

    if (amount < minBet || amount > maxBet)
    {
        displayErrorMessage('The amount should be between ' + minBet + ' to ' + maxBet)
        return false
    }

    $('#betAddBtn').prop('disabled', true)
    $.ajax({
        url: route('bet.store'),
        type: 'POST',
        data: {
            'match_id': match_id,
            'question_id': question_id,
            'option_id': option_id,
            'amount': amount,
            'win_amount': win_amount,
        },
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                $('#addBetModal').modal('hide')
                $('#userTotalBalance').val(parseInt($('#userTotalBalance').val()) - amount)
                $('#betAddBtn').prop('disabled', false)
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('#betAddBtn').prop('disabled', false)
        },
    })
})
