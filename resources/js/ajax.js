// window.ajaxPost = function ajaxPost(url, data) {
//     var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
//     return new Promise(function (resolve, reject) {
//         var formData = {};
//         for (var [key, value] of data.entries()) {
//             formData[key] = value;
//         }
//         var xhr = new XMLHttpRequest();
//         xhr.open('POST', url);
//         xhr.setRequestHeader('Content-Type', 'application/json');
//         xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
//         xhr.onload = function () {
//             if (xhr.status === 200) {
//                 resolve(xhr.response);
//             } else {
//                 var errorResponse = JSON.parse(xhr.responseText);
//                 if (errorResponse.errors) {
//                     reject(errorResponse.errors);
//                 } else {
//                     reject(xhr.statusText);
//                 }
//             }
//         };
//         xhr.onerror = function () {
//             reject(xhr.statusText);
//         };
//         xhr.send(JSON.stringify(formData));
//     });
// }

window.formDataToObject = function formDataToObject(formData) {
    const object = {};
    formData.forEach((value, key) => {
      if (key.endsWith('[]')) {
        const realKey = key.slice(0, -2);
        object[realKey] = object[realKey] || [];
        object[realKey].push(value);
      } else {
        object[key] = value;
      }
    });
    return object;
  }

window.ajaxPost = async function ajaxPost(url, data, method = 'POST') {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const response = await fetch(url, {
        method: method,
        headers: {
            'Accept': '*/*',
            'X-CSRF-TOKEN': csrfToken
        },
        body: data
    });
    const responseData = await response.json();
    if (!response.ok) {
        const error = new Error(responseData.message || response.statusText);
        error.response = responseData;
        error.status = response.status;
        throw error;
    }
    return responseData;
}

window.ajaxFetch = async function ajaxFetch(route) {
    try {
        const response = await fetch(route);
        const data = await response.json();
        return data;
    } catch (error) {
        return console.error(error);
    }
}

window.handleValidationErrors = function handleValidationErrors(error) {
    if (error.status == 422) {
        var errors = error.response.errors;

        for (const key in errors) {
            toastr['error'](errors[key][0])
        }
    }
}

window.fireSwal = function fireSwal(data) {
    Swal.fire({
        icon: data.status,
        title: data.message,
        text: ''
    });
}

window.loading = function loading(state) {
    if (state == 0) {
        $("#sehifeLoading").fadeOut(200, function () {
            $(this).remove();
        });
    } else {
        if ($("#sehifeLoading").length == 0) {
            $("body").append("<div id='sehifeLoading' style='position:fixed;top:0;left:0;width:100%;height:100%;z-index:999999999;background: rgba(0,0,0,0.4);'><div style='width: 120px; height: 40px; position: absolute; top: 0px; bottom: 0px; left: 0px; right: 0px; margin: auto; background: none repeat scroll 0% 0% rgb(238, 238, 238); text-align: center; line-height: 38px; border: 1px solid rgb(221, 221, 221); vertical-align: middle; border-radius: 5px ! important; color: rgb(131, 131, 131);'><i class='fa fa-spinner fa-spin'></i> Yüklənir...</div></div>");
            $("body>div:last").hide().fadeIn(200);
        }
    }
    setTimeout(function (e) {
        $("#sehifeLoading").fadeOut(200, function () {
            $(this).remove();
        });
    }, 10000);
}

window.generalPostRequest = function generalPostRequest(url, formData, method = 'POST') {
    loading(true)
    ajaxPost(url, formData, method).then(function (data) {
        fireSwal(data)
        window.location.reload()
    }).catch(function (error) {
        fireSwal(error.response)
        handleValidationErrors(error)
    }).finally(function () {
        loading(false)
    })
}

window.fillForm = function fillForm(jsonData, formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('input, select');

    inputs.forEach(input => {
        const inputName = input.getAttribute('name');
        if (jsonData.hasOwnProperty(inputName)) {
            input.value = jsonData[inputName];
        }
    });
}
