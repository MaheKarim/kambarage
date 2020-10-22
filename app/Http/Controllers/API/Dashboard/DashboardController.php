<?php

namespace App\Http\Controllers\API\Dashboard;

use Illuminate\Http\Request;
use App\Book;
use App\BookRating;
use App\UserWishlistBook;
use App\Mobile_slider;
use App\Author;
use App\Category;
use App\Setting;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Book\BookResource;
use App\Http\Resources\API\Book\UserWishlistBookResource;
use App\Http\Resources\API\Book\TopSearchBookResource;
use App\Http\Resources\API\Book\TopSellBookResource;
use App\Http\Resources\API\Book\MobileSliderResource;
use App\Http\Resources\API\Author\AuthorResource;

use Config;

class DashboardController extends Controller
{

    public function getDashboardDetail(Request $request){
        $slider                              =  MobileSliderResource::collection(Mobile_slider::get());
        $p_book                           = Book::orderBy('rating','desc')->paginate(12);

        $popular_book              = BookResource::collection($p_book);
        $t_search_book             = Book::orderBy('book_id','desc');

        if($request->has('category_id') && $request->category_id != null ){
            $t_search_book->where('category_id',$request->category_id);
        }
        $top_search_book        = BookResource::collection($t_search_book->paginate(12));

        $top_sell_book              = BookResource::collection($t_search_book->where('flag_top_sell',1)->paginate(12));
        $recommended_book = BookResource::collection($t_search_book->where('flag_recommend',1)->paginate(12));

        $top_author                   = AuthorResource::collection(Author::take(10)->orderBy('author_id','desc')->get());
        $category_book            = Category::get();

        $notification_count = 0;
        if($request->has('user_id') && $request->user_id != null ){
            $notification_count = Notification_history::where('user_id',$request->user_id)->where('status',0)->get()->count();
        }

        switch ($request->type) {

            case 'popular_book':
                    $items = $popular_book;
            break;
            case 'category':
            case 'top_search_book':
                    $items = $top_search_book;
            break;
            case 'top_sell_book':
                    $items = $top_search_book;
            break;
            case 'recommended_book':
                    $items = $top_search_book;
            break;

            default:
                $setting              = Config::get('mobile-config');
                foreach($setting as $k=>$s){
                    foreach ($s as $sk => $ss){
                        $getSetting[]=$k.'_'.$sk;
                    }
                }

                $setting_value  =Setting::whereIn('key',$getSetting)->get();

                $response = [
                    "status"              => true,
                    "slider"                => $slider,
                    "popular_book" => $popular_book,
                    "top_search_book" => $top_search_book,
                    "top_sell_book" => $top_sell_book,
                    "recommended_book" => $recommended_book,
                    "top_author" => $top_author,
                    "category_book" => $category_book,
                    "notification_count"=>$notification_count,
                    "configuration"=>$setting_value,
                    "message"=> trans('messages.dashboard_detail')

                ];



                return response()->json($response);

            break;
        }

        $response = [
            'pagination' => [
                        'total_items' => $items->total(),
                        'per_page' => $items->perPage(),
                        'currentPage' => $items->currentPage(),
                        'totalPages' => $items->lastPage(),
                        'from' => $items->firstItem(),
                        'to' => $items->lastItem(),
                        'next_page'=>$items->nextPageUrl(),
                        'previous_page'=>$items->previousPageUrl()
            ],
            'data' => $items,
        ];
        return response()->json($response);
    }
}
