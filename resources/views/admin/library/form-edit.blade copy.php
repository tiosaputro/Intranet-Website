@extends('layout_web.template')
<!-- BEGIN: Content-->
@section('custom_css')

<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/pickers/form-pickadate.css') }}">
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
                        <h2 class="content-header-title float-start mb-0">Form {{ $modul }}</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ url($route) }}">{{ $modul }}</a>
                                </li>
                                <li class="breadcrumb-item active">Form Add
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
                        @if (Session::has('error'))
                                <div class="alert alert-danger">
                                    <strong>Error!</strong> {{ Session::get('error') }}
                                </div>
                        @endif
                        <div class="card-body">
                            <form class="pt-0 form" enctype="multipart/form-data" id="image-upload-preview" action="{{ url($route.'/update/'.$row->id) }}"" method="POST">
                                @csrf()
                          <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $row->title }}" placeholder="Title" />
                                    @if ($errors->has('title'))
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $row->name }}" />
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Type Library</label>
                                            <select name="category" id="select2InModal"  class="form-select form-control" required>
                                                <option value="">--Pilih Category--</option>
                                                @foreach($category as $rows)
                                                    <option value="{{ $rows['id'] }}" {{ ($row->category == $rows['id']) ? 'selected' : '' }}>{{ $rows['name'] }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('category'))
                                                <span class="text-danger">{{ $errors->first('category') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Category Level</label>
                                            <input type="text" class="form-control" id="category_library" value="{{ $row->category_libraries }}" name="category_libraries" placeholder="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">File Library</label>
                                    <br/>
                                    <input type="file" name="file" placeholder="Choose File">
                                    @if ($errors->has('file'))
                                        <span class="text-danger">{{ $errors->first('file') }}</span>
                                    @endif
                                    @if(!file_exists($row->file_path))
                                        <span class="text-danger">Empty File</span>
                                    @else
                                        @if(checkImageOrFile($row->file_path))
                                            <img id="preview-image" class="lightboxed rounded" rel="group1" src="{{ asset($row->file_path) }}" width="120" height="120" style="max-height: 250px; object-fit:contain;" />
                                        @else
                                            <div class="mt-1">
                                            <a href="{{ asset($row->file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                                <i data-feather="file"></i> File
                                            </a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">SOP Number</label>
                                                <input class="form-control" type="text" name="sop_number" value="{{ $row->sop_number }}">
                                                @if ($errors->has('sop_number'))
                                                    <span class="text-danger">{{ $errors->first('sop_number') }}</span>
                                                @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Rev No</label>
                                                <input class="form-control" type="number" name="rev_no" value="{{ $row->rev_no }}">
                                                @if ($errors->has('rev_no'))
                                                    <span class="text-danger">{{ $errors->first('rev_no') }}</span>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Issued</label>
                                            <input type="text" class="form-control flatpickr-basic" name="issued" value="{{ $row->issued }}" placeholder="YYYY-MM-DD" />
                                                @if ($errors->has('issued'))
                                                    <span class="text-danger">{{ $errors->first('issued') }}</span>
                                                @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Expired</label>
                                            <input type="text" class="form-control flatpickr-basic" name="expired" value="{{ $row->expired }}" placeholder="YYYY-MM-DD" />
                                                @if ($errors->has('expired'))
                                                    <span class="text-danger">{{ $errors->first('expired') }}</span>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Status</label>
                                            <select name="status" id="select2InModal"  class="form-select form-control" required>
                                                <option value="">--Pilih Status--</option>
                                                @foreach( $status as $rows )
                                                    <option value="{{ $rows['id'] }}" {{ ($rows['id'] == $row->status) ? 'selected' : '' }}>{{ $rows['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Division Owner</label>
                                            <input type="text" class="form-control" name="devision_owner" value="{{ $row->devision_owner }}"/>
                                                @if ($errors->has('devision_owner'))
                                                    <span class="text-danger">{{ $errors->first('devision_owner') }}</span>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Remark</label>
                                            <input type="text" class="form-control" name="remark" value="{{ $row->remark }}"/>
                                            @if ($errors->has('remark'))
                                                <span class="text-danger">{{ $errors->first('remark') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Business Unit</label>
                                            <select name="business_unit_id" class="form-select form-control" required>
                                                <option value="">--Pilih Business Unit--</option>
                                                @foreach( $business_unit as $rows )
                                                    <option value="{{ $rows->id }}" {{ ($rows->id == $row->business_unit_id) ? 'selected' : '' }}>{{ $rows->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Location</label>
                                            <input type="text" class="form-control" name="location" value="{{ $row->location }}"/>
                                            @if ($errors->has('location'))
                                                <span class="text-danger">{{ $errors->first('location') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Shared Function</label>
                                            <select name="shared_function_id" class="form-select form-control" required>
                                                <option value="">--Pilih Business Unit--</option>
                                                @foreach( $shared_function as $rowsSf )
                                                    <option value="{{ $rowsSf->id }}" {{ ($rowsSf->id == $row->shared_function_id) ? 'selected' :'' }}>{{ $rowsSf->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Tags Relation Document (Press Comma (,))</label>
                                                <input class="form-control" type="text" name="tags_relation" value="{{ implode(',',json_decode($row->tags_relation,1)) }}" required>
                                                @if ($errors->has('tags_relation'))
                                                    <span class="text-danger">{{ $errors->first('tags_relation') }}</span>
                                                @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1 mt-2">
                                            <input type="checkbox" name="active" class="checkbox form-check-input" {{ ($row->active == '1') ? 'checked' : '' }}> Status Aktif ?
                                            @if ($errors->has('active'))
                                            <span class="text-danger">{{ $errors->first('active') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                            <div class="col-xl-4 col-12 mt-3">
                                <button type="submit" class="btn btn-primary me-1 data-submit">Submit</button>
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
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
var path = `{{ url($route) }}`;
var sugesTags = `<?php echo json_encode($sugesTags); ?>`;
</script>
<script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
<script src="{{ asset('app-assets/tags-input/js/jquery.amsify.suggestags.js') }}"></script>
<script>
  $('input[name="tags_relation"]').amsifySuggestags({
      type : 'amsify',
      suggestions: JSON.parse(sugesTags)
  });
</script>
{{-- <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script src="{{ asset('js/pages/form-content.js?v='.date('ymdhis')) }}"></script> --}}
@endpush

