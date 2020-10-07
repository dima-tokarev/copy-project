<?php

namespace App\Http\ViewComposers;

use App\Catalog;
use Illuminate\View\View;

class NavigationCatalogBlockComposer
{



    public function compose(View $view)
    {


        $id = request()->route()->parameter('id');


        $menuitems = Catalog::isLive()
            ->ofSort(['parent_id' => 'asc', 'sort_order' => 'asc'])->where('view_id',$id)
            ->get();



        $menuitems = $this->buildTree($menuitems);

        return $view->with('menuitems', $menuitems);
    }

    public function buildTree($items)
    {
        $grouped = $items->groupBy('parent_id');



        foreach ($items as $item) {



            if ($grouped->has($item->id)) {
              $item->children = $grouped[$item->id];

            }
        }



        return $items->where('parent_id', null);
    }

}