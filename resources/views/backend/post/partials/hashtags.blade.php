@if($post->hashtags->count() > 0)
    <div class="hashtags mt-2">
        @foreach($post->hashtags as $hashtag)
            <a href="{{ route('hashtags.show', $hashtag->slug) }}" class="badge bg-primary me-1 text-decoration-none">
                #{{ $hashtag->name }}
            </a>
        @endforeach
    </div>
@endif 