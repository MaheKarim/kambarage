<?php

namespace App\Http\Controllers\API\Book;

use Illuminate\Http\Request;
use App\Book;
use App\BookRating;
use App\UserWishlistBook;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Book\BookResource;
use App\Http\Resources\API\Book\UserWishlistBookResource;
use App\Http\Resources\API\Book\BookDetailResource;
use App\Http\Resources\API\Book\BookRatingResource;
use App\Http\Resources\API\Author\AuthorResource;


class BookController extends Controller
{

    public function getBookList(Request $request){
        $book_data       =       Book::orderBy('book_id', 'DESC')
                                                ->with([
                                                        'getAuthor',
                                                        'categoryName',
                                                        'subCategoryName',
                                                        // 'isWishlistBook'
                                                    ]);

            if($request->has('category_id') && $request->category_id != null ){
                    $book_data->where('category_id',$request->category_id);
            }

            if($request->has('subcategory_id') && $request->subcategory_id != null ){
                $book_data->where('subcategory_id',$request->subcategory_id);
            }

            if($request->has('search_text') && $request->search_text != null){
                $book_data->orWhere('name', 'LIKE', '%'.$request->search_text.'%');
                $book_data->orWhere('title', 'LIKE', '%'.$request->search_text.'%');
            }

            if($request->has('author_id') && $request->author_id != null ){
                $book_data->where('author_id',$request->author_id);
            }

            if($request->has('min_price') && $request->min_price != null || $request->has('max_price') && $request->max_price != null){
                $book_data->having('price','>=',$request->min_price)->having('price','<=',$request->max_price);
            }

            if($request->has('rating') && $request->rating != null ){
                $book_data->where('rating',$request->rating);
            }

            $max               =  $book_data->max('price');
            $book_data  =  $book_data->paginate(12);

            $items        =   BookResource::collection($book_data);
            $response = [
                        'pagination' => [
                                                'total_items' => $items->total(),
                                                'per_page' => $items->perPage(),
                                                'currentPage' => $items->currentPage(),
                                                'totalPages' => $items->lastPage(),
                                                'from' => $items->firstItem(),
                                                'to' => $items->lastItem(),
                                                'next_page'=>$items->nextPageUrl(),
                                                'previous_page'=>$items->previousPageUrl(),
                                            ],
                        'data' => $items,
                        'max_price'=> $max

                    ];
            return response()->json($response);

    }

    public function getBookDetail(Request $request){
        $book_data =     Book::where('book_id', $request->book_id)
                                                    ->with([
                                                        'categoryName',
                                                        'subCategoryName',
                                                        'getAuthors',
                                                        'getAuthorBookList',
                                                        'getCategoryBookList',
                                                        'getBookRating',
                                                        'getWishList',
                                                        'getPurchase'
                                                    ])
                                                    ->get();
        $getBookDetail                    =   BookDetailResource::collection($book_data);
        $getBookRating                   =   BookRatingResource::collection($book_data[0]->getBookRating);
        $getAuthorBookList           =   BookResource::collection($book_data[0]->getAuthorBookList);
        $getCategoryBookList       =   BookResource::collection($book_data[0]->getCategoryBookList);
        $getUserReview                   =  Null;
        $getAuthorDetail                 = AuthorResource::collection($book_data[0]->getAuthors);


        if($request->user_id != null){
            $getUserReview          =    BookRating::where('user_id',$request->user_id)->where('book_id',$request->book_id)->first();
        }

        $response = [
                'book_detail' => $getBookDetail,
                'author_detail' =>$getAuthorDetail,
                'author_book_list' => $getAuthorBookList,
                'recommended_book'=>$getCategoryBookList,
                'book_rating_data'=>$getBookRating,
                'user_review_data'=>$getUserReview
        ];

        return response()->json($response);
    }

    // Rating Module
    public function addBookRating(Request $request){
        $data = $request->all();

        $user  = \Auth::user();
        $data['user_id'] = $user->id;

        $result = BookRating::Create($data);
        $message = trans('messages.save_form',['form' => 'Book Rating']);

        return response()->json([ 'status' => true ,'message' => $message ]);
    }

    public function updateBookRating(Request $request){
        $data = $request->all();

        $user  = \Auth::user();
        $data['user_id'] = $user->id;

        $result = BookRating::where('rating_id',$rating_id)->Update($data);
        $message = trans('messages.update_form',['form' => 'Book Rating']);

        return response()->json([ 'status' => true ,'message' => $message ]);
    }

    public function getBookRating(Request $request){

        $rating_data = BookRating::where('book_id',$request->book_id)->get();
        return  BookRatingResource::collection($rating_data);
    }

    public function deleteBookRating(Request $request){
        $user = \Auth::user();

        $book_rating = BookRating::where('rating_id',$request->id)->where('user_id',$user->id)->delete();

        $message = trans('messages.delete_form',['form' => 'Book Rating']);

        return response()->json([ 'status' => true ,'message' =>$message ]);
    }

    public function getUserWishlistBook(){
        $user = \Auth::user();
        $user_id = $user->id;
        $data = UserWishlistBook::where('user_id',$user_id)
                                ->orderBy('wishlist_id', 'DESC')
                                ->with([
                                    'getBook'
                                ])
                                ->get();
        $wishlist_data =  UserWishlistBookResource::collection($data);
        return response()->json(['status' => true ,'data' => $wishlist_data]);

    }

    public function addRemoveWishlistBook(Request $request){
        $user   = \Auth::user();
        $id     = isset($request->id) ? $request->id : '';

        $data   = $request->all();
        $data['user_id'] = $user->id;

        if($request->is_wishlist == 0){
            UserWishlistBook::where('book_id',$data['book_id'])->where('user_id',$data['user_id'])->delete();
            $message = trans('messages.removed_in_wishlist');
        }else{
            UserWishlistBook::Create($data);
            $message = trans('messages.added_in_wishlist');
        }

        return response()->json([ 'status' => true ,'message' => $message ]);
    }
}
