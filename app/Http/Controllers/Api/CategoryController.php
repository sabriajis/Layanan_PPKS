<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
     // index api
     public function index()
     {
         $categories = Category::all();
         return response()->json([
             'status' => 'success',
             'data' => $categories
         ], 200);
     }
}
