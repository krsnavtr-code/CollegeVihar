@php
$permissions = Request::get('admin_permissions');
@endphp
@push('css')
@endpush
@section('popup_content')
<form action="/admin/lead/update" method="post" id="update_form">
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
    <div class="overflow-auto text-nowrap">
        <table class="table">
            <thead class="text-center">
                <tr>
                    <th>Sr.No.</th>
                    @if ($leads['agent_name'])
                    <th>Agent Name</th>
                    @endif
                    <th>Lead Name</th>
                    <th>Qualification</th>
                    <th>Looking For</th>
                    @if ($leads['course'])
                    <th>State</th>
                    @endif
                    @if ($leads['mode_of_admission'])
                    <th>Mode of Admission</th>
                    @endif
                    <th>Date & Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leads as $id => $lead)
                <tr>
                    <td>{{ $id +1 }}.</td>
                    @if ($lead['agent_name'] )
                    <td>{{ $lead['agent_name'] }}</td>
                    @endif
                    <td><a href="/admin/lead/update/{{ $lead['id'] }}">{{ $lead['lead_name'] }}</a></td>
                    <td>{{ $lead['lead_old_qualification'] }}</td>
                    <td>
                        @if ($lead['university'])
                        <span>{{ $lead['university']['univ_name'] }}</span>
                        @endif
                        @if ($lead['course'])
                        <i class="text" title="{{ $lead['course']['course_name'] }}">{{ $lead['course']['course_short_name'] }}</i>
                        @endif
                    </td>
                    @if ($lead['state'])
                    <td>{{ $lead['state']['state_name'] }}</td>
                    @endif
                    @if ($lead['mode_of_admission'])
                    <td>
                        {{ $lead['mode_of_admission'] }}
                    </td>
                    @endif
                    <td class="text-success fw-500">
                        {{ \Carbon\Carbon::parse($lead['created_at'])->format('d-m-y H:i:s') }}
                    </td>
                    <td>
                        @if ($lead['lead_contact'])
                        <a class="btn btn-primary rounded-circle" href="tel:+91{{ $lead['lead_contact'] }}">
                            <i class="icon fa-solid fa-phone"></i>
                        </a>
                        @endif
                        @if ($lead['lead_email'])
                        <a class="btn btn-danger rounded-circle" href="#" data-mail="{{ $lead['lead_email'] }}">
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