<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class PaginationController extends Controller
{
    //
    public function index()
    {
       $data = DB::table('client')->paginate(5);
       return view('pagination', compact('data'));
    }
}
