<style>
    .testimonial {
        --bg:red;
        text-align: center;
        padding-block: 80px 40px;
        background: var(--bg);
    }

    .testimonial .wrapper {
        background: #ffffffdd;
        backdrop-filter: blur(10px);
        padding: 50px 15px 20px;
        border-radius: 15px;
    }
    .testimonial .profile_pic {
        --dim: 100px;
        width: var(--dim);
        position: absolute;
        top: 0%;
        transform: translateY(-50%);
        height: var(--dim);
        border: 7px solid var(--bg);
        border-radius: 100px;
        /* box-shadow: 0 0 10px 0 #00000033; */
    }

    .testimonial h4 {
        margin-block: 20px 0px;
        font-size: 2rem;
    }

    .testimonial p {
        font-size: 1.5rem;
        margin-block: 10px;
    }

    .testimonial img {
        border-radius: inherit;
    }
</style>
<div class="testimonial row">
    @php
        $testimonials = [['profile' => '/images/profile/profile 19.jpg', 'username' => 'Kumar', 'review' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque, odio!'], ['profile' => '/images/profile/profile 20.jpg', 'username' => 'Kumar', 'review' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque, odio!'], ['profile' => '/images/profile/profile 21.jpg', 'username' => 'Kumar', 'review' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque, odio!'], ['profile' => '/images/profile/profile 22.jpg', 'username' => 'Kumar', 'review' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque, odio!']];
    @endphp
    @foreach ($testimonials as $testimonial)
        <div class="col-12 col-s-6 col-m-3">
            <div class="wrapper cflex aic">
                <div class="profile_pic">
                    <img src="{{ $testimonial['profile'] }}" alt="profile">
                </div>
                <h4 class="username">{{ $testimonial['username'] }}</h4>
                <p class="review">{{ $testimonial['review'] }}</p>
            </div>
        </div>
    @endforeach
</div>
