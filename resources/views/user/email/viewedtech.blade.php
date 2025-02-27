@extends('admin.components.layout')

@push('css')
<style>
            
table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
        }
        .delete-button {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }
        .delete-button:hover {
            background-color: #c82333;
        }
</style>
@endpush

@section('main')
    <main>
        <div>
            <h1 class="page_title">View Competitive Exam</h1><br>
            <p class="page_sub_title">All Competitive Exam Written by our team</p>
        </div>

        <table>
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

                @foreach($registrations as $registration)
                <tr>
                    <td>{{ $registration->name }}</td>
                    <td>{{ $registration->email }}</td>
                    <td>{{ $registration->phone }}</td>
                    <td>{{ $registration->address }}</td>
                    <td>{{ $registration->message }}</td>
                    <td>
                        <form action="{{ route('ed-tech-franchise.destroy', $registration->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </main>
    @endsection