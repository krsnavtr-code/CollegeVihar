<div class="university col-12 col-s-6 col-m-4 col-l-3">
    <div class="wrapper">
        <img class="univ_img" src="{{ !empty($univ_image) ? '/images/university/campus/' . $univ_image : '/images/placeholder-university.jpg' }}" alt="{{ $univ_name ?? 'University' }}" />
        <div class="univ_details">
            <p class="course">{{ !empty($courses) ? count($courses) : 0 }} Course{{ !empty($courses) && count($courses) !== 1 ? 's' : '' }} Available</p>
            <h4 class="univ_name">{{ $univ_name ?? 'University' }}</h4>
            <h5 class="univ_address"><i class="fa-solid fa-location-dot"></i> {{ $state_name ?? 'Location not specified' }}</h5>
            @php
                $urlSlug = !empty($metadata['url_slug']) ? $metadata['url_slug'] : (!empty($univ_slug) ? $univ_slug : '#');
            @endphp
            <a href="/{{ $urlSlug }}" class="btn">Explore</a>
        </div>
    </div>
</div>
