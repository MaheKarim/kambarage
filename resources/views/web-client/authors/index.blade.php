@extends('layouts.web-client')

@section('content')

<div id="page-content-wrapper">
    <h2 class="m-3">Book Authors</h2>
    <div class="col">
        <!-- POSTS -->
        <div class="d-flex flex-wrap article-feed">
            @foreach ($authors as $author)

            <div class="w-100 border-bottom py-3 px-0 item">
                <div class="row">
                    <div class="col-4 col-lg-3 col-xl-2">
                        <a href="{{route('web-client.author',$author->author_id)}}">
                            <img class="img-fluid rounded-circle shadow-sm"
                                src="{{getSingleMedia($author,'image',null)}}">
                        </a>

                    </div>
                    <div class="col-8 col-lg-9 col-xl-3">
                        <div class="p-2">
                            <a href="{{route('web-client.author',$author->author_id)}}">
                                <h6>{{$author->name}}</h6>
                            </a>
                            <a href="{{route('web-client.author',$author->author_id)}}"
                                class="btn btn-custom btn-sm rounded-pill text-uppercase"><i
                                    class="fas fa-arrow-circle-right"></i> View more</a>
                        </div>
                    </div>
                    <div class="col-12 col-xl-7">
                        <div class="row">
                            @foreach ($author->getBooks()->take(4)->get() as $book)
                                @include('web-client.books.book-component',["size"=>"col-4 col-lg-3 py-3 py-xl-0 px-3"])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>

</div>
@endsection
