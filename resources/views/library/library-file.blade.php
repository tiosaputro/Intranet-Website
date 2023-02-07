<div class="view-container">
@if(!empty($table))
    @foreach($table as $rowFile)
    <div class="card file-manager-item file">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="checkFile-{{ $rowFile->id }}" />
            <label class="form-check-label" for="checkFile-{{ $rowFile->id }}"></label>
        </div>
        <div class="card-img-top file-logo-wrapper" data-idfile="{{ $rowFile->id }}" data-copy="{{ asset($rowFile->file_path) }}">
            <div class="dropdown float-end">
                <i data-feather="more-vertical" class="toggle-dropdown mt-n25"></i>
            </div>
            <a href="#" onclick="detailInfo(`{{ $rowFile->id }}`)" data-bs-toggle="modal" data-bs-target="#app-file-manager-info-sidebar">
                <div class="d-flex align-items-center justify-content-center w-100">
                    @if($rowFile->type_file == 'image')
                    <img src="{{ asset($rowFile->file_path) }}" class="lightboxed  rounded card-img-top" data-link="{{ asset($rowFile->file_path) }}" data-caption="{{ $rowFile->title }}" style="object-fit: contain;" alt="file-icon" height="67" />
                    @else
                    <img src="{{ asset('app-assets/images/icons/'.$rowFile->ext_file.'.png') }}" alt="file-icon" height="67" />
                    @endif
                </div>
            </a>
        </div>
        <a class="card-body" href="#" onclick="detailInfo(`{{ $rowFile->id }}`)" data-bs-toggle="modal" data-bs-target="#app-file-manager-info-sidebar">
            <div class="content-wrapper">
                <b style="display: none;">{{ (!empty($rowFile->tags_relation)) ? implode(',',json_decode($rowFile->tags_relation,1)) : '' }}</b>
                <p class="card-text file-name mb-0">{{ $rowFile->title }}</p>
                <p class="card-text file-size mb-0">{{ 'Rev. '.$rowFile->rev_no }}</p>
                <p class="card-text file-date">{{ customTanggal($rowFile->created_at, 'd M Y h:i') }}</p>
            </div>
            <small class="file-accessed text-muted">Last Update: {{ humanDate($rowFile->updated_at) }}</small> |
            <small class="card-text file-name"><i class="fa fa-user-check"></i> {{ empty($rowFile->updater->name) ? $rowFile->creator->name : $rowFile->updater->name }}</small>
        </a>
    </div>
    @endforeach
@endif
    <div class="d-none flex-grow-1 align-items-center no-result mb-3">
        <i data-feather="alert-circle" class="me-50"></i>
        No Results
    </div>
</div>

@if($table->count() == 0)
<div class="view-container">
    <div class="alert alert-danger">
        <i data-feather="search"></i> No results found
    </div>
</div>
@endif
