@extends('layouts.template')
<!-- BEGIN: Content-->
@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper" style="margin-top:-2%;">
        <div class="content-header row">
        </div>
        <div class="content-body">

            <div class="row match-height">
                <div class="col-md-8 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title fw-bolder">EMP News <i data-feather="globe"></i></h4>
                        </div>
                        <div class="card-body">
                            <div id="carousel-example-caption" class="carousel slide" data-bs-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-bs-target="#carousel-example-caption" data-bs-slide-to="0" class="active"></li>
                                    <li data-bs-target="#carousel-example-caption" data-bs-slide-to="1"></li>
                                    <li data-bs-target="#carousel-example-caption" data-bs-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner" style="">
                                    <div class="carousel-item active" style="max-height: 310px;">
                                        <img class="img-fluid" src="../../../app-assets/images/slider/09.jpg" alt="First slide" />
                                        <div class="carousel-caption d-none d-md-block">
                                            <h3 class="text-dark">EMP Peduli</h3>
                                            <p class="text-dark fw-bolder">
                                                EMP Bentu Ltd Berikan Bantuan Timbangan Balita untuk 27 Posyandu di Kabupaten..
                                            </p>
                                        </div>
                                    </div>
                                    <div class="carousel-item" style="max-height: 310px;">
                                        <img class="img-fluid" src="../../../app-assets/images/slider/08.jpg" alt="Second slide" />
                                        <div class="carousel-caption d-none d-md-block">
                                            <h3 class="text-white">Second Slide Label</h3>
                                            <p class="text-white">
                                                Press Release – EMP signed Conditional Sales & Purchase Agreement to acquire the Sengkang Gas Block
                                            </p>
                                        </div>
                                    </div>
                                    <div class="carousel-item" style="max-height: 310px;">
                                        <img class="img-fluid" src="../../../app-assets/images/slider/10.jpg" alt="Third slide" />
                                        <div class="carousel-caption d-none d-md-block">
                                            <h3 class="text-white">Third Slide Label</h3>
                                            <p class="text-white">
                                                EMP Increased Its Stake in the Kangean Block.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <a class="carousel-control-prev" data-bs-target="#carousel-example-caption" role="button" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </a>
                                <a class="carousel-control-next" data-bs-target="#carousel-example-caption" role="button" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- Transaction Card -->
                <div class="col-lg-2 col-12">
                    <div class="card card-transaction">
                        <a class="card-header" href="#grafik-bentu" data-bs-toggle="modal" data-bs-target="#xlarge">
                            <h4 class="card-title fw-bolder text-primary">Production &nbsp; <i data-feather="trending-up" class="text-success font-medium-3"></i></h4>
                            <!-- <div class="dropdown chart-dropdown">
                                <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Last 28 Days</a>
                                    <a class="dropdown-item" href="#">Last Month</a>
                                    <a class="dropdown-item" href="#">Last Year</a>
                                </div>
                            </div> -->
                        </a>
                        <div class="card-body">
                            <div class="transaction-item">
                                <div class="d-flex">
                                    <div class="transaction-percentage">
                                        <h6 class="transaction-title">Emp Bentu</h6>
                                        <small>Oil</small>
                                    </div>
                                </div>
                                <div class="fw-bolder text-success">74</div>
                            </div>
                            <div class="transaction-item">
                                <div class="d-flex">
                                    <div class="transaction-percentage">
                                        <h6 class="transaction-title">EMP Malacca</h6>
                                        <small>Oil</small>
                                    </div>
                                </div>
                                <div class="fw-bolder text-success">480</div>
                            </div>
                            <div class="transaction-item">
                                <div class="d-flex">
                                    <div class="transaction-percentage">
                                        <h6 class="transaction-title">KEI</h6>
                                        <small>Oil</small>
                                    </div>
                                </div>
                                <div class="fw-bolder text-success">590</div>
                            </div>
                            <div class="transaction-item">
                                <div class="d-flex">
                                    <div class="transaction-percentage">
                                        <h6 class="transaction-title">EMP Tonga</h6>
                                        <small>Oil</small>
                                    </div>
                                </div>
                                <div class="fw-bolder text-danger">230</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Transaction Card -->
                    <!-- Transaction Card -->
                <div class="col-lg-2 col-12">
                    <div class="card card-transaction">
                        <a class="card-header" href="#grafik-bentu" data-bs-toggle="modal" data-bs-target="#xlarge">
                            <h4 class="card-title fw-bolder text-primary">Sales &nbsp; <i data-feather="trending-up" class="text-success font-medium-3"></i></h4>
                            <!-- <div class="dropdown chart-dropdown">
                                <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Last 28 Days</a>
                                    <a class="dropdown-item" href="#">Last Month</a>
                                    <a class="dropdown-item" href="#">Last Year</a>
                                </div>
                            </div> -->
                        </a>
                        <div class="card-body">
                            <div class="transaction-item">
                                <div class="d-flex">
                                    <div class="transaction-percentage">
                                        <h6 class="transaction-title">Emp Bentu</h6>
                                        <small>Oil</small>
                                    </div>
                                </div>
                                <div class="fw-bolder text-success">
                                    139
                                </div>
                            </div>
                            <div class="transaction-item">
                                <div class="d-flex">
                                    <div class="transaction-percentage">
                                        <h6 class="transaction-title">EMP Malacca</h6>
                                        <small>Oil</small>
                                    </div>
                                </div>
                                <div class="fw-bolder text-success">480</div>
                            </div>
                            <div class="transaction-item">
                                <div class="d-flex">
                                    <div class="transaction-percentage">
                                        <h6 class="transaction-title">KEI</h6>
                                        <small>Oil</small>
                                    </div>
                                </div>
                                <div class="fw-bolder text-success">590</div>
                            </div>
                            <div class="transaction-item">
                                <div class="d-flex">
                                    <div class="transaction-percentage">
                                        <h6 class="transaction-title">EMP Tonga</h6>
                                        <small>Oil</small>
                                    </div>
                                </div>
                                <div class="fw-bolder text-danger">230</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Transaction Card -->

            </div>

            <!-- Dashboard Ecommerce Starts -->
            <section id="dashboard-ecommerce">
                <div class="row match-height">

                    <!-- Browser States Card -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card card-browser-states">
                            <div class="card-header">
                                <div>
                                    <h4 class="card-title fw-bolder"><i data-feather="tv"></i> Media Highlights</h4>
                                    <!-- <p class="card-text font-small-2">Counter August 2020</p> -->
                                </div>
                                <div class="dropdown chart-dropdown">
                                    <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Last 28 Days</a>
                                        <a class="dropdown-item" href="#">Last Month</a>
                                        <a class="dropdown-item" href="#">Last Year</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Recent Posts -->
                            <div class="blog-recent-posts">
                                <div class="mt-0">
                                    <div class="d-flex mb-2">
                                        <a href="page-blog-detail.html" class="me-2">
                                            <img class="rounded" src="../../../app-assets/images/banner/banner-22.jpg" width="100" height="70" alt="Recent Post Pic" />
                                        </a>
                                        <div class="blog-info">
                                            <h6 class="blog-recent-post-title">
                                                <a href="page-blog-detail.html" class="text-body-heading">EMP MSSA Kenaikan Langkah Penanganan Kebakaran Hutan kepada 300 Siswa di Sungai Apit</a>
                                            </h6>
                                            <div class="text-muted mb-0">5 Oktober 2021</div>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <a href="page-blog-detail.html" class="me-2">
                                            <img class="rounded" src="../../../app-assets/images/banner/banner-27.jpg" width="100" height="70" alt="Recent Post Pic" />
                                        </a>
                                        <div class="blog-info">
                                            <h6 class="blog-recent-post-title">
                                                <a href="page-blog-detail.html" class="text-body-heading">Gas EMP Malacca Strait SA Terangi 3.150 Unit Rumah di Pulau Padang.</a>
                                            </h6>
                                            <div class="text-muted mb-0">4 Oktober 2021</div>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <a href="page-blog-detail.html" class="me-2">
                                            <img class="rounded" src="../../../app-assets/images/banner/banner-39.jpg" width="100" height="70" alt="Recent Post Pic" />
                                        </a>
                                        <div class="blog-info">
                                            <h6 class="blog-recent-post-title">
                                                <a href="page-blog-detail.html" class="text-body-heading">CSR EMP Bentu Ltd Majukan Usaha Olahan Ikan Warga Langgam</a>
                                            </h6>
                                            <div class="text-muted mb-0">4 Oktober 2021</div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <a href="page-blog-detail.html" class="me-2">
                                            <img class="rounded" src="../../../app-assets/images/banner/banner-35.jpg" width="100" height="70" alt="Recent Post Pic" />
                                        </a>
                                        <div class="blog-info">
                                            <h6 class="blog-recent-post-title">
                                                <a href="page-blog-detail.html" class="text-body-heading">Tingkatkan Kualitas Pelayanan Posyandu</a>
                                            </h6>
                                            <div class="text-muted mb-0">3 Oktober 2021</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Recent Posts -->
                            </div>
                        </div>
                    </div>
                    <!--/ Browser States Card -->

                    <!-- Goal Overview Card -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <!-- latest profile pictures -->
                        <div class="card">
                                <div class="card-header">
                                <div><h4 class="card-title fw-bolder"><i data-feather="tv"></i> Company Campaign</h4></div>
                                <div class="dropdown chart-dropdown">
                                    <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Lihat Semua</a>
                                    </div>
                                </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mt-2">
                                        <div class="col-md-4 col-6 profile-latest-img">
                                            <a href="#">
                                                <img src="../../../app-assets/images/pages/eCommerce/sharp-50.jpg" class="img-fluid rounded" alt="avatar img" />
                                                <h6 class="text-center fw-bolder">Poster Program K3nEMP2021</h6>
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-6 profile-latest-img">
                                            <a href="#">
                                                <img src="../../../app-assets/images/pages/eCommerce/sharp-50.jpg" class="img-fluid rounded" alt="avatar img" />
                                                <h6 class="text-center fw-bolder">Poster Tema BK3N2021</h6>
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-6 profile-latest-img">
                                            <a href="#">
                                                <img src="../../../app-assets/images/pages/eCommerce/sharp-50.jpg" class="img-fluid rounded" alt="avatar img" />
                                                <h6 class="text-center fw-bolder">Poster Pemenang Lomba K3N EMP</h6>
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-6 profile-latest-img">
                                            <a href="#">
                                                <img src="../../../app-assets/images/pages/eCommerce/sharp-50.jpg" class="img-fluid rounded" alt="avatar img" />
                                                <h6 class="text-center fw-bolder">Survival Kit</h6>
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-6 profile-latest-img">
                                            <a href="#">
                                                <img src="../../../app-assets/images/pages/eCommerce/sharp-50.jpg" class="img-fluid rounded" alt="avatar img" />
                                                <h6 class="text-center fw-bolder">Berada di tempat kerja</h6>
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-6 profile-latest-img">
                                            <a href="#">
                                                <img src="../../../app-assets/images/pages/eCommerce/sharp-50.jpg" class="img-fluid rounded" alt="avatar img" />
                                                <h6 class="text-center fw-bolder">Istirahat Jam Kerja</h6>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ latest profile pictures -->
                    </div>
                    <!--/ Goal Overview Card -->

                    <!-- Info EMP -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card card-browser-states">
                            <div class="card-header">
                                <div>
                                    <h4 class="card-title fw-bolder"><i data-feather="tv"></i> Info EMP</h4>
                                    <!-- <p class="card-text font-small-2">Counter August 2020</p> -->
                                </div>
                                <div class="dropdown chart-dropdown">
                                    <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Last 28 Days</a>
                                        <a class="dropdown-item" href="#">Last Month</a>
                                        <a class="dropdown-item" href="#">Last Year</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Recent Posts -->
                            <div class="blog-recent-posts">
                                <div class="mt-0">
                                    <div class="d-flex mb-2">
                                        <a href="page-blog-detail.html" class="me-2">
                                            <img class="rounded" src="../../../app-assets/images/banner/banner-19.jpg" width="100" height="70" alt="Recent Post Pic" />
                                        </a>
                                        <div class="blog-info">
                                            <h6 class="blog-recent-post-title">
                                                <a href="page-blog-detail.html" class="text-body-heading">Organisasi Tanggap Darurat Banjir Jabodetabek</a>
                                            </h6>
                                            <div class="text-muted mb-0">5 Oktober 2021</div>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <a href="page-blog-detail.html" class="me-2">
                                            <img class="rounded" src="../../../app-assets/images/banner/banner-15.jpg" width="100" height="70" alt="Recent Post Pic" />
                                        </a>
                                        <div class="blog-info">
                                            <h6 class="blog-recent-post-title">
                                                <a href="page-blog-detail.html" class="text-body-heading">Memo EMP MSSA Mencapai 10 Juta Jam Kerja Aman</a>
                                            </h6>
                                            <div class="text-muted mb-0">4 Oktober 2021</div>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <a href="page-blog-detail.html" class="me-2">
                                            <img class="rounded" src="../../../app-assets/images/banner/banner-21.jpg" width="100" height="70" alt="Recent Post Pic" />
                                        </a>
                                        <div class="blog-info">
                                            <h6 class="blog-recent-post-title">
                                                <a href="page-blog-detail.html" class="text-body-heading">Memo VP HCS Pemakaian Seragam Kerja EMP (Kantor Jakarta)</a>
                                            </h6>
                                            <div class="text-muted mb-0">4 Oktober 2021</div>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <a href="page-blog-detail.html" class="me-2">
                                            <img class="rounded" src="../../../app-assets/images/banner/banner-10.jpg" width="100" height="70" alt="Recent Post Pic" />
                                        </a>
                                        <div class="blog-info">
                                            <h6 class="blog-recent-post-title">
                                                <a href="page-blog-detail.html" class="text-body-heading">Berita Duka</a>
                                            </h6>
                                            <div class="text-muted mb-0">2 Oktober 2021</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Recent Posts -->
                            </div>
                        </div>
                    </div>
                    <!--/ Browser States Card -->
                </div> <!-- End Row -->
            </section>
            <!-- Dashboard Ecommerce ends -->

            <section id="card-3">
                <div class="row match-height">
                        <!-- Developer Meetup Card -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card card-developer-meetup">
                        <div class="card-header">
                            <h5 class="card-title fw-bolder"><i data-feather="award"></i> Upcoming Events</h5>
                            <div class="dropdown chart-dropdown">
                                <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Semua Event</a>
                                    <a class="dropdown-item" href="#">Last Month</a>
                                    <a class="dropdown-item" href="#">Last Year</a>
                                </div>
                            </div>
                        </div>
                        <div class="meetup-img-wrapper rounded-top text-center">
                            <img src="../../../app-assets/images/illustration/email.svg" alt="Meeting Pic" height="170" />
                        </div>
                        <div class="card-body">
                            <div class="meetup-header d-flex align-items-center">
                                <div class="meetup-day">
                                    <h6 class="mb-0">Rabu</h6>
                                    <h3 class="mb-0">06</h3>
                                </div>
                                <div class="my-auto">
                                    <h4 class="card-title mb-25">Meet & Great EMP</h4>
                                    <p class="card-text mb-0">Evaluasi Kinerja</p>
                                </div>
                            </div>
                            <div class="d-flex flex-row meetings">
                                <div class="avatar bg-light-primary rounded me-1">
                                    <div class="avatar-content">
                                        <i data-feather="calendar" class="avatar-icon font-medium-3"></i>
                                    </div>
                                </div>
                                <div class="content-body">
                                    <h6 class="mb-0">Rabu, 06 Oktober 2021</h6>
                                    <small>10:AM to 6:PM</small>
                                </div>
                            </div>
                            <div class="d-flex flex-row meetings">
                                <div class="avatar bg-light-primary rounded me-1">
                                    <div class="avatar-content">
                                        <i data-feather="map-pin" class="avatar-icon font-medium-3"></i>
                                    </div>
                                </div>
                                <div class="content-body">
                                    <h6 class="mb-0">Room 27A </h6>
                                    <small>Bakrie Tower</small>
                                </div>
                            </div>
                            <div class="avatar-group">
                                <div data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="bottom" title="Billy Hopkins" class="avatar pull-up">
                                    <img src="../../../app-assets/images/portrait/small/avatar-s-9.jpg" alt="Avatar" width="33" height="33" />
                                </div>
                                <div data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="bottom" title="Amy Carson" class="avatar pull-up">
                                    <img src="../../../app-assets/images/portrait/small/avatar-s-6.jpg" alt="Avatar" width="33" height="33" />
                                </div>
                                <div data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="bottom" title="Brandon Miles" class="avatar pull-up">
                                    <img src="../../../app-assets/images/portrait/small/avatar-s-8.jpg" alt="Avatar" width="33" height="33" />
                                </div>
                                <div data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="bottom" title="Daisy Weber" class="avatar pull-up">
                                    <img src="../../../app-assets/images/portrait/small/avatar-s-20.jpg" alt="Avatar" width="33" height="33" />
                                </div>
                                <div data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="bottom" title="Jenny Looper" class="avatar pull-up">
                                    <img src="../../../app-assets/images/portrait/small/avatar-s-20.jpg" alt="Avatar" width="33" height="33" />
                                </div>
                                <h6 class="align-self-center cursor-pointer ms-50 mb-0">+42</h6>
                            </div>
                        </div>
                    </div>
                </div> <!-- End Col -->
                <!--/ Developer Meetup Card -->
                <!-- Knowledges Sharing -->
                <div class="col-lg-4 col-md-6 col-12">
                        <!-- twitter feed card -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title fw-bolder"><i data-feather="share" class="font-medium-2"></i> Knowledges Sharing</h5>
                                <div class="dropdown chart-dropdown">
                                    <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Last 28 Days</a>
                                        <a class="dropdown-item" href="#">Last Month</a>
                                        <a class="dropdown-item" href="#">Last Year</a>
                                    </div>
                                </div>
                            </div>
                                <div class="card-body">
                                    <!-- twitter feed -->
                                    <div class="profile-twitter-feed mt-2">
                                        <div class="d-flex justify-content-start align-items-center mb-1">
                                            <div class="avatar me-1">
                                                <img src="../../../app-assets/images/avatars/12-small.png" alt="avatar img" height="40" width="40" />
                                            </div>
                                            <div class="profile-user-info">
                                                <h6 class="mb-0">Mr.Agus</h6>
                                                <a href="#">
                                                    <small class="text-muted">Kepala Bidang</small>
                                                    <i data-feather="check-circle"></i>
                                                </a>
                                            </div>
                                            <div class="profile-star ms-auto">
                                                <i data-feather="star" class="font-medium-3 profile-favorite"></i>
                                            </div>
                                        </div>
                                        <p class="card-text mb-50">
                                        Agile Development Methods (Agile software development)
                                        </p>
                                        <a href="#">
                                            <small>#agile #scrum</small>
                                        </a>
                                    </div>
                                    <!-- twitter feed -->
                                    <div class="profile-twitter-feed mt-2">
                                        <div class="d-flex justify-content-start align-items-center mb-1">
                                            <div class="avatar me-1">
                                                <img src="../../../app-assets/images/avatars/12-small.png" alt="avatar img" height="40" width="40" />
                                            </div>
                                            <div class="profile-user-info">
                                                <h6 class="mb-0">Mr.Arief</h6>
                                                <a href="#">
                                                    <small class="text-muted">Database Administrator</small>
                                                    <i data-feather="check-circle"></i>
                                                </a>
                                            </div>
                                            <div class="profile-star ms-auto">
                                                <i data-feather="star" class="font-medium-3 profile-favorite"></i>
                                            </div>
                                        </div>
                                        <p class="card-text mb-50">
                                            Development Software With Oracle Database
                                        </p>
                                        <a href="#">
                                            <small>#oracle #database #software</small>
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <!--/ twitter feed card -->

                </div>
                <!-- End Knowledge -->

                <!-- Comodities -->
                    <!-- Transaction Card -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card card-transaction">
                            <div class="card-header">
                                <h4 class="card-title"><i class="font-medium-2" data-feather="trending-up"></i> Live Comodities</h4>
                                <div class="dropdown chart-dropdown">
                                    <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Last 28 Days</a>
                                        <a class="dropdown-item" href="#">Last Month</a>
                                        <a class="dropdown-item" href="#">Last Year</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title fw-bolder">investing.com</h4>
                                <div class="transaction-item">
                                    <div class="d-flex">
                                        <div class="avatar bg-light-info rounded float-start">
                                            <div class="avatar-content">
                                                <i data-feather="trending-up" class="avatar-icon font-medium-3"></i>
                                            </div>
                                        </div>
                                        <div class="transaction-percentage">
                                            <h6 class="transaction-title">Brent Oil</h6>
                                            <small><i data-feather="clock"></i> 10:20:19 | Energy</small>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="fw-bolder text-danger">-0.35 &nbsp; &nbsp; &nbsp; &nbsp; (0.57%) </div>
                                    </div>

                                    <div class="fw-bolder text-success float-right">62.80</div>
                                </div>
                                <div class="transaction-item">
                                    <div class="d-flex">
                                        <div class="avatar bg-light-info rounded float-start">
                                            <div class="avatar-content">
                                                <i data-feather="trending-up" class="avatar-icon font-medium-3"></i>
                                            </div>
                                        </div>
                                        <div class="transaction-percentage">
                                            <h6 class="transaction-title">Crude Oil WTI</h6>
                                            <small><i data-feather="clock"></i> 09:20:19 | Energy</small>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="fw-bolder text-danger">-0.48 &nbsp; &nbsp; &nbsp; &nbsp; (0.80%) </div>
                                    </div>

                                    <div class="fw-bolder text-success float-right">59.29</div>
                                </div>
                                <div class="transaction-item">
                                    <div class="d-flex">
                                        <div class="avatar bg-light-danger rounded float-start">
                                            <div class="avatar-content">
                                                <i data-feather="trending-down" class="avatar-icon font-medium-3"></i>
                                            </div>
                                        </div>
                                        <div class="transaction-percentage">
                                            <h6 class="transaction-title">Gold</h6>
                                            <small><i data-feather="clock"></i> 09:20:19 | Metails</small>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="fw-bolder text-success">+5.25 &nbsp; &nbsp; &nbsp; &nbsp; (+0.90%) </div>
                                    </div>

                                    <div class="fw-bolder text-danger float-right">1.746.29</div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--/ Transaction Card -->

                <!-- End Comodities -->

                </div> <!-- End Row -->
            </section>

        </div>
    </div>
</div>
<!-- END: Content-->
@endsection

