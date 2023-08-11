<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth']);
    }
    //action
    public function index()
    {
        $user = 'Mohammed';
        return view('dashboard.index',compact('user'));
    }
}
