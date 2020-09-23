<?php

namespace App\Http\ViewComposers;


use App\Catalog1c;
use Illuminate\View\View;

class Navigation1cComposer
{
    public function compose(View $view)
    {
        $menuitems = Catalog1c::isLive()
            ->ofSort(['parentId_1C' => 'asc', 'sort_order' => 'asc'])
            ->get();


        $menuitems = $this->buildTree($menuitems);

        return $view->with('menuitems', $menuitems);
    }

    public function buildTree($items)
    {
        $grouped = $items->groupBy('parentId_1C');



        foreach ($items as $item) {


            if ($grouped->has($item->id_1C)) {

                $item->children = $grouped[$item->id_1C];

            }
        }



        return $items->where('parentId_1C', null);
    }

}