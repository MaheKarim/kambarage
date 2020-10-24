<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\College;
use App\Author;
use App\User;
use App\Transaction;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $auth_user=authSession();

        if($auth_user->role_id===1 || $auth_user->user_type === "admin")
        {
            $book=Book::orderBy('book_id','DESC')->with(['getAuthor'])->get();
            $user = User::where('user_type','user')->orderBy('id','DESC')->get();
            $author = Author::orderBy('author_id','DESC')->get();
            $total_subadmin = User::where("role_id", 2)->count();
            $total_adminassistant = User::where("role_id", 5)->count();
            $total_tutor = User::where("role_id", 3)->count();
            $total_student = User::where("role_id", 4)->count();
            $total_college = College::count();
            
            $data=[];
            $data['card']=[
                'total_book' => $book->count('book_id'),
                'total_author' => $author->count('author_id'),
                'total_user' => $user->count('id'),
                'total_subadmin' => $total_subadmin,
                'total_adminassistant' => $total_adminassistant,
                'total_college' => $total_college,
                'total_tutor' => $total_tutor,
                'total_student' => $total_student,
            ];

            for($i=1;$i<=12;$i++) {
                $data['graph']['books'][] = $book->filter(function ($value, $key) use ($i) {
                                                                return date('Y-m', strtotime($value->created_at)) == (date('Y').'-'.sprintf('%02d', $i));
                                                            })->count('id');
                $data['graph']['users'][] = $user->filter(function ($value, $key) use ($i) {
                                                                return date('Y-m', strtotime($value->created_at)) == (date('Y').'-'.sprintf('%02d', $i));
                                                            })->count('id');
            }


            $data['list']=[
                'book' => $book->take(5),
                'college' => College::orderBy('college_id','DESC')->limit(5)->get(),
            ];
            return view('Admin.home',compact(['data']));
        }
        elseif($auth_user->role_id===5 || $auth_user->user_type === "admin_assistant")
        {
            $data= $book_list = $transaction_list = [];
            
            $total_author = $total_book = $total_sale = $total_tutor = $total_student = $total_subadmin = 0;
            $roles = array_map("trim", explode(";;", $auth_user->admin_assistant_roles));            

            if(in_array("content", $roles, true))
            {
                $book = Book::orderBy('book_id','DESC')->with(['getAuthor'])->get();
                $total_book = $book->count('book_id');
                $book_list = $book->take(5);
            }

            if(in_array("sales", $roles, true))
            {
                $transaction = Transaction::with(['getSingleTransactionDetail'])->orderBy('transaction_id','DESC')->get();
                $total_sale = $transaction->count('transaction_id');
                $transaction_list = $transaction->take(5);

                for($i=1;$i<=12;$i++) {
                    $data['graph']['sales'][] = $transaction->filter(function ($value, $key) use ($i) {
                        return date('Y-m', strtotime($value->datetime)) == (date('Y').'-'.sprintf('%02d', $i));
                    })->sum('total_amount');
                }
            }
            else
            { 
                $data['graph']['sales'][] = null;
            }
            
            if(in_array("contributors", $roles, true))
            {
                $author = Author::orderBy('author_id','DESC')->get();
                $total_author = $author->count('author_id');
            }
             
            
            if(in_array("college", $roles, true))
            {
                $total_subadmin = User::where("role_id", 2)->count();
                $total_tutor = User::where("role_id", 3)->count();
                $total_student = User::where("role_id", 4)->count();
            }

            $data['card']=[
                'total_book' => $total_book,
                'total_author' => $total_author,
                'total_subadmin' => $total_subadmin,
                'total_tutor' => $total_tutor,
                'total_student' => $total_student,
                'total_sale' => $total_sale,
            ];

            $data['list']=[
                'book' => $book_list,
                'transaction' => $transaction_list,
            ];
            return view('Admin.assistant.home',compact(['data', 'roles']));
        }
        elseif($auth_user->role_id == 2 || $auth_user->user_type === "subadmin")
        {
            $total_tutor = User::where("college_id", $auth_user->college_id)
            ->where("role_id", 3)->count();
            $total_student = User::where("college_id", $auth_user->college_id)
            ->where("role_id", 4)->count();
            
            return view('subadmin.home',compact('total_tutor', 'total_student'));
        }
        else
        {
            return view('errors.error_403');
        }
    }

    public function checkEnvironment(Request $request)
    {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        $message = "";
        if($request->tab == "tab3"){
            try{
                $con = mysqli_connect($request->database_hostname.':'.$request->database_port,$request->database_username,$request->database_password,$request->database_name);
                $status = true;
                if(empty($request->database_name)){
                    $message = "Database not found in your server";
                    $status = false;
                }
            }
            catch (\Exception $e){
                $con = false;
                if(strpos($e->getMessage(), 'Access denied for user') !== false){
                    $message = "Please enter correct database username or password";
                }elseif(strpos($e->getMessage(), 'Unknown database') !== false){
                    $message = "Database not found in your server";
                }elseif(strpos($e->getMessage(), "Connection refused") !== false){
                    $message = "Please enter valid database port ";
                }elseif(strpos($e->getMessage(), "Connection timed out") !== false || strpos($e->getMessage(), "Invalid argument") !== false){
                    $message = "Please enter valid database host";
                }else{
                    $message = $e->getMessage();
                }
                $status = false;
            }
        }elseif ($request->tab == "tab4"){

            $envFileData =
                'APP_NAME=\'' . optional($request)->app_name . "'\n" .
                'APP_ENV=' . optional($request)->environment . "\n" .
                'APP_KEY=' . 'base64:bODi8VtmENqnjklBmNJzQcTTSC8jNjBysfnjQN59btE=' . "\n" .
                'APP_DEBUG=' . optional($request)->app_debug . "\n" .
                'APP_LOG_LEVEL=' . optional($request)->app_log_level . "\n" .
                'APP_URL=' . optional($request)->app_url . "\n\n" .
                'DB_CONNECTION=' . optional($request)->database_connection . "\n" .
                'DB_HOST=' . optional($request)->database_hostname . "\n" .
                'DB_PORT=' . optional($request)->database_port . "\n" .
                'DB_DATABASE=' . optional($request)->database_name . "\n" .
                'DB_USERNAME=' . optional($request)->database_username . "\n" .
                'DB_PASSWORD=' . optional($request)->database_password . "\n\n" .
                'BROADCAST_DRIVER=' . optional($request)->broadcast_driver . "\n" .
                'CACHE_DRIVER=' . optional($request)->cache_driver . "\n" .
                'SESSION_DRIVER=' . optional($request)->session_driver . "\n" .
                'QUEUE_DRIVER=' . optional($request)->queue_driver . "\n\n" .
                'REDIS_HOST=' . optional($request)->redis_hostname . "\n" .
                'REDIS_PASSWORD=' . optional($request)->redis_password . "\n" .
                'REDIS_PORT=' . optional($request)->redis_port . "\n\n" .
                'MAIL_DRIVER=' . optional($request)->mail_driver . "\n" .
                'MAIL_HOST=' . optional($request)->mail_host . "\n" .
                'MAIL_PORT=' . optional($request)->mail_port . "\n" .
                'MAIL_USERNAME=' . optional($request)->mail_username . "\n" .
                'MAIL_PASSWORD=' . optional($request)->mail_password . "\n" .
                'MAIL_ENCRYPTION=' . optional($request)->mail_encryption . "\n\n";

            try {
                file_put_contents(base_path('.env'), $envFileData);
//                $mail_vals=[optional($request)->mail_driver,optional($request)->mail_host,optional($request)->mail_port,optional($request)->mail_username,optional($request)->mail_password,optional($request)->mail_encryption];
                $mail_vals=[optional($request)->mail_driver];
                if(in_array('null',$mail_vals) || in_array('',$mail_vals)){
                    $message = "Please check mail configuration";
                    $status = false;
                }else{
                    $status = true;
                }
            }
            catch(Exception $e) {
                $results = trans('Mail Server Not Connected, Please check you mail configuration');
                $status = false;
            }

        }else{
            $status = true;
            if(empty($request->app_name)){
                $status = false;
                $message = "Please enter the app name";
            }elseif ($request->environment=="other" && isset($request->environment_custom)){
                $status = false;
                $message = "Please enter the app environment";
            }
        }
        return response()->json([ 'status' => $status , 'message' => $message , 'tab' => $request->tab ]);
    }

}
