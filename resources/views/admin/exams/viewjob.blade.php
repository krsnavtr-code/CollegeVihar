@extends('admin.components.layout')

@push('css')
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fff;
        margin: auto;
        padding: 20px;
        border-radius: 8px;
        width: 80%;
        max-width: 600px;
        position: relative;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .close {
        position: absolute;
        right: 15px;
        top: 10px;
        font-size: 28px;
        font-weight: bold;
        color: #aaa;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: #000;
    }

    @media (max-width: 576px) {
        .modal-content {
            width: 90%;
            padding: 15px;
        }
    }
</style>
@endpush

@section('main')
<main>
    <div>
        <h5>View Job Openings</h5>
        <p class="mb-3">All Job openings listed by our team</p>
    </div>
    <div class="overflow-auto text-nowrap">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Job Profile</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Experience</th>
                    <th>Logo</th>
                    <th>Details</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobopenings as $index => $job)
                <tr>
                    <td>{{ $index + 1 }}.</td>
                    <td>{{ $job->job_profile }}</td>
                    <td>{{ $job->company_name }}</td>
                    <td><a href="mailto:{{ $job->company_email }}">{{ $job->company_email }}</a></td>
                    <td><a href="tel:+91{{ $job->company_phone }}">{{ $job->company_phone }}</a></td>
                    <td>{{ $job->job_experience }}</td>
                    <td>
                        <img src="{{ asset('uploads/logos/' . $job->logo) }}" alt="Logo" width="80" class="img-thumbnail">
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary open-modal" data-detail="{{ htmlentities($job->job_detail) }}">
                            View Details
                        </button>
                    </td>
                    <td>
                        @if ($job->job_status == 1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('jobopenings.edit', $job->id) }}" class="btn btn-light rounded-circle" title="Edit">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        <form action="{{ route('jobopenings.destroyjob', $job->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-circle" title="Delete">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-content">
            <span class="close" aria-label="Close">&times;</span>
            <h5 id="modalTitle" class="mb-3">Job Description</h5>
            <div id="modal-detail" style="white-space: pre-wrap;"></div>
        </div>
    </div>
</main>
@endsection

@push('script')
<script>
    const modal = document.getElementById("myModal");
    const modalDetail = document.getElementById("modal-detail");
    const closeModalBtn = document.querySelector(".close");

    // Open modal
    document.querySelectorAll(".open-modal").forEach(btn => {
        btn.addEventListener("click", function () {
            modal.style.display = "block";
            modalDetail.innerHTML = this.getAttribute("data-detail");
        });
    });

    // Close modal
    closeModalBtn.addEventListener("click", () => {
        modal.style.display = "none";
    });

    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
</script>
@endpush
