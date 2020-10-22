<?php

namespace App\Http\Controllers\API\College;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\College;
use App\User;
use Auth;

class CollegeController extends Controller
{
    //
    public function getCollegeList()
    {//GET A LIST OF COLLEGES
        if(Auth::user()->role_id === 1)
        {
            $collegeList = College::orderBy('college_id', 'DESC')->get() ;
            $response = ["college_list" => $collegeList];
        }
        elseif(Auth::user()->role_id === 2)
        {
            $collegeList = College::where("college_id", Auth::user()->college_id)
            ->orderBy('college_id', 'DESC')->get() ;
            $response = ["college_list" => $collegeList];
        }
        else
        {
            $message = trans('messages.permission_denied');
            $response = ['status' => true,'message' => $message ];
        }

        return response()->json($response);
    }

    public function collegeDetails(Request $request)
    {
        $auth_user=Auth::user();
        if($auth_user->role_id !== 1 && $auth_user->role_id !== 2)
        {
            $message = trans('messages.permission_denied');
            $response = ['status' => true,'message' => $message ];
        }
        elseif($auth_user->role_id == 2 && $auth_user->college_id != $request->college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS STORE
            $message = trans('messages.permission_denied');
            $response = ['status' => true,'message' => $message ];
        }
        else
        {
            $collegeList = College::where('college_id', $request->college_id)->get() ;
            $response = ["college_list" => $collegeList];
        }

        return response()->json($response);
    }

    public function tutorlist(Request $request)
    {//LOADS TUTORS VIA AJAX
        $auth_user=Auth::user();
        if($auth_user->role_id !== 1 && $auth_user->role_id !== 2)
        {
            $message = trans('messages.permission_denied');
            return response()->json([ 'status' => true ,'message' => $message ]);
        }
                
        if($auth_user->role_id == 2 && $auth_user->college_id != $request->college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS STORE
            $message = trans('messages.permission_denied');
            return response()->json([ 'status' => true ,'message' => $message ]);
        }

        $tutorList = User::where("college_id", $request->college_id)
        ->where("role_id", 3)->orderBy('id', 'DESC')->get();
        
        $response = [
            "college_list" => $tutorList
        ];
        return response()->json($response);
    }

    public function studentlist(Request $request)
    {//LOADS TUTORS VIA AJAX
        $auth_user=Auth::user();
        if($auth_user->role_id !== 1 && $auth_user->role_id !== 2)
        {
            $message = trans('messages.permission_denied');
            return response()->json([ 'status' => true ,'message' => $message ]);
        }
                
        if($auth_user->role_id == 2 && $auth_user->college_id != $request->college_id)
        {//CHECK IF SUBADMIN CAN ACCESS THIS STORE
            $message = trans('messages.permission_denied');
            return response()->json([ 'status' => true ,'message' => $message ]);
        }

        $studentList = User::where("college_id", $request->college_id)
        ->where("role_id", 4)->orderBy('id', 'DESC')->get();
        
        $response = ["student_list" => $studentList];
        return response()->json($response);
    }
}
