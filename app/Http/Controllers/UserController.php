<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\SendOtpMail;

class UserController extends Controller
{
    public function showLoginForm()
    {
        return view('users.login');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $plainPassword = $request->input('password');

        $user = DB::table('users')->where('userEmail', $username)->first();

        $uip = $request->ip();
        $authenticated = false;

        if ($user) {
            if (md5($plainPassword) === $user->password) {
                $authenticated = true;
                // Upgrade hash to bcrypt
                DB::table('users')->where('id', $user->id)->update([
                    'password' => Hash::make($plainPassword)
                ]);
            } else {
                try {
                    if (Hash::check($plainPassword, $user->password)) {
                        $authenticated = true;
                    }
                } catch (\Exception $e) {
                    // Ignore exception if hash format is invalid
                }
            }
        }

        if ($authenticated) {
            Session::put('login', $username);
            Session::put('id', $user->id);

            DB::table('userlog')->insert([
                'uid' => $user->id,
                'username' => $username,
                'userip' => $uip,
                'status' => 1,
                'logout' => ''
            ]);

            // Need to implement dashboard route later
            return redirect('/users/dashboard');
        } else {
            DB::table('userlog')->insert([
                'uid' => 0,
                'username' => $username,
                'userip' => $uip,
                'status' => 0,
                'logout' => ''
            ]);

            return redirect()->back()->with('errormsg', 'Invalid username or password');
        }
    }

    public function forgotPassword(Request $request)
    {
        $email = $request->input('email');

        $user = DB::table('users')
            ->where('userEmail', $email)
            ->first();

        if ($user) {
            $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            
            DB::table('users')
                ->where('userEmail', $email)
                ->update([
                    'otp' => $otp,
                    'otp_expires_at' => now()->addMinutes(10)
                ]);

            // Send OTP email
            Mail::to($email)->send(new SendOtpMail($otp));

            return redirect()->back()
                ->with('otp_sent_to', $email)
                ->with('msg', 'An OTP has been sent to your email.');
        } else {
            return redirect()->back()->with('errormsg', 'Invalid email id');
        }
    }

    public function verifyOtp(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $newPassword = $request->input('new_password');

        $user = DB::table('users')
            ->where('userEmail', $email)
            ->where('otp', $otp)
            ->where('otp_expires_at', '>', now())
            ->first();

        if ($user) {
            DB::table('users')
                ->where('userEmail', $email)
                ->update([
                    'password' => Hash::make($newPassword),
                    'otp' => null,
                    'otp_expires_at' => null,
                    'updationDate' => now()
                ]);

            return redirect('/users/login')->with('msg', 'Password Changed Successfully! You can now login.');
        } else {
            return redirect('/users/login')->with('errormsg', 'Invalid or expired OTP.');
        }
    }

    public function showRegistrationForm()
    {
        return view('users.register');
    }

    public function register(Request $request)
    {
        $fullname = $request->input('fullname');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));
        $contactno = $request->input('contactno');

        // Check if email already exists
        $exists = DB::table('users')->where('userEmail', $email)->exists();
        if ($exists) {
            return redirect()->back()->with('errormsg', 'Email is already registered!');
        }

        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store registration details and OTP in session
        Session::put('registration_data', [
            'fullName' => $fullname,
            'userEmail' => $email,
            'password' => $password,
            'contactNo' => $contactno,
            'status' => 1
        ]);
        Session::put('registration_otp', $otp);
        Session::put('registration_otp_expires_at', now()->addMinutes(15));
        Session::put('registration_email', $email);

        // Send OTP email
        Mail::to($email)->send(new SendOtpMail($otp));

        return redirect()->back()
            ->with('registration_otp_sent_to', $email)
            ->with('msg', 'An OTP has been sent to your email to verify your registration.');
    }

    public function verifyRegistrationOtp(Request $request)
    {
        $otp = $request->input('otp');
        $email = Session::get('registration_email');
        $sessionOtp = Session::get('registration_otp');
        $expiresAt = Session::get('registration_otp_expires_at');

        if (!$email || !$sessionOtp || !$expiresAt) {
            return redirect()->back()->with('errormsg', 'Session expired. Please register again.');
        }

        if ($otp !== $sessionOtp) {
            return redirect()->back()
                ->with('registration_otp_sent_to', $email)
                ->with('errormsg', 'Invalid OTP. Please try again.');
        }

        if (now()->greaterThan($expiresAt)) {
            Session::forget(['registration_data', 'registration_otp', 'registration_otp_expires_at', 'registration_email']);
            return redirect()->back()->with('errormsg', 'OTP has expired. Please register again.');
        }

        // OTP is valid, insert user
        $userData = Session::get('registration_data');
        DB::table('users')->insert($userData);

        // Clear session data
        Session::forget(['registration_data', 'registration_otp', 'registration_otp_expires_at', 'registration_email']);

        return redirect('/users/login')->with('msg', 'Registration successful. Your email has been verified. You can now login!');
    }

    public function checkAvailability(Request $request)
    {
        $email = $request->input('email');
        
        $count = DB::table('users')->where('userEmail', $email)->count();

        if ($count > 0) {
            return "<span style='color:red'> Email already exists .</span>";
        } else {
            return "<span style='color:green'> Email available for Registration .</span>";
        }
    }

    public function dashboard()
    {
        $userId = Session::get('id');
        if (!$userId) return redirect('/users/login');

        $num1 = DB::table('tblcomplaints')->where('userId', $userId)->whereNull('status')->count();
        $num2 = DB::table('tblcomplaints')->where('userId', $userId)->where('status', 'in Process')->count();
        $num3 = DB::table('tblcomplaints')->where('userId', $userId)->where('status', 'closed')->count();

        return view('users.dashboard', compact('num1', 'num2', 'num3'));
    }

    public function profile()
    {
        $userId = Session::get('id');
        if (!$userId) return redirect('/users/login');

        $user = DB::table('users')->where('id', $userId)->first();
        $states = DB::table('state')->get();
        $emergencyContacts = \App\Models\EmergencyContact::where('user_id', $userId)->get();

        return view('users.profile', compact('user', 'states', 'emergencyContacts'));
    }

    public function updateProfile(Request $request)
    {
        $userId = Session::get('id');
        if (!$userId) return redirect('/users/login');
        
        DB::table('users')->where('id', $userId)->update([
            'fullName' => $request->input('fullname') ?? '',
            'contactNo' => intval($request->input('contactno')),
            'address' => $request->input('address') ?? '',
            'State' => $request->input('state') ?? '',
            'country' => $request->input('country') ?? '',
            'pincode' => intval($request->input('pincode')),
            'updationDate' => now()
        ]);

        return redirect()->back()->with('successmsg', 'Profile Updated Successfully!');
    }

    public function changePasswordForm()
    {
        if (!Session::get('id')) return redirect('/users/login');
        return view('users.change-password');
    }

    public function updatePassword(Request $request)
    {
        $userId = Session::get('id');
        if (!$userId) return redirect('/users/login');

        $plainOldPassword = $request->input('password');
        $newPasswordHash = Hash::make($request->input('newpassword'));

        $user = DB::table('users')->where('id', $userId)->first();
        $passwordMatches = false;

        if ($user) {
            if (md5($plainOldPassword) === $user->password) {
                $passwordMatches = true;
            } else {
                try {
                    if (Hash::check($plainOldPassword, $user->password)) {
                        $passwordMatches = true;
                    }
                } catch (\Exception $e) {
                    // Ignore exception if hash format is invalid
                }
            }
        }

        if ($passwordMatches) {
            DB::table('users')->where('id', $userId)->update([
                'password' => $newPasswordHash,
                'updationDate' => now()
            ]);
            return redirect()->back()->with('successmsg', 'Password Changed Successfully !!');
        } else {
            return redirect()->back()->with('errormsg', 'Old Password does not match !!');
        }
    }

    public function helplines()
    {
        $userId = Session::get('id');
        if (!$userId) return redirect('/users/login');

        $helplines = DB::table('tbl_helplines')->where('status', 1)->get();
        return view('users.helplines', compact('helplines'));
    }

    public function logout()
    {
        Session::forget('login');
        Session::forget('id');
        Session::forget('user');
        return redirect('/')->with('successmsg', 'You have successfully logged out');
    }
}
