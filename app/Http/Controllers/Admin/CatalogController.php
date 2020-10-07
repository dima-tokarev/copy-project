<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Catalog;



class CatalogController extends AdminController
{
    //
    public function __construct()
    {

        parent::__construct();



        $this->template = 'admin.catalog';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //

        $views = DB::table('view')->get();


        $this->content = view('admin.main')->with(['views' => $views])->render();

        return $this->renderOutput();

    }



}
