<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Helpers\ResponseFormatter;

class CategoryController extends Controller
{
    public function index()
    {
        $data = Category::all();

        return ResponseFormatter::success($data, 'Data displayed successfully!');
    }
}
