@extends('admin.components.layout')
@section('main')
<main>
    <div>
        <h1 class="page_title">View Ed-Tech Franchise</h1><br>
        <p class="mb-4">All Ed-Tech Franchise Written by our team</p>
    </div>
    <div class="overflow-auto text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach($registrations as $index => $registration)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $registration->name }}</td>
                    <td>{{ $registration->email }}</td>
                    <td>{{ $registration->phone }}</td>
                    <td>{{ $registration->address }}</td>
                    <td>{{ $registration->message }}</td>
                    <td>
                        <form action="{{ route('ed-tech-franchise.destroy', $registration->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this franchise?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-circle">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection