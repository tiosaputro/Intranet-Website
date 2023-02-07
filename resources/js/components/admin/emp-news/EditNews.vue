<template>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Edit Form Content</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#/dashboard">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#/admin-emp-news">Data EMP News</a>
                                </li>
                                <li class="breadcrumb-item active">Form Add
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row match-height">
                <div class="card">
                    <div class="card-body border-bottom">
                        <div class="row">
                            <!-- Begin row -->
                            <form class="pt-0" @submit.prevent="addModul">
                            <div class="col-xl-4 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" v-model="form.title" placeholder="Title News" />
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">Category</label>
                                    <select name="category" v-model="form.category" class="select2 form-control" @change="changeCategory(form.category)" required>
                                        <option :value="kategori.id" v-for="kategori in category" :key="kategori.id">{{ kategori.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div style="width:50%;">
                                        <image-zoom
                                            :regular="form.banner"
                                            :zoom="form.banner"
                                            :zoom-amount="2"
                                            :click-zoom="true"
                                            img-class="img-fluid w-100 h-50"
                                            alt="Banner">
                                        </image-zoom>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12" v-if="form.category != null">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold">Change Banner / Slider / Photo</label>
                                        <vue-dropzone :options="dropzoneOptions" :id="bannerid" @vdropzone-removed-file="hapus(this)" v-model="form.banner" ref="dropzone" @vdropzone-success="sendingEvent">
                                        </vue-dropzone>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-6 col-12 mt-5">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">Content</label>
                                    <ckeditor :editor="editor" v-model="form.content" :config="editorConfig"></ckeditor>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">Meta Tags (Press Enter)</label>
                                    <vue-tags-input
                                        id="meta_tags"
                                        v-model="form.tag"
                                        :tags="tags"
                                        @tags-changed="newTags => tags = newTags"
                                        :autocomplete-items="filteredItems"
                                        @keyup="tagging(form.tag)"
                                    ></vue-tags-input>
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">Status </label>
                                    <input type="checkbox" id="checkbox" name="status" class="checkbox" v-model="form.active"> Aktif ?
                                </div>
                            </div>

                            <div class="col-xl-4 col-12 mt-3">
                                <button type="submit" class="btn btn-primary me-1 data-submit" :disabled="disableSubmit">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                            </form>
                        </div> <!-- end row -->
                    </div>
                </div>
            </div>
        </div> <!-- end content body -->
    </div> <!-- end content wrapper -->
</div> <!-- end app content -->
</template>
<style scoped>
@import '/app-assets/vendors/css/forms/select/select2.min.css';
@import url("https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
@import 'vue2-dropzone/dist/vue2Dropzone.min.css';
.dropzone-custom-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}

.dropzone-custom-title {
  margin-top: 0;
  color: #00b782;
}

.subtitle {
  color: #314b5f;
}

</style>
<script>
import FeatherIcon from '../../../@core/components/feather-icon/FeatherIcon.vue'
import CKEditor from "@ckeditor/ckeditor5-vue2";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import VueDropzone from 'vue2-dropzone';
import VueTagsInput from '@johmun/vue-tags-input';
import imageZoom from 'vue-image-zoomer';
const modul = "news";

class MyUploadAdapter {
    constructor( loader ) {
        // The file loader instance to use during the upload.
        this.loader = loader;
    }

    // Starts the upload process.
    upload() {
        return this.loader.file
            .then( file => new Promise( ( resolve, reject ) => {
                this._initRequest();
                this._initListeners( resolve, reject, file );
                this._sendRequest( file );
            } ) );
    }

    // Aborts the upload process.
    abort() {
        if ( this.xhr ) {
            this.xhr.abort();
        }
    }

    // Initializes the XMLHttpRequest object using the URL passed to the constructor.
    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();

        // Note that your request may look different. It is up to you and your editor
        // integration to choose the right communication channel. This example uses
        // a POST request with JSON as a data structure but your configuration
        // could be different.
        xhr.open( 'POST', '/api/uploads/file_content', true );
        xhr.responseType = 'json';
    }

    // Initializes XMLHttpRequest listeners.
    _initListeners( resolve, reject, file ) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = `Couldn't upload file: ${ file.name }.`;

        xhr.addEventListener( 'error', () => reject( genericErrorText ) );
        xhr.addEventListener( 'abort', () => reject() );
        xhr.addEventListener( 'load', () => {
            const response = xhr.response;

            if ( !response || response.error ) {
                return reject( response && response.error ? response.error.message : genericErrorText );
            }

            // If the upload is successful, resolve the upload promise with an object containing
            // at least the "default" URL, pointing to the image on the server.
            // This URL will be used to display the image in the content. Learn more in the
            // UploadAdapter#upload documentation.
            console.log(response)
            resolve( {
                default: response.url
            } );
        } );

        // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
        // properties which are used e.g. to display the upload progress bar in the editor
        // user interface.
        if ( xhr.upload ) {
            xhr.upload.addEventListener( 'progress', evt => {
                if ( evt.lengthComputable ) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            } );
        }
    }

    // Prepares the data and sends the request.
    _sendRequest( file ) {
        // Prepare the form data.
        const data = new FormData();

        data.append( 'upload', file );

        // Important note: This is the right place to implement security mechanisms
        // like authentication and CSRF protection. For instance, you can use
        // XMLHttpRequest.setRequestHeader() to set the request headers containing
        // the CSRF token generated earlier by your application.

        // Send the request.
        this.xhr.send( data );
    }
}

// ...

function MyCustomUploadAdapterPlugin( editor ) {
    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        // Configure the URL to the upload script in your back-end here!
        console.log(loader)
        return new MyUploadAdapter( loader );
    };
}
const formId = '';
export default {
  data(){
      return {
        disableSubmit : false,
         tags: [],
         category : [
             {id : 'info', name : 'Info'},
             {id : 'news', name : 'News'},
             {id : 'media', name : 'Media Highlight'},
             {id : 'campaign', name : 'Company Campaign'}
         ],
         bannerid : "files",
         editId :  1,
         errors : null,
          form : {
              id : '',
              title : '',
              content : '',
              active : '',
              banner : '',
              tag : '',
              push_tags : '',
              category : '',
              autocompleteItems : ''
          },
          editor: ClassicEditor,
          editorConfig: {
                extraPlugins: [ MyCustomUploadAdapterPlugin ],
                // toolbar: [ 'bold', 'italic', '|', 'link', 'ckfinder' ],
                fillEmptyBlocks: false,
                basicEntities: false,
                entities: false,
                entities_greek: false,
                entities_latin: false,
                entities_additional: "",
                // ckfinder: {
                    // Upload the images to the server using the CKFinder QuickUpload command.
                    // uploadUrl : "/api/uploads/file_content",
                    // openerMethod : 'modal',
                    // Define the CKFinder configuration (if necessary).
                    // options: {
                        // resourceType: "Images",
                    // },
                // },
                image: {
                        toolbar: [
                            'imageStyle:inline',
                            'imageStyle:block',
                            'imageStyle:side',
                            '|',
                            'toggleImageCaption',
                            'imageTextAlternative',
                            'ImageResizeEditing'
                        ]
                    },
                // mediaEmbed: {
                //     previewsInData: true,
                // },
            },
            dropzoneOptions: {
                url: "/api/uploads",
                maxFilesize: 25, // MB
                maxFiles: 1,
                thumbnailWidth: 350, // px
                thumbnailHeight: 250,
                addRemoveLinks: true,
                dictDefaultMessage: "<i class='fa fa-cloud-upload'></i> Upload File"

            }
      }
  },
  components: {
      FeatherIcon,
      ckeditor: CKEditor.component,
      VueDropzone,
      VueTagsInput,
      imageZoom
  },
  computed: {
    filteredItems() {
      if(this.autocompleteItems){
        return this.autocompleteItems.filter(i => {
            return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
        });
      }
    },
  },
  created() {
      var self = this;
       axios.get('detail-news/'+this.$route.params.id).then(function(response){
          const row = response.data
          self.tags = JSON.parse(row.meta_tags)
          self.editId = row.id
          self.form =  {
              id : row.id,
              title : row.title,
              content : row.content,
              active : (row.active == 1) ? true : false,
              banner : row.banner_path,
            //   tag : JSON.parse(row.meta_tags),
              category : row.category,
              autocompleteItems : JSON.parse(row.meta_tags)
          };
      })
      .catch(function(error){
          console.log(error)
      });
  },
  methods : {
    changeCategory(id){
      this.dropzoneOptions.url = "/api/uploads/"+id;
    },
    hapus(file){
        this.$refs.dropzone.removeFile(file)
        console.log(file);
    },
    removeAllFiles() {
      this.$refs.dropzone.removeAllFiles();
    },
    sendingEvent (file, res) {
        // this.form.banner = res.path;
        // this.form.id = res.formid
    },
    addModul(){
        this.disableSubmit = true;
        this.form.push_tags = this.tags;
        axios.put(modul+'/'+this.editId, this.form).then(response => (
            this.disableSubmit = false,
            this.$router.push({name: 'management-emp-news-'+modul}),
            this.$swal(this.$func.notifAlert('success','Berhasil','Data Content Berhasil Diperbaharui'))
        ))
        .catch(err=> console.log(err))
        .finally(() =>
            this.getResults()
        ) //end
    }
  } //end methods
}
</script>
