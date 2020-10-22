@extends('layouts.master')

@section('content')

<div id="newapp">
    <div class="card">
        <div class="card-header">
            <h3 class="d-inline">{{isset($pageTitle) ? $pageTitle:'List'  }}</h3>
        </div>
        <div class="card-body">
            <div class="card-block row">
                <div class="col-sm-12">
                        <data-table  class="table table-responsive-sm text-center" ajax="{{ route('transactions.list') }}" :columns="[
                            {data: 'DT_RowIndex','searchable':false, name: 'DT_RowIndex', title : 'Sr no','orderable' : false },
                            {data: 'created_at'    ,'name' : 'created_at'  ,'title' : 'Transaction Date'},
                            {data: 'order_id'    ,'name' : 'order_id'  ,'title' : 'Transaction Id'},
                            {data: 'order_by'   ,'name' : 'order_by' ,'title' : 'Order By'},
                            {data: 'total_amount' ,'name' : 'total_amount'  ,'title' : 'Total Amount'},
                            {data: 'type' ,'name' : 'type'  ,'title' : 'Type'},
                            {data: 'status' ,'name' : 'status'  ,'title' : 'Payment Status'},
                            {data: 'action'       ,'name' : 'action'     ,'title' : 'action',orderable : false,'searchable':false},
                        ]">
                       </data-table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
