

document.addEventListener('turbo:load', loadNewsLetterData)

function loadNewsLetterData () {
    listen('click', '.delete-subscriber-btn', function (event) {
        let subscriberId = $(event.currentTarget).attr('data-id')
        deleteItem(route('news-letter.destroy', subscriberId), Lang.get('messages.common.subscriber'))
    })
}
