<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Matching;
use App\Product;
use App\Product1c;
use Illuminate\Http\Request;

class MatchingController extends AdminController
{
    //

    public function __construct()
    {

        parent::__construct();



        $this->template = 'admin.matching';
    }

    public function index(Request $request)
    {

        $data = $request->all();

        $product = Product::find($data['id']);
        $products = Product1c::all();
        $matching_products = Matching::where('product_id',$data['id'])->get();




        $this->content = view('admin.matching_index')->with(['products' => $products,'product_id' => $data['id'],'matching_products' => $matching_products, 'product' => $product])->render();

        return $this->renderOutput();

    }

   public function selectCat1c(Request $request)
   {
       $data = $request->all();

       $products = Product1c::where('catalog_1c', $data['cat_1c_product_id'])->get();

       $html = '';
       if(count($products) > 0) {
           $html .='<thead>
                                    <th>Название</th>
                                    <th>Код 1с</th>
                                    <td align="center"><b>Выбрать</b></td>
                                </thead><tbody>';
           foreach ($products as $product) {
               $html .= ' 
                                <tbody >
                            <tr>
                                <td>' . $product->name . '</td>
                                  <td>' . $product->code_1c . '</td>
                                    <td align="center">
                                      <input type="checkbox" onclick="add_item(this)" data-name="' . $product->name . '" data-1c="' . $product->code_1c . '" id="product_' . $product->id . '"  data-id="' . $product->id . '" name="product"></td>
                                            </tr>';
               $html .= ' <script>';
               $html .= '$(document).ready(function () {';
               $html .= 'if($("#select_' . $product->id . '").length) {';
               $html .= '$("#product_' . $product->id . '").prop("checked", true);';
               $html .= '}})';
               $html .= '</script>';

           }
           $html .='</tbody>';
       }else{
          $html .= '<h5 style="padding: 20px" align="center">Товары не найдены</h5>';
       }
       echo $html;

   }




    public function store(Request $request)
    {

        //

        $data = $request->all();

        if(isset($data['select_product'])) {
            foreach ($data['select_product'] as $key => $product) {
                foreach ($product as $code => $val) {

                    Matching::updateOrCreate([

                        'product_id' => $data['product_id'],
                        'code_1c' => $code,
                        'product_1c_id' => $key


                    ]);
                }


            }

        }
        if(isset($data['main'])){

            Matching::where('product_1c_id',$data['main'])->where('product_id',$data['product_id'])->update(['is_base' => 1]);
            Matching::where('product_1c_id','!=',$data['main'])->where('product_id',$data['product_id'])->update(['is_base' => null]);
        }

        if(isset($data['del_id'])) {

            foreach ($data['del_id'] as $del) {
                Matching::where('product_1c_id', $del)->where('product_id', $data['product_id'])->delete();
            }
        }

        return redirect()->route('show_product',$data['product_id'])->with('success','Карточка сопоставлена');


    }


}
