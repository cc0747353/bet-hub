document.addEventListener('turbo:load', loadCompanyPolicyData)

let licencesInfoQuillData = null
let rulesForBetQuillData = null
let termsOfServiceQuillData = null
let privacyPolicyQuillData = null

function loadCompanyPolicyData () {

    if (!$('#companyPolicyForm').length) {
        return
    }

    if ($('#licencesInfoQuillData').length) {
        licencesInfoQuillData = new Quill('#licencesInfoQuillData', {
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],

                    [{ 'header': 1 }, { 'header': 2 }],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'script': 'sub' }, { 'script': 'super' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],

                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'font': [] }],
                    [{ 'align': [] }],
                    ['link', 'image', 'video'],
                    ['clean']], keyboard: {
                    bindings: {
                        tab: 'disabled',
                    },
                },
            }, placeholder: 'Enter Licences Info', theme: 'snow',
        })
    }

    if ($('#rulesForBetQuillData').length) {
        rulesForBetQuillData = new Quill('#rulesForBetQuillData', {
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],

                    [{ 'header': 1 }, { 'header': 2 }],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'script': 'sub' }, { 'script': 'super' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],

                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'font': [] }],
                    [{ 'align': [] }],
                    ['link', 'image', 'video'],
                    ['clean']], keyboard: {
                    bindings: {
                        tab: 'disabled',
                    },
                },
            }, placeholder: 'Enter Rules For Bet', theme: 'snow',
        })
    }

    if ($('#termsOfServiceQuillData').length) {
        termsOfServiceQuillData = new Quill('#termsOfServiceQuillData', {
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],

                    [{ 'header': 1 }, { 'header': 2 }],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'script': 'sub' }, { 'script': 'super' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],

                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'font': [] }],
                    [{ 'align': [] }],
                    ['link', 'image', 'video'],
                    ['clean']], keyboard: {
                    bindings: {
                        tab: 'disabled',
                    },
                },
            }, placeholder: 'Enter Terms of Service', theme: 'snow',
        })
    }

    if ($('#privacyPolicyQuillData').length) {
        privacyPolicyQuillData = new Quill('#privacyPolicyQuillData', {
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],

                    [{ 'header': 1 }, { 'header': 2 }],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'script': 'sub' }, { 'script': 'super' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],

                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'font': [] }],
                    [{ 'align': [] }],
                    ['link', 'image', 'video'],
                    ['clean']], keyboard: {
                    bindings: {
                        tab: 'disabled',
                    },
                },
            }, placeholder: 'Enter Privacy Policy', theme: 'snow',
        })
    }

    if ($('#companyPolicyForm').length && licencesInfoQuillData &&
        rulesForBetQuillData && termsOfServiceQuillData &&
        privacyPolicyQuillData) {
        
        licencesInfoQuillData.on('text-change',
            function (delta, oldDelta, source) {
                if (licencesInfoQuillData.getText().trim().length === 0) {
                    licencesInfoQuillData.setContents([{ insert: '' }])
                }
            })
        
        rulesForBetQuillData.on('text-change',
            function (delta, oldDelta, source) {
                if (rulesForBetQuillData.getText().trim().length === 0) {
                    rulesForBetQuillData.setContents([{ insert: '' }])
                }
            })
        
        termsOfServiceQuillData.on('text-change',
            function (delta, oldDelta, source) {
                if (termsOfServiceQuillData.getText().trim().length === 0) {
                    termsOfServiceQuillData.setContents([{ insert: '' }])
                }
            })
        
        privacyPolicyQuillData.on('text-change',
            function (delta, oldDelta, source) {
                if (privacyPolicyQuillData.getText().trim().length === 0) {
                    privacyPolicyQuillData.setContents([{ insert: '' }])
                }
            })
    }
}

listenSubmit('#companyPolicyForm', (e) => {

    let licencesInfoEditorContent = licencesInfoQuillData.root.innerHTML
    if (licencesInfoQuillData.getText().trim().length === 0) {
        displayErrorMessage('Licences Info field is required.')
        return false
    }

    $('#licencesInfo').val(licencesInfoEditorContent)

    let rulesForBetEditorContent = rulesForBetQuillData.root.innerHTML
    if (rulesForBetQuillData.getText().trim().length === 0) {
        displayErrorMessage('Rules For Bet field is required.')
        return false
    }

    $('#rulesForBet').val(rulesForBetEditorContent)

    let termsOfServiceEditorContent = termsOfServiceQuillData.root.innerHTML
    if (termsOfServiceQuillData.getText().trim().length === 0) {
        displayErrorMessage('Terms of Service field is required.')
        return false
    }

    $('#termsOfService').val(termsOfServiceEditorContent)

    let privacyPolicyEditorContent = privacyPolicyQuillData.root.innerHTML
    if (privacyPolicyQuillData.getText().trim().length === 0) {
        displayErrorMessage('Privacy Policy field is required.')
        return false
    }

    $('#privacyPolicy').val(privacyPolicyEditorContent)
})
