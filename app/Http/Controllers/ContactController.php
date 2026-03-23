<?php

namespace App\Http\Controllers;

use App\Mail\ContactInquiryMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
     public function index()
    {
        return view('contact.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'message' => 'required|string|max:2000',
        ]);

        $contact = Contact::create($validated);

        try {
                Mail::to(config('mail.from.address'))->send(new ContactInquiryMail($contact));        
            } 
            catch (\Exception $e) {
            // Log silently — don't block user confirmation
            \Log::error('Contact mail failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Your message has been sent! We will get back to you soon. 🧵');
    }
}
