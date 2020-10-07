<!-- Left Side Of Navbar -->
<ul style="padding-left: 5px" class="navbar-nav mr-auto" id="mainMenu">
    @php
        function buildMenu($items, $parent)
        {
            foreach ($items as $item) {
                if (isset($item->children)) {
    @endphp
    <li style="padding: 5px;" class="nav-item">
        <a class="user_select_cat_product" data-id-cat="{{ $item->id }}" href="{{ $item->url }}"
           class="nav-link"
           id="hasSub-{{ $item->id }}"
           data-toggle="collapse"
           data-target="#subnav-{{ $item->id }}"
           aria-controls="subnav-{{ $item->id }}"
           aria-expanded="false"
        >
            {{ $item->name }}
        </a>
        <ul class="navbar-collapse collapse"
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
    <li style="padding: 5px;" class="nav-item">
        <a  class="user_select_cat_product" data-id-cat="{{ $item->id }}" view-id="{{$item->view_id}}" href="javascript:void(0)" class="nav-link">{{ $item->name }}</a>
    </li>
    @php
        }
    }
}

buildMenu($menuitems, 'mainMenu')
    @endphp
</ul>