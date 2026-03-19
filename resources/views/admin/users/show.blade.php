@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-gray-700 text-sm">← Back</a>
        <h1 class="text-2xl font-bold text-gray-800">👤 User #{{ $user->id }}</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow p-6 space-y-5">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Name</p>
                <p class="text-gray-800 font-medium">{{ $user->name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Status</p>
                @if($user->is_active)
                    <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs">Active</span>
                @else
                    <span class="px-2 py-1 bg-red-100 text-red-500 rounded-full text-xs">Inactive</span>
                @endif
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Email</p>
                <p class="text-gray-700 text-sm">{{ $user->email }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Phone</p>
                <p class="text-gray-700 text-sm">{{ $user->phone ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Joined</p>
                <p class="text-gray-500 text-sm">{{ $user->created_at->format('d M Y, h:i A') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Total Orders</p>
                <p class="text-gray-700 text-sm font-semibold">{{ $user->orders()->count() ?? 0 }}</p>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <form action="{{ route('admin.users.toggle', $user) }}" method="POST">
                @csrf @method('PATCH')
                <button class="text-sm px-4 py-2 rounded-xl font-medium
                    {{ $user->is_active ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                    {{ $user->is_active ? '🔒 Deactivate User' : '✅ Activate User' }}
                </button>
            </form>

            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this user?')">
                @csrf @method('DELETE')
                <button class="text-sm bg-red-100 text-red-600 px-4 py-2 rounded-xl hover:bg-red-200 font-medium">
                    🗑 Delete User
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
