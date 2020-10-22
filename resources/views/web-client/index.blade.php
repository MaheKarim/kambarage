@extends('layouts.web-client')

@section('content')
<div id="page-content-wrapper">
	<div class="col-12 my-3">
        <div class="row"> 
            <div class="carousel w-100"
                data-flickity='{ "pageDots": false, "imagesLoaded": true, "wrapAround": true, "cellAlign": "left", "rightToLeft": false, "autoPlay": true, "pauseAutoPlayOnHover": false }'>
                @foreach($ads as $ad)
                <div class="col-12 col-lg-6 p-3">
                    <div class="card border-class">
                        <div class="img__wrap">
                            <img class="img-fluid border-class shadow-sm"
                                src="{{getSingleMedia($ad,'slide_image',null)}}">
                            <a class="imageoutlink"></a>
                        </div>
                    </div>
                </div> 
                @endforeach
            </div>
        </div>
    </div>

	<div class="col-12 my-3">
		<div class="woocommerce py-3">
	        <div class="row article-feed product">
		        <div class="col">
                    <div class="d-inline-block">
                        <h4>Latest books</h4>
                    </div>
                    <div class="home-va-btn">
                        <a href="product-category/novel/index.html">See all <i class="fas fa-chevron-right fa-sm"></i>
                        </a>
                    </div>
	            </div>
		        <div class="carousel w-100 mb-3" data-flickity='{ "pageDots": false, "imagesLoaded": true, "wrapAround": true, "cellAlign": "left", "rightToLeft": false }'>
                    @foreach ($latest_books as $book)
                        @include('web-client.books.book-component')
                    @endforeach
                </div>
            </div>
        </div>
	</div>
	<div class="col-12 my-3">
		<div class="woocommerce py-3">
	        <div class="row article-feed product">
		        <div class="col">
                    <div class="d-inline-block">
                        <h4>Most popular</h4>
                    </div>
                    <div class="home-va-btn">
                        <a href="product-category/novel/index.html">See all <i class="fas fa-chevron-right fa-sm"></i>
                        </a>
                    </div>
	            </div>
		        <div class="carousel w-100 mb-3" data-flickity='{ "pageDots": false, "imagesLoaded": true, "wrapAround": true, "cellAlign": "left", "rightToLeft": false }'>
                    @foreach ($most_read as $book)
                        @include('web-client.books.book-component')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
	<div class="col-12 my-3">
        <div class="row"> 
            <div class="carousel w-100"
                data-flickity='{ "pageDots": false, "imagesLoaded": true, "wrapAround": true, "cellAlign": "left", "rightToLeft": false, "autoPlay": true, "pauseAutoPlayOnHover": false }'>
                @foreach($bottom_ads as $ad)
                <div class="col-12 col-lg-6 p-3">
                    <div class="card border-class">
                        <div class="img__wrap">
                            <img class="img-fluid border-class shadow-sm"
                                src="{{getSingleMedia($ad,'slide_image',null)}}">
                            <a class="imageoutlink"></a>
                        </div>
                    </div>
                </div> 
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
