<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
class Author extends Model implements HasMedia
{
    use HasMediaTrait;
    use SoftDeletes;
    protected $table="author";

    public $primaryKey='author_id';

    public $fillable=['name','education','description','designation','mobile','email','address','image'];
    public $timestamp=true;

    public function getBooks(){
        return $this->hasMany(Book::class, 'author_id');
    }
    public function getBookRating(){
        return $this->hasManyThrough('App\BookRating', 'App\Book','book_id','book_id','author_id','author_id');
    }
}
