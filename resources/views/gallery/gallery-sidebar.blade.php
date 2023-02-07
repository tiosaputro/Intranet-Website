<div class="sidebar-list">
    <!-- links for file manager sidebar -->
    <div class="list-group">
        {{-- <div class="my-drive"></div> --}}
        <a href="{{ url('gallery/filter?all=true') }}" class="list-group-item list-group-item-action {{ str_contains(Request::fullUrl(), '/gallery/filter?all=true') ? 'active' : '' }}">
            <i data-feather="list" class="me-50 font-medium-3"></i>
            <span class="align-middle">All File</span>
        </a>
        <a href="{{ url('gallery/filter?is_important=true') }}" class="list-group-item list-group-item-action {{ str_contains(Request::fullUrl(), '/gallery/filter?is_important=true') ? 'active' : '' }}">
            <i data-feather="star" class="me-50 font-medium-3"></i>
            <span class="align-middle">Important</span>
        </a>
        <a href="{{ url('gallery/filter?recent=true') }}" class="list-group-item list-group-item-action {{ str_contains(Request::fullUrl(), '/gallery/filter?recent=true') ? 'active' : '' }}">
            <i data-feather="clock" class="me-50 font-medium-3"></i>
            <span class="align-middle">Recents</span>
        </a>
    </div>
    <div class="list-group list-group-labels">
        <h6 class="section-label px-2 mb-1">Labels</h6>
        <a href="{{ url('gallery/filter?type_file=document') }}" class="list-group-item list-group-item-action {{ str_contains(Request::fullUrl(), '/gallery/filter?type_file=document') ? 'active' : '' }}">
            <i data-feather="file-text" class="me-50 font-medium-3"></i>
            <span class="align-middle">Documents</span>
        </a>
        <a href="{{ url('gallery/filter?type_file=image') }}" class="list-group-item list-group-item-action {{ str_contains(Request::fullUrl(), '/gallery/filter?type_file=image') ? 'active' : '' }}">
            <i data-feather="image" class="me-50 font-medium-3"></i>
            <span class="align-middle">Images</span>
        </a>
        <a href="{{ url('gallery/filter?type_file=video') }}" class="list-group-item list-group-item-action {{ str_contains(Request::fullUrl(), '/gallery/filter?type_file=video') ? 'active' : '' }}">
            <i data-feather="video" class="me-50 font-medium-3"></i>
            <span class="align-middle">Videos</span>
        </a>
        <a href="{{ url('gallery/filter?type_file=audio') }}" class="list-group-item list-group-item-action {{ str_contains(Request::fullUrl(), '/gallery/filter?type_file=audio') ? 'active' : '' }}">
            <i data-feather="music" class="me-50 font-medium-3"></i>
            <span class="align-middle">Audio</span>
        </a>
        <a href="{{ url('gallery/filter?type_file=archive') }}" class="list-group-item list-group-item-action {{ str_contains(Request::fullUrl(), '/gallery/filter?type_file=archive') ? 'active' : '' }}">
            <i data-feather="layers" class="me-50 font-medium-3"></i>
            <span class="align-middle">Archives</span>
        </a>
    </div>
    <!-- links for file manager sidebar ends -->

</div>
