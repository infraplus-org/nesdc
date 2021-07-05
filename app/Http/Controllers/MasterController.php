<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Models\Masters;

class MasterController extends Controller
{
    public function index()
    {
        $data['master_type'] = Masters::select('type')->distinct()->orderBy('type')->get();
        $data['masters'] = Masters::all();
        return view('master.list', $data);
    }

    public function update($id)
    {
        $data['types'] = Masters::groupBy('type')->selectRaw('type, MAX(code) AS code')->orderBy('type')->get();
        $data['master'] = Masters::where('id', $id)->firstOr(function(){
            return new Masters;
        });

        return view('master.modal_manage', $data);
    }

    public function updating(Request $request)
    {
        DB::beginTransaction();

        if ($request->filled('id'))
        {
            $result = Masters::where('id', $request->get('id'))
                ->update([
                    'type' => $request->get('type'),
                    'code' => $request->get('code'),
                    'description' => $request->get('description'),
                    'actived' => (bool)$request->get('actived'),
                    'ranking' => $request->get('ranking'),
                ]);
            if ($result == 0)
            {
                DB::rollback();
                return redirect('/master')->with('response', response_error('ไม่สามารถแก้ไขข้อมูลมาสเตอร์ได้'));
            }
        }
        else
        {
            $check = Masters::where('code', $request->get('code'))->count();
            if ($check > 0)
            {
                return redirect('/master')->with('response', response_error('รหัสมีอยู่แล้วในระบบ'));
            }

            $result = Masters::create([
                'type' => $request->get('type'),
                'code' => $request->get('code'),
                'description' => $request->get('description'),
                'actived' => (bool)$request->get('actived'),
                'ranking' => $request->get('ranking'),
            ]);
            if (empty($result))
            {
                DB::rollback();
                return redirect('/master')->with('response', response_error('ไม่สามารถสร้างข้อมูลมาสเตอร์ได้'));
            }
        }
    
        DB::commit();
        return redirect('/master')->with('response', response_success('บันทึกข้อมูลเรียบร้อยแล้ว'));
    }
}
