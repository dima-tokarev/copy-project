<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProductCatOption;
use App\ProductTypeOption;
use Illuminate\Http\Request;

class BlockAttributeController extends AdminController
{

    public function __construct()
    {

        parent::__construct();



        $this->template = 'admin.blockAttribute';
    }


    public function index()
    {


        $block_attr = ProductCatOption::all();

        $this->content = view('admin.block_attribute_content')->with(['block_attr' => $block_attr])->render();

        return $this->renderOutput();


    }


    public function show($id)
    {
        $block_name = ProductCatOption::find($id);

        $block_attr = ProductTypeOption::where('product_cat_option_id',$id)->get();

        $this->content = view('admin.block_attribute_show')->with(['block_attr' => $block_attr,'block_name' => $block_name])->render();

        return $this->renderOutput();


    }

    public function add()
    {
        $this->content = view('admin.block_attribute_add')->with(['block_attr' => ''])->render();

        return $this->renderOutput();
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',

        ]);

        $data = $request->all();


        ProductCatOption::create(['name' => $data['name']]);

        return redirect()->route('block_attribute')->with('success','Блок добавлен');


    }


    public function edit($id)
    {


    }

    public function update(Request $request)
    {


    }


    public function delete(Request $request)
    {


    }



}
