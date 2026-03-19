@extends('layouts.app')

@section('title', 'View Inquiry')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.contacts.index') }}" class="text-gray-400 hover:text-gray-700 text-sm">← Back</a>
        <h1 class="text-2xl font-bold text-gray-800">📩 Inquiry #{{ $contact->id }}</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow p-6 space-y-5">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Name</p>
                <p class="text-gray-800 font-medium">{{ $contact->name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Status</p>
                @php $colors = ['new'=>'bg-blue-100 text-blue-600','read'=>'bg-gray-100 text-gray-600','replied'=>'bg-green-100 text-green-600']; @endphp
                <span class="px-2 py-1 rounded-full text-xs {{ $colors[$contact->status] }}">{{ ucfirst($contact->status) }}</span>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Email</p>
                <a href="mailto:{{ $contact->email }}" class="text-blue-500 hover:underline text-sm">{{ $contact->email }}</a>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Phone</p>
                <p class="text-gray-700 text-sm">{{ $contact->phone ?? '—' }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Received</p>
                <p class="text-gray-500 text-sm">{{ $contact->created_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        <div>
            <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Message</p>
            <div class="bg-gray-50 rounded-xl p-4 text-gray-700 text-sm leading-relaxed">
                {{ $contact->message }}
            </div>
        </div>

        {{-- Update Status --}}
        <form action="{{ route('admin.contacts.status', $contact) }}" method="POST" class="flex items-center gap-3">
            @csrf @method('PATCH')
            <select name="status" class="border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                <option value="new" {{ $contact->status === 'new' ? 'selected' : '' }}>New</option>
                <option value="read" {{ $contact->status === 'read' ? 'selected' : '' }}>Read</option>
                <option value="replied" {{ $contact->status === 'replied' ? 'selected' : '' }}>Replied</option>
            </select>
            <button type="submit" class="bg-gray-800 text-white text-sm px-4 py-2 rounded-xl hover:bg-gray-600">Update Status</button>
            <a href="mailto:{{ $contact->email }}" class="bg-rose-500 text-white text-sm px-4 py-2 rounded-xl hover:bg-rose-400">Reply via Email</a>
        </form>
    </div>
</div>
@endsection
