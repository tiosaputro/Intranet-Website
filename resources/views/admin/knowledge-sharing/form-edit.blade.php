@extends('layout_web.template')
<!-- BEGIN: Content-->
@section('custom_css')
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<link href="{{ asset('app-assets/tags-input/css/amsify.suggestags.css') }}" rel="stylesheet"/>
@endsection
@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Form Knowledge Sharing</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ url($route) }}">Knowledge Sharing</a>
                                </li>
                                <li class="breadcrumb-item active">Form Edit
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section id="multiple-column-form">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            <h4 class="card-title">Multiple Column</h4>
                        </div> --}}
                        <div class="card-body">
                            <form class="pt-0 form" enctype="multipart/form-data" id="image-upload-preview" action="{{ url($route.'/update/'.$row->id) }}"" method="POST">
                                @csrf()
                          <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $row->title }}" name="title" placeholder="Title" />
                                    @if ($errors->has('title'))
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">Departement</label>
                                    <select name="departement_id" id="select2InModal"  class="form-select form-control" required>
                                        <option value="">--Pilih Departement--</option>
                                        @foreach($departement as $rows)
                                            <option value="{{ $rows['id'] }}" {{ ($row->departement_id == $rows['id']) ? 'selected' : '' }}>{{ $rows['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                        <span class="text-danger">{{ $errors->first('departement') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">File Share</label>
                                    <br/>
                                    <input type="file" name="file" placeholder="Choose File">
                                    @if ($errors->has('file'))
                                        <span class="text-danger">{{ $errors->first('file') }}</span>
                                    @endif
                                    @if(!file_exists($row->path_file))
                                        <img id="preview-image" class="lightboxed rounded" rel="group1" src="{{ asset('app-assets/image_not_found.gif') }}" width="120" height="120" style="max-height: 250px;" />
                                    @else
                                        @if(checkImageOrFile($row->path_file))
                                            <img id="preview-image" class="lightboxed rounded" rel="group1" src="{{ asset($row->path_file) }}" width="120" height="120" style="max-height: 250px; object-fit:contain;" />
                                        @else
                                            <a href="{{ asset($row->path_file) }}" target="_blank" class="btn btn-sm btn-primary">
                                                <i data-feather="file"></i> File
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">Banner/Photo/Slider</label>
                                    <br/>
                                    <input type="file" name="banner_path" placeholder="Choose image" id="image">
                                    @if ($errors->has('banner_path'))
                                        <span class="text-danger">{{ $errors->first('banner_path') }}</span>
                                    @endif
                                    @if(!file_exists($row->banner_path))
                                        <img id="preview-image" class="lightboxed rounded" rel="group1" src="{{ asset('app-assets/image_not_found.gif') }}" width="120" height="120" style="max-height: 250px;" />
                                    @else
                                        @if(checkImageOrFile($row->banner_path))
                                            <img id="preview-image" class="lightboxed rounded" rel="group1" src="{{ asset($row->banner_path) }}" width="120" height="120" style="max-height: 250px; object-fit:contain;" />
                                        @else
                                            <a href="{{ asset($row->banner_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                                <i data-feather="file"></i> File
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">Meta Tags (Press Koma (,))</label>
                                        <input class="form-control" type="text" name="tags" value="{{ (!empty($row->meta_tags)) ? implode(',',json_decode($row->meta_tags,1)) : ''  }}">
                                        @if ($errors->has('tags'))
                                            <span class="text-danger">{{ $errors->first('tags') }}</span>
                                        @endif
                                </div>

                                @if(in_array('moderasi', $permission) && in_array('update', $permission))
                                <div class="mt-2 form-check form-check-inline" style="">
                                    <input type="checkbox" name="active" class="checkbox form-check-input w-10" {{ ($row->active == 1) ? 'checked' : '' }}> Publish Content ?
                                    @if ($errors->has('active'))
                                    <span class="text-danger">{{ $errors->first('active') }}</span>
                                    @endif
                                </div>

                                @if(!$broadcast)
                                    <div class="mt-2 form-check">
                                        <input type="checkbox" name="broadcast" class="checkbox form-check-input w-10" {{ ($broadcast) ? 'checked' : '' }}> Broadcast Mobile ? <br/><br/>
                                        <span class="alert alert-warning p-1">
                                            <i data-feather="alert-circle"></i> Push Notification to all device
                                        </span>
                                        @if ($errors->has('broadcast'))
                                        <span class="text-danger">{{ $errors->first('broadcast') }}</span>
                                        @endif
                                    </div>
                                @else
                                    <!-- Broadcasted -->
                                    <span class="alert alert-success p-1">
                                        <i data-feather="check-square"></i> Already Broadcast
                                    </span>
                                @endif

                                @endif

                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Author</label>
                                                <input class="form-control" type="text" name="author" value="{{ $row->author }}">
                                                @if ($errors->has('author'))
                                                    <span class="text-danger">{{ $errors->first('author') }}</span>
                                                @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Photo Author</label>
                                            <input type="file" name="photo_author" placeholder="Choose image" id="image2">
                                            @if ($errors->has('photo_author'))
                                                <span class="text-danger">{{ $errors->first('photo_author') }}</span>
                                            @endif
                                            <br/>
                                            <br/>
                                        @if(!file_exists($row->photo_author))
                                            <img id="preview-image" class="lightboxed rounded" rel="group1" src="{{ asset('app-assets/image_not_found.gif') }}" width="120" height="120" style="max-height: 250px;" />
                                            @else
                                            @if(checkImageOrFile($row->photo_author))
                                                <img id="preview-image" class="lightboxed rounded" rel="group1" src="{{ asset($row->photo_author) }}" width="120" height="120" style="max-height: 250px; object-fit:contain;" />
                                            @else
                                                <a href="{{ asset($row->photo_author) }}" target="_blank" class="btn btn-sm btn-primary">
                                                    <i data-feather="file"></i> File
                                                </a>
                                            @endif
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">Content</label>
                                    <textarea name="content" class="my-editor form-control" id="my-editor" cols="30" rows="10">{{ $row->content }}</textarea>
                                    @if ($errors->has('content'))
                                    <span class="text-danger">{{ $errors->first('content') }}</span>
                                @endif
                                </div>
                            </div>

                            <div class="col-xl-4 col-12 mt-3">
                                @if(in_array('create', $permission) || in_array('update', $permission))
                                <button type="submit" class="btn btn-primary me-1 data-submit">Submit</button>
                                @endif
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>

                          </div> <!-- End row -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div> <!-- end content wrapper -->
</div> <!-- end app content -->
@endsection

@push('page-js')
<script>
var path = `{{ url('/backend/management-knowledge-sharing') }}`;
var sugesTags = `<?php echo json_encode($sugesTags); ?>`;
var token = `{{ csrf_token() }}`;
var modul = $('input[name="category"]').val()
</script>
<script src="https://cdn.ckeditor.com/4.14.0/full/ckeditor.js"></script>
<script src="{{ asset('app-assets/tags-input/js/jquery.amsify.suggestags.js') }}"></script>
<script src="{{ asset('js/pages/form-content.js?v='.date('ymdhis')) }}"></script>
@endpush

