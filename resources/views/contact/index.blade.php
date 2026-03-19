@extends('layouts.app')

@section('title', 'Contact Us — Soochikaari')

@section('content')
<div class="min-h-screen bg-[#f5f0eb] py-16 px-4">
    <div class="max-w-2xl mx-auto">

        {{-- Header --}}
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Get in Touch 🧵</h1>
            <p class="text-gray-500 text-lg">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-6 flex items-center gap-3">
            <span class="text-2xl">✅</span>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        {{-- Contact Card --}}
        <div class="bg-white rounded-3xl shadow-xl p-8">
            {{-- Info Row --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="text-center p-4 bg-[#fdf3f0] rounded-2xl">
                    <div class="text-2xl mb-2">📍</div>
                    <div class="text-sm font-semibold text-gray-700">Location</div>
                    <div class="text-xs text-gray-500 mt-1">India</div>
                </div>
                <div class="text-center p-4 bg-[#fdf3f0] rounded-2xl">
                    <div class="text-2xl mb-2">📧</div>
                    <div class="text-sm font-semibold text-gray-700">Email</div>
                    <div class="text-xs text-gray-500 mt-1">vaishnavi.kansara00@gmail.com</div>
                </div>
                <div class="text-center p-4 bg-[#fdf3f0] rounded-2xl">
                    <div class="text-2xl mb-2">🕐</div>
                    <div class="text-sm font-semibold text-gray-700">Response Time</div>
                    <div class="text-xs text-gray-500 mt-1">Within 24 hours</div>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Your Name <span class="text-red-400">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#c0877f] @error('name') border-red-400 @enderror"
                            placeholder="Priya Sharma">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-400">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#c0877f] @error('email') border-red-400 @enderror"
                            placeholder="priya@example.com">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#c0877f]"
                        placeholder="+91 99999 00000">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Message <span class="text-red-400">*</span></label>
                    <textarea name="message" rows="5"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#c0877f] resize-none @error('message') border-red-400 @enderror"
                        placeholder="Tell us about your inquiry...">{{ old('message') }}</textarea>
                    @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <button type="submit"
                    class="w-full bg-gray-900 text-white py-3 rounded-xl font-semibold text-sm hover:bg-gray-700 transition-colors duration-200">
                    Send Message ✉️
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
