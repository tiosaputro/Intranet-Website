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
                        <h2 class="content-header-title float-start mb-0">Form Edit Content</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ url('backend/management-content') }}">Content EMP</a>
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
                            <form class="pt-0 form" enctype="multipart/form-data" id="image-upload-preview" action="{{ url('backend/management-content/update/'.$row->id.'?modul=content') }}"" method="POST">
                                @csrf()
                          <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" name="title" value="{{ $row->title }}" placeholder="Title News" />
                                    @if ($errors->has('title'))
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">Category</label>
                                    <select name="category" id="select2InModal"  class="form-select form-control" required>
                                        <option value="">--Pilih Category--</option>
                                        @foreach($category as $rows)
                                            <option value="{{ $rows['id'] }}" {{ ($rows['id'] == $row->category) ? 'selected' : '' }}>{{ $rows['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                        <span class="text-danger">{{ $errors->first('category') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">Banner / Slider / Photo</label>
                                    <br/>
                                    <input type="file" name="file" placeholder="Choose image" id="image">
                                    @if ($errors->has('file'))
                                        <span class="text-danger">{{ $errors->first('file') }}</span>
                                    @endif
                                    <div class="col-md-12 mb-2 mt-2">
                                        @if(!file_exists($row->banner_path))
                                            <img id="preview-image" class="lightboxed rounded" rel="group1" src="{{ asset('app-assets/image_not_found.gif') }}" width="120" height="120" style="max-height: 250px;" />
                                        @else
                                        <img id="preview-image" class="lightboxed rounded" rel="group1" src="{{ asset($row->banner_path) }}" width="120" height="120" style="max-height: 250px;" />
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">Meta Tags (Press Comma (,))</label>
                                        <input class="form-control" type="text" name="tags" value="{{ implode(',',json_decode($row->meta_tags,1)) }}">
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
var path = `{{ url('/backend/management-content') }}`;
var sugesTags = `<?php echo json_encode($sugesTags); ?>`;
var token = `{{ csrf_token() }}`;
var modul = $('input[name="category"]').val()
</script>
<script src="https://cdn.ckeditor.com/4.14.0/full/ckeditor.js"></script>
<script src="{{ asset('app-assets/tags-input/js/jquery.amsify.suggestags.js') }}"></script>
<script src="{{ asset('js/pages/form-content.js?v='.date('ymdhis')) }}"></script>
@endpush

