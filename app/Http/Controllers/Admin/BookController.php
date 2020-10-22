<?php

namespace App\Http\Controllers\Admin;

use App\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use App\UserFavouriteBook;
use App\Category;
use App\StaticData;
use App\TransactionDetail;
use File;
use Datatables;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class BookController extends Controller
{
    public function index(Request $request)
    {
        if(!Auth::user()->allowedAccess("content"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $type = (isset($request->type) && in_array($request->type,['recommended','top-sell','all']) ) ? $request->type : 'all';
        switch ($type){
            case 'top-sell' : $pageTitle=trans('messages.list_form_title',['form' => trans('messages.top_selling_book')  ]); break;
            case 'recommended' : $pageTitle=trans('messages.list_form_title',['form' => trans('messages.recommended_book')  ]); break;
            case 'all' :
            default : $pageTitle=trans('messages.list_form_title',['form' => trans('messages.book')  ]); break;
        }

        return view('Admin.book.index',compact(['pageTitle','type']));
    }

    public function create(Request $request,$id=-1)
    {
        if(!Auth::user()->allowedAccess("content"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle = trans('messages.add_button_form',['form' => trans('messages.book')  ]);
        $bookdata=new Book;
        if($id != -1)
        {
            $pageTitle=trans('messages.update_form_title',['form' => trans('messages.book')  ]);
            $bookdata=Book::where('book_id',$id)->with(['subCategoryName','categoryName'])->first();
        }
        $relation = [
            'author_id' => Author::all()->pluck('name', 'author_id')->prepend( trans('messages.select_name',['select' => trans('messages.author')]), ''),
            'category_id' => Category::all()->pluck('name', 'category_id')->prepend( trans('messages.select_name',['select' => trans('messages.category')]), ''),
            'language' => StaticData::all()->where('type','language')->pluck('value','id')->prepend(trans('messages.select_name',['select' => trans('messages.language')]),''),
            'publisher' => StaticData::all()->where('type','publisher')->pluck('value','id')->prepend(trans('messages.select_name',['select' => trans('messages.publisher')]),''),
            'book_formate' => StaticData::where('type','formate')->get(),
        ];

        return view('Admin.book.create',compact('pageTitle','bookdata')+$relation);

    }

    public function bookActions(Request $request){
        if(!Auth::user()->allowedAccess("content"))
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $book = Book::where('book_id',$request->book_id)->first();
        if(isset($request->flag_top_sell)){
            $data['flag_top_sell'] = $request->flag_top_sell;
        }
        if(isset($request->flag_recommend)){
            $data['flag_recommend'] = $request->flag_recommend;
        }
        if(!empty($book) && $book->update($data)){
            if(isset($request->event) && $request->event=="add"){
                return response()->json(['status'=>true,'message'=>'Book Added']);
            }else{
                return response()->json(['status'=>true,'message'=>'Book Removed']);
            }
        }else{
            return response()->json(['status'=>true,'message'=>'No Book Found']);
        }
    }

   public function bookList(Request $request)
   {
        if(!Auth::user()->allowedAccess("content"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

       $type = (isset($request->type) && in_array($request->type,['recommended','top-sell','all']) ) ? $request->type : 'all';
       $alldata=Book::orderBy('book_id', 'DESC');

       if($type=='top-sell'){
            $alldata->where('flag_top_sell',1);
       }
       if($type=='recommended'){
           $alldata->where('flag_recommend',1);
       }

       $alldata->with(['getAuthor','categoryName'])->select('book.*');


       return Datatables::eloquent($alldata)
       ->editColumn('name', function ($alldata) {
           return isset($alldata->title) ? ($alldata->title) :'';
       })
       ->editColumn('title', function ($alldata) {
               return isset($alldata->title) ? ($alldata->title) : '';
       })
       ->editColumn('author_name',function($alldata){
            return '<a  href="'.route('author.show',['id'=>$alldata->author_id,'redirect_url'=>route('book.index')]).' "  class="tooltip tooltip-effect-3" ><b>'.(optional($alldata->getAuthor)->name).'</b><span class="tooltip-content"><span class="tooltip-front"><img class="m-inherit mlr-auto mt-6px" src="'.getSingleMedia($alldata->getAuthor,'image',null).'" alt="user3"/></span><span class="tooltip-back"><div>'.(optional($alldata->getAuthor)->name).'</div></span></span></a>';
       })
      ->editColumn('category_name',function($alldata){
           return isset($alldata->categoryName) ? $alldata->categoryName->name : '';
       })
       ->editColumn('isbn',function($alldata){
        return isset($alldata->isbn) ? $alldata->isbn : '';
        })
       ->editColumn('front_cover',function($alldata){
            return '<img src="'.getSingleMedia($alldata,'front_cover',null).'" border="0" width="40" class="img-rounded dashboard-image" align="center" />';
       })
       ->editColumn('action', function ($alldata) {
           return '<a href="'.route('book.view',['id'=>$alldata->book_id]).' " title = "'. trans('messages.view') .'" class="btn btn-sm btn-info text-white"><i class="fa fa-eye"></i><a/>
            <a class="btn btn-sm btn-primary" title = "'. trans('messages.edit') .'"
               href="'.route('book.update', ['id' => $alldata->book_id]).'">
             <i class="fa fa-edit "></i>
           </a>
           <a onclick="return confirm(\'Are you sure?\')" class="btn btn-sm btn-danger" title = "'. trans('messages.delete') .'"
           href="'.route('book.delete', ['id' => $alldata->book_id]).'">
             <i class="fa fa-trash"></i>
           </a>';
       })
       ->addIndexColumn()
       ->rawColumns(['front_cover','action','author_name'])
       ->toJson();
   }

    public function store(Request $request)
    { 
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }

        if(!Auth::user()->allowedAccess("content"))
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $bookdata=$request->all();
        
        $validator = Validator::make($request->all(),[
            'front_cover'=>'mimes:jpg,png,jpeg|file|max:2048',
            'author_id'=>'required|array',
            'back_cover'=>'mimes:jpg,png,jpeg|file|max:2048',
        ],['front_cover'=>'Image should be png/PNG, jpg/JPG','back_cover'=>'Image should be png/PNG, jpg/JPG'
        ]);
        $bookdata = $request->all();
        $bookdata['author_id'] = $bookdata['author_id'][0]; 
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        if(isset($request->format)){
            if($request->format == 'pdf'){
                $validation_string  = 'mimes:pdf|file';
                $validation_message = 'File type must be in pdf format.';
            }elseif($request->format == 'video'){
                $validation_string  = 'mimes:mp4,mov,ogg,wmv|file';
                $validation_message = 'File type must be in mp4 , mov, ogg, wmv format.';
            }elseif($request->format == 'epub'){
                $validation_string  = 'mimes:epub|file';
                $validation_message = 'File type must be in epub format.';
            }
            else{
                $validation_message = 'Enter valid file.';
            }
            $file_validator = validator::make($bookdata,[
                'file_path'=> $validation_string,
            ],[$validation_message]);
            if($file_validator->fails()){
                return Redirect::back()->withInput()->withErrors($file_validator);
            }
        }

        if(!isset($request->book_id)){
            $validator = Validator::make($bookdata,[
                'file_path'=>'required',
                'format'=>'required',
            ],['Book file format is required'
            ]);
            if($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }
        }

        $bookdata['date_of_publication'] = date('Y-m-d', strtotime($request->date_of_publication));
        $result=Book::updateOrCreate(['book_id'=>$request->book_id],$bookdata);
  
        $result->authors()->sync($request->author_id);
        $files=['front_cover','back_cover','file_path','file_sample_path'];
        foreach($files as $f){
            if(is_file($request->$f)) {
                $result->clearMediaCollection($f);
                $result->addMediaFromRequest($f)->toMediaCollection($f);
            }
        }

        $message = trans('messages.update_form',['form' =>  trans('messages.book')]);
        if($result->wasRecentlyCreated){
            $message = trans('messages.save_form',['form' =>  trans('messages.book')]);
        }
        return redirect(route('book.index'))->withSuccess($message);
    }

    public function view($id,Request $request)
    {
        if(!Auth::user()->allowedAccess("content"))
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle =  trans('messages.form_detail',['form' => trans('messages.book')]);
        $viewdata=Book::where('book_id',$id)->with(['getAuthor','categoryName','subCategoryName','getBookRating'])->first();


        $avg_rating = $count_rating = 0;
        if(count($viewdata->getBookRating)>0){
            $avg_rating = $viewdata->getBookRating->avg('rating');
            $count_rating = $viewdata->getBookRating->count();
        }
        $book_language  = DB::table('static_data')->where('id',$viewdata->language)->first();
        $viewdata->publisher  = DB::table('static_data')->where('id',$viewdata->publisher)->first()->value;
        $extra=[
            'redirect_url' => optional($request)->redirect_url,
        ];
       return view("Admin.book.view",compact('viewdata','book_language', 'avg_rating', 'count_rating','pageTitle','extra'));
    }

    public function destroy($id)
    {
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }

        if(!Auth::user()->allowedAccess("content"))
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $book_data = Book::where('book_id',$id)->first();
        if($book_data != ''){
            $tran_data = TransactionDetail::where('book_id',$id)->with('getUser')->first();

            if(!empty($tran_data) && !empty($tran_data->getUser)){
                return redirect(route('book.index'))->withSuccess(trans('messages.check_delete_msg',['form' => trans('messages.book')]));
            }else{
                $book_data->delete();
                return redirect(route('book.index'))->withSuccess(trans('messages.delete_success_msg',['form' => trans('messages.book')]));
            }
        }else{
            return redirect()->back()->withSuccess(trans('messages.not_found_entry',['form'=> trans('messages.book')]));
        }
    }

}
