@extends('user.components.layout')
@push('css')
    <style>
        main {
            padding: 40px 20px 20px;
        }

        .univ_image {
            isolation: isolate;
            position: relative;
        }

        .univ_image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: #00000099;
            backdrop-filter: blur(5px);
        }

        .univ_image img {
            width: 100%;
        }

        .univ_image .text {
            display: flex;
            overflow: hidden;
            align-items: center;
            justify-content: center;
            position: absolute;
            inset: 0;
            -webkit-text-fill-color: transparent;
            background-size: 100% !important;
            -webkit-background-clip: text !important;
            color: transparent;
            z-index: 1;
        }

        .univ_image h1 {
            font-weight: 900;
            white-space: nowrap;
            font-size: 2rem;
            animation: zoom 3s cubic-bezier(1, 0.04, 1, 1) 1s 1 forwards;
        }

        main section {
            padding: 30px;
            margin-block: 15px;
            border-radius: 5px;
        }

        main section .block p:not(:first-of-type) {
            margin-top: 20px;
        }

        main section .section_desc {
            color: var(--gray_600);
        }

        .advantage .advantage_title {
            margin-bottom: 10px;
            font-size: 1.7rem;
        }

        main section ul {
            margin-top: 10px
        }

        main section li::marker {
            margin-left: 10px;
        }

        main section li {
            padding: 5px;
        }

        section .schedule {
            margin-top: 10px;
        }

        section .schedule p {
            padding: 5px 0;
        }

        section :where(ol, ul) {
            margin-left: 20px;
        }

        .extra_options button {
            padding: 10px;
            border: none;
            border-radius: 7px;
            color: white;
            font-weight: 600;
            background: var(--btn_primary);
        }

        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #00000033;
        }

        th {
            padding: 10px 20px;
            text-align: left;
            background: var(--fv_prime);
            font-weight: 600;
        }

        td {
            padding: 7px 20px;
            border-bottom: 1px solid var(--fv_prime);
        }

        td:nth-of-type(1) {
            font-weight: 600;
        }

        .placements .wrapper {
            border: 2px solid #91a6ff;
            padding: 20px;
            border-radius: 10px;
            transition: all 0.1s;
            background: linear-gradient(315deg, #ffffff 0%, #91a6ff 74%);
        }

        .placements .wrapper:hover {
            scale: 1.05;
        }

        img.icon {
            --dim: 52px;
            height: var(--dim);
            width: var(--dim);
            padding: 10px;
            border-radius: 8px;
        }

        .placements img {
            margin-bottom: 20px;
            background: white;
            box-shadow: 0 0 4px 0 #00000099;
        }

        .placements p {
            font-size: 1.4rem;
            font-weight: 600;
        }

        .schedule .wrapper {
            padding: 20px;
            box-shadow: 0 0 10px 0 #00000033;
            border-radius: 10px;
        }

        .schedule .step {
            letter-spacing: 2px;
            font-weight: 700;
            font-size: 1.2rem;
            color: #a14f00;
        }

        .schedule .step_title {
            font-size: 1.8rem;
        }

        .schedule .step_desc {
            font-size: 1.6rem;
        }

        .advantage .wrapper {
            padding: 10px;
        }

        .advantage img {
            --dim: 80px;
            object-fit: contain;
            margin-bottom: 20px;
        }

        .advantage h6 {
            margin-bottom: 10px;
        }
    </style>
@endpush
@section('main')
    @php
        $page_title = $university['univ_name'];
        $univ_img = $university['univ_image'];
    @endphp
    @include('user.components.univ_breadcrumb')
    <main>
        <div class="container">
            <section>
                <h2 class="section_title left"><span>About {{ $university['univ_name'] }}</span></h2>
                <div class="block">
                    <p>{{ $university['univ_description'] }}</p>
                </div>
            </section>
            <section>
                <h2 class="section_title left"><span>Online Manipal Universities Facts</span></h2>
                <div class="block">{{ $university['univ_facts'] }}</div>
            </section>
            <div class="extra_options row">
                <div class="col-4 cflex">
                    <button class="btn">Download Course Brochure</button>
                </div>
                <div class="col-4 cflex">
                    <button class="btn">Get More Info</button>
                </div>
                <div class="col-4 cflex">
                    <button class="btn">Admission & Fee</button>
                </div>
            </div>
            <section>
                @php
                    $university['univ_advantage'] = json_decode($university['univ_advantage'], true);
                @endphp
                <h2 class="section_title" style="margin-top: 20px;"><span>{{ $university['univ_name'] }} Advantages</span>
                </h2>
                <div class="row advantages">
                    @foreach ($university['univ_advantage']['data'] as $adv)
                        <div class="col-12 col-s-6 col-m-4 cflex advantage">
                            <div class="wrapper">
                                <img class="icon" src="/icon_png/{{ $adv['logo'] }}" alt="icon">
                                <h6 class="advantage_title">{{ $adv['title'] }}</h6>
                                <p class="advantage_desc">{{ $adv['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
            <section>
                <h2 class="section_title"><span></span></h2>
                <table>
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Fees</th>
                            <th>Vacancies</th>
                            <th>Brochure</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $courses = [['course' => 'MBA', 'fee' => '₹1,66,000', 'vacancy' => '', 'brocher' => ''], ['course' => 'BCA', 'fee' => '₹1,35,000', 'vacancy' => '', 'brocher' => ''], ['course' => 'BBA', 'fee' => '₹1,26,000', 'vacancy' => '', 'brocher' => ''], ['course' => 'B.Com', 'fee' => '₹90,000', 'vacancy' => '', 'brocher' => ''], ['course' => 'MCA', 'fee' => '₹1,50,000', 'vacancy' => '', 'brocher' => ''], ['course' => 'MCOM', 'fee' => '₹1,00,000', 'vacancy' => '', 'brocher' => ''], ['course' => 'MA-JMC', 'fee' => '₹1,30,000', 'vacancy' => '', 'brocher' => '']];
                        @endphp
                        @foreach ($courses as $course)
                            <tr>
                                <td>{{ $course['course'] }}</td>
                                <td>{{ $course['fee'] }}</td>
                                <td>{{ $course['vacancy'] }}</td>
                                <td>{{ $course['brocher'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
            <section>
                @php
                    $university['univ_admission'] = json_decode($university['univ_admission'], true);
                @endphp
                <h2 class="section_title left"><span>{{ $university['univ_name'] }} Admission Process</span></h2>
                <p>{{ $university['univ_admission']['about'] }}</p>
                <div class="schedule row">
                    @for ($i = 0; $i < count($university['univ_admission']['data']); $i++)
                        @php
                            $adm = $university['univ_admission']['data'][$i];
                        @endphp
                        <div class="col-12 col-m-6 col-l-3">
                            <div class="wrapper">
                                <p class="step">Step {{ $i + 1 }}</p>
                                <h5 class="step_title">{{ $adm['title'] }}</h5>
                                <p class="step_desc">{{ $adm['description'] }}</p>
                            </div>
                        </div>
                    @endfor
                </div>
            </section>
            <section>
                @php
                    $university['univ_exam_process'] = json_decode($university['univ_exam_process'], true);
                @endphp
                <h2 class="section_title left"><span>{{ $university['univ_name'] }} Examination Pattern</span></h2>
                <p>{{ $university['univ_exam_process']['about'] }}</p>
                <div class="schedule">
                    @foreach ($university['univ_exam_process']['data'] as $ep)
                        <p><b>{{ $ep['title'] }}</b> {{ $ep['description'] }}</p>
                    @endforeach
                </div>
            </section>
            <section>
                @php
                    $university['univ_industry'] = json_decode($university['univ_industry'], true);
                @endphp
                <h2 class="section_title left"><span>Industry-Ready Programs for Enhanced Career Readiness</span></h2>
                <ol>
                    @foreach ($university['univ_industry']['data'] as $re)
                        <li>{{ $re }}</li>
                    @endforeach
                </ol>
            </section>
            <section>
                @php
                    $university['univ_carrier'] = json_decode($university['univ_carrier'], true);
                @endphp
                <h2 class="section_title left"><span>Expert Career Guidance and Placement Services</span></h2>
                <div class="block">
                    <p>{{ $university['univ_carrier']['about'] }}</p>
                </div>
                <ul>
                    @foreach ($university['univ_carrier']['data'] as $car)
                        <li>{{ $car }}</li>
                    @endforeach
                </ul>
            </section>
            <section>
                @php
                    $university['univ_placement_partner'] = json_decode($university['univ_placement_partner'], true);
                @endphp
                <h2 class="section_title left"><span>{{ $university['univ_name'] }} Placement Partners</span></h2>
                <div class="row placements">
                    @foreach ($university['univ_placement_partner']['data'] as $par)
                        <div class="col-12 col-m-4">
                            <div class="wrapper">
                                <img class="icon" src="/icon_png/{{ $par['logo'] }}" alt="icon">
                                <p>{{ $par['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
            </section>
        </div>
    </main>
@endsection
