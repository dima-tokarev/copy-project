<div class="mobile-menu"></div>
<br>
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <div class="menubar">
                <nav id="mobile-menu" class="menu-header-menu-container" style="display: block;">
                    <ul id="menu-header-menu" class="menu">

                        <li>
                            <a style="color: gray" href="javascript:void(0);">B2G</a>
                            <ul class="sub-menu">
                                <li style="width: 100%">
                              {{--     <a href="#">Управление работами</a>--}}
                                    <ul style="color: gray" class="sub-menu">
                                      {{--  <li><a style="color: gray" href="#">Предварительные работы</a></li>--}}

                                          <li><a href="{{route('preworks.index')}}">Предварительные работы</a></li>
                                       <li><a href="#">Подготовка контракта</a></li>
                                    </ul>
                                </li>
                                {{--    <li>
                                <a href="#">Заголовок</a>--}}
                              {{--      <ul class="sub-menu">
                                        <li><a href="#">пункт меню</a></li>
                                        <li><a href="#">пункт меню</a></li>
                                        <li><a href="#">пункт меню</a></li>
                                        <li><a href="#">пункт меню</a></li>
                                    </ul>
                                </li>
                                --}}
                                {{--    <li>
                                {{--   <a href="#">Заголовок</a>--}}
                                 {{--   <ul class="sub-menu">
                                        <li><a href="#">пункт меню</a></li>
                                        <li><a href="#">пункт меню</a></li>
                                        <li><a href="#">пункт меню</a></li>
                                        <li><a href="#">пункт меню</a></li>
                                    </ul>
                                </li>
                                --}}
                            </ul>
                        </li>
                        <li><a  style="color: gray" href="javascript:void(0);">Пункт 1</a></li>
                        <li><a style="color:gray" href="javascript:void(0);">Пункт 2</a></li>
                        @canany(['edit_attr_admin','edit_attr_leader','edit_attr_manager'])
                            <li>
                                <a style="color: gray;" href="#">Администрирование</a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="#">Справочники</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{route('clients.index')}}">Клиенты</a></li>
                                            <li></li>

                                        </ul>
                                    </li>
                                    @canany(['edit_attr_admin'])
                                    <li>
                                        <a href="#">Управление</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{route('users.index')}}">Пользователи</a></li>
                                           <li></li>
                                        </ul>
                                    </li>
                                    @endcanany
                            {{--        @canany(['edit_attr_admin'])--}}
                                        <li>
                                            <a href="#">Каталог</a>
                                            <ul class="sub-menu">
                                                <li><a href="{{route('catalog_index')}}">Каталог</a></li>
                                                <li><a href="{{route('block_attribute')}}">Атрибуты</a></li>
                                                <li><a href="{{route('cat_all')}}">Категории-блоки</a></li>
                                            </ul>
                                        </li>
                             {{--       @endcanany--}}
                                </ul>
                            </li>
                           @endcanany
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
