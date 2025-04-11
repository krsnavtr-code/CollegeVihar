@extends('admin.components.layout')

@section('main')
<div class="container mt-4">
    <div class="card shadow-lg p-4 w-50 mx-auto">
        <h2 class="text-center">📧 Send Bulk Emails</h2>

        {{-- Success & Error Message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.send-email') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Emails</label>
                <textarea id="emailInput" name="emails" class="form-control" rows="3" 
                    placeholder="Enter emails separated by comma" required 
                    oninput="autoResize(this)" 
                    style="resize: none; overflow-y: hidden; width: 100%;"></textarea>
                <small id="emailError" style="color: red; display: none;">❌ Invalid email(s) detected</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Subject</label>
                <input type="text" name="subject" class="form-control" placeholder="Subject for Email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Message (Optional)</label>
                <textarea name="message" cols="30" rows="5" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Attachments (Optional)</label>
                <input type="file" name="attachments[]" multiple class="form-control" accept="*">
            </div>
            <button type="submit" class="btn btn-primary mt-3 w-50">Send</button>
        </form>
    </div>



    <!-- proposal email form -->
    <div class="container mt-4">
        <div class="card shadow-lg p-4 w-50 mx-auto">
            <h2 class="text-center">📄 Send Proposal Email</h2>

            {{-- Success & Error Message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.send-proposal-email') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Recipient Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter recipient's email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" placeholder="Proposal Subject" value="College Vihar Proposal" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Cover Letter (Optional)</label>
                    <textarea name="cover_letter" class="form-control" rows="5" placeholder="Add a personalized cover letter..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-3 w-50">Send Proposal</button>
            </form>
        </div>
    </div>

{{-- Auto-hide messages after 3 seconds --}}
<script>
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(alert => alert.style.display = 'none');
    }, 3000);
</script>

<script>
    function autoResize(input) {
        input.style.height = 'auto';
        input.style.height = input.scrollHeight + 'px';
    }

    // Email Validation Function
    document.getElementById("emailInput").addEventListener("input", function () {
        const emailField = this;
        const emailError = document.getElementById("emailError");

        // Get emails & trim spaces
        let emails = emailField.value.split(",").map(email => email.trim());

        // Email validation regex
        const emailPattern = /^([\w\.-]+)@([\w-]+)\.([a-z]{2,8})$/i;

        // Check each email
        let isValid = emails.every(email => emailPattern.test(email));

        if (!isValid) {
            emailError.style.display = "block";
            emailField.style.border = "2px solid red";
        } else {
            emailError.style.display = "none";
            emailField.style.border = "2px solid green";
        }
    });
</script>
@endsection
