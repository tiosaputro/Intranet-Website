<div class="horizontal-menu-wrapper ">
    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal floating-nav navbar-light navbar-shadow menu-border container-xl" role="navigation" data-menu="menu-wrapper" data-menu-type="floating-nav">
          <div class="navbar-header">
              <ul class="nav navbar-nav flex-row">
                  <li class="nav-item me-auto" style="top : 0 !important;">
                      <a class="navbar-brand" href="#">
                          <span class="brand-logo">
                              <img src="{{ asset('app-assets/images/logo/logo.png') }}" style="max-width: 136px; max-height:40px;"/>
                          </span>
                           <h2 class="brand-text mb-0 gold shadow-siap"></h2>
                      </a>
                  </li>
                  <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
                      <i data-feather="x" class="d-block d-xl-none text-primary toggle-icon font-medium-4"></i>
                  </a>
                  </li>
              </ul>
          </div>
          <div class="shadow-bottom"></div>
          <div class="navbar-container main-menu-content " data-menu="menu-container" style="border-radius : 0px 0px 10px 7px;">
                <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation" style="justify-content: center;">
                    @if(!empty($menu))
                        @foreach($menu as $row)
                            @php
                                $isLink = ($row['menu_name'] == 'Link') ? true : false;
                                $icon = (!empty($row['menu_icon'])) ? strtolower($row['menu_icon']) : 'menu';
                            @endphp
                            @if(count($row['submenu']) == 0)
                                <li class="nav-item {{ $row['hide_mobile'] == 1 ? 'menu-hide-mobile' : '' }} {{ str_contains(Request::url(), $row['menu_slug']) ? 'active' : '' }}">
                                    <a class="d-flex align-items-center fn-color-nav" href="{{ $row['menu_url'] }}" data-bs-toggle="" data-i18n="">
                                      <i data-feather="{{ $icon }}"></i><span data-i18n="{{ $icon }}">{{ $row['menu_name'] }}</span>
                                    </a>
                                </li>
                            @endif

                            {{-- jika ada submenu --}}
                            @if(count($row['submenu']) > 0 && !$row['haveChild'])
                            {{-- <li class="dropdown nav-item sidebar-group-active active open" data-menu="dropdown"> --}}
                            <li class="dropdown nav-item {{ $row['hide_mobile'] == 1 ? 'menu-hide-mobile' : '' }}" data-menu="dropdown">
                                <a class="dropdown-toggle nav-link d-flex align-items-center fn-color-nav" href="#" data-bs-toggle="dropdown">
                                    <i data-feather="{{ $icon }}"></i><span data-i18n="{{ $icon }}">{{ $row['menu_name'] }}</span>
                                </a>
                                  <ul class="dropdown-menu" data-bs-popper="none">
                                    @foreach($row['submenu'] as $sub)
                                    @php
                                        $subicon = (!empty($sub['menu_icon'])) ? strtolower($sub['menu_icon']) : 'menu';
                                    @endphp
                                    <li class="{{ $sub['hide_mobile'] == 1 ? 'menu-hide-mobile' : '' }} {{ str_contains(Request::url(), $sub['menu_slug']) ? 'active' : '' }}">
                                        @if($isLink)
                                        <a class="dropdown-item d-flex align-items-center fn-color-nav" href="{{ $sub['menu_url'] }}" data-bs-toggle="" data-i18n="{{ $subicon }}">
                                           <strong> <i data-feather="{{ $subicon }}"></i><span data-i18n="{{ $subicon }}">{{ $sub['menu_name'] }}</span> </strong>
                                        </a>
                                        @else
                                        <a class="dropdown-item d-flex align-items-center fn-color-nav" href="{{ $sub['menu_url'] }}" data-bs-toggle="" data-i18n="{{ $subicon }}">
                                            <strong> <i data-feather="{{ $subicon }}"></i><span data-i18n="{{ $subicon }}">{{ $sub['menu_name'] }}</span> </strong>
                                         </a>
                                        @endif
                                    </li>
                                    @endforeach
                                  </ul>
                            </li>
                            <!-- submenu -->
                            @endif

                            <!-- sub-menu level 3 -->
                            @if($row['haveChild'] && count($row['submenu']) > 0)
                            <li class="dropdown nav-item {{ $row['hide_mobile'] == 1 ? 'menu-hide-mobile' : '' }}" data-menu="dropdown"><a class="dropdown-toggle nav-link d-flex align-items-center fn-color-nav" href="#" data-bs-toggle="dropdown"><i data-feather="{{ $row['menu_icon'] }}"></i><span>{{ $row['menu_name'] }}</span></a>
                                <ul class="dropdown-menu" data-bs-popper="none">
                                    @foreach($row['submenu'] as $sub)
                                    @php
                                        $subicon = (!empty($sub['menu_icon'])) ? strtolower($sub['menu_icon']) : 'menu';
                                    @endphp
                                        @if(count($sub['child']) > 0)
                                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu" class="{{ str_contains(Request::url(), $sub['menu_slug']) ? 'active' : '' }} {{ $sub['hide_mobile'] == 1 ? 'menu-hide-mobile' : '' }}">
                                            <a class="dropdown-item d-flex align-items-center dropdown-toggle fn-color-nav" href="#" data-bs-toggle="dropdown" data-i18n="{{ $subicon }}">
                                                <i data-feather="{{ $subicon }}"></i><span data-i18n="{{ $subicon }}">{{ $sub['menu_name'] }}</span>
                                            </a>
                                            <ul class="dropdown-menu" data-bs-popper="none">
                                                @foreach($sub['child'] as $child)
                                                <li data-menu="" class="{{ str_contains(Request::url(), $child['slug']) ? 'active' : '' }}">
                                                    <a class="dropdown-item d-flex align-items-center fn-color-nav" href="{{ $child['url'] }}" data-bs-toggle="" data-i18n="{{ $subicon }}">
                                                        <i data-feather="circle"></i><span data-i18n="{{ $subicon }}">{{ $child['menu_name'] }}</span>
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        @else
                                        <li class="{{ str_contains(Request::url(), $sub['menu_slug']) ? 'active' : '' }} {{ $sub['hide_mobile'] == 1 ? 'menu-hide-mobile' : '' }}">
                                            @if($isLink)
                                            <a class="dropdown-item d-flex align-items-center fn-color-nav" href="{{ $sub['menu_url'] }}" data-bs-toggle="" data-i18n="{{ $subicon }}">
                                               <strong> <i data-feather="{{ $subicon }}"></i><span data-i18n="{{ $subicon }}">{{ $sub['menu_name'] }}</span> </strong>
                                            </a>
                                            @else
                                            <a class="dropdown-item d-flex align-items-center fn-color-nav" href="{{ $sub['menu_url'] }}" data-bs-toggle="" data-i18n="{{ $subicon }}">
                                                <strong> <i data-feather="{{ $subicon }}"></i><span data-i18n="{{ $subicon }}">{{ $sub['menu_name'] }}</span> </strong>
                                             </a>
                                            @endif
                                        </li>
                                        @endif

                                    @endforeach
                                </ul>
                            </li>
                            @endif
                            <!-- end sub-menu level 3 -->

                        @endforeach
                    @endif
                </ul> <!-- ul navbar -->

            </div>
      </div>
</div>
