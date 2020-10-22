@php
    $categories = \App\Category::orderBy('name','asc')->get();
    $active_category_id = request()->has('category_id')?request()->category_id:0;
@endphp
<ul id="accordion-sidenav" class="menu">
    @foreach ($categories as $category)
    <li id="menu-item-227"
        class="menu-item
            menu-item-type-taxonomy
            menu-item-object-product_cat
            menu-item-227 menu-hover
            {{$active_category_id==$category->category_id?'current-menu-item menu-item-221 menu-hover':''}}">
        <a href="{{route('web-client.books',"category_id=".$category->category_id)}}">{{$category->name}}</a></li>
    @endforeach
</ul>
