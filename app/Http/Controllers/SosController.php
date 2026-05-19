<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SosController extends Controller
{
    public function trigger(Request $request)
    {
        $userId = \Illuminate\Support\Facades\Session::get('id');
        $userLogin = \Illuminate\Support\Facades\Session::get('login');
        if (!$userId || !$userLogin) return redirect('/users/login');

        $user = \Illuminate\Support\Facades\DB::table('users')->where('id', $userId)->first();
        if (!$user) {
            \Illuminate\Support\Facades\Session::forget(['login', 'id']);
            return redirect('/users/login')->with('errormsg', 'Session invalid. Please log in again.');
        }
        $contacts = \App\Models\EmergencyContact::where('user_id', $userId)->get();

        if ($contacts->isEmpty()) {
            return redirect()->back()->with('sos_error', 'No emergency contacts found. Please add contacts in your profile first.');
        }

        $locationLink = null;
        if ($request->filled('latitude') && $request->filled('longitude')) {
            $locationLink = "https://maps.google.com/?q=" . $request->latitude . "," . $request->longitude;
        }

        // Log SOS alert in database
        \Illuminate\Support\Facades\DB::table('sos_alerts')->insert([
            'user_id' => $userId,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $emailsSent = 0;
        $smsSent = 0;
        
        // Twilio Credentials
        $twilioSid = env('TWILIO_SID');
        $twilioToken = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_PHONE_NUMBER');
        
        $twilioClient = null;
        if (!empty($twilioSid) && !empty($twilioToken)) {
            try {
                $twilioClient = new \Twilio\Rest\Client($twilioSid, $twilioToken);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Twilio client init failed: " . $e->getMessage());
            }
        }

        foreach ($contacts as $contact) {
            // Send Email Alert
            if (!empty($contact->email)) {
                try {
                    \Illuminate\Support\Facades\Mail::to($contact->email)->send(new \App\Mail\EmergencySosMail($user, $locationLink));
                    $emailsSent++;
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("SOS Email failed for {$contact->email}: " . $e->getMessage());
                }
            }

            // Send SMS Alert
            if (!empty($contact->phone) && $twilioClient && !empty($twilioNumber)) {
                try {
                    $message = "🚨 URGENT SOS ALERT 🚨\n{$user->fullName} is in an emergency situation and requires immediate help. Please contact them at {$user->contactNo} immediately.";
                    if ($locationLink) {
                        $message .= "\n\nLive Location: " . $locationLink;
                    }

                    $twilioClient->messages->create(
                        $contact->phone,
                        [
                            'from' => $twilioNumber,
                            'body' => $message
                        ]
                    );
                    $smsSent++;
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("SOS SMS failed for {$contact->phone}: " . $e->getMessage());
                }
            }
        }

        $msg = "Alert dispatched successfully! ($emailsSent Emails sent).";
        if ($smsSent > 0) {
            $msg = "Alert dispatched successfully! ($emailsSent Emails, $smsSent SMS sent).";
        } else if (empty($twilioSid)) {
            $msg .= " SMS alerts were not sent because Twilio is not configured.";
        }

        return redirect()->back()->with('sos_success', $msg);
    }
}
