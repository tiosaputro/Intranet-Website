@extends('layout_web.template')
@section('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/page-knowledge-base.css') }}">
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
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
                            {{-- <h2 class="content-header-title float-start mb-0">INFO EMP</h2> --}}
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Search Knowledges Sharing
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                    <div class="mb-1 breadcrumb-right">
                        <div class="dropdown">
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Knowledge base Jumbotron -->
                <section id="knowledge-base-search">
                    <div class="row">
                        <div class="col-12">
                            <div class="card knowledge-base-bg text-center" style="background-image: url('{{ $fotoBanner}}'); padding: 1rem !important;">
                                <div class="card-body">
                                    <h2 class="fn-color-nav">Knowledges Sharing EMP</h2>
                                    <p class="card-text mb-2">
                                        <span>Pencarian Semua Tentang : </span><span class="fw-bolder"><i>{{ $keyword }}</i></span>
                                    </p>
                                    <form class="kb-search-input" action="{{ url('knowledges-sharing/search') }}" method="GET">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i data-feather="search"></i></span>
                                            <input type="text" name="q" class="form-control" id="autocomplete" placeholder="Materi Knowledge Sharing EMP" value="{{ $keyword }}" />
                                        </div>
                                    </form>
                                    {!! (count($result) > 0) ? "<h4 class='text-success mt-2'><i data-feather='check-circle'></i> ". count($result).' Pencarian Ditemukan ! </h4>' : "<h5 class='text-danger mt-2'><i data-feather='check-circle'></i> Coba gunakan <i>keyword</i> lain !</h5>" !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Knowledge base Jumbotron -->
                <!-- Knowledge base -->
                <section id="knowledge-base-content">
                    <div class="row kb-search-content-info match-height">
                        <!-- sales card -->
                        @if(count($result) > 0)
                        @foreach($result as $row)
                        <div class="col-md-4 col-sm-6 col-12 kb-search-content">
                            <div class="card">
                                <a href="{{ url('knowledges-sharing/detail/'.$row->id) }}">
                                    <img src="{{ asset($row->banner_path) }}" class="card-img-top" width="250" height="220" alt="knowledge-base-image" />

                                    <div class="card-body text-center">
                                        <h4 class="card-title">{{ $row->title }}</h4>
                                        <div class="d-flex">
                                            <div class="avatar me-50">
                                                <img src="{{ asset($row->photo_author) }}" alt="Avatar" width="24" height="24">
                                            </div>
                                            <div class="author-info">
                                                <small class="text-muted me-25">by</small>
                                                <small><a href="#" class="text-body">{{ $row->author }}</a></small>
                                                <span class="text-muted ms-50 me-25">|</span>
                                                <small class="text-muted">{{ humanDate($row->created_at) }}</small>
                                            </div>
                                        </div>
                                        <div class="card-text text-body mt-1 mb-0 text-truncate my-1 py-25">
                                                @if(is_array(json_decode($row->meta_tags,1)))
                                                @foreach(json_decode($row->meta_tags,1) as $tg)
                                                <a href="{{ url('knowledges-sharing/detail/'.$row->id) }}">
                                                    <span class="badge rounded-pill badge-light-danger me-50">{{ '#'.$tg  }}</span>
                                                </a>
                                                @endforeach
                                                @endif
                                        </div>
                                        <p class="blog-content-truncate text-truncate mt-2">
                                            {!! \Str::words($row->content,15) !!}
                                        </p>
                                    </div>

                                </a>
                            </div>
                        </div>
                        @endforeach
                        @endif

                        @if(count($result) < 1)
                        <!-- no result -->
                        <div class="col-12 text-center no-result no-items">
                            <h4 class="mt-4">Search result not found!!</h4>
                        </div>
                        @endif
                    </div>
                </section>
                <!-- Knowledge base ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
@push('page-js')
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
    var tags = JSON.parse(`<?php echo json_encode($tagging); ?>`);
    $(function() {
       $( "#autocomplete" ).autocomplete({
          source: tags,
          minLength:2,
          delay:500,
          select : showResult,
        //   focus : showResult,
          change :showResult
       });
       function showResult(event, ui){
           if(ui.item.label != ''){
            var q = ui.item.label;
            window.location.href = '/knowledges-sharing/search?q='+q
           }
       }
    });
 </script>
@endpush
