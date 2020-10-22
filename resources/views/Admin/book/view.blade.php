@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>{{($viewdata->title)?$viewdata->title:'-'}}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 plr-20 pb-20 book-detail-image">
                            <div class="w-315">
                                <a id="home"><img class="image_on obj-fit-cov max-hw-315 w-100" src="{{ getSingleMedia($viewdata,'front_cover',null) }}" alt="logo" />
                                <img class="image_off obj-fit-cov max-hw-315 w-100" src="{{ getSingleMedia($viewdata,'back_cover',null) }}" alt="logo" /></a>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="m-auto">
                                {!!Form::label('name',trans('messages.field_name',['field' => trans('messages.book')]),array('class'=>'form-control-label'))!!}
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="m-auto">
                                {{($viewdata->name)?$viewdata->name:'-'}}
                            </div>
                        </div>
                        <div class="col-md-12 mt-10">
                            <div class="rateYo m-auto" data-rating="{{ $avg_rating }}"> </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="m-auto"> {{ trans('messages.from') }} ({{ $count_rating }}) {{ trans('messages.users') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                   <h3 class="d-inline">{{$pageTitle}}</h3>

                    <a id="back" href="{{ isset($extra['redirect_url']) ? $extra['redirect_url'] : route('book.index')}}"  class="btn btn-sm btn-primary float-right text-white inline ml-3"> <i class="fa fa-angle-double-left"></i> {{ trans('messages.back') }}</a>
                    @if($viewdata->format == 'pdf' || $viewdata->format == 'video' )
                        <a class="btn btn-sm btn-primary float-right text-white inline  ml-3" href="{{getSingleMedia($viewdata,'file_path','',$viewdata->format)}} " target="_blank"><i class="fa fa-eye"></i> {{ trans('messages.open') }} {{$viewdata->format}}</a>
                    @endif

                    @if($viewdata->format =='epub')
                    <a class="btn btn-sm btn-primary float-right text-white inline  ml-3" href="{{'https://www.ofoct.com/viewer/viewer_url.php?fileurl='.getSingleMedia($viewdata,'file_path','','epub')}} " target="_blank"><i class="fa fa-eye"></i> {{ trans('messages.open') }} {{ trans('messages.epub') }}</a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>{{trans('messages.recommended_book')}}
                                <span class="custom-togge">
                                    <input type="checkbox" class="flag_recommend_toggle" @php if($viewdata->flag_recommend == 1) echo 'checked'; @endphp value="{{$viewdata->book_id}}">
                                    <!-- <span class="custom-toggle-slider rounded-circle"></span> -->
                                </span>
                                <span class="mx-3"></span>
                                {{trans('messages.top_selling_book')}}
                                <span class="custom-tggle">
                                    <input type="checkbox" class="flag_top_sell_toggle" @php if($viewdata->flag_top_sell == 1) echo 'checked'; @endphp value="{{$viewdata->book_id}}">
                                    <!-- <span class="custom-toggle-slider rounded-circle"></span> -->
                                </span>
                            </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <tr>
                                    <td>
                                        {!!Form::label('isbn',trans('messages.isbn_number').' :',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{$viewdata->isbn}}</label>
                                    </td>
                                    <td>
                                        {!!Form::label('edition',trans('messages.edition').' :',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{$viewdata->edition}}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!!Form::label('volume',trans('messages.volume').' :',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{$viewdata->volume}}</label>
                                    </td>
                                    <td>
                                        {!!Form::label('issue',trans('messages.issue').' :',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{$viewdata->issue}}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!!Form::label('doi',trans('messages.doi').' :',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{$viewdata->doi}}</label>
                                    </td>
                                    <td>
                                        {!!Form::label('lang',trans('messages.language').' :',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{isset($book_language->value)?$book_language->value:'-'}}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!!Form::label('authornm',trans('messages.field_name',['field' => trans('messages.author')]).' :',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{isset($viewdata->getAuthor)?$viewdata->getAuthor->name:'-'}}</label>
                                    </td>
                                    <td>
                                        {!!Form::label('bookpublisher',trans('messages.book')." ".trans('messages.publisher').' : ',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{isset($viewdata->publisher)?$viewdata->publisher:'-'}}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!!Form::label('category',trans('messages.category').' : ',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{isset($viewdata->categoryName)?$viewdata->categoryName->name:'-'}}</label>
                                    </td>
                                    <td>
                                        {!!Form::label('subcategory',trans('messages.subcategory').' : ',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{isset($viewdata->subCategoryName)?$viewdata->subCategoryName->name:'-'}}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!!Form::label('date_of_publication',trans('messages.date_publication').' : ',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{isset($viewdata->date_of_publication)? showDate($viewdata->date_of_publication):'-'}}</label>

                                    </td>
                                    <td>
                                        {!!Form::label('price',trans('messages.price').' : ',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{ money(optional($viewdata)->price)}}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!!Form::label('qty',trans('messages.quantity').' : ',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>

                                        <label>{{max(optional($viewdata)->in_stock,0)}}</label>

                                    </td>
                                    <td>
                                            {!!Form::label('format',trans('messages.format').' : ',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label class="text-uppercase">{{isset($viewdata->format)?$viewdata->format :'-'}}</label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(count($viewdata->getBookRating) > 0)
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="d-inline">{{ trans('messages.list_of_books_review_rating') }}</h3>
            </div>
            <div class="col-md-12 mt-4 mb-4">
                @foreach ($viewdata->getBookRating as $rating)
                    <div class="card shadow mb-1">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="hw-80">
                                        <img src="{{ getSingleMedia($rating->getUsername,'image') }}"  class="book-detail-user-rating-img obj-fit-cov max-hw-80">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h3>{{ isset($rating->getUsername) ? ucwords($rating->getUsername->name) : '' }}</h3>
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

    @if($viewdata->description)
    <div class="card mt-3">
        <div class="card-header"><h3>{{ trans('messages.book') }} {{ trans('messages.description') }}:</h3></div>
        <div class="col-md-12 mb-3">
            <div class="ml-3 col-md-12 mt-3">
                <div>
                    <?php echo html_entity_decode(optional($viewdata)->description); ?>
                </div>
            </div>
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
        $('.book-list-item').addClass('active');

        function addChapter(id) {
            $('#chaptermodal').modal('show');
        }

        function bookActions(ele,postData) {

            var loadurl = "{{ route('book.actions') }}";
            $.post(loadurl,postData ,function(data) {
                if(data.status == true && data.message!=''){
                    showMessage(data.message);
                }
            });

            return true;
        }

        $(document).ready(function () {
            $("#addmore").click(function () {
                $('#fieldsrow').clone().insertAfter(this);
            });

            $(document).on('click',".flag_recommend_toggle",function (event) {
                if($(this).is(":checked")){
                    var postData = {'book_id':$(this).val(),'flag_recommend':1,'event':'add'};
                }else{
                    var postData = {'book_id':$(this).val(),'flag_recommend':0};
                }
                bookActions($(this),postData);
            });
            $(document).on('click',".flag_top_sell_toggle",function (event) {
                if($(this).is(":checked")){
                    var postData = {'book_id':$(this).val(),'flag_top_sell':1,'event':'add'};
                }else{
                    var postData = {'book_id':$(this).val(),'flag_top_sell':0};
                }
                bookActions($(this),postData);
            });
        });
    </script>
@endsection