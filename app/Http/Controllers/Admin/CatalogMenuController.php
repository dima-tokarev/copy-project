<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use App\Product1c;
use App\ProductCatOption;
use App\ProductImg;
use App\ProductSelectOption;
use Illuminate\Http\Request;
use DB;
use App\Catalog;




class CatalogMenuController extends AdminController
{
    //
    public function __construct()
    {

        parent::__construct();



        $this->template = 'admin.catalog_menu';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $catalog = Catalog::all();
        $products = Product::paginate(25);

        $this->content = view('admin.catalog_menu_main')->with(['catalogs' => $catalog,'products' => $products])->render();

        return $this->renderOutput();

    }

 /* select*/


    public function selectProduct(Request $request)
    {
        $data = $request->all();

        $products  = Product::where('series_id',$data['select_id'])->get();

        $html = '';
        if($data['select_id']){
        if(count($products) > 0) {


            $html .= '<div class="container-fluid">   <div class="row">
                    <div  class="col-lg-12 col-md-12 col-sm-12">
                    <div class="row">
                    ';
            foreach ($products as $product) {
                if(isset($product->productImg->first()->path)){
                    $img = $product->productImg->first()->path;
                }else{
                    $img = '123.jpg';
                }
                $html .= '
             
                         <!--1rd card-->
                            <div style="padding-top: 24px;" class="col=lg-4 col-md-4 order-md-3">
                                <div class="container block rounded-lg rounded-sm">
                                    <!--1st row--->
                                    <div class="row">
                                                                            
                                        <div class="col-lg-12 col-md-12 col-sm-12 img-catalog">
                                           <a href="/admin/product/' . $product->id . '"><img  src="http://'.$_SERVER['SERVER_NAME'].'/storage/app/public/'.$img.'" alt="placeholder image"/></a>

                                        </div>
                                    </div>
                                    <!--2nd row--->
                                    <div class="row" >
                                        <div class="col-lg-12 col-md-12 col-sm-12 block2">
                                            <p><h6 style="color: #fff" class="mb-3">'.$product->name.'</h6></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
             
             ';


                /*       $html .= '

                               <td><a href="/admin/product/'.$product->id.'">'.$product->name.'</a></td>
                            <td align="right">
                                      <form action="/admin/catalog-delete-product" method="post" style="display:  inline-flex">
                                          <input type="hidden" name="del_product" value="'.$product->id.'">
                                          <button  onclick="return confirm(\'Удалить работу?\')" class="btn btn-info" aria-hidden="true">Удалить</button>
                                          ' . csrf_field() . '
                                      </form>
                                  </td>

                           ';*/
            }
            $html .= '</div></div></div></div>';
        }else{
            $html .= '<div align="center"><h5>Товары не найдены</h5></div>';
        }
            echo $html;


        }

    }

    public function userSelectProduct(Request $request)
    {
        $data = $request->all();

        $products  = Product::where('series_id',$data['select_id'])->get();

        $html = '';
        if($data['select_id']){


            foreach ($products as $product) {
                $html .= '
              <tr>
                    <td><a href="/admin/product/'.$product->id.'">'.$product->name.'</a></td>
                       <td align="right">
                           <form action="/admin/catalog-delete-product" method="post" style="display:  inline-flex">
                               <input type="hidden" name="del_product" value="'.$product->id.'">
                               <button  onclick="return confirm(\'Удалить работу?\')" class="btn btn-info" aria-hidden="true">Удалить</button>
                               ' . csrf_field() . '
                           </form>
                       </td>
                   </tr>
                ';
            }

            echo $html;


        }

    }


    public function addCat(Request $request)
    {
        $data = $request->all();

        if($data['add_cat']){

            $html = '';

            $html .= "
              <div class='container'>
              
              <br/><h5>Добавить категорию</h5><br/>
                 <form action='/admin/catalog-store-cat' method='post'>
                <div class='row'>
               
                    <div class='col-7'>
                            <input class='form-control' type='text' name='name_cat' placeholder='введите название категории' required>
                    </div>
                      <div class='col-3'>
                          <input type='hidden' name='cat_id' value='".$data['add_cat']."' placeholder='введите название категории'>
                         <button class='btn btn-info'>Добавить</button>
                    </div>
                      ".csrf_field()."
                </div>
              
                
               </form>  
              </div>  
            ";


            echo $html;


        }

    }

    public function storeCat(Request $request)
    {
        $data = $request->all();


            Catalog::create([

                'name' => $data['name_cat'],
                'parent_id' => $data['cat_id'],
                'url' => '#',
                'sort_order' => 0,
                'live' => 1,
                'type' => 'cat'


            ]);

            return redirect()->route('catalog_menu')->with('success','Категория добавлена');





    }

    public function deleteCat(Request $request)
    {




        $data = $request->all();

        $cat = Catalog::where('id',$data['del_cat'])->delete();

        return redirect()->route('catalog_menu')
            ->with('success', 'Категория удалена!');
    }


    public function addSeries(Request $request)
    {
        $data = $request->all();

        if($data['add_series']){

            $html = '';

            $html .= "
              <div class='container'>
              
              <br/><h5>Добавить Серию</h5><br/>
                 <form action='/admin/catalog-store-series' method='post'>
                <div class='row'>
               
                    <div class='col-7'>
                            <input class='form-control' type='text' name='name_cat' placeholder='введите название категории' required>
                    </div>
                      <div class='col-3'>
                          <input type='hidden' name='cat_id' value='".$data['add_series']."' placeholder='введите название категории'>
                         <button class='btn btn-info'>Добавить</button>
                    </div>
                      ".csrf_field()."
                </div>
              
                
               </form>  
              </div>  
            ";


            echo $html;


        }

    }


    public function storeSeries(Request $request)
    {
        $data = $request->all();


        Catalog::create([

            'name' => $data['name_cat'],
            'parent_id' => $data['cat_id'],
            'url' => '#',
            'sort_order' => 0,
            'live' => 1,
            'type' => 'series'


        ]);

        return redirect()->route('catalog_menu')->with('success','Серия добавлена');


    }

    public function deleteSeries(Request $request)
    {


        $data = $request->all();

        $cat = Catalog::where('id',$data['del_cat'])->delete();

        return redirect()->route('catalog_menu')
            ->with('success', 'Серия удалена!');
    }



    public function addProduct($id)

    {

        $catalog = Catalog::find($id);




   /*     foreach ($cat as $val)
        {

            foreach ($val->typeOption as $item)
            {
                dd($item->optionType);
            }
        }*/

        $this->content = view('admin.catalog_add_product')->with(['series_id' => $id , 'cat' => $catalog->blocks])->render();

        return $this->renderOutput();




    }


    public function storeProduct(Request $request)
    {
        $data = $request->all();


           $request->validate([
                'name' => 'required',

            ]);



       $product = Product::create([
            'name' => $data['name'],
            'series_id' => $data['series_id']
        ]);


        if($product){

            if($request->file('file_img')) {




                foreach ($data['file_img'] as $file) {
                   /* $size = $file->getSize();*/
                    $img_name = $file->getClientOriginalName();
                    $path = $file->store('uploads', 'public');


                    $attach = ProductImg::create([
                        'path' => $path,
                        'name' => $img_name,
                        'product_id' => $product->id
                    ]);




                }
            }
            if(isset($data['select_option'])){
                foreach ($data['select_option'] as $index_cat => $cat) {

             foreach ($cat as $index_item => $item) {

                 ProductSelectOption::create([

                     'product_cat_id' => $index_cat,
                     'product_id' => $product->id,
                     'type_option_value' => $index_item,
                     'value_option' => $item

                 ]);
                     }
                 }
            }
        }



        return redirect()->route('catalog_menu')->with('success','Карточка добавлена');


    }

    public function deleteProduct(Request $request)
    {


        $data = $request->all();

        $product = Product::where('id',$data['del_product'])->delete();

        return redirect()->route('catalog_menu')
            ->with('success', 'Карточка удалена!');
    }











}
