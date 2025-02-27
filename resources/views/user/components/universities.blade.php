<section class="universities">
    <h2 class="section_title">Universities</h2>
    <p class="section_desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed mollitia adipisci cumque illo
        tempora asperiores optio exercitationem velit maxime autem, assumenda atque dicta accusantium quibusdam
        dignissimos quaerat laborum possimus cupiditate.</p>
    <div class="row">
        @php
            $universities = ['a', 'b', 'c', 'd', 'a', 'b', 'c', 'd'];
        @endphp
        @foreach ($universities as $university)
            <x-university univ="1" />
        @endforeach
    </div>
</section>
