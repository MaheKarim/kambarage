@php
    $size = $size??"col-lg-five col-xl-six p-3 post col-hover";
@endphp
<div class="{{$size}}">
    <div id="woo-height">
        <a href="{{route('web-client.books.view',$book->book_id)}}"
            class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
            <img width="300" height="450"
                src="{{getSingleMedia($book,'front_cover',null)}}"
                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" />
            <div class="p-2 mb-2">
                <h6 class="text-break">{{Str::limit($book->title,13,'..')}}</h6>
                <span>{{$book->subCategoryName->name}}</span>
                <p class="h6 author-name-archive"><a href="{{route('web-client.author',$book->author_id)}}">{{$book->getAuthor->name}}</a>
                </p>
            </div>
        </a>
    </div>
</div>
