<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Author;
use App\Book;
use Session;
use File;
use DataTables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Html\Builder;
use Auth;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::user()->allowedAccess("contributors"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle = trans('messages.list_form_title',['form' => trans('messages.author')  ]);
        return view('Admin.author.index',compact('pageTitle'));
    }

    public function dataList(Request $request)
    {
        if(!Auth::user()->allowedAccess("contributors"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $type = $request->type;
        $data = Author::orderBy('author_id','DESC');
        if($type != null)
        {
            if($type == "top_5")
            {
                $data->take(5);
            }
        }

        $data = $data->get();

        return Datatables::of($data)
            ->editColumn('image', function ($data)
             {
                return '<img src='.getSingleMedia($data,'image',null).' border="0" width="40" class="img-rounded" />';
            })
            ->editColumn('action', function ($data) {
                return '

                 <a href="'.route('author.show',['id'=>$data->author_id]).' " title = "'. trans('messages.view') .'" class="btn btn-sm btn-info mr-05">
                 <i class="fa fa-eye "></i>
                 </a>

                <a class="btn btn-sm btn-primary mr-05" title = "'. trans('messages.edit') .'"
                    href="'.route('author.edit', ['id' => $data->author_id]).'">

                  <i class="fa fa-edit "></i>
                </a>

                <a onclick="return confirm(\'Are you sure?\')" class="btn btn-sm btn-danger" title = "'. trans('messages.delete') .'"
                    href="'.route('author.destroy', ['id' => $data->author_id]).'">
                  <i class="fa fa-trash "></i>
                </a>';
            })
            ->addIndexColumn()
            ->rawColumns(['name','image','action'])
            ->toJson();

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = -1)
    {
        if(!Auth::user()->allowedAccess("contributors"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle = trans('messages.add_button_form',['form' => trans('messages.author')  ]);
        $author_data= new Author;

        if($id != -1){
            $pageTitle = trans('messages.update_form_title',['form' => trans('messages.author')  ]);
            $author_data= Author::where('author_id',$id)->first();
        }

        return view('Admin.author.create',compact('author_data','pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }

        if(!Auth::user()->allowedAccess("contributors"))
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $data=$request->all();
        $valid['validation'] =[
            'name' => 'required|regex:/^[a-z0-9 .\-]+$/i|min:2',
            'description' => 'required',
            'designation'=>'required',
            'education'=>'required',
        ];
        $valid['messsage']=[];


        $validator = \Validator::make($data,$valid['validation'],$valid['messsage']);

        $result = Author::updateOrCreate(['author_id'=>$request->author_id],$data);
        if($request->image) {
            $result->clearMediaCollection('image');
            $result->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        $message = trans('messages.update_form',['form' => trans('messages.author')] );
        if($result->wasRecentlyCreated){
            $message = trans('messages.save_form',['form' => trans('messages.author')] );
        }
        return redirect(route('author.index'))->withSuccess($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        if(!Auth::user()->allowedAccess("contributors"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle = trans('messages.author')." ".trans('messages.detail');
        $author= Author::where('author_id',$id)->with(['getBooks','getBookRating'])->first();

        $extra=[
            'redirect_url' => optional($request)->redirect_url,
        ];
        return view('Admin.author.show',compact('author','pageTitle','extra'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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

        if(!Auth::user()->allowedAccess("contributors"))
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        $author=Author::where('author_id',$id)->with('getBooks')->first();
        if($author==''){
            $message = trans('messages.not_delete_form',['form'=> trans('messages.author') ]);
            return redirect(route('author.index'))->withSuccess($message);
        }
        if(count($author->getBooks)>0){
            $message = trans('messages.check_delete_msg',['form'=> trans('messages.author') ]);
            return redirect(route('author.index'))->withSuccess($message);
        }
        $author->delete();
        $message = trans('messages.delete_form',['form'=> trans('messages.author') ]);
        return redirect(route('author.index'))->withSuccess($message);
    }

    public function getAuthorList(){
        $data = Author::get();
        return response()->json(['status' => true ,'data' => $data , 'message' => trans('messages.list_form_title',['form' =>  trans('messages.author') ]) ]);
    }

    public function getAuthorBookList(Request $request){
        $data = Book::getBookList("author",$request->author_id);
        return response()->json(['status' => true ,'data' => $data , 'message' => trans('messages.list_form_title',['form' => trans('messages.author')  ]) ]);

    }
}
