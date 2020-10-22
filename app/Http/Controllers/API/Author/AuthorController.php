<?php

namespace App\Http\Controllers\API\Author;

use Illuminate\Http\Request;
use App\Author;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Author\AuthorResource;

class AuthorController extends Controller
{
    public function getAuthorList(){
        $author = Author::get();
        return AuthorResource::collection($author); 
    }
}