<section class="other_options rflex jcc" id="">
    <div class="wrapper rflex">
        <div class="other_option cflex">
            <h6>Universities</h6>
            <section class="sub_nav universities cflex">
                <nav class="row">
                    @foreach (Request::get('universities') as $university)
                        <div class="col-6">
                            <div class="wrapper univ">
                                <a href="/{{ $university['metadata']['url_slug'] }}" class="rflex aic"
                                    title="{{ $university['univ_name'] }}">
                                    <img style="height: 40px;width:60px;margin-right:20px;object-fit:contain;"
                                        src="/images/university/logo/{{ $university['univ_logo'] }}" alt="">
                                    <h6>{{ $university['univ_name'] }}</h6>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </nav>
            </section>
        </div>
        <div class="other_option cflex">
            <h6>Under Graduate courses</h6>
            <section class="sub_nav universities cflex">
                <nav class="row">
                    @foreach (Request::get('courses') as $course)
                        @if ($course['course_type'] == 'UG')
                            <div class="col-4">
                                <div class="wrapper univ">
                                    <a href="/{{ $course['metadata']['url_slug'] }}"
                                        title="{{ $course['course_name'] }}">
                                        <h6 style="color: var(--fv_sec)">{{ $course['course_short_name'] }}</h6>
                                        <p style="font-size: 1.2rem">{{ $course['course_name'] }}</p>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </nav>
            </section>
        </div>
        <div class="other_option cflex">
            <h6>Post Graduate courses</h6>
            <section class="sub_nav universities cflex">
                <nav class="row">
                    @foreach (Request::get('courses') as $course)
                        @if ($course['course_type'] == 'PG')
                            <div class="col-4">
                                <div class="wrapper univ">
                                    <a href="/{{ $course['metadata']['url_slug'] }}"
                                        title="{{ $course['course_name'] }}">
                                        <h6 style="color: var(--fv_sec)">{{ $course['course_short_name'] }}</h6>
                                        <p style="font-size: 1.2rem">{{ $course['course_name'] }}</p>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </nav>
            </section>
        </div>
        <div class="other_option cflex">
            <h6>Diploma Courses</h6>
            <section class="sub_nav universities cflex">
                <nav class="row">
                    @foreach (Request::get('courses') as $course)
                        @if ($course['course_type'] == 'DIPLOMA')
                            <div class="col-4">
                                <div class="wrapper univ">
                                    <a href="/{{ $course['metadata']['url_slug'] }}"
                                        title="{{ $course['course_name'] }}">
                                        <h6 style="color: var(--fv_sec)">{{ $course['course_short_name'] }}</h6>
                                        <p style="font-size: 1.2rem">{{ $course['course_name'] }}</p>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </nav>
            </section>
        </div>
        <div class="other_option cflex">
            <h6>Certification Courses</h6>
            <section class="sub_nav universities cflex">
                <nav class="row">
                    @foreach (Request::get('courses') as $course)
                        @if ($course['course_type'] == 'CERTIFICATION')
                            <div class="col-4">
                                <div class="wrapper univ">
                                    <a href="/{{ $course['metadata']['url_slug'] }}"
                                        title="{{ $course['course_name'] }}">
                                        <h6 style="color: var(--fv_sec)">{{ $course['course_short_name'] }}</h6>
                                        <p style="font-size: 1.2rem">{{ $course['course_name'] }}</p>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </nav>
            </section>
        </div>
    </div>
</section>
