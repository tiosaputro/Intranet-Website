function editData(id){
    $.ajax({
        url: path+'/'+id,
        type: 'GET',
        success: function(data){
            $("input[name='id']").val(data.id);
            $("input[name='name']").val(data.menu_name);
            $("input[name='slug']").val(data.slug);
            $("input[name='url']").val(data.url);
            $("input[name='icon']").val(data.icon);
            $("input[name='order']").val(data.order);
            // $("select[name='is_parent']").val(data.is_parent);
            //selected option select2
            $("select[name='is_parent']").val(data.is_parent).trigger('change');

            if(data.active == 1){
                $("input[name='active']").prop('checked', true);
            }else{
                $("input[name='active']").prop('checked', false);
            }
            if(data.hide_mobile == 1){
                $("input[name='hide_mobile']").prop('checked', true);
            }else{
                $("input[name='hide_mobile']").prop('checked', false);
            }
        }
    });
}
$(document).on('click', '.add-new', function(){
    document.getElementById("add-form").reset();
});
function removeData(id){
    removeMenu('Data yang berelasi akan terhapus!', path+'-delete/'+id, fetch)
}
$(function () {

    $('form').on('submit', function(e) {
        $("#loading-login").show();
        $("#submit").hide('fadeOut');
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: path,
            dataType : 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: $("#add-form").serialize(),
            success: function( msg ) {
                 //success
                 toastr['success'](
                    'Data Updated!',
                    '👋 Data berhasil diupdate!',
                    {
                        closeButton: true,
                        tapToDismiss: false
                    }
                );
                setTimeout(function () {
                    window.location.href = fetch
                }, 400);
            },
            error : function(msg){
                $("#error").show()
                //show message error array
                var htmlError = '<ol>';
                $.each(msg.responseJSON.errors, function(key, value){
                    htmlError+='<li>'+value[0]+'</li>';
                });
                htmlError+='</ol>';
                $("#message-error").html(htmlError);
                $("#loading-login").hide();
                $("#submit").show('fadeOut');
            }
        });
    });
    $('.table').DataTable({
        // processing: true,
        // serverSide: true,
        // ajax: fetch,
        // columns: [
        //     {data: 'name', name: 'name'},
        //     {data: 'email', name: 'email'},
        //     {data: 'role', name: 'role'},
        //     {data: 'active', name: 'active'},
        //     {data: 'action', name: 'action', orderable: false, searchable: false},
        // ],
      dom:
          '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
          '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
          '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
          '>t' +
          '<"d-flex justify-content-between mx-2 row mb-1"' +
          '<"col-sm-12 col-md-6"i>' +
          '<"col-sm-12 col-md-6"p>' +
          '>',
      // Buttons with Dropdown
      buttons: [
          {
            extend: 'collection',
            className: 'btn btn-outline-secondary dropdown-toggle me-2',
            text: feather.icons['external-link'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
            buttons: [
              {
                extend: 'print',
                text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Print',
                className: 'dropdown-item',
                exportOptions: { columns: [0,1, 2, 3] }
              },
              {
                extend: 'csv',
                text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                className: 'dropdown-item',
                exportOptions: { columns: [0, 1, 2, 3] }
              },
              {
                extend: 'excel',
                text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                className: 'dropdown-item',
                exportOptions: { columns: [0, 1, 2, 3] }
              },
              {
                extend: 'pdf',
                text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                className: 'dropdown-item',
                exportOptions: { columns: [0, 1, 2, 3] }
              },
              {
                extend: 'copy',
                text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                className: 'dropdown-item',
                exportOptions: { columns: [0, 1, 2, 3] }
              }
            ],
            init: function (api, node, config) {
              $(node).removeClass('btn-secondary');
              $(node).parent().removeClass('btn-group');
              setTimeout(function () {
                $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex mt-50');
              }, 50);
            }
          },
          {
            text: 'Add New',
            className: 'add-new btn btn-primary',
            attr: {
              'data-bs-toggle': 'modal',
              'data-bs-target': '#modals-slide-in'
            },
            init: function (api, node, config) {
              $(node).removeClass('btn-secondary');
            }
          }
        ],
    })
  });
