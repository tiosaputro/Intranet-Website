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
                        @include('layout_web.notif-alert')
                        <div class="card-body">
                            <form class="pt-0 form" enctype="multipart/form-data" id="image-upload-preview" action="{{ url($route.'/update/'.$row->id) }}"" method="POST">
                                @csrf()
                          <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Business Unit</label>
                                            <select name="business_unit_id" class="select2 form-select form-control" required>
                                                <option value="">--Business Unit--</option>
                                                @foreach( $business_unit as $rows )
                                                    <option value="{{ $rows->id }}"  {{ ($row->business_unit_id == $rows->id) ? 'selected' : ''}}>{{ $rows->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Category Library</label>
                                            <select name="category_libraries"  class="select2 form-select form-control" required>
                                                <option value="">--Category--</option>
                                                @foreach($categoryLibraries as $rows)
                                                    <option value="{{ $rows }}" {{ ($row->category_libraries == $rows) ? 'selected' : '' }}>{{ $rows }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('category'))
                                                <span class="text-danger">{{ $errors->first('category_libraries') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label fw-bold">Title</label>
                                    <input type="text" class="form-control" id="title" value="{{ $row->title }}" name="title" placeholder="Title" />
                                    @if ($errors->has('title'))
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
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
                                        <div class="mb-1 position-relative">
                                            <label class="form-label fw-bold">Issued (Year-Month-Day)</label>
                                            <input type="text" class="form-control pickadate-months-year" name="issued" value="{{ $issued }}" placeholder="YYYY-MM-DD" />
                                                @if ($errors->has('issued'))
                                                    <span class="text-danger">{{ $errors->first('issued') }}</span>
                                                @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1 position-relative">
                                            <label class="form-label fw-bold">Expired (Year-Month-Day)</label>
                                            <input type="text" class="form-control pickadate-months-year" name="expired" value="{{ $expired }}" placeholder="YYYY-MM-DD" />
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
                                                <option value="">--Status--</option>
                                                @foreach( $status as $rows )
                                                    <option value="{{ $rows }}" {{ ($row->status == $rows) ? 'selected' : '' }}>{{ $rows }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Department/Division Owner</label>
                                            <select name="devision_owner"  class="select2 form-select form-control" required>
                                                <option value="">--Department--</option>
                                                @foreach( $masterDepartment as $rows )
                                                    <option value="{{ $rows['id'] }}" {{ ($row->devision_owner == $rows['id']) ? 'selected' : '' }}>{{ $rows['name'] }}</option>
                                                @endforeach
                                            </select>
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
                                            <label class="form-label fw-bold">Location</label>
                                            <input type="text" class="form-control" name="location" value="{{ $row->location }}"/>
                                            @if ($errors->has('location'))
                                                <span class="text-danger">{{ $errors->first('location') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6">
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
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label fw-bold">Tags Relation Document (Press Comma (,))</label>
                                                <input class="form-control" type="text" name="tags_relation" value="{{ $tags_relation }}">
                                                @if ($errors->has('tags_relation'))
                                                    <span class="text-danger">{{ $errors->first('tags_relation') }}</span>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-1 mt-2">
                                            <input type="checkbox" {{ ($row->active) ? 'checked' : ''}} name="active" class="checkbox form-check-input"> Status Active ?
                                            @if ($errors->has('active'))
                                            <span class="text-danger">{{ $errors->first('active') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-1 form-check">
                                            <input type="checkbox" name="broadcast"
                                                class="checkbox form-check-input w-10"> Broadcast Mobile ?
                                            <br /><br />
                                            <span class="alert alert-warning p-1">
                                                <i data-feather="alert-circle"></i> Push Notification to all device
                                            </span>
                                            <br /><br />
                                            @if($row->is_notif_mobile == 1)
                                                <span class="alert alert-success p-1">
                                                    <i data-feather="check-circle"></i> Already Push Notification
                                                </span>
                                            @endif
                                            @if ($errors->has('broadcast'))
                                                <span class="text-danger">{{ $errors->first('broadcast') }}</span>
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

                            </div> <!-- End row -->
                            </form>
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

