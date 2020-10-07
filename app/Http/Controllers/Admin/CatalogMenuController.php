<?php

namespace App\Http\Controllers\Admin;


use App\Product;


use App\ProductImg;
use App\ProductSelectOption;
use Illuminate\Http\Request;
use App\Catalog;
use DB;




class CatalogMenuController extends AdminController
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
        $catalog = Catalog::all();
        $products = Product::where('view_id',$id)->paginate(25);
        $views = DB::table('view')->get();
        $this->content = view('admin.catalog_menu_main')->with(['catalogs' => $catalog,'products' => $products,'views' => $views ,'view_id' => $id])->render();

        return $this->renderOutput();

    }

 /* select*/


    public function selectProduct(Request $request)
    {


        $data = $request->all();

        $products  = Product::where('series_id',$data['select_id'])->where('view_id',$data['view_id'])->get();

        $json_product = [];

            foreach ($products as $product) {
                $json_product[$product->id] = [
                    'name' => $product->name,
                    'img' => isset($product->productImg->first()->path) ? $product->productImg->first()->path : 'http://'.$_SERVER['SERVER_NAME'].'/storage/app/public/123.jpg',
                    'link' => '/admin/product/'.$product->id
                ];

            }



     return  json_encode($json_product);


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

                <div class='row'>

                    <div class='col-7'>
                            <input class='form-control' type='text' name='name_cat' placeholder='введите название категории' required>
                    </div>

                      <div class='col-3'>
                         <form  action='/admin/".$data['add_view_id']."/catalog-store-cat/' method='post'>
                          <input type='hidden' name='cat_id' value='".$data['add_cat']."'>
                             <input type='hidden' name='view_id' value='".$data['add_view_id']."'>
                                   ".csrf_field()."
                         <button type='submit' class='btn btn-info'>Добавить</button>

               </form>
                    </div>

                </div>


               </form>
              </div>



              </div>
            ";


            echo $html;


        }

    }

    public function storeCat(Request $request)
    {
        $data = $request->all();


        if(isset($data['main_cat'])){
            $res =Catalog::create([

                'name' => $data['name'],
                'parent_id' => null,
                'url' => '#',
                'sort_order' => 0,
                'live' => 1,
                'type' => 'cat',
                'hasСontent' => 0,
                'view_id' => $data['view_id']
            ]);


        }else{


           $res = Catalog::create([

                'name' => $data['name_cat'],
                'parent_id' => $data['cat_id'],
                'url' => '#',
                'sort_order' => 0,
                'live' => 1,
                'type' => 'cat',
                'hasСontent' => 0,
                'view_id' => $data['view_id']
            ]);
        }

            return $res ? json_encode('Success') : json_encode('');
    }

    public function deleteCat(Request $request)
    {




        $data = $request->all();

        $cat = Catalog::where('id',$data['del_cat'])->delete();

        return $cat ? json_encode('Success') : json_encode('');

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
                          <input type='hidden' name='cat_id' value='".$data['add_series']."'>
                              <input type='hidden' name='view_id' value='".$data['add_view_id']."'>
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


       $res = Catalog::create([

            'view_id' => $data['view_id'],
            'name' => $data['name_cat'],
            'parent_id' => $data['cat_id'],
            'url' => '#',
            'sort_order' => 0,
            'live' => 1,
            'type' => 'series',
            'hasContent' => 0,
            'view_id' => $data['view_id']
        ]);

        return $res ? json_encode('Success') : json_encode('');


    }

    public function deleteSeries(Request $request)
    {


        $data = $request->all();

        $cat = Catalog::where('id',$data['del_cat'])->delete();

        return $cat ? json_encode('Success') : json_encode('');

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

        $this->content = view('admin.catalog_add_product')->with(['series_id' => $id ,'view_id' => $catalog->view_id, 'cat' => $catalog->blocks])->render();

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
            'series_id' => $data['series_id'],
            'view_id' => $data['view_id']
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



        return redirect()->route('catalog_menu',$data['view_id'])->with('success','Карточка добавлена');


    }

    public function deleteProduct(Request $request)
    {


        $data = $request->all();

        $product = Product::where('id',$data['del_product'])->delete();

        return $product ? json_encode('Success') : json_encode('');

    }











}
