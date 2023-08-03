            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            @foreach ($sidebarItems as $item)
                                @if (!$item->get('route') and $item->get('inner') === null)
                                    <li class="menu-title" key="t-menu">{{ $item['title'] }}</li>
                                @elseif($item->get('route') and !is_array($item->get('inner')))
                                    <li class="{{ $item->get('is_active_route') ? 'mm-active' : '' }}">
                                        <a href="{{ route($item->get('route'), $item->get('params') ?? []) }}"
                                            class="waves-effect">
                                            {!! $item->get('icon') !!}<span>{{ $item->get('title') }}</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="{{ $item->get('is_active_route') ? 'mm-active' : '' }}">
                                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                                            {!! $item->get('icon') !!}
                                            <span key="t-dashboards">{{ $item->get('title') }}</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            @foreach ($item->get('inner') as $inner)
                                                <li><a href="{{ route($inner->get('route')) }}" key="t-default"
                                                        class="{{ $inner->get('isActiveGroup') ? 'active' : '' }}">{{ $inner->get('title') }}</a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </li>
                                @endif
                            @endforeach




                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->
