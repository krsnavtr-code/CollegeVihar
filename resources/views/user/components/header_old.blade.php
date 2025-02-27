<!-- <link rel="stylesheet" href="/css/header.css"> -->
<header>
    <!-- Info section -->
    @include('user.components.header.contact_section')
    <!-- Main section -->
    @include('user.components.header.main_section')
    <!-- University section -->
    @include('user.components.header.univ_section')
    <!-- Side Bar section -->
    @include('user.components.header.side_bar')

    <!-- Scroll Progress Bar  Use if you want a scroll progress bar -->
    <div id="scroll_process_bar">
        <span></span>
    </div>
</header>
@push('script')
    <script>
        $("#side_bar_btn").addEventListener("click", function(e) {
            $(".side_bar")[0].addClass("active");
            e.stopPropagation();
        },false);
        document.addEventListener("click", function(e) {
            let sideBar = $(".side_bar")[0];
            if (!sideBar.contains(e.target)) {
                sideBar.removeClass("active");
            }
        });
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
