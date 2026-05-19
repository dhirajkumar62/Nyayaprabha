<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $plainPassword = $request->input('password');

        $admin = DB::table('admin')->where('username', $username)->first();

        $authenticated = false;

        if ($admin) {
            if (md5($plainPassword) === $admin->password) {
                $authenticated = true;
                // Upgrade hash
                DB::table('admin')->where('id', $admin->id)->update([
                    'password' => Hash::make($plainPassword)
                ]);
            } else {
                try {
                    if (Hash::check($plainPassword, $admin->password)) {
                        $authenticated = true;
                    }
                } catch (\Exception $e) {
                    // Ignore exception if the hash format is invalid
                }
            }
        }

        if ($authenticated) {
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

        // Statistics
        $totalUsers = DB::table('users')->count();
        $activeUsers = DB::table('userlog')->where('loginTime', '>=', now()->subDays(30))->distinct('uid')->count();
        $sosAlerts = DB::table('sos_alerts')->where('status', 'active')->count();
        $pendingComplaints = DB::table('tblcomplaints')->whereNull('status')->count();
        $resolvedCases = DB::table('tblcomplaints')->where('status', 'closed')->count();
        $emergencyRequests = DB::table('emergency_contacts')->count();

        // Data for Map
        $liveSosAlerts = DB::table('sos_alerts')
            ->join('users', 'sos_alerts.user_id', '=', 'users.id')
            ->select('sos_alerts.*', 'users.fullName as user_name', 'users.contactNo')
            ->where('sos_alerts.status', 'active')
            ->orderBy('sos_alerts.created_at', 'desc')
            ->get();

        // Recent Activity Feed
        $recentComplaints = DB::table('tblcomplaints')
            ->join('users', 'tblcomplaints.userId', '=', 'users.id')
            ->select('tblcomplaints.complaintNumber as id', 'tblcomplaints.noc as title', 'tblcomplaints.regDate as time', 'users.fullName as user', DB::raw("'complaint' as type"))
            ->orderBy('tblcomplaints.regDate', 'desc')
            ->take(3)
            ->get();

        $recentSos = DB::table('sos_alerts')
            ->join('users', 'sos_alerts.user_id', '=', 'users.id')
            ->select('sos_alerts.id', DB::raw("'Emergency SOS Triggered' as title"), 'sos_alerts.created_at as time', 'users.fullName as user', DB::raw("'sos' as type"))
            ->orderBy('sos_alerts.created_at', 'desc')
            ->take(3)
            ->get();
            
        $recentUsers = DB::table('users')
            ->select('users.id', DB::raw("'New User Registered' as title"), 'users.regDate as time', 'users.fullName as user', DB::raw("'user' as type"))
            ->orderBy('users.regDate', 'desc')
            ->take(2)
            ->get();

        $recentActivity = collect($recentComplaints)
            ->merge($recentSos)
            ->merge($recentUsers)
            ->sortByDesc('time')
            ->take(5);

        return view('admin.dashboard', compact(
            'totalUsers', 'activeUsers', 'sosAlerts', 'pendingComplaints', 
            'resolvedCases', 'emergencyRequests', 'liveSosAlerts', 'recentActivity'
        ));
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

    public function destroyUser($id)
    {
        if (!Session::get('alogin')) return redirect('/admin/login');
        
        DB::table('users')->where('id', $id)->delete();
        
        // Optionally delete their complaints as well
        // DB::table('tblcomplaints')->where('userId', $id)->delete();
        
        return redirect('/admin/manage-users')->with('msg', 'User has been successfully deleted!');
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
