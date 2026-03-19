{{--
    INSTRUCTIONS:
    This file shows the changes needed in your existing layouts/admin.blade.php (or wherever
    your admin sidebar/navbar is defined). Find the relevant sections and apply these changes.
--}}

{{-- ============================================================
     1. SIDEBAR NAV — Add these two links to your admin sidebar
     ============================================================ --}}

{{-- Users link --}}
<a href="{{ route('admin.users.index') }}"
   class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium
          {{ request()->routeIs('admin.users*') ? 'bg-gray-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
    <span>👥</span> Users
</a>

{{-- Contacts link --}}
<a href="{{ route('admin.contacts.index') }}"
   class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium
          {{ request()->routeIs('admin.contacts*') ? 'bg-gray-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
    <span>📬</span> Contacts
    @php $newContacts = \App\Models\Contact::where('status','new')->count(); @endphp
    @if($newContacts > 0)
        <span class="ml-auto bg-rose-500 text-white text-xs rounded-full px-2 py-0.5">{{ $newContacts }}</span>
    @endif
</a>

{{-- ============================================================
     2. CURRENCY FIX — Find ALL occurrences of $ in your admin
        Blade views and replace with ₹.

     Common patterns to search and replace across admin views:
     - '$' . number_format(...)    →   '₹' . number_format(...)
     - ${{ price }}                →   ₹{{ price }}
     - '$' . $product->price       →   '₹' . $product->price
     - '$' . $order->total         →   '₹' . $order->total

     In Blade templates, use the helper below.
     ============================================================ --}}
