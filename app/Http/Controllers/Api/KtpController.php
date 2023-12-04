<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KtpVarified;

class KtpController extends Controller
{
    public function index()
    {
        //
    }

    public function verification(Request $request)
    {
        return $request->all();
    }
}
