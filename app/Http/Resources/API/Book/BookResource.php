<?php

namespace App\Http\Resources\API\Book;

use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\Conversion\Conversion;
use Spatie\MediaLibrary\Conversion\ConversionCollection;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'book_id'=>$this->book_id,
            'category_name' => optional($this->categoryName)->name,
            'subcategory_name' => optional($this->subCategoryName)->name,
            'author_name'=>optional($this->getAuthor)->name,
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
            'is_wishlist'=>$this->is_wishlist
        ];
    }
}
