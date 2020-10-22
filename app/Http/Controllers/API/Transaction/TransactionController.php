<?php

namespace App\Http\Controllers\API\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Transaction;
use \App\TransactionDetail;
use App\Http\Resources\API\Transaction\TransactionResource;
use App\Http\Resources\API\User\UserPurchasedBookResource;
use App\Http\Resources\API\Book\BookResource;

class TransactionController extends Controller
{
    public function saveTransaction(Request $request){

        $user = \Auth::user();
        $data = json_decode($request->order_detail,true);
        $other_detail                                       = json_decode($request->transaction_detail,true);
        $data['datetime']                               = date('Y-m-d H:i:s');
        $data['other_transaction_detail']= $request->transaction_detail;
        $data['user_id']                                  = $user->id;
        $data['txn_id']                                    = $other_detail['TXNID'];
        $data['payment_status']                 = $other_detail['STATUS'];

        $transaction_detail                          =  $data['other_detail'];
        unset($data['other_detail']);

        $result                                                   = Transaction::Create($data);
        foreach ($transaction_detail['data'] as $key => $value) {
            $td['transaction_id']     = $result->transaction_id;
            $td['book_id']   = $value['book_id'];
            $td['user_id']    = $user->id;

            TransactionDetail::create($td);

                $cart_data = \App\UserCartMapping::where('book_id',$value['book_id'])->where('user_id',$user->id)->first();
                if($cart_data != null){
                    $cart_data->delete();
                }

                $book_data = \App\Book::where('book_id',$value['book_id'])->first();
        }


        if($other_detail['STATUS'] == "TXN_SUCCESS" || $other_detail['STATUS'] == "approved" ){
                return response()->json(['status' => true ,'message' => trans('messages.save_form',['form' => 'Transaction']) ]);

                // $to = $user->email;
                // $from = env('MAIL_USERNAME');
                // $data = array(
                //     'name' => $user->name,
                //     'book_name' => $book_data->name,
                //     'title' => $book_data->title,
                //     'quantity' => $result->quantity,
                //     'amount' => $result->total_amount,
                // );
                // sendMail(7,$data,$to,$from);
        }else{
            return response()->json(['status' => false ,'message' => trans('messages.transaction_fail') ]);
        }
    }

    public function getTransactionDetail(Request $request){
        $user = \Auth::user();

        $data = TransactionDetail::where('user_id',$user->id)
                                                 ->with(['getBook','getTransaction'])->get();

        $transaction_data    =   TransactionResource::collection($data);

        return response()->json(['status' => true , 'data' => $transaction_data]);
    }

    public function getUserPurchaseBookList(){
        $user = \Auth::user();

        $data                           =    TransactionDetail::where('user_id',$user->id)->get();
        $purchase_data       =    UserPurchasedBookResource::collection($data);
        $message                   =   trans('messages.list_form_title',['form' => 'Purchase Book']);

        return response()->json([ "status" => true , "message" => $message ,'data' => $purchase_data ]);

    }

    public function checkSumGenerator(Request $request){
        $order_data = $request->all();

        $data = paytm_checksum($order_data);
        return response()->json(['status' => true , 'data' => $data]);
    }
}
