
<div class="container">


    <div class="row">


        <div  class="col-12">

            <!-- Left Side Of Navbar -->
            <ul  >
                @php
                    function buildMenu($items, $parent)
                    {
                        foreach ($items as $item) {

                            if (isset($item->children)) {

                @endphp
                <li >
                <span id="hasSub-{{ $item->id_1C }}">
                    <a class="select_cat_1c_product" data-id-cat="{{ $item->id_1C }}" href="javascript:void(0)"> {{ $item->name }}</a>

                </span>

                    <ul id="subnav-{{ $item->id_1C }}">
                        @php  buildMenu($item->children, 'subnav-'.$item->id_1C) @endphp
                    </ul>
                </li>
                @php
                    } else {
                @endphp
                <li class="last-li" style="margin-top: 10px;">

                    <a class="select_cat_1c_product" data-id-cat="{{ $item->id_1C }}" href="javascript:void(0)"> {{ $item->name }}</a>

                </li>
                @php
                    }
                }
            }

            buildMenu($menuitems, 'mainMenu')
                @endphp
            </ul>

        </div>


    </div>
</div>
