<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminComplaintController extends Controller
{
    public function notProcessed()
    {
        if (!Session::get('alogin')) return redirect('/admin/login');
        $complaints = DB::table('tblcomplaints')
            ->select('tblcomplaints.*', 'users.fullName as name')
            ->join('users', 'users.id', '=', 'tblcomplaints.userId')
            ->whereNull('tblcomplaints.status')
            ->get();
        return view('admin.notprocess-complaint', compact('complaints'));
    }

    public function inProcess()
    {
        if (!Session::get('alogin')) return redirect('/admin/login');
        $complaints = DB::table('tblcomplaints')
            ->select('tblcomplaints.*', 'users.fullName as name')
            ->join('users', 'users.id', '=', 'tblcomplaints.userId')
            ->where('tblcomplaints.status', 'in Process')
            ->get();
        return view('admin.inprocess-complaint', compact('complaints'));
    }

    public function closed()
    {
        if (!Session::get('alogin')) return redirect('/admin/login');
        $complaints = DB::table('tblcomplaints')
            ->select('tblcomplaints.*', 'users.fullName as name')
            ->join('users', 'users.id', '=', 'tblcomplaints.userId')
            ->where('tblcomplaints.status', 'closed')
            ->get();
        return view('admin.closed-complaint', compact('complaints'));
    }

    public function show($id)
    {
        if (!Session::get('alogin')) return redirect('/admin/login');
        
        $complaint = DB::table('tblcomplaints')
            ->select('tblcomplaints.*', 'category.categoryName as catname', 'users.fullName as name', 'users.userEmail as email', 'users.contactNo as contact')
            ->join('category', 'category.id', '=', 'tblcomplaints.category')
            ->join('users', 'users.id', '=', 'tblcomplaints.userId')
            ->where('tblcomplaints.complaintNumber', $id)
            ->first();

        if (!$complaint) return redirect('/admin/dashboard');

        $remarkHistory = DB::table('complaintremark')
            ->where('complaintNumber', $id)
            ->get();

        return view('admin.complaint-details', compact('complaint', 'remarkHistory'));
    }

    public function updateStatus(Request $request, $id)
    {
        if (!Session::get('alogin')) return redirect('/admin/login');

        $status = $request->input('status');
        $remark = $request->input('remark');

        DB::table('complaintremark')->insert([
            'complaintNumber' => $id,
            'status' => $status,
            'remark' => $remark,
            'remarkDate' => date('Y-m-d H:i:s')
        ]);

        DB::table('tblcomplaints')
            ->where('complaintNumber', $id)
            ->update(['status' => $status]);
            
        // Fetch complaint details to send email
        $complaint = DB::table('tblcomplaints')
            ->select('tblcomplaints.*', 'users.fullName as name', 'users.userEmail as email')
            ->join('users', 'users.id', '=', 'tblcomplaints.userId')
            ->where('tblcomplaints.complaintNumber', $id)
            ->first();

        if ($complaint && $complaint->email) {
            try {
                \Illuminate\Support\Facades\Mail::to($complaint->email)->send(new \App\Mail\StatusUpdateMail((array)$complaint, $status, $remark));
            } catch (\Exception $e) {
                // Log error or ignore if email fails but status is updated
                \Illuminate\Support\Facades\Log::error('Failed to send status update email: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('msg', 'Complaint details updated and user notified successfully!');
    }
}
