/**
 * App user list
 */

 $(function () {
    'use strict';

    var dataTablePermissions = $('.datatables-permissions'),
      assetPath = '../../../app-assets/',
      dt_permission,
      userList = '#';

    if ($('body').attr('data-framework') === 'laravel') {
      assetPath = $('body').attr('data-asset-path');
      userList = assetPath + 'app/user/list';
    }

    // Users List datatable
    if (dataTablePermissions.length) {
      dt_permission = dataTablePermissions.DataTable({
        // ajax: assetPath + 'data/dummy-library.json', // JSON file to add data
        ajax : route+'/get-data',
        columns: [
          // columns according to JSON
          { data: '' },
          { data: 'id' },
          { data: 'name' },
          { data: 'title' },
          { data: 'category_libraries' },
          { data: 'sop_number' },
          { data: 'rev_no' },
          { data: 'issued' },
          { data: 'business_unit_name' },
          { data: 'shared_function_name' },
          { data: 'file_path' },
          { data: 'category' },
        //   { data: '' }
        ],
        columnDefs: [
          {
            // For Responsive
            className: 'control',
            orderable: false,
            responsivePriority: 2,
            targets: 0,
            render: function (data, type, full, meta) {
              return '';
            }
          },
          {
            targets: 1,
            visible: false
          },
          {
            targets: 11,
            visible: false
          },
          {
            targets : 10,
            orderable : false,
            render : function(data, type, full, meta){
                return '<a href="'+full['file_path']+'" class="btn btn-sm btn-primary" target="_blank">File</a>';
            }
          },
        //   {
        //     // User Role
        //     targets: 3,
        //     orderable: false,
        //     render: function (data, type, full, meta) {
        //       var $assignedTo = full['assigned_to'],
        //         $output = '';
        //       var roleBadgeObj = {
        //         Admin:
        //           '<a href="' +
        //           userList +
        //           '" class="me-50"><span class="badge rounded-pill badge-light-primary">Administrator</span></a>',
        //         Manager:
        //           '<a href="' +
        //           userList +
        //           '" class="me-50"><span class="badge rounded-pill badge-light-warning">Manager</span></a>',
        //         Users:
        //           '<a href="' +
        //           userList +
        //           '" class="me-50"><span class="badge rounded-pill badge-light-success">Users</span></a>',
        //         Support:
        //           '<a href="' +
        //           userList +
        //           '" class="me-50"><span class="badge rounded-pill badge-light-info">Support</span></a>',
        //         Restricted:
        //           '<a href="' +
        //           userList +
        //           '" class="me-50"><span class="badge rounded-pill badge-light-danger">Restricted User</span></a>'
        //       };
        //       for (var i = 0; i < $assignedTo.length; i++) {
        //         var val = $assignedTo[i];
        //         $output += roleBadgeObj[val];
        //       }
        //       return $output;
        //     }
        //   },
        //   {
        //     // Actions
        //     targets: -1,
        //     title: 'Actions',
        //     orderable: false,
        //     render: function (data, type, full, meta) {
        //       return (
        //         '<button class="btn btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#editPermissionModal">' +
        //         feather.icons['edit'].toSvg({ class: 'font-medium-2 text-body' }) +
        //         '</i></button>' +
        //         '<button class="btn btn-sm btn-icon delete-record">' +
        //         feather.icons['trash'].toSvg({ class: 'font-medium-2 text-body' }) +
        //         '</button>'
        //       );
        //     }
        //   }
        ],
        order: [[1, 'asc']],
        dom:
          '<"d-flex justify-content-between align-items-center header-actions text-nowrap mx-1 row mt-75"' +
          '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
          '<"col-sm-12 col-lg-8"<"dt-action-buttons d-flex align-items-center justify-content-lg-end justify-content-center flex-md-nowrap flex-wrap"<"me-1"f><"user_role mt-50 width-200 me-1">B>>' +
          '><"text-nowrap" t>' +
          '<"d-flex justify-content-between mx-2 row mb-1"' +
          '<"col-sm-12 col-md-6"i>' +
          '<"col-sm-12 col-md-6"p>' +
          '>',
        language: {
          sLengthMenu: 'Show _MENU_',
          search: 'Search',
          searchPlaceholder: 'Search..'
        },
        // Buttons with Dropdown
        // For responsive popup
        responsive: {
          details: {
            display: $.fn.dataTable.Responsive.display.modal({
              header: function (row) {
                var data = row.data();
                return 'Details of Library';
              }
            }),
            type: 'column',
            renderer: function (api, rowIdx, columns) {
              var data = $.map(columns, function (col, i) {
                let filePath = col.data;
                // if(col.title !== '' && col.title == 'File'){
                //     filePath = "<a href='"+col.data+"' class='btn btn-sm btn-primary' target='_blank'>File</a>";
                // }
                return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                  ? '<tr data-dt-row="' +
                      col.rowIndex +
                      '" data-dt-column="' +
                      col.columnIndex +
                      '">' +
                      '<td>' +
                      col.title +
                      ':' +
                      '</td> ' +
                      '<td>' +
                      filePath +
                      '</td>' +
                      '</tr>'
                  : '';
              }).join('');

              return data ? $('<table class="table"/><tbody />').append(data) : false;
            }
          }
        },
        language: {
          paginate: {
            // remove previous & next text from pagination
            previous: '&nbsp;',
            next: '&nbsp;'
          }
        },
        initComplete: function () {
          // Adding role filter once table initialized
          this.api()
            .columns(11)
            .every(function () {
              var column = this;
              var select = $(
                '<select id="UserRole" class="form-select text-capitalize"><option value=""> All Category </option><option value="policy" class="text-capitalize">Policy & Procedure</option><option value="forms" class="text-capitalize">Forms</option><option value="references" class="text-capitalize">References</option></select>'
              )
                .appendTo('.user_role')
                .on('change', function () {
                  var val = $.fn.dataTable.util.escapeRegex($(this).val());
                  column.search(val ? val : '', true, false).draw();
                });
            });
        }
      });
    }

    // Delete Record
    $('.datatables-permissions tbody').on('click', '.delete-record', function () {
      dt_permission.row($(this).parents('tr')).remove().draw();
    });

    // Filter form control to default size
    // ? setTimeout used for multilingual table initialization
    setTimeout(() => {
      $('.dataTables_filter .form-control').removeClass('form-control-sm');
      $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
  });
