@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Business Stories</h1>
        <a href="{{ route('business.stories.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            Create New Story
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($stories as $story)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($story->media)
            <img src="{{ Storage::url($story->media->path) }}" alt="{{ $story->title }}" class="w-full h-48 object-cover">
            @endif
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-2">{{ $story->title }}</h2>
                <p class="text-gray-600 mb-4">{{ Str::limit($story->content, 100) }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">{{ $story->created_at->diffForHumans() }}</span>
                    <div class="flex space-x-2">
                        <a href="{{ route('business.stories.edit', $story) }}" class="text-blue-500 hover:text-blue-600">
                            Edit
                        </a>
                        <form action="{{ route('business.stories.destroy', $story) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-600">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $stories->links() }}
    </div>
</div>
@endsection 