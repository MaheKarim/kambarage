<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\StaticData;
use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DataTables;
use Yajra\DataTables\Html\Builder;
use Auth;


class StaticDataController extends Controller
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


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */    
    public function view($type)
    {
        //
        if(!Auth::user()->allowedAccess())
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        if($type != "language" && $type != "publisher")
        {
            return Redirect::back();
        }

        $pageTitle = trans('messages.list_form_title',['form' => trans('messages.'.$type) ]);
        return view("Admin.staticdata.list", compact("pageTitle", "type"));

    }

    public function languageList()
    {//LOADS LANGUAGES VIA AJAX
        if(!Auth::user()->allowedAccess())
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        
        $query = StaticData::where("type", "language")
        ->orderBy('id', 'DESC')->get() ;
        return Datatables::of($query)
        ->editColumn('name', function ($query) {
            return isset($query->value) ? ($query->value) :'';
        })

        ->editColumn('action', function ($query) {
            return '

            <a class="btn btn-sm btn-primary"  title ="'.trans('messages.edit') .'"
                href="'.route('staticdata.edit', ["type" => "language", 'id' => $query->id]).'">
              <i class="fa fa-edit "></i>
            </a>
            <a onclick="return confirm(\''.trans('messages.delete_form_message',['form' => trans('messages.language')]).'\')" class="btn btn-sm btn-danger"  title ="'.trans('messages.delete') .'"
            href="'.route('staticdata.destroy', ["type" => "language", 'id' => $query->id]).'">
              <i class="fa fa-trash"></i>
            </a>';
        })
        ->addIndexColumn()
        ->toJson();
    }

    public function publisherList()
    {//LOADS PUBLISHERS VIA AJAX
        if(!Auth::user()->allowedAccess())
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }
        
        $query = StaticData::where("type", "publisher")
        ->orderBy('id', 'DESC')->get() ;
        return Datatables::of($query)
        ->editColumn('name', function ($query) {
            return isset($query->value) ? ($query->value) :'';
        })

        ->editColumn('action', function ($query) {
            return '

            <a class="btn btn-sm btn-primary"  title ="'.trans('messages.edit') .'"
                href="'.route('staticdata.edit', ["type" => "publisher", 'id' => $query->id]).'">
              <i class="fa fa-edit "></i>
            </a>
            <a onclick="return confirm(\''.trans('messages.delete_form_message',['form' => trans('messages.publisher')]).'\')" class="btn btn-sm btn-danger"  title ="'.trans('messages.delete') .'"
            href="'.route('staticdata.destroy', ["type" => "publisher", 'id' => $query->id]).'">
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
    public function create($type = null)
    {
        if($type != "language" && $type != "publisher")
        {
            return Redirect::back()->withInput();
        }
        
        if(!Auth::user()->allowedAccess())
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        //USED TO CREATE NEW LANGUAGE AND PUBLISHER
        $pageTitle = trans('messages.add_button_form',['form' => ucfirst($type)]);
        return view('Admin.staticdata.adddata',compact('pageTitle', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->allowedAccess())
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        //TO STORE NEW LANGUAGE AND NEW PUBLISHER
        $validator=\Validator::make($request->all(),[
            'name' => 'required|regex:/^[a-z0-9 .\-]+$/i|min:2|unique:static_data,value',
        ]);
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $data = $request->all();

        if($data["type"] != "language" && $data["type"] != "publisher")
        {
            return Redirect::route("author.index");
        }

        $result = StaticData::create([
            'type'=>$data['type'],
            'value'=>$data['name'],
            'label'=>$data['name'],
            'status'=>1
        ]);

        // $message = trans('messages.update_form',['form' => ucfirst($data["type"])]);
        // if($result->wasRecentlyCreated){
        //     $message = trans('messages.save_form',['form' => ucfirst($data["type"])]);
        // }

        if($result){
            $message = trans('messages.save_form',['form' => ucfirst($data["type"])]);
            return redirect(route('staticdata.view', [$data["type"]]))->withSuccess($message);
        }
        return Redirect::back()->withInput();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\StaticData  $staticData
     * @return \Illuminate\Http\Response
     */
    public function show(StaticData $staticData)
    {
        //
        // $pageTitle = trans('messages.list_form_title',['form' => trans('messages.publisher') ]);
        // return view("admin.staticdata.publisher", compact("pageTitle"));        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StaticData  $staticData
     * @return \Illuminate\Http\Response
     */
    public function edit($type, $id, StaticData $staticData)
    {
        //
        if(!Auth::user()->allowedAccess())
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        if($type != "language" && $type != "publisher")
        {
            return Redirect::back()->withInput();
        }

        $data = StaticData::where("id", $id)->where("type", $type)->first();

        //USED TO CREATE NEW LANGUAGE AND PUBLISHER
        $pageTitle = trans('messages.edit')." ".trans(ucfirst($type));
        return view('Admin.staticdata.editdata',compact('pageTitle', 'type', 'data'));    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StaticData  $staticData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaticData $staticData)
    {
        //

        if(!Auth::user()->allowedAccess())
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $data = $request->all();
        //TO STORE NEW LANGUAGE AND NEW PUBLISHER
        $validator=\Validator::make($request->all(),[
            'name' => 'required|regex:/^[a-z0-9 .\-]+$/i|min:2|unique:static_data,value,'.$data["id"],
        ]);
        
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }        

        if($data["type"] != "language" && $data["type"] != "publisher")
        {
            return Redirect::route("author.index");
        }

        $result = StaticData::where("id", $data["id"])->update([
            'value'=>$data['name'],
            'label'=>$data['name'],
        ]);

        if($result){
            $message = trans('messages.save_form',['form' => ucfirst($data["type"])]);
            return redirect(route('staticdata.view', [$data["type"]]))->withSuccess($message);
        }

        return Redirect::back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StaticData  $staticData
     * @return \Illuminate\Http\Response
     */
    public function destroy($type, $id)
    {
        //
        $check = Book::where("publisher", $id)->orwhere("language", $id)->first();
        
        if(!empty($check))
        {
            return redirect()->back()->withErrors('The value is in use and cannot be deleted.');
        }
        
        $data = StaticData::where("id", $id);
        $data->delete();
        return redirect()->back()->withSuccess('Data has been deleted successfully.');
    }
}
