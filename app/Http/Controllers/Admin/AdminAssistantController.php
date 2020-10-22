<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Datatables;
use Yajra\DataTables\Html\Builder;
use App\User;
use Auth;

class AdminAssistantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        if(!Auth::user()->allowedAccess())
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }
        
        $pageTitle = trans('messages.list_form_title',['form' => trans('messages.admin_assistant') ]);
        return view('Admin.assistant.index',compact('pageTitle'));
    }

    function list()
    {
        if(!Auth::user()->allowedAccess())
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $user =  User::where('role_id',5)->orderBy("id", "DESC");
        return Datatables::eloquent($user)
        ->editColumn('action', function ($query) {
            return '
            <a class="btn btn-sm btn-primary"  title ="'.trans('messages.edit') .'"
                href="'.route('assistant.edit', ['id' => $query->id]).'">
              <i class="fa fa-edit "></i>
            </a>
            <a onclick="return confirm(\'Are you sure?\')" class="btn btn-sm btn-danger" title ="'.trans('messages.delete') .'"
            href="'.route('user.delete', ['id' => $query->id]).'">
              <i class="fa fa-trash"></i>
            </a>

            </a>';
        })
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
        if(!Auth::user()->allowedAccess())
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }
        
        $pageTitle = trans('messages.add_button_form',['form' => 'messages.assistant']);
        return view('Admin.assistant.add',compact('pageTitle'));
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
        if(!Auth::user()->allowedAccess())
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        
        $validator=\Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'array'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contact_number' => ['required', 'string', 'max:15', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $data = $request->all();
        
        $result = User::create([
            'role_id' => 5,
            'user_type' => "admin_assistant",
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'admin_assistant_roles' => implode(";;", $data["role"]),
            'password' => Hash::make($data['password']),
        ]);
        
        
        if($result){
            $message = trans('messages.save_form',['form' => trans('messages.assistant')]);
            return redirect(route('assistant.index'))->withSuccess($message);
        }
        
        return Redirect::back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id=null, User $user)
    {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id=null, User $user)
    {
        //
        
        if(!Auth::user()->allowedAccess())
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }
        
        if(!is_numeric($id))
        {
            return Redirect::back();
        }
        
        $pageTitle = trans('messages.edit_button_form',['form' => 'messages.assistant']);
        $assistant = User::where("id", $id)->first();
        return view('Admin.assistant.edit',compact('pageTitle', 'assistant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, User $user)
    {
        //
        if(!Auth::user()->allowedAccess())
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        
        $validator=\Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'array'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'contact_number' => ['required', 'string', 'max:15', 'unique:users,contact_number,'.$id],
        ]);
        
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $data = $request->all();        
        $result = User::where("id", $id)->update([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'contact_number' => $data['contact_number'],
            'admin_assistant_roles' => implode(";;", $data["role"]),
        ]);
        
        
        if($result){
            $message = trans('messages.update_form',['form' => trans('messages.assistant')]);
            return redirect(route('assistant.index'))->withSuccess($message);
        }
        
        return Redirect::back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
