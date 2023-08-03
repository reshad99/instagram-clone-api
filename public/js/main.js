/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
window.get_query = function get_query() {
  var url = location.search;
  var qs = url.substring(url.indexOf('?') + 1).split('&');
  for (var i = 0, result = {}; i < qs.length; i++) {
    qs[i] = qs[i].split('=');
    result[qs[i][0]] = decodeURIComponent(qs[i][1]);
  }
  return result;
};
$(document).ready(function () {
  var swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
  });
  $(document).on('click', '.delete-button', function (event) {
    var form = $('#' + event.target.dataset.deleteId);
    swalWithBootstrapButtons.fire({
      title: 'Silinmə',
      text: "Sİlmək istədiyinizə əminsiniz ? bu məlumat geri qaytarılmaya bilər !",
      type: 'info',
      showCancelButton: true,
      confirmButtonText: 'Bəli silinsin!',
      cancelButtonText: 'Xeyr!',
      reverseButtons: true
    }).then(function (result) {
      if (result.value) {
        swalWithBootstrapButtons.fire('Silindi!', 'yenilənir...', 'success');
        form.submit();
      }
    });
  });
});
window.initUiElements = function initUiElements() {
  $('[data-toggle="tooltip"]').tooltip();
  $('.toggleSwitcher').bootstrapToggle();
};
/******/ })()
;