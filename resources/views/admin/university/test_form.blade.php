@extends('admin.components.layout')

@section('main')
    <div class="container">
        <h1>Test University Form</h1>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('test.university.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="univ_id" class="form-label">University ID</label>
                <input type="text" class="form-control" id="univ_id" name="univ_id" value="{{ old('univ_id', 1) }}" required>
            </div>
            
            <div class="mb-3">
                <label for="univ_name" class="form-label">University Name</label>
                <input type="text" class="form-control" id="univ_name" name="univ_name" value="{{ old('univ_name', 'Test University') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', 'Test description') }}</textarea>
            </div>
            
            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" class="form-control" id="logo" name="logo">
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
