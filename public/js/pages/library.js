
$(function () {
    'use strict';

    var sidebarFileManager = $('.sidebar-file-manager'),
      sidebarToggler = $('.sidebar-toggle'),
      fileManagerOverlay = $('.body-content-overlay'),
      filesTreeView = $('.my-drive'),
      sidebarRight = $('.right-sidebar'),
      filesWrapper = $('.file-manager-main-content'),
      viewContainer = $('.view-container'),
      fileManagerItem = $('.file-manager-item'),
      noResult = $('.no-result'),
      fileActions = $('.file-actions'),
      viewToggle = $('.view-toggle'),
      filterInput = $('.files-filter'),
      toggleDropdown = $('.toggle-dropdown'),
      sidebarMenuList = $('.sidebar-list'),
      fileDropdown = $('.file-dropdown'),
      fileContentBody = $('.file-manager-content-body');

    // Select File
    if (fileManagerItem.length) {
      fileManagerItem.find('.form-check-input').on('change', function () {
        var $this = $(this);
        if ($this.is(':checked')) {
          $this.closest('.file, .folder').addClass('selected');
        } else {
          $this.closest('.file, .folder').removeClass('selected');
        }
        if (fileManagerItem.find('.form-check-input:checked').length) {
          fileActions.addClass('show');
        } else {
          fileActions.removeClass('show');
        }
      });
    }

    // Toggle View
    if (viewToggle.length) {
      viewToggle.find('input').on('change', function () {
        var input = $(this);
        viewContainer.each(function () {
          if (!$(this).hasClass('view-container-static')) {
            if (input.is(':checked') && input.data('view') === 'list') {
              $(this).addClass('list-view');
            } else {
              $(this).removeClass('list-view');
            }
          }
        });
      });
    }

    // Filter
    if (filterInput.length) {
      filterInput.on('keyup', function () {
        var value = $(this).val().toLowerCase();

        fileManagerItem.filter(function () {
          var $this = $(this);

          if (value.length) {
            $this.closest('.file, .folder').toggle(-1 < $this.text().toLowerCase().indexOf(value));
            $.each(viewContainer, function () {
              var $this = $(this);
              if ($this.find('.file:visible, .folder:visible').length === 0) {
                $this.find('.no-result').removeClass('d-none').addClass('d-flex');
              } else {
                $this.find('.no-result').addClass('d-none').removeClass('d-flex');
              }
            });
          } else {
            $this.closest('.file, .folder').show();
            noResult.addClass('d-none').removeClass('d-flex');
          }
        });
      });
    }

    // sidebar file manager list scrollbar
    if ($(sidebarMenuList).length > 0) {
      var sidebarLeftList = new PerfectScrollbar(sidebarMenuList[0], {
        suppressScrollX: true
      });
    }

    if ($(fileContentBody).length > 0) {
      var rightContentWrapper = new PerfectScrollbar(fileContentBody[0], {
        cancelable: true,
        wheelPropagation: false
      });
    }

    // Files Treeview
    if (filesTreeView.length) {
      filesTreeView.jstree({
        core: {
          themes: {
            dots: false
          },
          data: [
            {
              text: 'My Drive',
              children: [
                {
                  text: 'photos',
                  children: [
                    {
                      text: 'image-1.jpg',
                      type: 'jpg'
                    },
                    {
                      text: 'image-2.jpg',
                      type: 'jpg'
                    }
                  ]
                }
              ]
            }
          ]
        },
        plugins: ['types'],
        types: {
          default: {
            icon: 'far fa-folder font-medium-1'
          },
          jpg: {
            icon: 'far fa-file-image text-info font-medium-1'
          }
        }
      });
    }

    // click event for show sidebar
    sidebarToggler.on('click', function () {
      sidebarFileManager.toggleClass('show');
      fileManagerOverlay.toggleClass('show');
    });

    // remove sidebar
    $('.body-content-overlay, .sidebar-close-icon').on('click', function () {
      sidebarFileManager.removeClass('show');
      fileManagerOverlay.removeClass('show');
      sidebarRight.removeClass('show');
    });

    // on screen Resize remove .show from overlay and sidebar
    $(window).on('resize', function () {
      if ($(window).width() > 768) {
        if (fileManagerOverlay.hasClass('show')) {
          sidebarFileManager.removeClass('show');
          fileManagerOverlay.removeClass('show');
          sidebarRight.removeClass('show');
        }
      }
    });

    // making active to list item in links on click
    sidebarMenuList.find('.list-group a').on('click', function () {
      if (sidebarMenuList.find('.list-group a').hasClass('active')) {
        sidebarMenuList.find('.list-group a').removeClass('active');
      }
      $(this).addClass('active');
    });

    // Toggle Dropdown
    if (toggleDropdown.length) {
      $('.file-logo-wrapper .dropdown').on('click', function (e) {
        var $this = $(this);
        //get attribute data-copy
        e.preventDefault();
        var dataCopy = $(this).parent().find('.file-manager-item').prevObject[0].dataset.copy;
        var dataIdfile = $(this).parent().find('.file-manager-item').prevObject[0].dataset.idfile;
        var dataIdfolder = $(this).parent().find('.file-manager-item').prevObject[0].dataset.idfolder;
        $("#paramHref").val(dataCopy);
        $("#paramIdFolder").val(dataIdfolder);
        $("#paramIdFile").val(dataIdfile);

        if (fileDropdown.length) {
          $('.view-container').find('.file-dropdown').remove();
          if ($this.closest('.dropdown').find('.dropdown-menu').length === 0) {
            fileDropdown
              .clone()
              .appendTo($this.closest('.dropdown'))
              .addClass('show')
              .find('.dropdown-item')
              .on('click', function () {
                $(this).closest('.dropdown-menu').remove();
              });
          }
        }
      });
      $(document).on('click', function (e) {
        if (!$(e.target).hasClass('toggle-dropdown')) {
          filesWrapper.find('.file-dropdown').remove();
        }
      });

      if (viewContainer.length) {
        $('.file, .folder').on('mouseleave', function () {
          $(this).find('.file-dropdown').remove();
        });
      }
    }

    $('#add-form').on('submit', function(e) {
        $("#submit").hide('fadeOut');
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: path+'/store',
            dataType : 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: $("#add-form").serialize(),
            success: function( msg ) {
                 //success
                 toastr['success'](
                    'Data Folder Updated!',
                    '👋 Data berhasil diupdate!',
                    {
                        closeButton: true,
                        tapToDismiss: false
                    }
                );
                setTimeout(function () {
                    window.location.href = path
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
  }); //endfunction
  function copyLink(e) {
    e.preventDefault()
    var copyText = document.getElementById("paramHref");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    toastr['success'](
        'Copied Link!',
        '👋 '+copyText.value,
        {
            closeButton: true,
            tapToDismiss: false
        }
    );
  }//end function
  function removeData(){
    var idFile = document.getElementById("paramIdFile");
    remove('Data yang berelasi akan terhapus!', path+'/delete/'+idFile, path)
  }

  function revision(){
      $("#form-detail").show();
      var id = document.getElementById("paramIdFile");
        $.ajax({
            type: "GET",
            url: path+'/info/'+id.value,
            dataType : 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function( data ) {
                $("#form-revision").show('fadeOut');
                //success with edit data
                var row = data.row;
                var masterBusinessUnit = data.businessUnit;
                var masterCategory = data.masterCategory
                var masterstatus = data.masterstatus
                var masterDepartment = data.masterDepartment
                //master business unit selected data
                $("input[name='id_library']").val(row.id);
                $("input[name='title']").val(row.title);
                $("#nama_file").html(row.title);
                $("input[name='sop_number']").val(row.sop_number);
                $("input[name='rev_no']").val(row.rev_no);
                $("input[name='issued']").val(row.issued_ymd);
                $("input[name='expired']").val(row.expired_ymd);
                var previewFileHtml = '';
                previewFileHtml+="<a href='"+row.file_path+"' target='_blank'>"+row.icon_view+"</a>";
                $("#preview_file").html(previewFileHtml);
                $("input[name='remark']").val(row.remark);
                $("input[name='location']").val(row.location);
                $('input[name="tags_relation"]').val(row.tags_relation_view);
                //status active
                if(row.active == 1){
                    $("input[name=active]").prop('checked', true);
                }else{
                    $("input[name=active]").prop('checked', false);
                }

                //add select2 option ======================================================
                  $("#business_unit").wrap('<div class="position-relative"></div>').select2({
                    dropdownAutoWidth: true,
                    dropdownParent: $("#business_unit").parent(),
                    width: '100%',
                    data: masterBusinessUnit
                  });
                  $("#business_unit").val(row.business_unit_id).trigger('change');

                  $("#category").wrap('<div class="position-relative"></div>').select2({
                    dropdownAutoWidth: true,
                    dropdownParent: $("#category").parent(),
                    width: '100%',
                    data: masterCategory
                  });
                  $("#category").val(row.category_libraries).trigger('change');

                  $("#status").wrap('<div class="position-relative"></div>').select2({
                    dropdownAutoWidth: true,
                    dropdownParent: $("#status").parent(),
                    width: '100%',
                    data: masterstatus
                  });
                  $("#status").val(row.status).trigger('change');

                  $("#department").wrap('<div class="position-relative"></div>').select2({
                    dropdownAutoWidth: true,
                    dropdownParent: $("#department").parent(),
                    width: '100%',
                    data: masterDepartment
                  });
                  $("#department").val(row.devision_owner).trigger('change');

                  //activity
                  $("#log_activity").html(showLogActivity(row.log, row));

            }
        });

  }

  function detailInfo(id = null){
      $("#form-detail").hide();
      $(".setting").hide();
      if(id == null){
          id = document.getElementById("paramIdFile").value;
      }
        $.ajax({
            type: "GET",
            url: path+'/info/'+id,
            dataType : 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function( data ) {
                var row = data.row;
                var masterBusinessUnit = data.businessUnit;
                var masterCategory = data.masterCategory
                var masterstatus = data.masterstatus
                var masterDepartment = data.masterDepartment
                //master business unit selected data
                var previewFileHtml = '';
                previewFileHtml+="<a href='"+row.file_path+"' target='_blank'>"+row.icon_view+"</a>";

                $(".icon_view").html(previewFileHtml)
                $(".description_view").html(row.title)
                $(".modal-title").html(row.title)
                $("#info-title").html(row.title)
                $("#info-category").html(row.category_libraries)
                $("#info-bu").html(row.business_unit.name)
                $("#info-sop").html(row.sop_number)
                $("#info-location").html(row.location)
                $("#info-tags").html(row.tags_relation_view)
                $("#info-issued").html(row.issued_ymd)
                $("#info-expired").html(row.expired_ymd)
                $("#info-remark").html(row.remark)
                $("#info-status").html(row.status)
                $("#info-revno").html(row.rev_no)
                var ket = '-';
                if(row.log.length > 0){
                    ket = row.log[(row.log.length-1)].keterangan;
                }
                $("#info-keterangan").html(ket)
                $(".log_activity").html(showLogActivity(row.log, row));

            }
        });
  }

  function showLogActivity(dataLog, row){
    var html = '';
    if(dataLog.length > 0){
        $.each(dataLog, function(key, value){
            if(key == 0){ //first log
                html += '<h6 class="file-manager-title my-2">'+row.created_at_indo+'</h6>';
            }else{
                html += '<h6 class="file-manager-title my-2">'+value.updated_human+'</h6>';
            }
            html += '<div class="d-flex align-items-center">';
            html += '<div class="avatar avatar-sm bg-light-primary me-50">';
                    html+= '<span class="avatar-content">-</span>';
            html += '</div>'
                html += '<div class="more-info">'
                    html += '<p class="mb-0">';
                        if(value.deleted_at !== null){
                            html +='<span class="fw-bold">'+value.deleter.name+'</span>';
                            html += ' deleted the file';
                        }else{
                            if(key == 0){
                                html +='<span class="fw-bold">'+value.creator.name+'</span>';
                                html += ' Created the file';
                            }else{
                                html +='<span class="fw-bold">'+value.updater.name+'</span>';
                                html += ' Updated the file';
                            }
                        }
                        html += '<span onclick="showDetail(`'+value.id+'`)" data-bs-toggle="modal" data-bs-target="#app-file-manager-info-sidebar-log" style="cursor:pointer;" class="btn btn-sm"><i data-feather="eye"></i> Show Detail</span>'
                    html += '</p>';
                html += '</div>';
            html += '</div>';
        });
        html += '<h6 class="file-manager-title my-2">'+row.updated_human+'</h6>';
        html += '<div class="d-flex align-items-center mb-2">';
        html += '<div class="avatar avatar-sm me-50">';
                html+= '<img src="../../../app-assets/images/logo/logo.png" alt="avatar" width="28">';
        html += '</div>'
            html += '<div class="more-info">'
                html += '<p class="mb-0">';
                    html +='<span class="fw-bold">'+row.updater.name+'</span>';
                    html += ' Last Updated the file at Tab Details';
                    // html += '<a class="nav-link" href="#details-tabinfo" aria-controls="details-tabinfo"><i data-feather="eye"></i> Show Detail</a>'
                html += '</p>';
            html += '</div>';
        html += '</div>';
    }else{
        //no data log
        html += '<div class="alert alert-danger mt-2 p-1"><i data-feather="x-circle"></i> No Activity!</div>';
    }
    return html;
  }

  function showDetail(id = null){
    $("#form-detail").hide();
    //modal close
    // $("#app-file-manager-info-sidebar").modal('hide')
    $(".setting").hide();
    if(id == null){
        id = document.getElementById("paramIdFile").value;
    }
      $.ajax({
          type: "GET",
          url: path+'/info-log/'+id,
          dataType : 'json',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function( data ) {
              var row = data.row;
              var masterBusinessUnit = data.businessUnit;
              var masterCategory = data.masterCategory
              var masterstatus = data.masterstatus
              var masterDepartment = data.masterDepartment
              //master business unit selected data
              var previewFileHtml = '';
              previewFileHtml+="<a href='"+row.file_path+"' target='_blank'>"+row.icon_view+"</a>";

              $(".icon_view_log").html(previewFileHtml)
              $(".description_view_log").html(row.title)
              $(".modal-title_log").html(row.title)
              $(".info-title_log").html(row.title)
              $(".info-category_log").html(row.category_libraries)
              $(".info-bu_log").html(row.business_unit.name)
              $(".info-sop_log").html(row.sop_number)
              $(".info-location_log").html(row.location)
              $(".info-tags_log").html(row.tags_relation_view)
              $(".info-issued_log").html(row.issued_ymd)
              $(".info-expired_log").html(row.expired_ymd)
              $(".info-remark_log").html(row.remark)
              $(".info-status_log").html(row.status)
              $(".info-revno_log").html(row.rev_no)
              var ket = '-';
              if(row.log.length > 0){
                  ket = row.log[(row.log.length-1)].keterangan;
              }
              $(".info-keterangan_log").html(ket)
            //   $(".log_activity_log").html(showLogActivity(row.log, row));

          }
      });
}

