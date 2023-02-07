@extends('layout_web.template')
<!-- BEGIN: Content-->
@section('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/page-profile.css') }}">
{{-- <link rel="stylesheet" type="text/css" href="https://unpkg.com/xzoom/dist/xzoom.css" media="all" />
<link rel="stylesheet" type="text/css" href="https://payalord.github.io/xZoom/examples/fancybox/source/jquery.fancybox.css" media="all" /> --}}
<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"
/>
<style>
.content-html{
    text-justify: auto;
    overflow-wrap: break-word;
    word-wrap: break-word;
    hyphens: auto;
}
figure img{
    width: 50% !important;
    max-width: 400px;
}
</style>

@endsection

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('knowledges-sharing') }}">{{ strtoupper($category) }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ $news->title }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                    <div class="mb-1 breadcrumb-right">

                    </div>
                </div>
            </div>
            <div class="content-detached content-left">
                <div class="content-body">
                    <!-- Blog Detail -->
                    <div class="blog-detail-wrapper">
                        <div class="row">
                            <!-- Blog -->
                            <div class="col-12">
                                <div class="card">
                                    @if(!empty($news->banner_path))
                                    <a data-fancybox="gallery" data-src="{{ asset($news->banner_path) }}">
                                        <img src="{{ asset($news->banner_path) }}" class="rounded img-fluid card-img-top" data-caption="{{ $news->title }}" style="max-height:370px; max-width:100%; object-fit:cover;" />
                                    </a>
                                    @endif

                                    <div class="card-body">
                                        <h4 class="card-title">{{ $news->title }}</h4>
                                        <div class="d-flex">
                                            <div class="avatar me-50">
                                                @if(!empty($news->photo_author))
                                                <img src="{{ asset($news->photo_author) }}" alt="Avatar" width="24" height="24" />
                                                @else
                                                <img src="{{ asset('app-assets/images/portrait/small/avatar-s-7.jpg') }}" alt="Avatar" width="24" height="24" />
                                                @endif
                                            </div>
                                            <div class="author-info">
                                                <small class="text-muted me-25">by</small>
                                                <small><a href="#" class="text-body">{{ $news->author }}</a></small>
                                                <span class="text-muted ms-50 me-25">|</span>
                                                <small class="text-muted">{{ humanDate($news->created_at) }}</small>
                                                @if(!empty($news->path_file))
                                                <span class="text-muted ms-50 me-25">|</span>
                                                <small class="">
                                                    <a href="{{ asset($news->path_file) }}" target="_blank" class="btn btn-sm btn-primary">Download File</a>
                                                </small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="my-1 py-25">
                                            @if(is_array($news->meta_tags))
                                            @foreach($news->meta_tags as $row)
                                            <a href="#">
                                                <span class="badge rounded-pill badge-light-danger me-50">{{ $row  }}</span>
                                            </a>
                                            @endforeach
                                            @endif
                                        </div>
                                        <div class="col-lg-12" class="content-html card-text mb-2">
                                            <b>
                                            @php
                                            $konten = str_replace("storage/","../../../storage/",$news->content);
                                            $konten = popupImageCkeditor($konten);
                                            @endphp
                                            {!! $konten !!}
                                            </b>
                                        </div>
                                      <!-- Comment -->
                                        <div class="d-flex align-items-start">
                                            <div class="avatar me-2" style="display:none;">
                                                <img src="{{ asset('app-assets/images/portrait/small/avatar-s-6.jpg') }}" width="60" height="60" alt="Avatar" />
                                            </div>
                                            <div class="author-info" style="display:none;">
                                                <h6 class="fw-bolder">Mr. Arief</h6>
                                                <p class="card-text mb-0">
                                                   Okeey
                                                </p>
                                            </div>
                                        </div>
                                        <hr class="my-2" />
                                        <div class="d-flex align-items-center justify-content-between" style="display: none !important;">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center me-1">
                                                    <a href="#" class="me-50">
                                                        <i data-feather="message-square" class="font-medium-5 text-body align-middle"></i>
                                                    </a>
                                                    <a href="#">
                                                        <div class="text-body align-middle">19.1K</div>
                                                    </a>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <a href="#" class="me-50">
                                                        <i data-feather="bookmark" class="font-medium-5 text-body align-middle"></i>
                                                    </a>
                                                    <a href="#">
                                                        <div class="text-body align-middle">139</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="dropdown blog-detail-share">
                                                <i data-feather="share-2" class="font-medium-5 text-body cursor-pointer" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="#" class="dropdown-item py-50 px-1">
                                                        <i data-feather="github" class="font-medium-3"></i>
                                                    </a>
                                                    <a href="#" class="dropdown-item py-50 px-1">
                                                        <i data-feather="gitlab" class="font-medium-3"></i>
                                                    </a>
                                                    <a href="#" class="dropdown-item py-50 px-1">
                                                        <i data-feather="facebook" class="font-medium-3"></i>
                                                    </a>
                                                    <a href="#" class="dropdown-item py-50 px-1">
                                                        <i data-feather="twitter" class="font-medium-3"></i>
                                                    </a>
                                                    <a href="#" class="dropdown-item py-50 px-1">
                                                        <i data-feather="linkedin" class="font-medium-3"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end Comment -->
                                    </div>
                                </div>
                            </div>
                            <!--/ Blog -->

                            <!-- Blog Comment -->
                            <div class="col-12 mt-1" id="blogComment" style="display: none;">
                                <h6 class="section-label mt-25">Comment</h6>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            <div class="avatar me-75">
                                                <img src="{{ asset('app-assets/images/portrait/small/avatar-s-9.jpg') }}" width="38" height="38" alt="Avatar" />
                                            </div>
                                            <div class="author-info">
                                                <h6 class="fw-bolder mb-25">Mr.Agus</h6>
                                                <p class="card-text">4 Januari, 2021.</p>
                                                <p class="card-text">
                                                    Mantabss
                                                </p>
                                                <a href="#">
                                                    <div class="d-inline-flex align-items-center">
                                                        <i data-feather="corner-up-left" class="font-medium-3 me-50"></i>
                                                        <span>Reply</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Blog Comment -->

                            <!-- Leave a Blog Comment -->
                            <div class="col-12 mt-1" style="display: none;">
                                <h6 class="section-label mt-25">Leave a Comment</h6>
                                <div class="card">
                                    <div class="card-body">
                                        <form action="javascript:void(0)" class="form">
                                            <div class="row">
                                                <div class="col-sm-6 col-12">
                                                    <div class="mb-2">
                                                        <input type="text" class="form-control" placeholder="Name" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-12">
                                                    <div class="mb-2">
                                                        <input type="email" class="form-control" placeholder="Email" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-12">
                                                    <div class="mb-2">
                                                        <input type="url" class="form-control" placeholder="Website" />
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <textarea class="form-control mb-2" rows="4" placeholder="Comment"></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-check mb-2">
                                                        <input type="checkbox" class="form-check-input" id="blogCheckbox" />
                                                        <label class="form-check-label" for="blogCheckbox">Save my name, email, and website in this browser for the next time I comment.</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary">Post Comment</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--/ Leave a Blog Comment -->
                        </div>
                    </div>
                    <!--/ Blog Detail -->

                </div>
            </div>

        @include('blog-content.recentpost')

        </div>
    </div>
    <!-- END: Content-->
@endsection
@push('page-js')

{{-- <script type="text/javascript" src="https://payalord.github.io/xZoom/examples/hammer.js/1.0.5/jquery.hammer.min.js"></script> --}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> --}}
{{-- <script type="text/javascript" src="https://unpkg.com/xzoom/dist/xzoom.min.js"></script>
<script type="text/javascript" src="https://payalord.github.io/xZoom/examples/fancybox/source/jquery.fancybox.js"></script>

<script type="text/javascript" src="https://payalord.github.io/xZoom/examples/js/setup.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script>
    // Customization example
    Fancybox.bind('[data-fancybox="gallery"]', {
    infinite: false
    });
</script>
@endpush


