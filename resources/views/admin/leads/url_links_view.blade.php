@php
$permissions = Request::get('admin_permissions');
@endphp
@push('css')

@endpush

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
                    <th>Agent Name</th>
                    <th colspan="4">Social Media Links</th>
                    <th>Job Opening Link</th>
                    <th>LinkedIn Profile Link 1</th>
                    <th>LinkedIn Profile Link 2</th>
                    <th>LinkedIn Profile Link 3</th>
                    <th>LinkedIn Profile Link 4</th>
                    <th>LinkedIn Profile Link 5</th>
                    <th>LinkedIn Profile Link 6</th>
                    <th>LinkedIn Profile Link 7</th>
                    <th>LinkedIn Profile Link 8</th>
                    <th>LinkedIn Profile Link 9</th>
                    <th>LinkedIn Profile Link 10</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leads as $id => $lead)
                <tr>
                    <td>{{ $id + 1 }}.</td>
                    <td>{{ $lead['agent_name'] }}</td>
                    <td>
                        <a class="btn btn-primary rounded-circle" href="{{ $lead['social_media_link_1'] }}">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-danger rounded-circle" href="{{ $lead['social_media_link_2'] }}">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-dark rounded-circle" href="{{ $lead['social_media_link_3'] }}">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-success rounded-circle" href="{{ $lead['social_media_link_4'] }}">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-light rounded-circle" href="{{ $lead['job_opening_link'] }}">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-primary rounded-circle" href="{{ $lead['linkedin_profile_link_1'] }}">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                    </td>
                    <td><a href="{{ $lead['linkedin_profile_link_2'] }}">{{ $lead['linkedin_profile_link_2'] }}</a></td>
                    <td><a href="{{ $lead['linkedin_profile_link_3'] }}">{{ $lead['linkedin_profile_link_3'] }}</a></td>
                    <td><a href="{{ $lead['linkedin_profile_link_4'] }}">{{ $lead['linkedin_profile_link_4'] }}</a></td>
                    <td><a href="{{ $lead['linkedin_profile_link_5'] }}">{{ $lead['linkedin_profile_link_5'] }}</a></td>
                    <td><a href="{{ $lead['linkedin_profile_link_6'] }}">{{ $lead['linkedin_profile_link_6'] }}</a></td>
                    <td><a href="{{ $lead['linkedin_profile_link_7'] }}">{{ $lead['linkedin_profile_link_7'] }}</a></td>
                    <td><a href="{{ $lead['linkedin_profile_link_8'] }}">{{ $lead['linkedin_profile_link_8'] }}</a></td>
                    <td><a href="{{ $lead['linkedin_profile_link_9'] }}">{{ $lead['linkedin_profile_link_9'] }}</a></td>
                    <td><a href="{{ $lead['linkedin_profile_link_10'] }}">{{ $lead['linkedin_profile_link_10'] }}</a></td>
                    <td>
                        <a class="btn btn-light rounded-circle" href="/admin/lead/update/{{ $lead['id'] }}">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- pagination -->
    <x-pagination :paginator="$leads" />
</main>
@endsection