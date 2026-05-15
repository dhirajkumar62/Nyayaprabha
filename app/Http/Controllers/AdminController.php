<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = md5($request->input('password'));

        $admin = DB::table('admin')
            ->where('username', $username)
            ->where('password', $password)
            ->first();

        if ($admin) {
            Session::put('alogin', $username);
            Session::put('id', $admin->id);

            // Placeholder for admin dashboard
            return redirect('/admin/dashboard');
        } else {
            return redirect()->back()->with('errmsg', 'Invalid username or password');
        }
    }

    public function dashboard()
    {
        if (!Session::get('alogin')) return redirect('/admin/login');

        $num1 = DB::table('tblcomplaints')->whereNull('status')->count();
        $num2 = DB::table('tblcomplaints')->where('status', 'in Process')->count();
        $num3 = DB::table('tblcomplaints')->where('status', 'closed')->count();
        $num4 = DB::table('users')->count();

        return view('admin.dashboard', compact('num1', 'num2', 'num3', 'num4'));
    }

    public function logout()
    {
        Session::forget('alogin');
        Session::forget('id');
        return redirect('/admin/login')->with('successmsg', 'Successfully logged out');
    }

    // --- User Management ---
    public function manageUsers()
    {
        if (!Session::get('alogin')) return redirect('/admin/login');
        $users = DB::table('users')->get();
        return view('admin.manage-users', compact('users'));
    }

    public function userLogs()
    {
        if (!Session::get('alogin')) return redirect('/admin/login');
        $logs = DB::table('userlog')->get();
        return view('admin.user-logs', compact('logs'));
    }

    // --- Helplines Management ---
    public function helplines(Request $request)
    {
        if (!Session::get('alogin')) return redirect('/admin/login');
        
        $active_tab = $request->input('tab', 'helplines');
        $helplines = DB::table('tbl_helplines')->get();
        
        return view('admin.helpline-management', compact('helplines', 'active_tab'));
    }

    public function storeHelpline(Request $request)
    {
        if (!Session::get('alogin')) return redirect('/admin/login');
        
        DB::table('tbl_helplines')->insert([
            'name' => $request->input('h_name'),
            'number' => $request->input('h_number'),
            'category' => $request->input('h_category')
        ]);
        
        return redirect('/admin/helplines?tab=helplines')->with('msg', 'Helpline Added Successfully');
    }

    public function destroyHelpline($id)
    {
        if (!Session::get('alogin')) return redirect('/admin/login');
        
        DB::table('tbl_helplines')->where('id', $id)->delete();
        return redirect('/admin/helplines?tab=helplines')->with('msg', 'Helpline Deleted !!');
    }
}
