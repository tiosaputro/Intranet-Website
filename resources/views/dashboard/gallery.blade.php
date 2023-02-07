@section('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/page-profile.css') }}">
@endsection
<!-- Transaction Card -->
<div class="col-lg-4 col-md-6 col-12">
    <div class="card card-transaction">
        <div class="card-header border-top-success p-1">
            <h4 class="card-title"><i class="font-medium-2" data-feather="video"></i> Gallery</h4>
            <div class="dropdown chart-dropdown">
                <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#">Last 28 Days</a>
                    <a class="dropdown-item" href="#">Last Month</a>
                    <a class="dropdown-item" href="#">Last Year</a>
                </div>
            </div>
        </div>
        <div class="card-body" style="background:#f8f8f8;">
            <div class="row" id="user-profile">

                @foreach ($media as $row)
                    <div class="col-md-4 col-6 profile-latest-img">
                        <a href="{{ $row->banner_path }}">
                            <img class="lightboxed  rounded" rel="group1" src="{{ $row->banner_path }}" width="120"
                                height="120" data-link="{{ $row->banner_path }}" alt="Image Alt"
                                data-caption="{{ $row->title }}" style="object-fit: cover;" />
                        </a>
                    </div>
                @endforeach
                @foreach ($info as $row)
                    <div class="col-md-4 col-6 profile-latest-img">
                        <a href="{{ $row->banner_path }}">
                            <img class="lightboxed rounded" rel="group1" src="{{ $row->banner_path }}" width="120"
                                height="120" data-link="{{ $row->banner_path }}" alt="Image Alt"
                                data-caption="{{ $row->title }}" />
                        </a>
                    </div>
                @endforeach
                @foreach ($news as $row)
                    <div class="col-md-4 col-6 profile-latest-img">
                        <a href="{{ $row->banner_path }}">
                            <img class="lightboxed  rounded" rel="group1" src="{{ $row->banner_path }}" width="120"
                                height="120" data-link="{{ $row->banner_path }}" alt="Image Alt"
                                data-caption="{{ $row->title }}" style="object-fit: cover;" />
                        </a>
                    </div>
                @endforeach
                @foreach ($campaign as $row)
                    <div class="col-md-4 col-6 profile-latest-img">
                        <a href="{{ $row->banner_path }}">
                            <img class="lightboxed  rounded" rel="group1" src="{{ $row->banner_path }}" width="120"
                                height="120" data-link="{{ $row->banner_path }}" alt="Image Alt"
                                data-caption="{{ $row->title }}" style="object-fit: cover;" />
                        </a>
                    </div>
                @endforeach

            </div>

        </div>
    </div>
</div>
<!--/ Transaction Card -->
@push('page-js')
    <script src="{{ asset('app-assets/js/scripts/pages/page-profile.js') }}"></script>
@endpush
