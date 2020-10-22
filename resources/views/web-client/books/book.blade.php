@extends('layouts.web-client')

@section('content')

<div class="col my-3">

    <div id="product-125"
        class="product type-product post-125 status-publish instock product_cat-philosophy product_tag-criticism has-post-thumbnail shipping-taxable purchasable product-type-simple">
        <div class="row">
            <div class="col-12 col-md-5 col-xl-4">
                <div class="wpgs wpgs--with-images images">

                    <div class='woo-carousel carousel-main'>
                        <div class="woo-carousel-cell"><a data-toggle="lightbox"
                                data-gallery="gallery" title="beingandtime-heidegger"
                                href="#"><img
                                    style="width: 100%;height: auto;"
                                    src="{{getSingleMedia($book,'front_cover',null)}}"
                                    class="attachment-shop_single size-shop_single wp-post-image border-class shadow-sm"
                                    alt="" /></a></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-7 col-xl-5">
                <div class="summary entry-summary">
                    <h4 class="text-break">{{$book->title}}</h4>
                    <h6 class="author-name"><a
                            href="{{route('web-client.author',$book->author_id)}}">{{$book->getAuthor->name}}</a></h6>
                    <h6 class="publisher-name"><a
                            href="#">{{$book->getBookLanguage->name}}</a>
                    </h6>
                    <div class="woocommerce-product-details__short-description">
                        <p>{{$book->description}}</p>
                        <hr>
                        <p>
                            {!!$book->edition?'<strong>Edition: </strong>'.$book->edition.'<br>':null!!}
                            {!!$book->getBookLanguage?'<strong>Language: </strong>'.$book->getBookLanguage->value.'<br>':null!!}
                            {!!$book->getPublisher?'<strong>Publisher: </strong>'.$book->getPublisher->value.'<br>':null!!}
                            {!!$book->doi?'<strong>DOI: </strong>'.$book->doi.'<br>':null!!}
                            {!!$book->isbn?'<strong>ISBN: </strong>'.$book->isbn.'<br>':null!!}
                            {!!$book->volume?'<strong>Volume: </strong>'.$book->volume.'<br>':null!!}
                            {!!$book->issue?'<strong>Issue: </strong>'.$book->issue.'<br>':null!!}
                            {!!$book->date_of_plublication?'<strong>Date of publication: </strong>'.$book->date_of_plublication.'<br>':null!!}
                        </p>
                        <hr>
                        <p>Tags: <strong>{{$book->keywords}}</strong></p>
                    </div>
                    <div class="product_meta">
                        <span class="posted_in d-lg-block">
                            <div class="d-inline-block"><i class="far fa-folder"></i></div> <a
                                href="{{route('web-client.books',"category_id=".$book->categoryName->category_id."&sub_category_id=".$book->subCategoryName->subcategory_id)}}"
                                rel="tag">{{$book->subCategoryName->name}}</a>
                        </span>
                        <span class="tagged_as d-lg-block">
                            <div class="d-inline-block"><i class="fab fa-readme"></i></div> <a
                                href="{{route('web-client.books',"category_id=".$book->categoryName->category_id)}}"
                                rel="tag">{{$book->categoryName->name}}</a>
                        </span>
                    </div>
                    <div class="d-lg-block">
                        <a href="{{route('web-client.books.read',$book->book_id)}}" class="btn btn-primary">Read</a>
                        <a href="{{route('web-client.books.download',$book->book_id)}}" class="btn btn-primary">Download</a>
                    </div>
                    <p id="read-warning">If you are having trouble reading books, please disable your download manager, or contact support</p>
                </div>
            </div>
        <section class="related products py-3" style="width: 100%">
            @if($other_books->count()>0)
            <h4>Other books</h4>
            <div class="row article-feed product">
		        <div class="carousel w-100 mb-3" data-flickity='{ "pageDots": false, "imagesLoaded": true, "wrapAround": true, "cellAlign": "left", "rightToLeft": false }'>
                    @foreach ($other_books as $book)
                        @include('web-client.books.book-component')
                    @endforeach
                </div>
            </div>
            @endif
            @if($other_listings->count()>0)
            <h4>Other listings</h4>
            <div class="row article-feed product">
		        <div class="carousel w-100 mb-3" data-flickity='{ "pageDots": false, "imagesLoaded": true, "wrapAround": true, "cellAlign": "left", "rightToLeft": false }'>
                    @foreach ($other_listings as $book)
                        @include('web-client.books.book-component')
                    @endforeach
                </div>
            </div>
            @endif
        </section>
    </div>
</div>
@endsection
