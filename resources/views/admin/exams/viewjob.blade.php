@extends('admin.components.layout')

@push('css')
<style>
    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
        padding-top: 60px;
        box-sizing: border-box;
    }

    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        max-width: 500px;
        position: relative;
        box-sizing: border-box;
    }

    .close {
        color: #aaa;
        position: absolute;
        top: 10px;
        right: 25px;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>
@endpush

@section('main')
<main>
    <div>
        <h1>View Job Openings</h1>
        <p class="mb-3">All Job openings listed by our team</p>
    </div>
    <div class="overflow-auto text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Job Profile</th>
                    <th>Company</th>
                    <th>Company Email</th>
                    <th>Company Phone</th>
                    <th>Job Experience</th>
                    <th>Job Logo</th>
                    <th>Job Detail</th>
                    <th>Job Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobopenings as $index => $job)
                <tr>
                    <td>{{ $index + 1 }}.</td>
                    <td>{{ $job->job_profile }}</td>
                    <td>{{ $job->company_name }}</td>
                    <td>
                        <a href="mailto:{{ $job->company_email }}">
                            {{ $job->company_email }}
                        </a>
                    </td>
                    <td>
                        <a href="tel:+91{{ $job->company_phone }}">
                            {{ $job->company_phone }}
                        </a>
                    </td>
                    <td>{{ $job->job_experience }}</td>
                    <td>
                        <img src="{{ asset('uploads/logos/'. $job->logo) }}" alt="job" width="100" class="img-fluid">
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary open-modal" data-detail="{{ strip_tags($job->job_detail) }}">View Details</button>
                    </td>
                    <td>
                        @if ($job->job_status == 1)
                        <button class="btn btn-success">Active</button>
                        @else
                        <button class="btn btn-secondary">Inactive</button>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('jobopenings.edit', $job->id) }}" class="btn btn-light rounded-circle">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        <!-- Check permission for delete -->
                        <form action="{{ route('jobopenings.destroyjob', $job->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Delete Job" onclick="return confirm('Are you sure you want to delete this job?')"
                                class="btn btn-danger rounded-circle">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modal-detail"></p>
        </div>
    </div>
</main>
@endsection

@push('script')
<script>
    var modal = document.getElementById("myModal");
    var btns = document.getElementsByClassName("open-modal");
    var span = document.getElementsByClassName("close")[0];
    var modalDetail = document.getElementById("modal-detail");

    Array.from(btns).forEach(function(btn) {
        btn.onclick = function() {
            modal.style.display = "block";
            modalDetail.textContent = this.getAttribute("data-detail");
        }
    });

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endpush