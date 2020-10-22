<?php

namespace App\Http\Controllers\Subadmin;

use App\College;
use App\School;
use App\User;
use DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;


class SchoolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    //Used to load form for Adding Subadmins FOR A PARTICULAR COLLEGE
    public function addsubadmin($college_id)
    {
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        
        if($auth_user->role_id == 2 && $auth_user->college_id != $college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS COLLEGE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle = trans('messages.add_button_form',['form' => trans('messages.subadmin')  ]);
        $college = College::where('college_id', $college_id)->first();

        return view('Admin.college.addsubadmin',compact('college', 'pageTitle'));
    }


    //Used to store added subadmin to database
    public function newsubadmin($college_id, Request $request)
    {
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        
        if($auth_user->role_id == 2 && $auth_user->college_id != $college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS COLLEGE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        
        $validator=\Validator::make($request->all(), [
            'college_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
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
            'college_id' => $data['college_id'],
            'role_id' => 2,
            "user_type" => "subadmin",
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        
        
        if($result){
            $message = trans('messages.save_form',['form' => trans('messages.subadmin')]);
            return redirect(route('school.show', [$data["college_id"]]))->withSuccess($message);
        }
        
        return Redirect::back()->withInput();
    }

    //GET A LIST OF TUTORS FOR A PARTICULAR COLLEGE
    public function tutor($college_id)
    {//LOADS THE TUTOR VIEW
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        
        if($auth_user->role_id == 2 && $auth_user->college_id != $college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS COLLEGE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $college_name = College::where('college_id', $college_id)->first()["name"];
        $pageTitle = $college_name;

        return view("subadmin.college.tutor", compact("pageTitle", "college_id"));
    }
    
    public function tutorlist($college_id)
    {//LOADS TUTORS VIA AJAX
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        
        if($auth_user->role_id == 2 && $auth_user->college_id != $college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS COLLEGE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $query = User::where("college_id", $college_id)
        ->where("role_id", 3)->orderBy('id', 'DESC')->get() ;
        return Datatables::of($query)
        ->editColumn('name', function ($query) {
            return isset($query->name) ? ($query->name) :'';
        })

        ->editColumn('email', function ($query) {
            return isset($query->email) ? ($query->email) :'';
        })

        ->editColumn('contact_no', function ($query) {
            return isset($query->contact_number) ? ($query->contact_number) :'';
        })

        ->editColumn('action', function ($query) {
            return '

            <a class="btn btn-sm btn-primary"  title ="'.trans('messages.edit') .'"
                href="'.route('school.edittutor', ['id' => $query->id]).'">
              <i class="fa fa-edit "></i>
            </a>
            <a class="btn btn-sm btn-primary"  title ="'.trans('messages.edit')." ".trans('messages.email') .'"
                href="'.route('school.editemail', ['usertype' => 'tutor', 'id' => $query->id]).'">
              <i class="fa fa-envelope "></i>
            </a>
            <a onclick="return confirm(\''.trans('messages.delete_form_message',['form' => trans('messages.tutor')]).'\')" class="btn btn-sm btn-danger"  title ="'.trans('messages.delete') .'"
            href="'.route('school.destroytutor', ['id' => $query->id]).'">
              <i class="fa fa-trash"></i>
            </a>';
        })
        ->addIndexColumn()
        ->toJson();
    }

    //GET A LIST OF STUDENTS FOR A PARTICULAR COLLEGE
    public function student($college_id)
    {//LOADS THE STUDENT VIEW
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        
        if($auth_user->role_id == 2 && $auth_user->college_id != $college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS COLLEGE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $college_name = College::where('college_id', $college_id)->first()["name"];
        $pageTitle = $college_name;
        
        return view("subadmin.college.student", compact("pageTitle", "college_id"));
    }
    
    public function studentlist($college_id)
    {//LOADS STUDENTS VIA AJAX
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        
        if($auth_user->role_id == 2 && $auth_user->college_id != $college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS COLLEGE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $query = User::where("college_id", $college_id)
        ->where("role_id", 4)->orderBy('id', 'DESC')->get();
        return Datatables::of($query)
        ->editColumn('name', function ($query) {
            return isset($query->name) ? ($query->name) :'';
        })

        ->editColumn('email', function ($query) {
            return isset($query->email) ? ($query->email) :'';
        })

        ->editColumn('contact_no', function ($query) {
            return isset($query->contact_number) ? ($query->contact_number) :'';
        })

        ->editColumn('action', function ($query) {
            return '

            <a class="btn btn-sm btn-primary"  title ="'.trans('messages.edit') .'"
                href="'.route('school.editstudent', ['id' => $query->id]).'">
              <i class="fa fa-edit "></i>
            </a>
            <a class="btn btn-sm btn-primary"  title ="'.trans('messages.edit')." ".trans('messages.email') .'"
                href="'.route('school.editemail', ['usertype' => 'student', 'id' => $query->id]).'">
              <i class="fa fa-envelope "></i>
            </a>
            <a onclick="return confirm(\''.trans('messages.delete_form_message',['form' => trans('messages.student')]).'\')" class="btn btn-sm btn-danger"  title ="'.trans('messages.delete') .'"
            href="'.route('school.destroystudent', ['id' => $query->id]).'">
              <i class="fa fa-trash"></i>
            </a>';
        })
        ->addIndexColumn()
        ->toJson();
    }


    public function addtutor($college_id)
    {//USED TO LOAD FORM FOR ADDING TUTOR TO A PARTICULAR COLLEGE
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        
        if($auth_user->role_id == 2 && $auth_user->college_id != $college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS STORE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle = trans('messages.add_button_form',['form' => trans('messages.tutor')  ]);
        $college = College::where('college_id', $college_id)->first();

        return view('subadmin.college.addtutor',compact('college', 'pageTitle'));
    }

    public function edittutor($tutor_id)
    {//USED TO LOAD FORM FOR EDITING TUTOR TO A PARTICULAR COLLEGE
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle = trans('messages.add_button_form',['form' => trans('messages.tutor')  ]);
        $tutor = User::where("id", $tutor_id)->first();
        
        if($auth_user->role_id == 2 && $auth_user->college_id != $tutor->college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS STORE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        return view('subadmin.college.edittutor',compact('tutor', 'pageTitle'));
    }

    public function editemail($user_type, $user_id)
    {//USED TO LOAD FORM FOR EDITING TUTOR TO A PARTICULAR COLLEGE
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle = trans('messages.edit_button_form',['form' => trans('messages.email')  ]);
        $user = User::where("id", $user_id)->first();
        
        if($auth_user->role_id == 2 && $auth_user->college_id != $user->college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS STORE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        return view('subadmin.college.editemail',compact('user', 'user_type', 'pageTitle'));
    }

    public function updateemail($user_type, $id, Request $request)
    {//USED IN COLLEGE TO UPDATE TUTOR IN DATABASE
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        
        $validator=\Validator::make($request->all(), [
            'college_id' => ['required', 'numeric'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
        ]);
        
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $data = $request->all();
        $college_id = $data['college_id'];
        
        if($auth_user->role_id == 2 && $auth_user->college_id != $college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS STORE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }        
        
        $result = User::where("id", $id)->update([
            'email' => $data['email'],
        ]);
        
        
        if($result){
            $message = trans('messages.save_form',['form' => trans('messages.tutor')]);
            return redirect(route('school.'.$user_type, [$college_id]))->withSuccess($message);
        }
        
        return Redirect::back()->withInput();
    }


    public function newtutor($id, Request $request)
    {//USED IN COLLEGE TO ADD TUTOR TO DATABASE
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        
        $validator=\Validator::make($request->all(), [
            'college_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contact_number' => ['required', 'max:15', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $data = $request->all();
             
        if($auth_user->role_id == 2 && $auth_user->college_id != $data['college_id'])
        {//CHECK IF SUBADMIN CAN ACCESS THIS STORE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $result = User::create([
            'college_id' => $data['college_id'],
            'role_id' => 3,
            'user_type' => "tutor",
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'contact_number' => $data['contact_number'],
            'password' => Hash::make($data['password']),
        ]);
        
        
        if($result){
            $message = trans('messages.save_form',['form' => trans('messages.subadmin')]);
            return redirect(route('school.tutor', [$data["college_id"]]))->withSuccess($message);
        }
        
        return Redirect::back()->withInput();
    }

    public function updatetutor($id, Request $request)
    {//USED IN COLLEGE TO UPDATE TUTOR IN DATABASE
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        
        $validator=\Validator::make($request->all(), [
            'college_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'contact_number' => ['required', 'max:15', 'unique:users,contact_number,'.$id],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $data = $request->all();
        $college_id = $data['college_id'];
        
        if($auth_user->role_id == 2 && $auth_user->college_id != $college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS STORE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }        
        
        $result = User::where("id", $id)->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'contact_number' => $data['contact_number'],
            'password' => Hash::make($data['password']),
        ]);
        
        
        if($result){
            $message = trans('messages.save_form',['form' => trans('messages.tutor')]);
            return redirect(route('school.tutor', [$college_id]))->withSuccess($message);
        }
        
        return Redirect::back()->withInput();
    }


    public function addstudent($college_id)
    {//USED TO LOAD FORM FOR ADDING TUTOR TO A PARTICULAR COLLEGE
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
                
        if($auth_user->role_id == 2 && $auth_user->college_id != $college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS STORE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle = trans('messages.add_button_form',['form' => trans('messages.student')  ]);
        $college = College::where('college_id', $college_id)->first();

        return view('subadmin.college.addstudent',compact('college', 'pageTitle'));
    }

    public function newstudent($id, Request $request)
    {//USED IN COLLEGE TO ADD STUDENT TO DATABASE
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        
        $validator=\Validator::make($request->all(), [
            'college_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contact_number' => ['required', 'max:15', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $data = $request->all();
        
                
        if($auth_user->role_id == 2 && $auth_user->college_id != $data['college_id'])
        {//CHECK IF SUBADMIN CAN ACCESS THIS STORE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $result = User::create([
            'college_id' => $data['college_id'],
            'role_id' => 4,
            'user_type' => 'student',
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'contact_number' => $data['contact_number'],
            'password' => Hash::make($data['password']),
       ]);
        
        
        if($result){
            $message = trans('messages.save_form',['form' => trans('messages.subadmin')]);
            return redirect(route('school.student', [$data["college_id"]]))->withSuccess($message);
        }
        
        return Redirect::back()->withInput();
    }


    public function editstudent($student_id)
    {//USED TO LOAD FORM FOR EDITING STUDENT IN A PARTICULAR COLLEGE
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle = trans('messages.add_button_form',['form' => trans('messages.student')  ]);
        $student = User::where("id", $student_id)->first();

                
        if($auth_user->role_id == 2 && $auth_user->college_id != $student->college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS STORE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        return view('subadmin.college.editstudent',compact('student', 'pageTitle'));
    }

    public function updatestudent($id, Request $request)
    {//USED TO UPDATE STUDENT
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        
        $validator=\Validator::make($request->all(), [
            'college_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'contact_number' => ['required', 'max:15', 'unique:users,contact_number,'.$id],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        
        $data = $request->all();
        $college_id = $data['college_id'];
                
        if($auth_user->role_id == 2 && $auth_user->college_id != $college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS STORE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $result = User::where("id", $id)->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'contact_number' => $data['contact_number'],
            'password' => Hash::make($data['password']),
        ]);
        
        
        if($result){
            $message = trans('messages.save_form',['form' => trans('messages.student')]);
            return redirect(route('school.student', [$college_id]))->withSuccess($message);
        }
        
        return Redirect::back()->withInput();
    }

    public function destroystudent($student_id)
    {//TO DELETE STUDENT
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $student=User::find($student_id);       
        if($auth_user->role_id == 2 && $auth_user->college_id != $student->college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS COLLEGE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        if($student->delete())
        {
            $message = trans('messages.delete_form',['form' => trans('messages.student')]);
            return Redirect::back()->withSuccess($message);
        }
        
        return Redirect::back();
    }

    public function destroytutor($tutor_id)
    {//DELETE A TUTOR
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $tutor=User::find($tutor_id);
        if($auth_user->role_id == 2 && $auth_user->college_id != $tutor->college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS COLLEGE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        if($tutor->delete())
        {
            $message = trans('messages.delete_form',['form' => trans('messages.tutor')]);
            return Redirect::back()->withSuccess($message);
        }

        return Redirect::back();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importstudentform($college_id)
    {
        //LOAD FORM TO IMPORT STUDENT
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        if($auth_user->role_id == 2 && $auth_user->college_id != $college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS COLLEGE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle = trans('messages.import_button_form',['form' => trans('messages.student')  ]);

        return view('subadmin.college.studentimport',compact('college_id', 'pageTitle'));
    }
 
    public function importtutorform($college_id)
    {
        //LOAD FORM TO IMPORT TUTOR
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        if($auth_user->role_id == 2 && $auth_user->college_id != $college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS COLLEGE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle = trans('messages.import_button_form',['form' => trans('messages.student')  ]);

        return view('subadmin.college.tutorimport',compact('college_id', 'pageTitle'));
    }

    public function importtutor($college_id)
    {
        //IMPORT CSV OR EXCEL FILE WITH TUTOR LIST INTO THE SYSTEM
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        if($auth_user->role_id == 2 && $auth_user->college_id != $college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS COLLEGE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $role_id = 3;
        Excel::import(new UsersImport($college_id, $role_id), request()->file('file'));
      
        $message = trans('messages.save_form',['form' => trans('messages.tutor')]);
        return redirect(route('school.tutor', [$college_id]))->withSuccess($message);
    }

    public function importstudent($college_id)
    {//IMPORT CSV OR EXCEL FILE WITH STUDENTS LIST INTO THE SYSTEM
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        if($auth_user->role_id == 2 && $auth_user->college_id != $college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS COLLEGE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $role_id = 4;
        Excel::import(new UsersImport($college_id, $role_id), request()->file('file'));      
        $message = trans('messages.save_form',['form' => trans('messages.student')]);
        return redirect(route('school.student', [$college_id]))->withSuccess($message);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Subadmin  $subadmin
     * @return \Illuminate\Http\Response
     */
    public function show($college_id, College $college)
    {
        //VIEW COLLEGE DETAILS
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        if($auth_user->role_id == 2 && $auth_user->college_id != $college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS COLLEGE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle = trans("messages.college")." ".trans("messages.detail");
        $collegeAdmins = $college->subadmin($college_id);
        $college = College::find($college_id);

        return view('subadmin.college.view',compact('collegeAdmins','pageTitle', "college"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subadmin  $subadmin
     * @return \Illuminate\Http\Response
     */
    public function edit($college_id)
    {
        //LOAD FORM FOR UPDATING COLLEGE
        $auth_user=Auth::user();
        if(!Auth::user()->allowedAccess("college") && $auth_user->role_id !== 2)
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        if($auth_user->role_id == 2 && $auth_user->college_id != $college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS COLLEGE
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $countrylist = College::countryList();
        $pageTitle = trans('messages.update_form_title',['form' => trans('messages.college')  ]);
        $college = College::where('college_id', $college_id)->first();
   
        return view('Admin.college.create',compact('college','pageTitle', 'countrylist')); 
    }
}
