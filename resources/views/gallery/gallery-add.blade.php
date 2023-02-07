<div class="modal fade" id="new-folder-modal">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content pt-0" id="add-form">
            {{ csrf_field() }}
            <input type="hidden" name="id" id="id">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Folder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger p-2" id="error" style="display:none;">
                    <p id="message-error"></p>
                </div>

                <input type="text" class="form-control" placeholder="Untitled folder" name="name_folder" required/>
                <br/>
                <label class="label">Description Folder</label>
                <textarea class="form-control" name="description"></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" id="submit" class="btn btn-primary me-1 data-submit">Create</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
        </form>
    </div>
</div>

<div class="modal fade" id="upload-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                @if($view_file_folder)
                <h5 class="modal-title" id="title-folder">{{ $table->name_folder }}</h5>
                @else
                <h5 class="modal-title" id="title-folder">Uncategorized</h5>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger p-2" id="error" style="display:none;">
                    <p id="message-error"></p>
                </div>
                <form class="dropzone dropzone-area" id="dpz-multiple-files" action="{{ url('gallery/upload') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @if($view_file_folder)
                    <input type="hidden" name="folder_id" value="{{ $folder_id }}" id="id_upload">
                    @else
                    <input type="hidden" name="folder_id" id="id_upload">
                    @endif
                    <div class="dz-message text-center">Drop files here or click to upload file.</div>
            </div>
            <div class="modal-footer">
                <a href="{{ url()->current() }}" class="btn btn-primary"><i data-feather="check-square"></i> Done & Refresh</a>
            </div>
            </form>
        </div>
    </div>
</div>

