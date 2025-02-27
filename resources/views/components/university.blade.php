<div class="university col-12 col-s-6 col-m-4 col-l-3">
    <div class="wrapper">
        <img class="univ_img" src="/images/university/campus/{{ $univ_image }}" />
        <div class="univ_details">
            <p class="course">{{ count($courses) }} Course Available</p>
            <h4 class="univ_name">{{ $univ_name }}</h4>
            <h5 class="univ_address"><i class="fa-solid fa-location-dot"></i> {{ $state_name }}</h5>
            {{-- <p class="univ_desc">{{ $desc }}</p> --}}
            <a href="/{{ $metadata['url_slug'] }}" class="btn">Explore</a>
        </div>
    </div>
</div>
