<div class="view-container">
    <h6 class="files-section-title mt-2 mb-75">Files</h6>
@if(!empty($fileFolder))
    @foreach($fileFolder as $rowFile)
    <div class="card file-manager-item file">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="checkFile-{{ $rowFile->id }}" />
            <label class="form-check-label" for="checkFile-{{ $rowFile->id }}"></label>
        </div>
        <div class="card-img-top file-logo-wrapper" data-idfile="{{ $rowFile->id }}" data-copy="{{ asset($rowFile->path_file) }}">
            <div class="dropdown float-end">
                <i data-feather="more-vertical" class="toggle-dropdown mt-n25"></i>
            </div>
            <div class="d-flex align-items-center justify-content-center w-100">
                <img src="../../../app-assets/images/icons/{{ $rowFile->ext_file }}.png" alt="file-icon" height="45" />
            </div>
        </div>
        <a class="card-body" href="{{ $rowFile->path_file }}" target="_blank">
            <div class="content-wrapper">
                <p class="card-text file-name mb-0">{{ $rowFile->name_file }}</p>
                <p class="card-text file-size mb-0">{{ convertSizeStorage($rowFile->size_file) }}</p>
                <p class="card-text file-date">{{ $rowFile->created_at }}</p>
            </div>
            <small class="file-accessed text-muted">Last Update: {{ humanDate($rowFile->updated_at) }}</small>
            <br/>
            <small class="card-text file-name"><i class="fa fa-user-check"></i> {{ $rowFile->creator->name }}</small>
        </a>
    </div>
    @endforeach
@endif
    <div class="d-none flex-grow-1 align-items-center no-result mb-3">
        <i data-feather="alert-circle" class="me-50"></i>
        No Results
    </div>
</div>

@if($fileFolder->count() == 0)
<div class="view-container">
    <div class="alert alert-danger">
        <i data-feather="search"></i> No results found
    </div>
</div>
@endif
