<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmergencyContactController extends Controller
{
    public function index()
    {
        $userId = \Illuminate\Support\Facades\Session::get('id');
        if (!$userId) return redirect('/users/login');

        $emergencyContacts = \App\Models\EmergencyContact::where('user_id', $userId)->get();
        return view('users.emergency-contacts', compact('emergencyContacts'));
    }

    public function store(Request $request)
    {
        $userId = \Illuminate\Support\Facades\Session::get('id');
        if (!$userId) return redirect('/users/login');

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        // Check if user already has 5 contacts
        $count = \App\Models\EmergencyContact::where('user_id', $userId)->count();
        if ($count >= 5) {
            return redirect()->back()->with('errormsg', 'You can only add up to 5 emergency contacts.');
        }

        \App\Models\EmergencyContact::create([
            'user_id' => $userId,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('successmsg', 'Emergency contact added successfully.');
    }

    public function destroy($id)
    {
        $userId = \Illuminate\Support\Facades\Session::get('id');
        if (!$userId) return redirect('/users/login');

        $contact = \App\Models\EmergencyContact::where('id', $id)->where('user_id', $userId)->first();
        if ($contact) {
            $contact->delete();
            return redirect()->back()->with('successmsg', 'Emergency contact removed.');
        }

        return redirect()->back()->with('errormsg', 'Contact not found.');
    }
}
