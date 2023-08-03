// window.Echo.channel('user-channel')

var i = 0;

window.Echo.channel('users').listen('SendMessage', (data) => {
    i++;
    $('.chat-content ul').append('<li>' + i + ' ' + data.data + '</li>')
})
