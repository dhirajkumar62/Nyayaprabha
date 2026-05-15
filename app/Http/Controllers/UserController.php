<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function showLoginForm()
    {
        return view('users.login');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = md5($request->input('password'));

        $user = DB::table('users')
            ->where('userEmail', $username)
            ->where('password', $password)
            ->first();

        $uip = $request->ip();

        if ($user) {
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
        $contact = $request->input('contact');
        $password = md5($request->input('password'));

        $user = DB::table('users')
            ->where('userEmail', $email)
            ->where('contactNo', $contact)
            ->first();

        if ($user) {
            DB::table('users')
                ->where('userEmail', $email)
                ->where('contactNo', $contact)
                ->update(['password' => $password]);

            return redirect()->back()->with('msg', 'Password Changed Successfully');
        } else {
            return redirect()->back()->with('errormsg', 'Invalid email id or Contact no');
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
        $password = md5($request->input('password'));
        $contactno = $request->input('contactno');
        $status = 1;

        DB::table('users')->insert([
            'fullName' => $fullname,
            'userEmail' => $email,
            'password' => $password,
            'contactNo' => $contactno,
            'status' => $status
        ]);

        return redirect()->back()->with('msg', 'Registration successfull. Now You can login !');
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
        return view('users.profile', compact('user', 'states'));
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

        $oldPassword = md5($request->input('password'));
        $newPassword = md5($request->input('newpassword'));

        $user = DB::table('users')->where('id', $userId)->where('password', $oldPassword)->first();

        if ($user) {
            DB::table('users')->where('id', $userId)->update([
                'password' => $newPassword,
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
