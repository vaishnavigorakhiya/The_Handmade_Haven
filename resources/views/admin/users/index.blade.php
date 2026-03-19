@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">👥 Manage Users</h1>
        <span class="bg-indigo-100 text-indigo-600 text-sm font-semibold px-3 py-1 rounded-full">
            {{ $users->total() }} users
        </span>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-5 py-3 text-left">#</th>
                    <th class="px-5 py-3 text-left">Name</th>
                    <th class="px-5 py-3 text-left">Email</th>
                    <th class="px-5 py-3 text-left">Phone</th>
                    <th class="px-5 py-3 text-left">Status</th>
                    <th class="px-5 py-3 text-left">Joined</th>
                    <th class="px-5 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 text-gray-400">{{ $user->id }}</td>
                    <td class="px-5 py-3 text-gray-800 font-medium">{{ $user->name }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ $user->email }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $user->phone ?? '—' }}</td>
                    <td class="px-5 py-3">
                        @if($user->is_active)
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs">Active</span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-500 rounded-full text-xs">Inactive</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-3 flex items-center gap-2 flex-wrap">
                        <a href="{{ route('admin.users.show', $user) }}"
                           class="text-xs bg-gray-800 text-white px-3 py-1 rounded-lg hover:bg-gray-600">View</a>

                        <form action="{{ route('admin.users.toggle', $user) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="text-xs px-3 py-1 rounded-lg
                                {{ $user->is_active ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                              onsubmit="return confirm('Delete this user permanently?')">
                            @csrf @method('DELETE')
                            <button class="text-xs bg-red-100 text-red-600 px-3 py-1 rounded-lg hover:bg-red-200">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-10 text-center text-gray-400">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
