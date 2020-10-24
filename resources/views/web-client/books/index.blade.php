@extends('layouts.web-client')

@section('content')
<div id="page-content-wrapper">
    <h2 class="m-3">{{$header}}</h2>
    @if($active_category_id!=0)
    <div class="row">
        <div class="col-12 col-lg-6 px-4">
            <select class="form-control" id="sub-category-filter" onchange="filterSubCategory(this)">
                <option value="" disabled selected>Sub category</option>
                @foreach($sub_categories as $sub_category)
                    <option 
                        value="{{$sub_category->subcategory_id}}"
                        {{$active_sub_category_id==$sub_category->subcategory_id?'selected':''}} 
                        data-category-id="{{$sub_category->category_id}}">{{$sub_category->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endif
    <div class="col">
        <div class="row article-feed product">
            @foreach ($books as $book)
                @include('web-client.books.book-component')
            @endforeach
        </div>
        {{$books->appends(request()->except('page'))->links()}}
    </div>
</div>
@endsection
