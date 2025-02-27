<style>

    /* .side_bar>ul>li:where(.active, :hover) {
        background: #ffffff22;
    }

    .side_bar ul li:where(.active, :hover)>a {
        color: var(--gray_100);
        font-weight: 600;
    } */
</style>
<section class="side_bar">
    <ul>
        <li><a href="{{ route('admin_home') }}">Home</a></li>
        <li class="group_head">
            <a class="group_title rflex jcsb aic">Universities <i class="fa-regular fa-angle-down"></i>
            </a>
            <ul>
                @foreach (Request::get('universities') as $university)
                    <li>
                        <a href="/{{ $university['metadata']['url_slug'] }}" class="rflex aic"
                            title="{{ $university['univ_name'] }}">
                            <img style="height: 40px;width:60px;margin-right:20px;"
                                src="/images/university/logo/{{ $university['univ_logo'] }}" alt="">
                            <h6>{{ $university['univ_name'] }}</h6>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
        <li class="group_head">
            <a class="group_title rflex jcsb aic">UG courses <i class="fa-regular fa-angle-down"></i>
            </a>
            <ul>
                @foreach (Request::get('courses') as $course)
                    @if ($course['course_type'] == 'UG')
                        <li>
                            <a href="/{{ $course['metadata']['url_slug'] }}" title="{{ $course['course_name'] }}">
                                <h6>{{ $course['course_short_name'] }}</h6>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </li>
        <li class="group_head">
            <a class="group_title rflex jcsb aic">UG courses <i class="fa-regular fa-angle-down"></i>
            </a>
            <ul>
                @foreach (Request::get('courses') as $course)
                    @if ($course['course_type'] == 'PG')
                        <li>
                            <a href="/{{ $course['metadata']['url_slug'] }}" title="{{ $course['course_name'] }}">
                                <h6>{{ $course['course_short_name'] }}</h6>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </li>
        <li class="group_head">
            <a class="group_title rflex jcsb aic">UG courses <i class="fa-regular fa-angle-down"></i>
            </a>
            <ul>
                @foreach (Request::get('courses') as $course)
                    @if ($course['course_type'] == 'DIPLOMA')
                        <li>
                            <a href="/{{ $course['metadata']['url_slug'] }}" title="{{ $course['course_name'] }}">
                                <h6>{{ $course['course_short_name'] }}</h6>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </li>
        <li class="group_head">
            <a class="group_title rflex jcsb aic">UG courses <i class="fa-regular fa-angle-down"></i>
            </a>
            <ul>
                @foreach (Request::get('courses') as $course)
                    @if ($course['course_type'] == 'CERTIFICATION')
                        <li>
                            <a href="/{{ $course['metadata']['url_slug'] }}" title="{{ $course['course_name'] }}">
                                <h6>{{ $course['course_short_name'] }}</h6>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </li>
    </ul>
</section>
