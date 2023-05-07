<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        //return view('layouts.admin');
        return view('admin.dashboard.index');
    }
    public function tableList()
    {
        $data = [1, 2, 3];
        return view('admin.dashboard.table',compact('data'));
    }
    public function form()
    {
        $data = [1, 2, 3];
        return view('admin.dashboard.form');
    }
}
