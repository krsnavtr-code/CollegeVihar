@extends('admin.components.layout')
@section('main')
    <main>
        @include('admin.components.response')
        <form action="/admin/web_pages/edit" method="post" enctype="multipart/form-data">
            <h2 class="page_title">Edit Meta Data</h2>
            @csrf
            <section class="">
                <h3 class="section_title">URL slug</h3>
                <input type="hidden" name="meta_id" value="{{ $metadata['id'] }}">
                <div class="field">
                    <input type="text" readonly style="font-weight:600;" value="{{ $metadata['url_slug'] }}" disabled>
                </div>
            </section>
            <section class="panel">
                <h3 class="section_title">Seo Work</h3>
                <div class="field">
                    <label for="meta_h1">Text to display in H1 tag</label>
                    <input type="text" id="meta_h1" name="meta_h1" placeholder="meta_h1"
                        value="{{ $metadata['meta_h1'] }}">
                </div>
                <div class="field_group">
                    <div class="field">
                        <label for="meta_title">Meta Title of Page</label>
                        <input type="text" id="meta_title" name="meta_title" placeholder="meta_title"
                            value="{{ $metadata['meta_title'] }}">
                    </div>
                    <div class="field">
                        <label for="meta_description">Meta Description of Page</label>
                        <input type="text" id="meta_description" name="meta_description" placeholder="meta_description"
                            value="{{ $metadata['meta_description'] }}">
                    </div>
                </div>
                <div class="field">
                    <label for="meta_key">Meta Keywords of Page (key1, key2, key3)</label>
                    <input type="text" id="meta_key" name="meta_keywords" placeholder="meta_keywords"
                        value="{{ $metadata['meta_keywords'] }}">
                </div>
                <div class="field">
                    <label for="om">If any (Write complete tags)</label>
                    <textarea id="om" name="other_meta_tags" placeholder="Write Here...">{{ $metadata['other_meta_tags'] }}</textarea>
                </div>
            </section>
            <div class="text-end p-4">
            <button type="submit" class="btn btn-primary btn-lg">Update Meta Data</button>
        </div>
            <button type="submit"></button>
        </form>
    </main>
    @push('script')
        <script>
            function display_pic(node) {
                $(`label[for='${node.id}'] img`)[0].src = URL.createObjectURL(node.files[0]);
            }
            $(".add_field").perform((n) => {
                let i = 1;
                n.addEventListener('click', function() {
                    n.insert(0, n.get('data-field').replaceAll('__id__', i++));
                });
            })
        </script>
    @endpush
@endsection
