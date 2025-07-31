<div class="flex space-x-2">
    <img src="{{ asset('uploads/profile_pics/' . ($reply->user->profile_picture ?? 'default-user.png')) }}" class="w-8 h-8 rounded-full mt-1">
    <div>
        <div class="flex items-center space-x-2">
            <span class="font-semibold">{{ $reply->user->username }}</span>
            <span class="text-gray-400 text-xs">{{ $reply->created_at->diffForHumans() }}</span>
        </div>
        <p class="mt-1">
            {!! preg_replace('/@([\w\.]+)/', '<a href="/user/$1" class="text-blue-500">@\$1</a>', e($reply->comment)) !!}
        </p>
    </div>
</div>
