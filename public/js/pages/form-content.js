

    var options = {
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images&_token='+token+'&modul='+modul,
      filebrowserImageUploadUrl: '/uploads-editor?type=Images&_token='+token+'&modul='+modul,
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files&_token='+token+'&modul='+modul,
      filebrowserUploadUrl: '/uploads-editor?type=Files&_token='+token+'&modul='+modul,
      filebrowserUploadMethod : 'form'
    };
      CKEDITOR.replace('my-editor', options);

  $('input[name="tags"]').amsifySuggestags({
      type : 'amsify',
      suggestions: JSON.parse(sugesTags)
  });

    $('#image').change(function(){

    let reader = new FileReader();
    reader.onload = (e) => {
    $('#preview-image').attr('src', e.target.result);
    $('#preview-image').attr('data-link', e.target.result);
    $('#preview-image').attr('class', 'lightboxed rounded');
    }
    reader.readAsDataURL(this.files[0]);

    });

    $('#image2').change(function(){

    let reader2 = new FileReader();
    reader2.onload = (e) => {
    $('#preview-image2').attr('src', e.target.result);
    $('#preview-image2').attr('data-link', e.target.result);
    $('#preview-image2').attr('class', 'lightboxed rounded');
    }
    reader2.readAsDataURL(this.files[0]);

    });

    $('#image3').change(function(){

    let reader3 = new FileReader();
    reader3.onload = (e) => {
    $('#preview-image3').attr('src', e.target.result);
    $('#preview-image3').attr('data-link', e.target.result);
    $('#preview-image3').attr('class', 'lightboxed rounded');
    }
    reader3.readAsDataURL(this.files[0]);

    });

    //preview multiple image
    let image_template = document.getElementById('image-template');

    let icons_url = {
        'xlsx' : 'https://img.icons8.com/color/48/000000/ms-excel.png',
        'pdf' : 'https://img.icons8.com/color/50/000000/pdf.png',
        'docx' : 'https://img.icons8.com/color/48/000000/word.png',
    };

    function get_extenstion( file ){
        return file.name.split( "." )[1];
    }


    function show_file_previews( e ){
        let file_element = e.target;
        let files = e.target.files;
        let object_url = null, div = null, extension=null;

        image_template.innerHTML = "";
        if( files.length ){
            for( let index in files ){

                if( files[index] instanceof File ){

                    extension = get_extenstion( files[index] );
                    object_url = ( icons_url[extension] )? icons_url[extension]:  URL.createObjectURL( files[index] );

                    div = document.createElement('DIV');
                    div.innerHTML = `
                        <img src="${object_url}" class="img-small img-fluid" >
                    `;
                    image_template.appendChild( div );
                }

            }
        }
    }

    let file_promise = file => new Promise( ( resolve, reject ) => {
        reader = new FileReader();
        reader.readAsDataURL( file );
        reader.onload = function(){
            resolve(reader.result);
        }
    } );

    async function show_file_preview_using_file_reader( e ){

        let file_element = e.target;
        let files = e.target.files;
        let object_url = null, div = null, reader=null, extension=null;

        image_template.innerHTML = "";
        if( files.length ){
            for( let index in files ){

                if( files[index] instanceof File ){

                        extension = get_extenstion( files[index] );

                        object_url = ( icons_url[extension] )? icons_url[extension]:  await file_promise( files[index] );

                        div = document.createElement('DIV');
                        div.innerHTML = `
                            <div class="col-md-3"><a data-fancybox="gallery" data-src="${object_url}"> <img src="${object_url}" style="height:100px; max-width:100px; object-fit:contain;" class="img-small card-img-top img-fluid" > </a> </div>
                        `;
                        image_template.appendChild( div );
                    }
                }

        }
    }
