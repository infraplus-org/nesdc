<?php

namespace App\Http\Controllers;

//use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//use Illuminate\Foundation\Bus\DispatchesJobs;
//use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\vContacts;
use App\Models\vProjects;

class ContactController extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function project_detail($contact_id)
    {
        $data['contact'] = vContacts::where('contact_id', $contact_id)->first();
        $data['projects'] = vProjects::where('contact_id', $contact_id)->get();

        return view('project.modal_status', $data);
    }
}
