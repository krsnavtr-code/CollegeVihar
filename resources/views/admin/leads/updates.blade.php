
@section('main')
@include('admin.components.popup')
<main>
    <h2 class="page_title">Lead Updates</h2>
    <h3 class="section_title"></h3>
    <div class="overflow-auto text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Sr.No.</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</main>
@endsection
@push('script')
<script>
    $("#update_form").ajaxSubmit();
</script>
@endpush