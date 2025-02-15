document.addEventListener('turbo:load', loadAboutUsData)

function loadAboutUsData () {
    
}

listenSubmit('#updateAboutUsSetting', function (e){
    e.preventDefault();
    if ($('#aboutUsTitle').val().trim().length == 0){
        displayErrorMessage('Title field is required')
        return false;
    }
    if ($('#aboutUsDes').val().trim().length == 0){
        displayErrorMessage('Description field is required')
        return false;
    }
    $(this)[0].submit()
});

listenSubmit('#updateHomeSetting', function (e){
    e.preventDefault();
    if ($('#homeTitle').val().trim().length == 0){
        displayErrorMessage('Title field is required')
        return false;
    }
    if ($('#homeDes').val().trim().length == 0){
        displayErrorMessage('Description field is required')
        return false;
    }
    $(this)[0].submit()
});

listenSubmit('#updateAffiliateSetting', function (e){
    e.preventDefault();
    if ($('#homeTitle').val().trim().length == 0){
        displayErrorMessage('Title field is required')
        return false;
    }
    if ($('#affiliateDes').val().trim().length == 0){
        displayErrorMessage('Description field is required')
        return false;
    }
    $(this)[0].submit()
});

listenSubmit('#updateContactUsSetting', function (e){
    e.preventDefault();
    if ($('#contactUsTitle').val().trim().length == 0){
        displayErrorMessage('Title field is required')
        return false;
    }
    if ($('#contactUsDes').val().trim().length == 0){
        displayErrorMessage('Description field is required')
        return false;
    }
    $(this)[0].submit()
});
    
