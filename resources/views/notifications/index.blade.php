@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-semibold">Notifications</h2>
        <div class="flex items-center gap-3">
            <span class="text-sm text-gray-500">Unread: {{ $unreadCount }}</span>
            <form method="POST" action="{{ route('notifications.readAll') }}">
                @csrf
                <button class="px-3 py-1.5 text-xs bg-green-600 text-white rounded hover:bg-green-700">Mark all as read</button>
            </form>
        </div>
    </div>

    @if($notifications->count() === 0)
        <div class="bg-white p-6 rounded-lg shadow-sm text-gray-600">
            No notifications yet.
        </div>
    @else
        <div class="space-y-3">
            @foreach($notifications as $notification)
                <div class="bg-white p-4 rounded-lg shadow-sm border {{ $notification->read_at ? 'border-gray-200' : 'border-green-300' }}">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="text-sm font-semibold">
                                {{ data_get($notification->data, 'title', 'Notification') }}
                            </div>
                            <div class="text-sm text-gray-700 mt-1">
                                {{ data_get($notification->data, 'message', json_encode($notification->data)) }}
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <div class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                            <div class="mt-2 flex items-center gap-2">
                                @if(is_null($notification->read_at))
                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                    @csrf
                                    <button class="px-2 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">Mark read</button>
                                </form>
                                @endif
                                <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-2 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
