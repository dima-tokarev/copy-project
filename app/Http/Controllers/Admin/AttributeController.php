<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProductCatOption;
use App\ProductOption;
use App\ProductSelectOption;
use App\ProductTypeOption;
use Illuminate\Http\Request;

class AttributeController extends AdminController
{
    //
    public function __construct()
    {

        parent::__construct();



        $this->template = 'admin.attribute';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add($id)
    {
        //
        $opt_cat = ProductCatOption::find($id);


        $this->content = view('admin.attribute_add')->with(['attribute' => '','opt_cat' => $opt_cat])->render();

        return $this->renderOutput();

    }

    public function store(Request $request)
    {

        $data = $request->all();

   /*     $request->validate([
            'name' => 'required',

        ]);*/

        $i =0;


        if($data['type_attr'] == 'list') {
            $attr = ProductTypeOption::create([
                'name' => $data['name'],
                'type' => $data['type_attr'],
                'product_cat_option_id' => $data['cat_attr_id'],
            ]);

          foreach ($data['option_list'] as $item) {

              $attr_opt = ProductOption::create([
                  'value_option' => $item,
                  'product_type_option_id' => $attr->id,
              ]);
          }
        }else{
            $attr = ProductTypeOption::create([
                'name' => $data['name'],
                'type' => $data['type_attr'],
                'product_cat_option_id' => $data['cat_attr_id'],
            ]);
        }


        return redirect()->route('block_attribute_show',$data['cat_attr_id'])->with('success','Атрибут добавлен');
    }



    public function edit($id)
    {


        $type_opt = ProductTypeOption::find($id);
        $options = $type_opt->optionType;


        $cat = $type_opt->catType;



        $this->content = view('admin.attribute_edit')->with(['cat' => $cat,'type_opt' => $type_opt ,'options' => $options])->render();

        return $this->renderOutput();


    }


    public function update(Request $request)
    {

        $data = $request->all();



        $product_type = ProductTypeOption::where('id',$data['attr_id'])->update(['name' => $data['name']]);

        if(isset($data['option_list'])) {
            foreach ($data['option_list'] as $index => $val) {


                if(ProductOption::find($index)) {

                        ProductOption::where('id', $index)->update(['value_option' => $val]);
                    }else{
                        ProductOption::create(['value_option' => $val,'product_type_option_id' => $data['attr_id']]);
                    }
                }

            if (isset($data['del_list']) && count($data['del_list']) > 0) {

                foreach ($data['del_list'] as $index => $val) {

                    ProductOption::where('id', $index)->delete();
                }
            }
        }


        return redirect()->route('edit_attribute',$data['attr_id'])->with('success','Атрибут обновлен');


    }



    public function delete(Request $request)
    {
        $data = $request->all();

        $attr = ProductTypeOption::where('product_cat_option_id',$data['cat_attr_id'])->where('name',$data['attr_name'])->delete();
        $attr_select = ProductSelectOption::where('type_option_value',$data['attr_name'])->delete();
        return redirect()->route('block_attribute_show',$data['cat_attr_id'])->with('success','Атрибут удален');

    }







}
