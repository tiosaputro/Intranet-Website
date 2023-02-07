<div class="row">
    <div class="col-md-12">
        @if(Session::has('success'))
        <div class="col-md-12">
            <div class="alert alert-success">
                <p class="p-1"><i data-feather="check-circle"></i> {{ Session::get('success') }}</p>
            </div>
        </div>
        @endif
        @if(Session::has('error'))
        <div class="col-md-12">
            <div class="alert alert-danger">
                <p class="p-1"><i data-feather="check-circle"></i> {{ Session::get('error') }}</p>
            </div>
        </div>
        @endif
    </div>
</div>
