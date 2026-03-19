@extends('layouts.app')

@section('title', 'Contact Inquiries')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📬 Contact Inquiries</h1>
        <span class="bg-rose-100 text-rose-600 text-sm font-semibold px-3 py-1 rounded-full">
            {{ $contacts->total() }} total
        </span>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4">
            {{ session('success') }}
        </div>
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
                    <th class="px-5 py-3 text-left">Date</th>
                    <th class="px-5 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($contacts as $contact)
                <tr class="hover:bg-gray-50 {{ $contact->status === 'new' ? 'font-semibold' : '' }}">
                    <td class="px-5 py-3 text-gray-400">{{ $contact->id }}</td>
                    <td class="px-5 py-3 text-gray-800">{{ $contact->name }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ $contact->email }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $contact->phone ?? '—' }}</td>
                    <td class="px-5 py-3">
                        @php
                            $colors = ['new' => 'bg-blue-100 text-blue-600', 'read' => 'bg-gray-100 text-gray-600', 'replied' => 'bg-green-100 text-green-600'];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs {{ $colors[$contact->status] }}">
                            {{ ucfirst($contact->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-gray-400">{{ $contact->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-3 flex items-center gap-2">
                        <a href="{{ route('admin.contacts.show', $contact) }}"
                           class="text-xs bg-gray-800 text-white px-3 py-1 rounded-lg hover:bg-gray-600">View</a>
                        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST"
                              onsubmit="return confirm('Delete this inquiry?')">
                            @csrf @method('DELETE')
                            <button class="text-xs bg-red-100 text-red-600 px-3 py-1 rounded-lg hover:bg-red-200">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-10 text-center text-gray-400">No contact inquiries yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-4">
            {{ $contacts->links() }}
        </div>
    </div>
</div>
@endsection
