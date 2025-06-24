@extends('user.components.layout')

@section('main')
    <main class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="mb-4">Our Courses</h1>
                    
                    <div class="row">
                        @forelse(\App\Models\Course::where('course_status', true)->orderBy('course_name')->get() as $course)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $course->course_name }}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">{{ $course->course_short_name }}</h6>
                                        <p class="card-text">{{ $course->course_eligibility_short }}</p>
                                        <a href="{{ route('course.show', $course->course_slug) }}" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">No courses available at the moment.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
