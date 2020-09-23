<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use App\ProductImg;
use App\ProductOption;
use App\ProductSelectOption;
use App\ProductCatOption;
use Illuminate\Http\Request;

class ProductController extends AdminController
{

    //
    public function __construct()
    {

        parent::__construct();



        $this->template = 'admin.product';
    }

    //
    public function showProduct($id)
    {

        $product = Product::find($id);
        $product_opt = ProductSelectOption::where('product_id',$id)->get();
        $product_img = ProductImg::where('product_id',$id)->get();
        $product_opt = $product_opt->groupBy('product_cat_id');




        $this->content = view('admin.product_show')->with(['product' => $product ,'product_opt' => $product_opt,'product_img' => $product_img,'series_id' => $id])->render();

        return $this->renderOutput();


    }

    public function editProduct($id)
    {




        $product = Product::find($id);

        $cat = $product->category->blocks;

        $product_opt = ProductSelectOption::where('product_id',$id)->get();


       /* dd($product_opt);*/

        $product_img = ProductImg::where('product_id',$id)->get();
        $product_opt = $product_opt->groupBy('product_cat_id');


        $this->content = view('admin.product_edit')->with(['product' => $product ,'product_opt' => $product_opt,'product_img' => $product_img,'series_id' => $id, 'cat' => $cat,'product_id' => $id])->render();

        return $this->renderOutput();


    }



    public function updateProduct(Request $request)
    {


        $data = $request->all();

        $product = Product::where('id',$data['product_id'])->update(['name' => $data['name']]);



        foreach ($data['select_option'] as $index_cat => $item) {

            foreach ($item as $index => $val){


                if(ProductSelectOption::where('product_id',$data['product_id'])->where('type_option_value',$index)->first())
                {
                    $upd = ProductSelectOption::where('product_id',$data['product_id'])->where('type_option_value',$index)->update([
                        'value_option' => $val
                    ]);
                }else{
                    ProductSelectOption::create([
                        'product_cat_id' => $index_cat,
                        'product_id' => $data['product_id'],
                        'type_option_value' => $index,
                        'value_option' => $val,
                    ]);
                }


            }


        }


        if($request->file('file_img')) {





            foreach ($data['file_img'] as $file) {
                /* $size = $file->getSize();*/
                $img_name = $file->getClientOriginalName();
                $path = $file->store('uploads', 'public');


                $attach = ProductImg::create([
                    'path' => $path,
                    'name' => $img_name,
                    'product_id' => $data['product_id']
                ]);




            }
        }



        return redirect()->route('show_product',$data['product_id'])->with('success','Продукт обновлен');

    }


}
