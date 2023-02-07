<div class="sidebar-list">
    <!-- links for file manager sidebar -->
    <div class="list-group">
        {{-- <div class="my-drive"></div> --}}
        <a href="{{ url($route.'/filter?recent=true') }}" class="list-group-item list-group-item-action {{ str_contains(Request::fullUrl(), $route.'/filter?recent=true') ? 'active' : '' }}">
            <i data-feather="clock" class="me-50 font-medium-3"></i>
            <span class="align-middle">Recents</span>
        </a>
        @if(!empty($category))
            @foreach($category as $val)
                <a href="{{ url($route.'/filter?category='.$val) }}" class="list-group-item list-group-item-action {{ str_contains(Request::fullUrl(), $route.'/filter?category='.str_replace(" ","%20",$val)) ? 'active' : '' }}">
                    <i data-feather="star" class="me-50 font-medium-3"></i>
                    <span class="align-middle">{{ $val }}</span>
                </a>
            @endforeach
        @endif
    </div>
    <div class="list-group list-group-labels">
        <h6 class="section-label px-2 mb-1">Business Unit</h6>
        @foreach($businessUnit as $bu)
        <a href="{{ url($route.'/filter?bu='.$bu->id) }}" class="list-group-item list-group-item-action {{ str_contains(Request::fullUrl(), $route.'/filter?bu='.$bu->id) ? 'active' : '' }}">
            <i data-feather="file-text" class="me-50 font-medium-3"></i>
            <span class="align-middle">{{ $bu->name }}</span>
        </a>
        @endforeach
    </div>
    <!-- links for file manager sidebar ends -->

</div>
