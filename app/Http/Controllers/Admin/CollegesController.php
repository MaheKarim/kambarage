<?php

namespace App\Http\Controllers\Admin;

use App\College;
use App\User;
use DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Auth;

class CollegesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(!Auth::user()->allowedAccess("college"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }
        
        $pageTitle = trans("messages.college");
        return view("Admin.college.index", compact("pageTitle"));
    }

    //GET A LIST OF COLLEGES
    public function list()
    {
        if(!Auth::user()->allowedAccess("college"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $query = College::orderBy('college_id', 'DESC')->get() ;
        return Datatables::of($query)
        ->editColumn('name', function ($query) {
            return isset($query->name) ? ($query->name) :'';
        })
        ->editColumn('address', function ($query) {
            return isset($query->address) ? ($query->address) :'';
        })
        ->editColumn('gps', function ($query) {
            return isset($query->gps) ? ($query->gps) :'';
        })
        ->editColumn('country', function ($query) {
            return isset($query->country) ? ($query->country) :'';
        })

        ->editColumn('action', function ($query) {
            return '

            <a class="btn btn-sm btn-info"  title ="'.trans('messages.show') .'"
                href="'.route('college.show', ['id' => $query->college_id]).'">
              <i class="fa fa-eye "></i>
            </a>
            <a class="btn btn-sm btn-primary"  title ="'.trans('messages.edit') .'"
                href="'.route('college.edit', ['id' => $query->college_id]).'">
              <i class="fa fa-edit "></i>
            </a>
            <a onclick="return confirm(\'Are you sure?\')" class="btn btn-sm btn-danger"  title ="'.trans('messages.delete') .'"
            href="'.route('college.destroy', ['id' => $query->college_id]).'">
              <i class="fa fa-trash"></i>
            </a>';
        })
        ->addIndexColumn()
        ->toJson();
    }


    /**
 * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        //
        if(!Auth::user()->allowedAccess("college"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        if ($id != null && is_numeric($id)) {
            $pageTitle = trans('messages.update_form_title',['form' => trans('messages.college')  ]);
            $college = College::where('college_id', $id)->first();
        }else {
            $pageTitle = trans('messages.add_button_form',['form' => trans('messages.college')  ]);
            $college = new College;
        }

        $countrylist = College::countryList();

        return view('Admin.college.create',compact('college','pageTitle', 'countrylist'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }

        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $validator=\Validator::make($request->all(),[
            'name' => 'required|regex:/^[a-z0-9 .\-]+$/i|min:2|unique:colleges,name,'.$request->college_id.',college_id',
            'address' => 'required|max:255',
            'country' => 'required|max:255',
            'gps' => 'max:255',
        ]);
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $data = $request->all();
        $result = College::updateOrCreate(['college_id'=>$request->college_id],$data);

        $message = trans('messages.update_form',['form' => trans('messages.college')]);
        if($result->wasRecentlyCreated){
            $message = trans('messages.save_form',['form' => trans('messages.college')]);
        }

        if($auth_user->role_id != 1)
        {//SUBADMIN IS UPDATING
            return redirect(route('school.show', [$request->college_id]))->withSuccess($message);
        }

        return redirect(route('college.index'))->withSuccess($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\College  $college
     * @return \Illuminate\Http\Response
     */
    public function show($id, College $college)
    {
        //
        if(!Auth::user()->allowedAccess("college"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle = trans("messages.college")." ".trans("messages.detail");
        $collegeAdmins = $college->subadmin($id);
        $college = College::find($id);

        return view('Admin.college.view',compact('collegeAdmins','pageTitle', "college"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\College  $college
     * @return \Illuminate\Http\Response
     */
    public function edit(College $college)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\College  $college
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, College $college)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\College  $college
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //DELETE A PARTICULAR COLLEGE
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        
        if(!Auth::user()->allowedAccess("college"))
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $data= College::findOrFail($id);
        $data->delete();
        return redirect(route('college.index'))->withSuccess(trans('messages.delete_success_msg',['form' => trans('messages.college') ]));
    }
}
