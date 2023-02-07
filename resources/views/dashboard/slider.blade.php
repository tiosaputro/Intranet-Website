@section('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/page-profile.css') }}">
    <style>
        .btn-remove {
            float: right;
            position: absolute;
            top: 0;
            right: 0;
        }

        .carousel-item.active,
        .carousel-item-next,
        .carousel-item-prev {
            display: block;
            /* background: red; */
            /* padding: 1rem; */
        }

    </style>
@endsection
<div class="col-xl-12 col-12">
    <div class="card-text font-small-3 alert alert-primary mb-2"
        style="padding:0.7rem; background : #234354 !important;">
        @if (empty($message))
            <strong class="text-warning font-small-5">Hallo 🎉 {{ Auth::user()->name }}</strong>, tetap semangat dan
            jangan lupa tetap selalu menjaga protokol kesehatan ya. Terimakasih.
            <button type="button" class="btn btn-sm remove-wishlist btn-remove text-white">
                <i data-feather="x-circle"></i>
            </button>
        @endif

        @if (!empty($message))
            <button type="button" class="btn btn-sm remove-wishlist btn-remove text-white">
                <i data-feather="x-circle"></i>
            </button>

            <div id="carousel-example-caption" class="carousel slide" data-bs-ride="carousel">
                <ol class="carousel-indicators" style="margin-bottom: -1rem !important;">
                    @foreach ($message as $key => $item)
                        <li data-bs-target="#carousel-example-caption" data-bs-slide-to="{{ $key }}"
                            class="{{ $key == 0 ? 'active' : '' }}"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner" role="listbox">
                    @foreach ($message as $key => $item)
                        @php
                            $content = str_replace('[user-name]', Auth::user()->name, $item->content);
                        @endphp
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }} text-center p-1">
                            {!! $content !!}
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" data-bs-target="#carousel-example-caption" role="button"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" data-bs-target="#carousel-example-caption" role="button"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>
        @endif

    </div>
</div>
<div class="col-xl-8 col-12">
    <div class="card">
        <div class="card-header  border-1 p-1">
            <h4 class="card-title fw-bolder">EMP News <i data-feather="globe"></i></h4>
        </div>
        <div class="card-body p-0">
            <div id="carousel-example-caption" class="carousel slide" data-bs-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-bs-target="#carousel-example-caption" data-bs-slide-to="0" class="active"></li>
                    <li data-bs-target="#carousel-example-caption" data-bs-slide-to="1"></li>
                    <!-- <li data-bs-target="#carousel-example-caption" data-bs-slide-to="2"></li> -->
                </ol>
                <div class="carousel-inner" style="">
                    @if (count($news) > 0)
                        @foreach ($news as $idx => $row)
                            <div class="carousel-item {{ $idx == 0 ? 'active' : '' }}" style="max-height: 300px;">
                                <a href="{{ url('content/detail/' . $row->category . '/' . $row->id) }}">
                                    <img class="img-fluid img-rounded" src="{{ $row->banner_path }}" alt="First slide"
                                        style="width:100%;" />
                                    <div class="carousel-caption d-none d-md-block full"
                                        style="background:black; opacity:0.6;">
                                        <h3 class="text-dark">-</h3>
                                        <p class="text-white fw-bolder text-truncate" style="opacity:1 !important;">
                                            {{ $row->title }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
                @if (count($news) < 1)
                    <div class="carousel-inner">
                        <div class="alert alert-danger">
                            <p>News EMP Belum Diinput!</p>
                        </div>
                    </div>
                @endif
                <a class="carousel-control-prev" data-bs-target="#carousel-example-caption" role="button"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" data-bs-target="#carousel-example-caption" role="button"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-4 col-12">

    <!-- latest profile pictures -->
    <div id="user-profile">
        <div class="card">
            <div class="card-header p-1" style="background: #16222A;  /* fallback for old browsers */
                background: -webkit-linear-gradient(to right, #3A6073, #16222A);  /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to right, #3A6073, #16222A); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                ">
                <h4 class="card-title fw-bolder text-white">Quick Menu <i data-feather="external-link"></i></h4>
            </div>
            <div class="card-body" style="background:#f8f8f8;">
                <div class="row match-height mt-2" style="margin:0 auto;">

                    <div class="col-md-4 col-6 profile-latest-img" style="font-size:0.9rem;">
                        <a href="{{ url('directory') }}">
                            <div class="card icon-card cursor-pointer text-center mb-2 mx-50 gold" data-bs-html="true"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Extension & Emergency Phone"
                                style="background:#f8f8f8;">
                                {{-- <img src="{{ asset('app-assets/images/icons/book.svg') }}" alt="Emergency Phone" width="70"> --}}
                                <i data-feather="folder" class="rounded"
                                    style="width:30px; height:30px; margin: 0 auto;"></i>
                                <b class=" mb-0 mt-1 text-center gold">Directory</b>
                            </div>
                        </a>

                    </div>
                    <div class="col-md-4 col-6 profile-latest-img" style="font-size:0.9rem;">
                        <a href="{{ url('library') }}">
                            <div class="card icon-card cursor-pointer text-center mb-2 mx-50 gold" data-bs-html="true"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Library"
                                style="background:#f8f8f8;">
                                <i data-feather="file" class="lg bg-red"
                                    style="width:30px; height:30px; margin:0 auto;"></i>
                                <b class=" mb-0 mt-1 gold">Library</b>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-6 profile-latest-img" style="font-size:0.9rem;">
                        <a href="{{ url('content/search') }}">
                            <div class="card icon-card cursor-pointer text-center mb-2 mx-50 gold" data-bs-html="true"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Info EMP"
                                style="background:#f8f8f8;">
                                <i data-feather="bell" class="lg bg-red"
                                    style="width:30px; height:30px; margin:0 auto;"></i>
                                <b class=" mb-0 mt-1 gold">Info EMP</b>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-6 profile-latest-img" style="font-size:0.9rem;">
                        <a href="{{ url('knowledges-sharing') }}">
                            <div class="card icon-card cursor-pointer text-center mb-2 mx-50 gold" data-bs-html="true"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Knowledges Sharing"
                                style="background:#f8f8f8;">
                                <i data-feather="award" class="lg bg-red"
                                    style="width:30px; height:30px; margin:0 auto;"></i>
                                <b class=" mb-0 mt-1 gold">Knowledge Sharing</b>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-6 profile-latest-img" style="font-size:0.9rem;">
                        <a href="{{ url('calendar') }}">
                            <div class="card icon-card cursor-pointer text-center mb-2 mx-50 gold" data-bs-html="true"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Calendar EMP"
                                style="background:#f8f8f8;">
                                <i data-feather="calendar" class="lg bg-red"
                                    style="width:30px; height:30px; margin:0 auto;"></i>
                                <b class=" mb-0 mt-1 gold">Calendar</b>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ latest profile pictures -->
</div>


@push('page-js')
    <script src="{{ asset('app-assets/js/scripts/pages/page-profile.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/pages/app-ecommerce-wishlist.js') }}"></script>
@endpush
