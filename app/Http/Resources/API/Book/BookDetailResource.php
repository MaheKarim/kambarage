<?php

namespace App\Http\Resources\API\Book;

use Illuminate\Http\Resources\Json\JsonResource;

class BookDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user_id=request()->user_id;
        return [
            'book_id'=>$this->book_id,
            'category_name' => optional($this->categoryName)->name,
            'subcategory_name' => optional($this->subCategoryName)->name,
            'author_name'=> optional($this->getAuthor)->name,
            'name'=>$this->name,
            'title'=> $this->title,
            'topic_cover'=>$this->topic_cover,
            'description'=>strip_tags($this->description),
            'format'=>$this->format,
            'edition'=>$this->edition,
            'keywords'=>$this->keywords,
            'language'=>$this->language,
            'publisher'=>$this->publisher,
            'date_of_publication'=>$this->date_of_publication,
            'front_cover'=>getBookImage($this->media,'front_cover'),
            'back_cover'=>getBookImage($this->media,'back_cover'),
            'file_path'=> getBookImage($this->media,'file_path'),
            'file_sample_path'=>getBookImage($this->media,'file_sample_path'),
            'price'=>$this->price,
            'discount'=>$this->discount,
            'discounted_price'=>$this->discounted_price,
            'language'=>optional($this->getBookLanguage)->label,
            'is_wishlist'=>$this->getWishList->where('user_id',$user_id)->first()?1:0,
            'is_purchase'=>$this->getPurchase->where('user_id',$user_id)->first()?1:0,
            'total_review'=>$this->getBookRating->count('rating_id'),
            'total_rating'=>min($this->getBookRating->avg('rating'),0)
        ];
    }
}
