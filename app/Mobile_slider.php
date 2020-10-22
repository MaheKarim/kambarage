<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Mobile_slider extends Model implements HasMedia
{
    use HasMediaTrait, SoftDeletes;
    protected $table="mobile_slider";
    protected $primaryKey='mobile_slider_id';
    protected $fillable=['title','slide_image','link','position'];
}
