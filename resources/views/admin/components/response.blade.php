@if (Session::has('success'))
    @if (Session::get('success'))
        <div class="response success">
            <p class="alert alert-success" role="alert"><i class="fa-solid fa-check"></i>Action Success</p>
        </div>
    @else
        <div class="response error">
            <p  class="alert alert-danger" role="alert"><i class="fa-solid fa-bug"></i>There is some Error</p>
        </div>
    @endif
@endif
