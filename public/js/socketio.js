/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************!*\
  !*** ./resources/js/socketio.js ***!
  \**********************************/
// window.Echo.channel('user-channel')

var i = 0;
window.Echo.channel('users').listen('SendMessage', function (data) {
  i++;
  $('.chat-content ul').append('<li>' + i + ' ' + data.data + '</li>');
});
/******/ })()
;