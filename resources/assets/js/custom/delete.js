'use strict';

window.deleteItem = function (url, header) {
    var callFunction = arguments.length > 3 && arguments[3] !== undefined
        ? arguments[3]
        : null
    swal({
        title: Lang.get('messages.common.delete') + ' !',
        text: Lang.get('messages.common.are_you_sure_want_to_delete_this') + ' "' + header + '" ?',
        icon: sweetAlertIcon,
        buttons: {
            confirm: Lang.get('messages.common.yes'),
            cancel: Lang.get('messages.common.no'),
        },
    }).then((result) => {
        if (result) {
            livewire.emit('refresh')
            deleteItemAjax(url, header, callFunction)
        }
    });
};

function deleteItemAjax (url, header, callFunction = null) {
    $.ajax({
        url: url,
        type: 'DELETE',
        dataType: 'json',
        success: function (obj) {
            if (obj.success) {
                livewire.emit('refresh')
                window.livewire.emit('refreshDatatable')
                window.livewire.emit('resetPage')
            }
            swal({
                icon: 'success',
                title: Lang.get('messages.common.deleted'),
                text: header + ' ' + Lang.get('messages.common.has_been_deleted'),
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
