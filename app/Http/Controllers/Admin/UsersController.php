<?php

namespace App\Http\Controllers\Admin;

use App\TransactionDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use \App\Feedback;
use \App\Transaction;
use \App\UserAddress;
use \App\User;
use \App\Role;
use \App\College;
use \App\BookRating;
use Datatables;
use Yajra\DataTables\Html\Builder;
use Validator;
use Auth;
use Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::user()->allowedAccess("users"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle = trans('messages.list_form_title',['form' => trans('messages.user') ]);
        return view('Admin.users.index',compact('pageTitle'));
    }

    function list(){
        if(!Auth::user()->allowedAccess("users"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $user =  User::where('role_id',5);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }

        if(!Auth::user()->allowedAccess("users"))
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $user= User::find($id);
        if($user == ''){
            return redirect()->back()->withErrors(trans('messages.check_delete_msg',['form' => trans('messages.user') ]));
        }
        Transaction::where('user_id',$user->id)->delete();
        TransactionDetail::where('user_id',$user->id)->delete();
        $user->delete();
        return redirect(route('users.index'))->withSuccess(trans('messages.delete_success_msg',['form' => trans('messages.user') ]));
    }

    function userFeedback(){
        if(!Auth::user()->allowedAccess("user_feedback"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle = trans('messages.list_form_title',['form' => trans('messages.users_feedback')  ]);
        return view('Admin.users.users-feedback',compact('pageTitle'));
    }

    function userFeedbackDataList(){
        if(!Auth::user()->allowedAccess("user_feedback"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $user_feedback_data =  Feedback::orderBy("id",'Desc');

        return Datatables::eloquent($user_feedback_data)
        ->editColumn('comment', function ($user_feedback_data) {
            return '<a class="tooltip"><b>'.optional($user_feedback_data)->comment.'</b><span class="tooltip-content"><span class="tooltip-text"><span class="tooltip-inner">'.optional($user_feedback_data)->comment.'</span></span></span></a>';
        })
        ->editColumn('action', function ($user_feedback_data) {
            return '
            <a class="btn btn-sm btn-info"  title ="'.trans('messages.show') .'"
                href="'.route('users_feedback.details', ['id' => $user_feedback_data->id]).'">
              <i class="fas fa-eye "></i>
            </a>
            <a class="btn btn-sm btn-primary"  title ="'.trans('messages.mark_as_read') .'"
                href="'.route('users_feedback.mark', ['id' => $user_feedback_data->id]).'">
              <i class="fas fa-mark "></i>
            </a>
            ';
        })
        ->addIndexColumn()
        ->rawColumns(['image','transaction','comment','action'])
        ->toJson();
    }

    function userFeedbackDetails($id)
    {
        if(!Auth::user()->allowedAccess("user_feedback"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle = trans('messages.users_feedback')." ".trans('detail');

        $feedback = Feedback::where('feedback.id', $id)
                                        ->join('users', 'users.id', '=', 'feedback.user_id')
                                        ->first();
        
        $user_role = $feedback->role_id == NULL?  "" : 
        Role::select('display_name')->where('id', $feedback->role_id)->first()->display_name;
        
        $college = $feedback->college_id == NULL?  "" : 
        College::select('name')->where('college_id', $feedback->college_id)->first()->display_name;
       
        return view('Admin.users.users-feedback-detail',compact('pageTitle', 'feedback', 'user_role', 'college'));
    }

    function markAsRead($id)
    {
        if(!Auth::user()->allowedAccess("user_feedback"))
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $result = Feedback::where("id", $id)->update([
            'is_read' => 1
        ]);
        
        
        if($result){
            return Redirect::back()->withSuccess(trans('messages.mark_as_read_success'));
        }
        
        return Redirect::back()->withErrors(trans('messages.mark_as_read_fail'));
    }


    public function userDetail($id){
        if(!Auth::user()->allowedAccess("users"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $title= trans('messages.form_detail',['form' => trans('messages.user')  ]);
        $userdata = User::where("id", $id)->with(['ratings','getUserDetail'])->first();

       return view("Admin.users.user-details",compact('title', 'userdata'));
    }

    function userDeviceMacIdRemove(Request $request)
    {
        if(!Auth::user()->allowedAccess("users"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        $user = User::where("id", $request->user_id)->first();
        if($request->remove_data == "remove_device_id") {
            $user->registration_id = null;
            $user->device_id = null;
            $user->save();
            return response()->json(['status' => true ,'message' => trans('messages.remove_device_id'), 'event'=>'deleted']);
        }
        else if($request->remove_data == "remove_mac_id")
        {
            $user->mac_id = null;
            $user->save();
            return response()->json(['status' => true ,'message' => trans('messages.remove_mac_id'), 'event'=>'deleted']);
        }
        else{
            return response()->json(['status' => false ,'message' => trans('Unsuccessfully removed'), 'event'=>'validation']);
        }
    }

    public function passwordUpadte(Request $request)
    {
        // $role = 'user.settings';
        $role = 'admin.settings';
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        if($auth_user!='' && $auth_user->is('admin')){
            $role = 'admin.settings';
        }

        $user = User::find($auth_user->id);
        $page = 'password_form';

        $validator = Validator::make($request->all(), [
            'old' => 'required|max:255',
            'password' => 'required|min:6|confirmed|max:255',
        ],['old.*'=>'The old password field is required.',
            'password.required'=>'The new password field is required.',
            'password.confirmed'=>"The password confirmation does not match."]);

        if ($validator->fails()) {
            return redirect()->route($role, ['page'=>$page])->withErrors($validator->getMessageBag()->toArray());
        }

        $hashedPassword = $user->password;
        $match=Hash::check($request->old, $hashedPassword);
        $same_exits=Hash::check($request->password, $hashedPassword);

        if($match) {

            if($same_exits){
                return redirect()->route($role, ['page'=>$page])->withErrors(trans('messages.old_password_same'));
            }

            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();
            \Auth::logout();

            return redirect()->route($role, ['page'=>$page])->withSuccess('Your password has been changed.');

        }else{
            return redirect()->route($role, ['page'=>$page])->withSuccess('Please check your old password.');
        }
    }

    public function updateUpdate(Request $request){

        $id=$request->id;
        $page = 'profile_form';
        $auth_user=authSession();
        // $role = 'user.settings';
        $role = 'admin.settings';
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        if($auth_user!='' && $auth_user->is('admin')){
            $role = 'admin.settings';
            $validator=Validator::make($request->all(), [
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                return redirect()->route($role, ['page'=>$page])->withErrors($validator->getMessageBag()->toArray());
            }
        }

        $validator=Validator::make($request->all(), [
            'name' => 'required|regex:/^[\pL\s-]+$/u|max:255',
            'contact_number' => 'required|digits_between:10,12|unique:users,contact_number,'.$id,
            'profile_image' => 'mimetypes:image/jpeg,image/png,image/jpg,image/gif|max:255',
        ],['profile_image'=>'Image should be png/PNG, jpg/JPG',
        ]);

        if ($validator->fails()) {
            return redirect()->route($role, ['page'=>$page])->withErrors($validator->getMessageBag()->toArray());
        }

        $data=$request->all();

        $result=User::updateOrCreate(['id' => $id], $data);

        if($request->profile_image!=''){

            uploadImage($request->profile_image,'/uploads/profile-image',$id,'image');
        }
        authSession(true);

        return redirect()->route($role, ['page'=>$page])->withSuccess(trans('messages.profile').' '.trans('messages.msg_updated'));
    }
}
