<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class UserCartMapping extends Model
{

    protected $table = "user_cart_mapping";
    protected $primaryKey = "cart_mapping_id";
    protected $fillable = ['book_id','added_qty','user_id'];

    public function getBook(){
        return $this->belongsTo(Book::class, 'book_id','book_id')->with(['getAuthor']);
    }

}