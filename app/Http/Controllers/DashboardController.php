<?php

namespace App\Http\Controllers;

//use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//use Illuminate\Foundation\Bus\DispatchesJobs;
//use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\Models\Contacts;
use App\Models\Masters;
use App\Models\Projects;
use App\Models\vProjects;

class DashboardController extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        // print_r(Auth::user());
        return view('dashboard');
    }

    public function pom()
    {
        // print_r(Auth::user());
        return view('test');
    }
}
