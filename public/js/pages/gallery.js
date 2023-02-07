
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
    var idFolder = document.getElementById("paramIdFolder");
    var idFile = document.getElementById("paramIdFile");
    var id, type;
    if(idFolder.value !== ''){
          id = idFolder.value;
          type = 'folder';
    }else{
          id = idFile.value;
          type = 'file';
    }
    remove('Data yang berelasi akan terhapus!', path+'/delete/'+id+'/'+type, path)
  }

  function rename(){
      $("#form-detail").show();
      var idFolder = document.getElementById("paramIdFolder");
      var idFile = document.getElementById("paramIdFile");
      var id, type;
      if(idFolder.value !== ''){
            id = idFolder.value;
            type = 'folder';
      }else{
            id = idFile.value;
            type = 'file';
      }
        $.ajax({
            type: "GET",
            url: path+'/info/'+type+'/'+id,
            dataType : 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function( data ) {
                $("input[name='id_gallery']").val(data.id);
                $("input[name='type_gallery']").val(data.type_gallery);
                $("input[name='name']").val(data.name_folder);
                if(data.is_public == 1){
                    $("input[name='is_public']").prop('checked', true);
                }else{
                    $("input[name='is_public']").prop('checked', false);
                }
                if(data.is_important == 1){
                    $("input[name='is_important']").prop('checked', true);
                }else{
                    $("input[name='is_important']").prop('checked', false);
                }

                $("#nama_file").html(data.name_folder);
                $("#icon_view").html(data.icon_view);
                $(".size_view").html(data.size_view);
                if(data.type_gallery == 'folder'){
                    $("#type_view").html('Directory');
                    $(".setting").show();
                    $(".description_view").html(data.description_folder);
                    $("textarea[name='description']").val(data.description_folder);

                }else{
                    $(".setting").hide();
                    $("#type_view").html(data.type_file);
                    $(".description_view").html(data.description_file);
                    $("textarea[name='description']").val(data.description_file);

                }
                $("#owner_view").html(data.creator.name);
                $("#created_at").html(data.created_at_indo);
                $("#total_viewer_view").html(data.total_viewer);
                const assetFile = window.location.origin+'/'+data.path_file;
                $('.download_file').html('<a target="_blank" href="'+assetFile+'"'+' class="btn btn-primary btn-sm" download>Download</a>');
            }
        });

  }

  function detailInfo(type = null, id = null){
      $("#form-detail").hide();
      $(".setting").hide();
      var idFolder = document.getElementById("paramIdFolder");
      var idFile = document.getElementById("paramIdFile");
      var id, type;
      if(type == null && id == null){
        if(idFolder.value !== ''){
                id = idFolder.value;
                type = 'folder';
        }else{
                id = idFile.value;
                type = 'file';
        }
      }
        $.ajax({
            type: "GET",
            url: path+'/info/'+type+'/'+id,
            dataType : 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function( data ) {
                    $("#nama_file").html(data.name_folder);
                    $("#icon_view").html(data.icon_view);
                    $(".size_view").html(data.size_view);
                    if(data.type_gallery == 'folder'){
                        $("#type_view").html('Directory');
                    }else{
                        $("#type_view").html(data.type_file);
                    }
                    $("#owner_view").html(data.creator.name);
                    $("#created_at").html(data.created_at_indo);
                    $("#total_viewer_view").html(data.total_viewer);
                    $(".description_view").html(data.description_folder);
                    const assetFile = window.location.origin+'/'+data.path_file;
                    $('.download_file').html('<a target="_blank" href="'+assetFile+'"'+' class="btn btn-primary btn-sm" download>Download</a>');
            }
        });

  }

