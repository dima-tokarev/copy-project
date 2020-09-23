<?php

namespace App\Http\Controllers\Admin;

use App\Catalog;
use App\Http\Controllers\Controller;
use App\ProductCatOption;
use Illuminate\Http\Request;


class CatBlockController extends AdminController
{
    public function __construct()
    {

        parent::__construct();


        $this->template = 'admin.catalog_menu';
    }

    public function index()
    {

        $cat = Catalog::all();

        $this->content = view('admin.cat_block_all')->with(['cat_block' => $cat ])->render();

        return $this->renderOutput();

    }

    public function show($id)
    {

        $catalog =Catalog::find($id);

        $blocks = ProductCatOption::all();

        $this->content = view('admin.cat_block_show')->with(['blocks' => $blocks,'catalog' => $catalog ])->render();

        return $this->renderOutput();

    }

    public function store(Request $request)
    {
        //

        $data = $request->all();
        $cat = Catalog::find($data['cat_id']);



            if(isset($data[$cat->id])){
                $cat->saveBlock($data[$cat->id]);
            }else{
                $cat->saveBlock([]);
            }




        return back()->with('success','Категория обнавлена');

    }

}
