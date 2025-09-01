<div class="col-lg-12" style="margin-top: 20px">
    @if ($message = Session::get('success'))
        <div class="alert alert-success  alert-dismissible" role="alert">
            <p class="mb-0">{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                    fdprocessedid="dwqnc"></button>
        </div>
    @endif


    @if ($message = Session::get('error'))
        <div class="alert alert-danger  alert-dismissible" role="alert">
            <p class="mb-0">{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                    fdprocessedid="dwqnc"></button>
        </div>
    @endif


    @if ($message = Session::get('warning'))
        <div class="alert alert-warning  alert-dismissible" role="alert">
            <p class="mb-0">{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                    fdprocessedid="dwqnc"></button>
        </div>
    @endif


    @if ($message = Session::get('info'))
        <div class="alert alert-info  alert-dismissible" role="alert">
            <p class="mb-0">{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                    fdprocessedid="dwqnc"></button>
        </div>
    @endif


    @if ($errors->any())
        <div class="alert alert-danger  alert-dismissible" role="alert">
            <p class="mb-0">{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                    fdprocessedid="dwqnc"></button>
        </div>
    @endif
</div>
