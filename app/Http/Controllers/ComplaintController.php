<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ComplaintController extends Controller
{
    public function create()
    {
        if (!Session::get('id')) return redirect('/users/login');

        $categories = DB::table('category')->get();
        $states = DB::table('state')->get();
        return view('users.register-complaint', compact('categories', 'states'));
    }

    public function store(Request $request)
    {
        $uid = Session::get('id');
        if (!$uid) return redirect('/users/login');
        
        $compfile = '';
        if ($request->hasFile('compfile')) {
            $file = $request->file('compfile');
            $compfile = $file->getClientOriginalName();
            // Store file in public/complaintdocs instead of the old raw path
            $file->move(public_path('complaintdocs'), $compfile);
        }

        DB::table('tblcomplaints')->insert([
            'userId' => $uid,
            'category' => $request->input('category'),
            'subcategory' => $request->input('subcategory') ?? '',
            'complaintType' => $request->input('complaintype') ?? '',
            'state' => $request->input('state') ?? '',
            'noc' => $request->input('noc') ?? '',
            'complaintDetails' => $request->input('complaindetails') ?? '',
            'complaintFile' => $compfile,
            'regDate' => now()
        ]);

        $complaint = DB::table('tblcomplaints')->orderBy('complaintNumber', 'desc')->first();
        
        return redirect()->back()->with('successmsg', "Your complaint has been successfully filed and your complaint no is " . $complaint->complaintNumber);
    }

    public function getSubcategory(Request $request)
    {
        $catid = $request->input('catid');
        $subcategories = DB::table('subcategory')->where('categoryid', $catid)->get();
        
        $options = '<option value="">Select Subcategory</option>';
        foreach($subcategories as $subcat) {
            $options .= '<option value="' . htmlentities($subcat->subcategory) . '">' . htmlentities($subcat->subcategory) . '</option>';
        }
        
        return response($options);
    }

    public function history()
    {
        $userId = Session::get('id');
        if (!$userId) return redirect('/users/login');

        $complaints = DB::table('tblcomplaints')->where('userId', $userId)->get();
        return view('users.complaint-history', compact('complaints'));
    }

    public function show($id)
    {
        $userId = Session::get('id');
        if (!$userId) return redirect('/users/login');
        
        $complaint = DB::table('tblcomplaints')
            ->join('category', 'category.id', '=', 'tblcomplaints.category')
            ->select('tblcomplaints.*', 'category.categoryName as catname')
            ->where('tblcomplaints.userId', $userId)
            ->where('tblcomplaints.complaintNumber', $id)
            ->first();

        if (!$complaint) {
            return redirect()->route('users.complaint-history')->with('errormsg', 'Complaint not found or access denied.');
        }

        $remarkHistory = DB::table('complaintremark')
            ->where('complaintNumber', $id)
            ->get();

        return view('users.complaint-details', compact('complaint', 'remarkHistory'));
    }
}
