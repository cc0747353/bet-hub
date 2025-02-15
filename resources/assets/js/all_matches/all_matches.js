import 'flatpickr/dist/l10n'

document.addEventListener('turbo:load', loadAllMatches)

function loadAllMatches () {
    let matchStart = '.match-start'
    let startFrom = '.start-from'
    let endAt = '.end-at'

    if (!$(matchStart).length) {
        return
    }
    if (!$(startFrom).length) {
        return
    }
    if (!$(endAt).length) {
        return
    }
    let lang = $('.currentLanguage').val()
    $(matchStart).flatpickr({
        'locale': lang,
        enableTime: true,
        minDate: 'today',
        dateFormat: 'Y-m-d h:i K',
    })
    $(startFrom).flatpickr({
        'locale': lang,
        enableTime: true,
        minDate: 'today',
        dateFormat: 'Y-m-d h:i K',
        onChange: function (selectedDates, dateStr, instance) {
            endpicker.clear();
            endpicker.set('minDate', dateStr);
        },
    })  
    
    let endpicker = $(endAt).flatpickr({
        'locale': lang,
        enableTime: true,
        minDate: 'today',
        dateFormat: 'Y-m-d h:i K',
    })
}

listenHiddenBsModal('#addMatchModal', function () {
    $('#addMatchForm')[0].reset()
    flatpickr($('#matchStart')).clear()
    flatpickr($('#startFrom')).clear()
    flatpickr($('#endAt')).clear()
    livewire.emit('refresh')
})
//
// listenChange('#startFrom', function (){
//     var betMinTime = $('#startFrom').val();
// });

listenClick('#team_score', function () {
    if (!$('.team_a_score').val() && !$('.team_b_score').val()) {
        $('.team_a_score').prop('required', true)
    } else {
        $('.team_a_score').prop('required', false)
    }
})

listenSubmit('#teamScore', function (e) {
    e.preventDefault()

    let team_a = $('.team_a_score').val()
    let team_b = $('.team_b_score').val()
    let match_id = $('#matchId').val()

    $.ajax({
        type: 'POST',
        url: route('all-matches.match-score-store'),
        data: {
            team_a_score: team_a,
            team_b_score: team_b,
            match_id: match_id,
        },
        success: function (result) {
            livewire.emit('refresh')
            displaySuccessMessage(result.message)
        },
    })

    $('#teamScore')[0].reset()
})

listenClick('.match-change-status', function (event) {
    let matchID = $(event.currentTarget).attr('data-id')
    $.ajax({
        type: 'PUT',
        url: route('matches.change.status', matchID),
        data: { id: matchID },
        success: function (result) {
            livewire.emit('refresh')
            displaySuccessMessage(result.message)
        },
    })
})

listenClick('.match-locked-change-status', function (event) {
    let matchID = $(event.currentTarget).attr('data-id')
    $.ajax({
        type: 'PUT',
        url: route('matches-locked-status-change', matchID),
        data: { id: matchID },
        success: function (result) {
            livewire.emit('refresh')
            displaySuccessMessage(result.message)
        },
    })
})
