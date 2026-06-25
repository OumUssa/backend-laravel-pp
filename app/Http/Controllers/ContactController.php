<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Get all contacts (Admin)
    public function index(Request $request)
    {
        $contacts = Contact::with('user')->get();
        return response()->json($contacts);
    }

    // Submit a new contact message
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'topic' => 'required|in:general,support,feedback,other,change_role',
            'message' => 'required|string',
        ]);

        $user_id = auth('sanctum')->check() ? auth('sanctum')->id() : null;

        $contact = Contact::create([
            'user_id' => $user_id,
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'topic' => $validated['topic'],
            'message' => $validated['message'],
            'status' => 'pending'
        ]);

        return response()->json([
            'result' => true,
            'msg' => 'Contact message submitted successfully',
            'data' => $contact
        ], 201);
    }

    // Show a specific contact message
    public function show($id)
    {
        $contact = Contact::with('user')->find($id);

        if (!$contact) {
            return response()->json(['result' => false, 'msg' => 'Contact not found'], 404);
        }

        return response()->json($contact);
    }

    // Reply / Update contact status (Admin)
    public function reply(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,resolved'
        ]);

        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json(['result' => false, 'msg' => 'Contact not found'], 404);
        }

        $contact->update(['status' => $validated['status']]);

        return response()->json([
            'result' => true,
            'msg' => 'Contact status updated successfully',
            'data' => $contact
        ]);
    }
}
