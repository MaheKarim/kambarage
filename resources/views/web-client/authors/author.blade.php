@extends('layouts.web-client')
@section('page-styles')
<style>
@media only screen and (max-width: 991px){
    .woocommerce .size-woocommerce_thumbnail, img.woocommerce-placeholder, img.attachment-woocommerce_thumbnail {
        width: 100%;
        height: auto;
        border-radius: .35rem !important;
    }
}

</style>
@endsection
@section('content')
<div id="page-content-wrapper" class="d-flex flex-wrap">
    <div class="col-12 col-lg-6">
        <div class="navigation-sticky-top">
            <div class="py-3">
                <div class="card border-class shadow-sm">
                    <div class="img__wrap">
                        <img class="img-fluid rounded-top"
                            src="{{getSingleMedia($author,'image',null)}}">
                    </div>
                    <div class="card-body">
                        <div class="p-xl-3">
                            <h2>{{$author->name}}</h2>
                            <h4>{{$author->designation}}</h4>
                            <article>{{$author->description}} </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="py-3">
            <div class="d-flex flex-wrap mb-3">
                    @foreach ($author->getBooks as $book)
                        <div class="col-12 py-3 mb-3 border-class book-card-bg shadow-sm">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <a href="{{route('web-client.books.view',$book->book_id)}}"><img width="300"
                                            height="450" src="{{getSingleMedia($book,'front_cover',null)}}"
                                            class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                            alt="" /></a>
                                </div>
                                <div class="col-12 col-md-8 book-card-txt">
                                    <h5 class="my-2">
                                        <a
                                            href="{{route('web-client.books.view',$book->book_id)}}">{{$book->title}}</a>
                                    </h5>
                                    <p>{{Str::limit($book->description,200,'..')}}</p>
                                    <a href="{{route('web-client.books.view',$book->book_id)}}"
                                        class="btn btn-custom btn-sm rounded-pill text-uppercase"><i
                                            class="fas fa-arrow-circle-right"></i> View more</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>
            <div class="row">


            </div>
        </div>
    </div>
</div>
@endsection
