@extends('admin.components.layout')
@section('main')
    <main>
        @include('admin.components.response')
        <form action="/admin/web_pages/edit" method="post" enctype="multipart/form-data">
            <h5 class="page_title">Edit Meta Data</h5>
            <h6 class="section_title text-center">You Can Edit Meta Data Here by Filling the Form, <b class="text-primary">College Vihar</b> will update the meta data in the database</h6>
            @csrf
            <section class="">
                <h3 class="section_title">URL slug</h3>
                <input type="hidden" name="meta_id" value="{{ $metadata['id'] }}">
                <div class="field">
                    <div class="slug-edit-container" style="display: flex; align-items: center; gap: 10px;">
                        <input type="text" id="url_slug" name="url_slug" style="font-weight:600;" value="{{ $metadata['url_slug'] }}" class="slug-input">
                        <button type="button" id="updateSlugBtn" class="btn btn-sm btn-primary">Update</button>
                        <span id="slug-update-message" style="margin-left: 10px; display: none;"></span>
                    </div>
                </div>
            </section>
            <section class="panel">
                <h3 class="section_title">Seo Work</h3>
                <div class="field">
                    <label for="meta_h1">Text to display in H1 tag</label>
                    <input type="text" id="meta_h1" name="meta_h1" placeholder="meta_h1"
                        value="{{ $metadata['meta_h1'] }}">
                </div>
                <div class="field_group">
                    <div class="field">
                        <label for="meta_title">Meta Title of Page</label>
                        <input type="text" id="meta_title" name="meta_title" placeholder="meta_title"
                            value="{{ $metadata['meta_title'] }}">
                    </div>
                    <div class="field">
                        <label for="meta_description">Meta Description of Page</label>
                        <input type="text" id="meta_description" name="meta_description" placeholder="meta_description"
                            value="{{ $metadata['meta_description'] }}">
                    </div>
                </div>
                <!-- <div class="field">
                    <label for="meta_key">Meta Keywords of Page (key1, key2, key3)</label>
                    <input type="text" id="meta_key" name="meta_keywords" placeholder="meta_keywords"
                        value="{{ $metadata['meta_keywords'] }}">
                </div>
                <div class="field">
                    <label for="om">If any (Write complete tags)</label>
                    <textarea id="om" name="other_meta_tags" placeholder="Write Here...">{{ $metadata['other_meta_tags'] }}</textarea>
                </div> -->
            </section>
            <div class="text-end p-4">
                <button type="submit" class="btn btn-primary btn-lg">Update Meta Data</button>
            </div>
        </form>
    </main>
    @push('script')
        <script>
            // Simple test to see if jQuery is working
            console.log('jQuery version:', typeof $);
            
            // Simple direct event handler
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM fully loaded');
                
                // Get the button by ID
                var updateBtn = document.getElementById('updateSlugBtn');
                console.log('Update button found:', !!updateBtn);
                
                if (updateBtn) {
                    // Add click event listener
                    updateBtn.addEventListener('click', function() {
                        console.log('Button clicked!');
                        
                        var slugInput = document.getElementById('url_slug');
                        var oldSlug = '{{ addslashes($metadata["url_slug"] ?? "") }}';
                        var newSlug = slugInput.value.trim();
                        var messageEl = document.getElementById('slug-update-message');
                        
                        console.log('Old slug from PHP:', oldSlug);
                        console.log('New slug from input:', newSlug);
                        
                        // Make sure oldSlug is properly set
                        if (!oldSlug) {
                            console.error('Old slug is empty!');
                            messageEl.textContent = 'Error: Could not determine current slug';
                            messageEl.className = 'text-danger';
                            messageEl.style.display = 'inline';
                            return;
                        }
                        
                        if (newSlug === oldSlug) {
                            console.log('No changes detected');
                            messageEl.textContent = 'No changes detected';
                            messageEl.className = 'text-muted';
                            messageEl.style.display = 'inline';
                            setTimeout(() => { messageEl.style.display = 'none'; }, 3000);
                            return;
                        }
                        
                        // Show loading state
                        this.disabled = true;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
                        
                        messageEl.textContent = 'Updating...';
                        messageEl.className = '';
                        messageEl.style.display = 'inline';
                        
                        // Get CSRF token
                        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        console.log('CSRF Token:', token);
                        
                        // Prepare form data
                        const formData = new FormData();
                        formData.append('_token', token);
                        formData.append('old_slug', oldSlug);
                        formData.append('new_slug', newSlug);
                        
                        console.log('Sending form data:', {
                            old_slug: oldSlug,
                            new_slug: newSlug,
                            _token: token.substring(0, 10) + '...' // Only log first 10 chars of token for security
                        });
                        
                        // Send AJAX request
                        fetch('{{ route("admin.update-slug") }}', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        })
                        .then(async response => {
                            console.log('Raw response status:', response.status);
                            const responseData = await response.json().catch(() => ({}));
                            console.log('Response data:', responseData);
                            
                            if (!response.ok) {
                                const errorMsg = responseData.message || 'Network response was not ok';
                                console.error('Server error:', errorMsg);
                                throw new Error(errorMsg);
                            }
                            return responseData;
                        })
                        .then(data => {
                            console.log('Success:', data);
                            if (data.success) {
                                messageEl.textContent = 'Slug updated successfully!';
                                messageEl.className = 'text-success';
                                // Update the old slug in the form
                                slugInput.value = newSlug;
                            } else {
                                messageEl.textContent = data.msg || 'Failed to update slug';
                                messageEl.className = 'text-danger';
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            messageEl.textContent = 'An error occurred while updating the slug: ' + error.message;
                            messageEl.className = 'text-danger';
                        })
                        .finally(() => {
                            this.disabled = false;
                            this.textContent = 'Update';
                            setTimeout(() => {
                                messageEl.style.display = 'none';
                            }, 5000);
                        });
                    });
                } else {
                    console.error('Update button not found!');
                }
            });
        </script>
    @endpush
@endsection
