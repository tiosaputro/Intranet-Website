// confirmText.on('click', function () {
//       Swal.fire({
//         title: 'Are you sure?',
//         text: "You won't be able to revert this!",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonText: 'Yes, delete it!',
//         customClass: {
//           confirmButton: 'btn btn-primary',
//           cancelButton: 'btn btn-outline-danger ms-1'
//         },
//         buttonsStyling: false
//       }).then(function (result) {
//         if (result.value) {
//           Swal.fire({
//             icon: 'success',
//             title: 'Deleted!',
//             text: 'Your file has been deleted.',
//             customClass: {
//               confirmButton: 'btn btn-success'
//             }
//           });
//         }
//       });
// });

function checkAll(ele) {
    var checkboxes = document.getElementsByTagName('input');
    if (ele.checked) {
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = true;
            }
        }
    } else {
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = false;
            }
        }
    }
}

function remove (fieldMessage, routeDelete, direct){
    Swal.fire({
        title: 'Yakin data ini akan dihapus ?',
        text: fieldMessage,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false
      }).then(function (result) {
        if (result.value) {
          $.get(routeDelete).then(response => {
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: 'Your data has been deleted.',
                customClass: {
                  confirmButton: 'btn btn-success'
                }
            });
            // window.location.href = direct
          })
        }
      });
}

function removeMenu (fieldMessage, routeDelete, direct){
    Swal.fire({
        title: 'Yakin data ini akan dihapus ?',
        text: fieldMessage,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false
      }).then(function (result) {
        if (result.value) {
          $.get(routeDelete).then(response => {
            if(response.original.status == 'error'){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.original.message,
                    customClass: {
                      confirmButton: 'btn btn-success'
                    }
                });
            }else{
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'Your data has been deleted.',
                    customClass: {
                      confirmButton: 'btn btn-success'
                    }
                });
                window.location.href = direct
            }
          })
        }
      });
}
