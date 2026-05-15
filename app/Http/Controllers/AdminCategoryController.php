<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminCategoryController extends Controller
{
    // --- Category Management ---
    public function categories()
    {
        if (!Session::get('alogin')) return redirect('/admin/login');
        $categories = DB::table('category')->get();
        return view('admin.category', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        if (!Session::get('alogin')) return redirect('/admin/login');
        DB::table('category')->insert([
            'categoryName' => $request->input('category'),
            'categoryDescription' => $request->input('description') ?? ''
        ]);
        return redirect()->back()->with('msg', 'Category Created !!');
    }

    public function destroyCategory($id)
    {
        if (!Session::get('alogin')) return redirect('/admin/login');
        DB::table('category')->where('id', $id)->delete();
        return redirect()->back()->with('delmsg', 'Category deleted !!');
    }

    // --- Subcategory Management ---
    public function subcategories()
    {
        if (!Session::get('alogin')) return redirect('/admin/login');
        $subcategories = DB::table('subcategory')
            ->join('category', 'category.id', '=', 'subcategory.categoryid')
            ->select('subcategory.*', 'category.categoryName')
            ->get();
        $categories = DB::table('category')->get();
        return view('admin.subcategory', compact('subcategories', 'categories'));
    }

    // --- State Management ---
    public function states()
    {
        if (!Session::get('alogin')) return redirect('/admin/login');
        $states = DB::table('state')->get();
        return view('admin.state', compact('states'));
    }
}
