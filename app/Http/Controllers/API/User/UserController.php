<?php
namespace App\Http\Controllers\API\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Feedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
public $successStatus = 200;

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success              =$user;
            $success['api_token'] =  $user->createToken('MyApp')->accessToken;

            return response()->json(['data' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function register(Request $request){
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'regex:/^[\pL\s-]+$/u|max:255',
            'username' => 'required|unique:users,username' ,
            'email' => 'email|unique:users,email',
            'contact_number' => 'digits_between:6,12',//|unique:user_detail,contact_number',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }


            $password = $input['password'];
            $input['user_type'] = isset($input['user_type']) ? $input['user_type'] : 'user';
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);
            $input['api_token'] =  $user->createToken('MyApp')->accessToken;

            // Send email

            // $input['password'] = $password;
            // $to = $user->email;
            // $from = env('MAIL_USERNAME');
            // sendMail(6,$input,$to,$from);
            // $input['user_type'] = isset($input['user_type']) ? $input['user_type'] : 'user';
            // $role=\App\Role::where('name',$input['user_type'])->first();
            // if($role==""){
            //     $role=\App\Role::where('is_default',1)->first();
            // }
            $message = trans('messages.save_form',['form' => 'User']);

        return response()->json([ "status" => true , "message" => $message ,'data' => $input ]);
    }

    public function updateUserProfile(Request $request){
        $data = json_decode($request->user_detail,true);
        if ($data != "") {
            $validator = Validator::make($data, [
                'name' => 'regex:/^[\pL\s-]+$/u|max:255',
                'username' => 'required|unique:users,username,'.$data['id'] ,
                'email' => 'email|unique:users,email,'.$data['id'] ,
                'contact_number' => 'digits_between:6,12',
            ]);

            if ($validator->fails()) {
                return response()->json([ "status" => false , "errors" => $validator->getMessageBag()->all() ]);
            }
            $user = User::updateOrCreate(['id' => $data['id'] ], $data);
            if($request->image) {
                $user->clearMediaCollection('image');
                $user->addMediaFromRequest('image')->toMediaCollection('image');
            }
        }
        $message = trans('messages.update_form',['form' => 'User profile']);
        $user_detail = User::where('id',optional($user)->id)->first();
        $user_detail->image =getSingleMedia($user_detail,'image',null);
        return response()->json([ "status" => true , "message" => $message ,'data' => $user_detail ]);
    }

    public function saveFeedBack(Request $request){
		$validator = \Validator::make($request->all(), [
            'name'  => 'required',
            'email' => 'required|email',
            'comment' => 'required',
        ]);

        if ($validator->fails())
        {
                return \Response::json([
                    'status' => false,
                    'errors' => $validator->getMessageBag()->all()
                ]);
        }
        $temp = $request->all();
        Feedback::create($temp);

        return response()->json(['status' => true,'message' => trans('messages.save_form' ,['form' => 'Your feedback'])]);
    }
}
