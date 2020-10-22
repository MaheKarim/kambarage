<?php

namespace App\Http\Controllers;

use Auth;
use App\Author;
use App\Book;
use App\Category;
use App\Mobile_slider;
use App\SubCategory;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class WebClientController extends Controller
{
    public function index()
    {
        $data = [
            "ads"=> Mobile_slider::where("position", "top")->get(),
            "bottom_ads"=> Mobile_slider::where("position", "bottom")->get(),
            "latest_books"=>Book::orderBy('book_id','desc')->take(7)->get(),
            "most_read"=>Book::orderBy('book_id','asc')->where('flag_top_sell',true)->take(7)->get(),
        ];
        return view('web-client.index',$data);
    }

    public function viewBook($book_id)
    {
        $book = Book::find($book_id);
        $data=[
            "book" => $book,
            "other_listings" => Book::whereCategoryId($book->category_id)->take(7)->get(),
            "other_books" => Book::whereSubcategoryId($book->subcategory_id)->take(7)->get(),
        ];
        return view('web-client.books.book',$data);
    }

    public function read($book_id)
    {
        $book = Book::find($book_id);
        $data = [
            "book"=>$book,
        ];
        if($book->format == 'pdf')
            return view('web-client.books.read-pdf',$data);
        else if($book->format == 'epub')
            return view('web-client.books.read-ebook',$data);
    }

    public function download($book_id)
    {
        $book = Book::find($book_id);
        $url = $book->getFirstMedia('file_path')->getUrl();
        $url = asset($url);
        return redirect($url);
    }

    public function books(Request $request)
    {
        $books = Book::query();
        if($request->has('category_id')){
            $category_name = Category::find($request->category_id)->name;
            $books->whereCategoryId($request->category_id);
            $active_category_id = $request->category_id;

            $sub_categories = SubCategory::whereCategoryId($active_category_id)->get();
            if($request->has('sub_category_id')){
                $books->whereSubcategoryId($request->sub_category_id);
                $active_sub_category_id = $request->sub_category_id;
            }
        }
        $data = [
            "books"=>$books->paginate(24),
            "header"=>$category_name??"All books",
            "active_category_id"=>$active_category_id??0,
            "active_sub_category_id"=>$active_sub_category_id??0,
            "sub_categories"=> $sub_categories??[]
        ];  
        return view('web-client.books.index',$data);
    }

    public function authors()
    {
        $data = [
            "authors"=>Author::all()
        ];
        return view('web-client.authors.index',$data);
    }

    public function author($id)
    {
        $data = [
            "author"=>Author::find($id)
        ];
        return view('web-client.authors.author',$data);
    }

    public function search(Request $request)
    {
        $books = Book::paginate(24);
        $s = $request->s;
        if($request->has('s')){
            $books = Book::where('title','like',"%$s%")->paginate(24);
        }
        $data = [
            "books"=>$books,
            "active_category_id"=>$active_category_id??0,
            "header"=>"Search: '".$request->s."'"??"All books"
        ];
        return view('web-client.books.index',$data);
    }

    public function recommended()
    {
        $data = [
            "books"=>Book::whereFlagRecommend(true)->paginate(24),
            "header"=>"Recommended books"
        ];
        return view('web-client.books.index',$data);
    }

    public function tac()
    {
        $term_condition_data=Setting::where('key','terms&condition')->first();
        return view('web-client.pages.terms-and-conditions',compact('term_condition_data'));
        
    }

    public function pp()
    {
        $privacy_policy_data=Setting::where('key','privacy_policy')->first();
        return view('web-client.pages.privacy-policy',compact('privacy_policy_data'));
    }

    public function changePasswordForm()
    {
        return view('web-client.pages.change-password');
    }

    public function changePassword(Request $request)
    { 
        $request->validate([
            'password'=>'required|confirmed'
        ]);
        $user = $request->user();
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->back()->with('success','Password changed successfully!');
    }

    public function loginForm()
    {
        return view('web-client.pages.login');
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
