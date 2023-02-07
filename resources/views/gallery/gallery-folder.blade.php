@if(!empty($table))
<div class="view-container">
    <h6 class="files-section-title mt-25 mb-75">Folders</h6>
    <div class="files-header">
        <h6 class="fw-bold mb-0">Filename</h6>
        <div>
            <h6 class="fw-bold file-item-size d-inline-block mb-0">Size</h6>
            <h6 class="fw-bold file-last-modified d-inline-block mb-0">Last modified</h6>
            <h6 class="fw-bold d-inline-block me-1 mb-0">Actions</h6>
        </div>
    </div>
    <div class="card file-manager-item folder level-up">
        <div class="card-img-top file-logo-wrapper">
            <div class="d-flex align-items-center justify-content-center w-100">
                <i data-feather="arrow-up"></i>
            </div>
        </div>
        <div class="card-body ps-2 pt-0 pb-1">
            <div class="content-wrapper">
                <p class="card-text file-name mb-0">...</p>
            </div>
        </div>
    </div>
    @foreach($table as $row)
    <div class="card file-manager-item folder">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="{{ $row->id }}" />
            <label class="form-check-label" for="{{ $row->id }}"></label>
        </div>
        <div class="card-img-top file-logo-wrapper" data-idfolder="{{ $row->id }}" data-copy="{{ url('gallery/folder/'.$row->id)}}">
            <div class="dropdown float-end">
                <i data-feather="more-vertical" class="toggle-dropdown mt-n25"></i>
            </div>
            <a href="{{ url('gallery/folder/'.$row->id)}}">
                <div class="d-flex align-items-center justify-content-center w-100">
                    <?php
                    $thumbnail = thumbnail_gallery($row->id);
                    ?>
                    @if($thumbnail['status'])
                        <img src="{{ asset($thumbnail['path']) }}" class="lightboxed  rounded card-img-top" data-link="{{ asset($thumbnail['path']) }}" data-caption="{{ $thumbnail['path'] }}" style="object-fit: contain;" alt="file-icon" height="67" />
                    @else
                        {!! $thumbnail['path'] !!}
                    @endif
                </div>
            </a>
        </div>
        <a class="card-body" href="{{ url('gallery/folder/'.$row->id) }}" style="color:#5c52c0;">
            <div class="content-wrapper">
                <p class="card-text file-name mb-0">{{ $row->name_folder }}</p>
                <p class="card-text file-size mb-0">{{ convertSizeStorage($row->size_folder) }}</p>
                <p class="card-text file-date">{{ $row->created_at }}</p>
            </div>
            <small class="file-accessed text-muted">Last updated: {{ (empty($row->updated_at)) ? humanDate($row->created_at) : humanDate($row->updated_at) }}</small> |
            <small class="card-text file-name">{{ $row->creator->name }}</small>
            @if(in_array('moderasi', $permission))
            <br/>
            @if($row->is_public == 1)
            <span>
                <i data-feather="check"></i>
                <strong>Publish</strong>
            </span>
                @else
            <span class="text-danger">
                <i data-feather="x"></i>
                <strong>Publish</strong>
            </span>
                @endif
            @endif
        </a>
    </div>
    @endforeach

    <div class="d-none flex-grow-1 align-items-center no-result mb-3">
        <i data-feather="alert-circle" class="me-50"></i>
        No Results
    </div>
</div>
@endif

@if($table->count() == 0)
<div class="view-container">
    <div class="alert alert-danger">
        <i data-feather="search"></i> No results found
    </div>
</div>
@endif
