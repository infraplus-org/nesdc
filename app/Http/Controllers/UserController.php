<?php

namespace App\Http\Controllers;

//use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//use Illuminate\Foundation\Bus\DispatchesJobs;
//use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Masters;
use App\Models\User;
use App\Models\vUsers;

class UserController extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $data['users'] = vUsers::all();
        return view('user.list', $data);
    }

    public function update($id)
    {
        $data['roles'] = Masters::where('type', 'Role')->get();
        $data['user'] = User::where('id', $id)->firstOr(function(){
            return new User;
        });

        return view('user.modal_manage', $data);
    }

    public function updating(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required',
        ]);

        if ($request->input('id') == 0)
        {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);
        }
        else
        {
            $user = User::where('id', $request->input('id'))->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);
        }

        return redirect('/user')->with('response', response_success('บันทึกข้อมูลเรียบร้อยแล้ว'));
    }
}
