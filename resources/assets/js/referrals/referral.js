document.addEventListener('turbo:load', loadReferrals)

function loadReferrals () {

}

$(window).keydown(function (event) {
    if (window.location.pathname == '/admin/referrals') {
        if (event.keyCode == 13) {
            event.preventDefault()
            displayErrorMessage('Click generate button')
            return false
        }
    }
})

listenClick('#generateReferralLevel', function () {
    let levelID = $(this).attr('data-id')
    let level = $('.referralLevelGenerate' + levelID).val()
    if (level == '') {
        displayErrorMessage('Please enter level')
        return false
    }
    if (level > 10) {
        $('.referralLevelForm' + levelID).removeClass('d-none')
        $('.generateReferralLevelContainer' + levelID).html('')
        for (let i = 1; i <= 10; i++) {
            $('.generateReferralLevelContainer' + levelID).append(`
    <div class="input-group mt-4 referral-level${i + levelID}">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text no-right-border">${levelMessages}</span>
                                            </div>
                                            <input name="level[]" class="form-control referral-current-level" type="number" readonly value="${i}" required placeholder="Level" data-id="${i}">
                                            <input name="commission[]" class="form-control margin-top-10 commission" type="number" step=".01" min="0" max="100" required="" placeholder="${commissionMessages}">
                                            <div class="input-group-append bg-red-500">
                                                <button class="btn margin-top-10 delete-referral-level" data-id="${i +
            levelID}" type="button"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
    `)
        }
    } else {
        $('.referralLevelForm' + levelID).removeClass('d-none')
        $('.generateReferralLevelContainer' + levelID).html('')
        for (let i = 1; i <= level; i++) {
            $('.generateReferralLevelContainer' + levelID).append(`
    <div class="input-group mt-4 referral-level${i + levelID}">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text no-right-border">${levelMessages}</span>
                                            </div>
                                            <input name="level[]" class="form-control referral-current-level" type="number" readonly value="${i}" required placeholder="Level" data-id="${i}">
                                            <input name="commission[]" class="form-control margin-top-10 commission" type="number" step=".01" min="0" max="100" required="" placeholder="${commissionMessages}">
                                            <div class="input-group-append bg-red-500">
                                                <button class="btn margin-top-10 delete-referral-level" data-id="${i +
            levelID}" type="button"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
    `)
        }
    }
})

listenKeyup('#levelValue', function () {
    if ($(this).val() > 10) {
        $(this).val('10')
    }
})

listenKeyup('.commission', function () {
    if ($(this).val() > 100) {
        $(this).val('100')
    }
})

listenClick('.referrals-deposit-status', function (event) {
    let referralID = $(event.currentTarget).attr('data-id')
    $.ajax({
        type: 'PUT',
        url: route('referrals.change.status', referralID),
        success: function (result) {
            livewire.emit('refresh')
            displaySuccessMessage(result.message)
        },
    })
})

listenClick('.delete-referral-level', function (event) {
    let referralID = $(event.currentTarget).attr('data-id')
    $('.referral-level' + referralID).remove()
})
