<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Transaction;
use \App\UserAddress;
use Datatables;
use Auth;

class TransactionController extends Controller
{
    public function index()
    {
        if(!Auth::user()->allowedAccess("sales"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle="Sales";
        return view('Admin.users.user-transaction-list',compact('pageTitle'));
    }

    public function list($user_id = "", $limit="")
    {
        if(!Auth::user()->allowedAccess("sales"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $transactiondata =  Transaction::orderBy("transaction_id","DESC");
        if($user_id != "" && $user_id != "-1"){
            $transactiondata->where("user_id", $user_id);
        }
        if($limit != ""){
            $transactiondata->take($limit);
        }
        $transactiondata->withTrashed();
        return Datatables::eloquent($transactiondata)
        ->editColumn('created_at', function ($transactiondata) {
            return isset($transactiondata->created_at) ? date('Y-m-d',strtotime($transactiondata->created_at)) : '-';
        })
        ->editColumn('order_id', function ($transactiondata) {
            return optional($transactiondata)->txn_id;
        })
        ->editColumn('order_by', function ($transactiondata) {
            return ucwords(optional($transactiondata->getUser)->name);
        })
        ->editColumn('total_amount', function ($transactiondata) {
            return money(optional($transactiondata)->total_amount);
        })
        ->editColumn('action', function ($transactiondata) {
            return '';
//            if($transactiondata->shipping_address !=  null )
//            {
//                return '
//                <a class="btn btn-sm btn-info mr-05 loadRemoteModel" href="'.route('transactions.show', ['id' => $transactiondata->shipping_address ]).'">
//                    <i class="fa fa-eye "></i></a>';
//            }
//            else{
//                return "-";
//                // return '<a class="btn btn-sm btn-primary mr-05 loadRemoteModel"  href=""><i class="fa fa-eye "></i></a>';
//            }
        })
        ->editColumn('type', function ($transactiondata) {
            switch($transactiondata->type){

                case 'NB' :
                    return 'Net Banking';
                    break;
                case 'DC' :
                    return 'Debit Card';
                    break;
                case 'CD' :
                    return 'Credit Card';
                    break;
                default :
                    return 'Online Transaction';
                    break;
            }
        })
        ->editColumn('status' , function ($transactiondata){

            switch($transactiondata->status){
                case 0 :
                    return '<span class="badge badge-pill badge-lg badge-warning">Pending</span>';
//                    return '<a href="'.route('transactions_update.payment_status',["id" => $transactiondata->transaction_id , 'status' => 1 ]).'" onclick="return confirm(\'Are you sure want to update payment status pending to successfull ?\')"  class="badge badge-pill badge-lg badge-warning" title="Update Payment Status" />Pending</a>';
                    break;
                case 1 :
                    return '<span class="badge badge-pill badge-lg badge-success">Success</span>';
                    break;
                case 2 :
                    return '<span class="badge badge-pill badge-lg badge-danger">Failure</span>';
                    break;
                case 3 :
                    return '<span class="badge badge-pill badge-lg badge-info">Cancel</span>';
                    break;
                default :
                    return '<span class="badge badge-pill badge-lg badge-danger">Failure</span>';
                    break;
            }
        })
        ->addIndexColumn()
        ->rawColumns(['image','transaction', 'book_name','order_by','action','status'])
        ->toJson();
    }

    public function updatePaymentStatus($id,$status,Request $request)
    {
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        
        if(!Auth::user()->allowedAccess("sales"))
        {
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        $result = Transaction::where('transaction_id',$id)->update(['status' => $status]);

        if($result) {
            $message = trans('messages.update_form',['form' => 'Payment status ']);
        } else {
            $message =  trans('messages.not_updated',['form' => 'Payment']);
        }

        return redirect(route('transactions.index'))->withSuccess($message);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        if(!Auth::user()->allowedAccess("sales"))
        {
            return redirect("/")->withErrors(trans('messages.permission_denied'));
        }

        $pageTitle = "Shipping Address";
        $address = UserAddress::where('user_address_id',$id)->first();
        // $address = Transaction:: where('transaction_id',$id)->first()->shipping_address;
        return view('Admin.users.transaction-shipping-address',compact('pageTitle','address'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
