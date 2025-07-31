<div class="modal-body">
    <h5 class="mb-3">Social Media Post Preview</h5>
    <div class="p-3 border rounded">
        <h6>{{ $data['post_title'] ?? '' }}</h6>
        <p>{{ $data['post_content'] ?? '' }}</p>
        @if(!empty($data['post_image']))
            <img src="{{ asset('storage/'.$data['post_image']) }}" class="img-fluid" />
        @endif
        <p class="text-muted mt-2">Posted by {{ $data['user_name'] ?? '' }} on {{ $data['timestamp'] ?? '' }}</p>
    </div>
</div>