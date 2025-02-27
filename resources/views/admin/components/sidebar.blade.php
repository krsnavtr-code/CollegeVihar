@php
// Getting all Admin Pages
$pagegroups = App\Models\Adminpagegroup::with('adminpages')
->orderBy('group_index', 'asc')
->get()
->toArray();
$permissions = Request::get('admin_permissions');
@endphp
<aside class="side_bar">
    <nav>
        <a href="/">
            <img src="/images/web assets/logo_full.jpeg" alt="" class="img-fluid" width="200">
        </a>
        <a class="btn btn-primary flex p-3 ps-4 rounded-0" href="{{ route('admin_home') }}">Dashboard</a>

        @foreach ($pagegroups as $pagegroupIndex => $pagegroup)
        @php
        $inside = false;
        $innerPages = [];
        foreach ($pagegroup['adminpages'] as $page) {
        if ($page['can_display'] && $page['admin_page_status'] && ($permissions && ($permissions[0] == '*' || in_array($page['id'], $permissions)))) {
        $innerPages[] = $page['id'];
        if (Request::get('slug') == $page['admin_page_url']) {
        $inside = true;
        }
        }
        }
        @endphp
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $pagegroupIndex }}">
                    <button class="accordion-button @if(!$inside) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $pagegroupIndex }}" aria-expanded="{{ $inside ? 'true' : 'false' }}" aria-controls="collapse{{ $pagegroupIndex }}">
                        {{ $pagegroup['group_title'] }}
                    </button>
                </h2>
                <div id="collapse{{ $pagegroupIndex }}" class="accordion-collapse collapse @if($inside) show @endif" aria-labelledby="heading{{ $pagegroupIndex }}" data-bs-parent="#accordionExample">
                    <ul>
                        @foreach ($pagegroup['adminpages'] as $adminpage)
                        <!-- <li @class(['active'=> Request::get('slug') == $adminpage['admin_page_url']])> -->
                        <!-- @if (in_array($adminpage['id'], $innerPages)) -->
                        <li>
                            <a href="/admin/{{ $adminpage['admin_page_url'] }}">
                                {{ $adminpage['admin_page_title'] }}
                            </a>
                        </li>
                        <!-- @endif -->
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
        <a class="btn btn-danger flex p-3 ps-4 rounded-0" href="/admin/logout">Logout</a>
    </nav>
</aside>
@push('script')
<script>
    $(".group_title").perform((n, i, no) => {
        let desc = n.nextElementSibling;
        let height = desc.clientHeight + "px";
        n.addEventListener('click', () => {
            no.perform((x) => {
                if (n == x && !x.parentElement.hasClass("active")) {
                    x.parentElement.addClass("active");
                    x.nextElementSibling.addCSS('height', height);
                } else if (n == x && x.parentElement.hasClass("active")) {
                    x.parentElement.removeClass("active");
                    x.nextElementSibling.addCSS('height', "0");
                } else {
                    x.parentElement.removeClass("active");
                    x.nextElementSibling.addCSS('height', "0");
                }
            })
        })
        if (!n.parentElement.hasClass("active")) {
            desc.addCSS('height', "0");
        }
    });
</script>
@endpush