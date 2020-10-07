<!-- Left Side Of Navbar -->
<ul style="padding-left: 20px">
    @php
        function buildMenu($items, $parent)
        {
            foreach ($items as $item) {
                if (isset($item->children)) {
    @endphp
    <li style="padding: 10px;" >
        <span>
            {{ $item->name }}
        </span>
        <span><a href="{{route('cat_block_show',$item->id)}}"> / Назначить</a></span>
        <ul
            id="subnav-{{ $item->id }}"
            data-parent="#{{ $parent }}"
            aria-labelledby="hasSub-{{ $item->id }}"
        >
            @php buildMenu($item->children, 'subnav-'.$item->id) @endphp
        </ul>
    </li>
    @php
        } else {
    @endphp
    <li style="padding: 5px;" >
        <span  class="user_select_cat_product"   class="nav-link">{{ $item->name }}</span>
        <span><a href="{{route('cat_block_show',$item->id)}}"> / Назначить</a></span>
    </li>
    @php
        }
    }
}

buildMenu($menuitems, 'mainMenu')
    @endphp
</ul>
