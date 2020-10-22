@extends('layouts.master') 

@section('content')
{{-- {{dd($rating)}} --}}
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 plr-20 pb-20">
                            <div class="w-315">
                                <img class="rounded-circle obj-fit-cov max-hw-315 w-100" src="{{ getSingleMedia($userdata) }}" alt="logo" /></a>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            {{ optional($userdata)->name }}
                        </div>
                        <div class="col-md-12 text-center">
                            {{ optional($userdata)->email }}
                        </div>
                        <div class="col-md-12 text-center">
                            {{ optional($userdata->getUserDetail)->contact_number }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">           
                    <h3 class="d-inline">{{$title}}</h3> 
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                    <tr>
                                        <th class="th-lg">Date of Birth</th>
                                        <td class="col-md-10">{{ ($userdata->getUserDetail->dob)? $userdata->getUserDetail->dob :'-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="th-lg">Gendre</th>
                                        <td class="col-md-10">{{ strtoupper(($userdata->getUserDetail->gender)? $userdata->getUserDetail->gender : '-' )}}</td>
                                    </tr>
                                    <tr>
                                        <th class="th-lg">Interest</th>
                                        <td class="col-md-10">
                                            @php
                                                if(($userdata->getUserDetail)->interest != "" )
                                                {
                                                    $categories = explode(',',($userdata->getUserDetail)->interest);
                                                    foreach ($categories as $key => $value) {
                                                        echo ' <span class="badge badge-default">'.strtoupper($userdata->getCategoryData($value)->name).'</span>';
                                                    }
                                                }
                                                else {
                                                        echo '-';
                                                }
                                            @endphp
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="th-lg">Address</th>
                                        <td class="col-md-10">{{ strtoupper(($userdata->getUserDetail->address)? $userdata->getUserDetail->address : '-') }}</td>
                                    </tr>
                                    <tr>
                                            <th class="th-lg">State</th>
                                            <td class="col-md-10">{{ strtoupper( ($userdata->getUserDetail->state)? $userdata->getUserDetail->state : '-') }}</td>
                                        </tr>
                                    <tr>
                                        <th class="th-lg">Country</th>
                                        <td class="col-md-10">{{ strtoupper(  ($userdata->getUserDetail->country)?$userdata->getUserDetail->country : '-'  ) }}</td>
                                    </tr>
                                    <?php
                                        if(isset($userdata->registration_id))
                                        {
                                            ?>
                                                <tr id="user_registration_id">
                                                    <th class="th-lg">Registration-Id</th>
                                                    <td class="col-md-10">{{ ($userdata->registration_id)?$userdata->registration_id :'-' }} </td>
                                                </tr>
                                            <?php
                                        }
    
                                        if(isset($userdata->device_id))
                                        {
                                            ?>
                                                <tr id="user_device_id">
                                                    <th class="th-lg">Device-Id</th>
                                                    <td class="col-md-10">{{ ($userdata->device_id)?$userdata->device_id :'-' }} <button class="btn btn-sm btn1 btn-danger remove_device_id" id="remove_device_id" onclick="removeIdFunction('remove_device_id')" style="float:right;">Remove</button></td>
                                                </tr>
                                            <?php
                                        }
    
                                        if(isset($userdata->mac_id))
                                        {
                                            ?>
                                                <tr id="user_mac_id">
                                                    <th class="th-lg">Mac-Id</th>
                                                    <td class="col-md-10">{{ ($userdata->mac_id)?$userdata->mac_id :'-' }} <button class="btn btn-sm btn1 btn-danger remove_mac_id" id="remove_mac_id" onclick="removeIdFunction('remove_mac_id')" style="float:right;">Remove</button></td>
                                                </tr>
                                            <?php
                                        }
                                    ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (count($userdata->ratings) > 0)
        <div class="card mt-3">
            <div class="card-header">           
                <h3 class="d-inline">List Of Books Review / Rating</h3> 
              
            </div>
            <div class="col-md-12 mt-4 mb-4">
                @foreach ($userdata->ratings as $rating)
                    <div class="card shadow mb-1">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <h3>{{ ($rating->getBookname)->name }}</h3>
                                    <p class="description">{{ $rating->review}}</p>
                                </div>
                                <div class="col-md-3">
                                    <div class="rateYo" data-rating="{{ $rating->rating }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
            
</div>
        
@endsection
@section('body_bottom')
    <script>
        $(".rateYo").each(function(){
            var rating = $(this).attr("data-rating");
            $(this).rateYo({
                rating: rating,
                readOnly: true,
            });
        });
        $('.user-list').addClass('active');
        function removeIdFunction(para1 = "")
        {
            var r = confirm("Are you sure!");
            if (r == true) {
                var data = {
                    'user_id': '{{ (isset($userdata) ? $userdata->id : "-1") }}',
                    'remove_data': para1
                }
                $.ajax({
                    url: '{{ route("device_mac_id.destroy") }}',
                    type: 'get',
                    data: data,
                    dataType: 'json',
                    success: function(data){
                        if(data.status){
                            if(data.event == "deleted")
                            {
                                if(para1 == "remove_device_id")
                                {
                                    $("#user_registration_id").remove();
                                    $("#user_device_id").remove();
                                }
                                else{
                                    $("#user_mac_id").remove();
                                }
                                showMessage(data.message);
                            }
                            else
                            {
                                errorMessage(data.message);
                            }
                        }
                        else{
                            errorMessage(data.message);
                        }
                    }
                });
            } 
        }
      
    </script>
@endsection