@php
$permissions = Request::get('admin_permissions');
@endphp
@section('popup_content')
<form action="/admin/lead/update" method="post" style="padding:20px" id="update_form">
    @csrf
    <h6>Add Response</h6>
    <input type="hidden" name="lead_id" id="current_lead">
    <div class="field">
        <select name="update_from">
            <option>Call</option>
            <option>Mail</option>
            <option>WhatsApp</option>
            <option>Linked In</option>
            <option>Telegram</option>
            <option>Facebook</option>
            <option>Instagram</option>
        </select>
    </div>
    <div class="field">
        <textarea name="update_text" id="" placeholder="Add Note..."></textarea>
    </div>
    <button>Add Response</button>
</form>
@endsection
@extends('admin.components.layout')
@section('main')
@include('admin.components.popup')
<main>
    <h2 class="page_title">Leads</h2>
    <div class="overflow-auto text-nowrap text-center">
        <table class="table">
            <thead>
                <tr>
                    <th>Sr.No.</th>
                    <th>Lead Name</th>
                    <th>Looking For</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leads as $id => $lead)
                <tr>
                    <td> {{ $id +1 }} </td>
                    <td>
                        <a href="/admin/lead/update/{{ $lead['id'] }}">
                            {{ $lead['lead_name'] }}
                        </a>
                    </td>
                    <td>
                        @if ($lead['university'])
                        <span>{{ $lead['university']['univ_name'] }}</span>
                        @endif
                        @if ($lead['course'])
                        <i class="text" title="{{ $lead['course']['course_name'] }}" style="font-size:1.2rem">{{ $lead['course']['course_short_name'] }}</i>
                        @endif
                    </td>
                    @if ($lead['getAddress'])
                    <td> {{ $lead['getAddress'] }}</td>
                    @endif
                    <td>
                        @if ($lead['getNumber'])
                        <a class="btn btn-primary rounded-circle" href="tel:+91{{ $lead['getNumber'] }}"><i class="icon fa-solid fa-phone"></i></a>
                        @endif
                        @if ($lead['getEmail'])
                        <a class="btn btn-danger rounded-circle" href="#" data-mail="{{ $lead['getEmail'] }}">
                            <i class="fa-solid fa-envelope"></i>
                        </a>
                        @endif
                        <button class="btn btn-light rounded-circle" onclick="edit_lead(this)" data-lead="{{ $lead['id'] }}">
                            <i class="fa-solid fa-pencil"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- pagination --}}
    <x-pagination :paginator="$leads" />

</main>
@endsection
@push('script')
<script>
    function edit_lead(node) {
        $("#current_lead").value = node.get("data-lead");
        show_popup();
    }
    $("#update_form").ajaxSubmit();
</script>
@endpush