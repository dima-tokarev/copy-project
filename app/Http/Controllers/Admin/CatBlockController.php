<?php

namespace App\Http\Controllers\Admin;

use App\Catalog;
use App\CatBlock;
use App\Http\Controllers\Controller;
use App\ProductCatOption;
use Illuminate\Http\Request;
use DB;


class CatBlockController extends AdminController
{
    public function __construct()
    {

        parent::__construct();


        $this->template = 'admin.catalog';
    }

    public function index()
    {

        $cat = DB::table('view')->get();


        $this->content = view('admin.cat_block_all')->with(['catalogs' => $cat ])->render();

        return $this->renderOutput();

    }

    public function showCatalog($id){


        $this->content = view('admin.show_catalog_menu')->with(['catalogs' => '' ])->render();

        return $this->renderOutput();
    }



    public function show($id)
    {

        $catalog = Catalog::find($id);

        $blocks = ProductCatOption::all();


        $this->content = view('admin.cat_block_show')->with(['blocks' => $blocks->sortBy('sort'),'catalog' => $catalog])->render();

        return $this->renderOutput();

    }

    public function store(Request $request)
    {
        //

        $data = $request->all();
        $cat = Catalog::find($data['cat_id']);



            if(isset($data[$cat->id])){
                $cat->saveBlock($data[$cat->id],$data['sort']);
            }else{
                $cat->saveBlock([],[]);
            }




        return back()->with('success','Категория обнавлена');

    }

}
