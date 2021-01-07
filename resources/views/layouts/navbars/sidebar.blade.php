<div class="sidebar"
     data-color="{{ array_key_exists( 'sidebar-color', $_COOKIE ) ? $_COOKIE['sidebar-color'] : 'blue' }}">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
  -->
    <div class="logo">
        <a href="https://dealertower.com" class="simple-text logo-mini">
            {{ __(' DT') }}
        </a>
        <a href="https://dealertower.com" class="simple-text logo-normal">
            {{ __(' DealerTower') }}
        </a>
        <div class="navbar-minimize">
            <button id="minimizeSidebar" class="btn btn-simple btn-icon btn-neutral btn-round">
                <i class="now-ui-icons text_align-center visible-on-sidebar-regular"></i>
                <i class="now-ui-icons design_bullet-list-67 visible-on-sidebar-mini"></i>
            </button>
        </div>
    </div>
    <div class="sidebar-wrapper" id="sidebar-wrapper">

        <div class="user">
            <div class="photo">
                <img style="max-height:100%; max-width:none; width:auto;" src="{{ auth()->user()->profilePicture() }}"/>
            </div>
            <div class="info">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                <span>
                  {{ auth()->user()->name }}
                  <b class="caret"></b>
                </span>
                </a>
                <div class="clearfix"></div>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li>
                            <a href="{{ route('profile.edit') }}">
                                <span class="sidebar-mini-icon">{{ __("MP") }}</span>
                                <span class="sidebar-normal">{{ __("My Profile") }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('profile.edit')}}">
                                <span class="sidebar-mini-icon">{{ __("EP") }}</span>
                                <span class="sidebar-normal">{{ __("Edit Profile") }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="sidebar-mini-icon">{{ __("ST") }}</span>
                                <span class="sidebar-normal">{{ __("Settings") }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                                <span class="sidebar-mini-icon">{{ __("LG") }}</span>
                                <span class="sidebar-normal">{{ __("Logout") }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <ul class="nav">

            <li class="@if ($activePage === 'home') active @endif">
                <a href="{{ route('home') }}">
                    <i class="now-ui-icons design_app"></i>
                    <p>{{ __('Overview') }}</p>
                </a>
            </li>
            @can('manage-users', App\User::class)
            <li>
                <a data-toggle="collapse" href="#hosting">
                    <i class="now-ui-icons shopping_credit-card"></i>
                    <p>
                        {{ __("Hosting Services") }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse @if ($activeNav ?? '' == 'hosting') show @endif" id="hosting">
                    <ul class="nav">
                        <li class="@if ($activePage == 'credentials') active @endif">
                            <a href="{{ route('page.index','credentials') }}">
                                <span class="sidebar-mini-icon">{{ __("C") }}</span>
                                <span class="sidebar-normal"> {{ __("Credentials") }} </span>
                            </a>
                        </li>
                        <li class="@if ($activePage == 'domain') active @endif">
                            <a href="{{ route('page.index','domain') }}">
                                <span class="sidebar-mini-icon">{{ __("PD") }}</span>
                                <span class="sidebar-normal"> {{ __("Point Domain") }} </span>
                            </a>
                        </li>
                        <li class="@if ($activePage == 'tools') active @endif">
                            <a href="{{ route('page.index','tools') }}">
                                <span class="sidebar-mini-icon">{{ __("T") }}</span>
                                <span class="sidebar-normal"> {{ __("Tools") }} </span>
                            </a>
                        </li>
                        <li class="@if ($activePage == 'restore') active @endif">
                            <a href="{{ route('page.index','restore') }}">
                                <span class="sidebar-mini-icon">{{ __("RP") }}</span>
                                <span class="sidebar-normal"> {{ __("Restore points") }} </span>
                            </a>
                        </li>
                        <li class="@if ($activePage == 'resource') active @endif">
                            <a href="{{ route('page.index','resource') }}">
                                <span class="sidebar-mini-icon">{{ __("RU") }}</span>
                                <span class="sidebar-normal"> {{ __("Resource usage") }} </span>
                            </a>
                        </li>
                        <li class="@if ($activePage == 'logs') active @endif">
                            <a href="{{ route('page.index','logs') }}">
                                <span class="sidebar-mini-icon">{{ __("L") }}</span>
                                <span class="sidebar-normal"> {{ __("Logs") }} </span>
                            </a>
                        </li>
                        <li class="@if ($activePage == 'staging') active @endif">
                            <a href="{{ route('page.index','staging') }}">
                                <span class="sidebar-mini-icon">{{ __("SE") }}</span>
                                <span class="sidebar-normal"> {{ __("Staging Environment") }} </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endcan

            {{-- USERS --}}
            <li>
                <a data-toggle="collapse" href="#laravelExamples">
                    <i class="fa fa-users"></i>
                    <p>
                        {{ __('Users') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="laravelExamples">
                    <ul class="nav">
                        <li class="@if ($activePage == 'profile') active @endif">
                            <a href="{{ route('profile.edit') }}">
                                <span class="sidebar-mini-icon">{{ __("P") }}</span>
                                <span class="sidebar-normal"> {{ __("Profile") }} </span>
                            </a>
                        </li>
                        @can('manage-users', App\User::class)
                            <li class="@if ($activePage == 'roles') active @endif">
                                <a href="{{ route('role.index') }}">
                                    <span class="sidebar-mini-icon">{{ __("RL") }}</span>
                                    <span class="sidebar-normal"> {{ __("Role Management") }} </span>
                                </a>
                            </li>
                        @endcan
                        @can('manage-users', App\User::class)
                            <li class="@if ($activePage == 'users') active @endif">
                                <a href="{{ route('user.index') }}">
                                    <span class="sidebar-mini-icon">{{ __("US") }}</span>
                                    <span class="sidebar-normal"> {{ __("User Management") }} </span>
                                </a>
                            </li>
                        @endcan
                        @can('manage-items', App\User::class)
                            <li class="@if ($activePage == 'categories') active @endif">
                                <a href="{{ route('category.index') }}">
                                    <span class="sidebar-mini-icon">{{ __("CA") }}</span>
                                    <span class="sidebar-normal"> {{ __("Category Management") }} </span>
                                </a>
                            </li>
                        @endcan
                        @can('manage-items', App\User::class)
                            <li class="@if ($activePage == 'tags') active @endif">
                                <a href="{{ route('tag.index') }}">
                                    <span class="sidebar-mini-icon">{{ __("TG") }}</span>
                                    <span class="sidebar-normal"> {{ __("Tag Management") }} </span>
                                </a>
                            </li>
                        @endcan
                        @can('manage-items', App\User::class)
                            <li class="@if ($activePage == 'items') active @endif">
                                <a href="{{ route('item.index') }}">
                                    <span class="sidebar-mini-icon">{{ __("IT") }}</span>
                                    <span class="sidebar-normal"> {{ __("Item Management") }} </span>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('item.index') }}">
                                    <span class="sidebar-mini-icon">{{ __("IT") }}</span>
                                    <span class="sidebar-normal"> {{ __("Items") }} </span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>

            {{-- SITES --}}
            <li>
                <a data-toggle="collapse" href="#sites">
                    <i class="fa fa-asterisk"></i>
                    <p>
                        {{ __('Sites') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="sites">
                    <ul class="nav">
                        @can('manage-my-sites', App\Site::class)
                            <li class="@if ($activePage === 'sites') active @endif">
                                <a href="{{ route('sites.index') }}">
                                    <span class="sidebar-mini-icon">{{ __('L') }}</span>
                                    <span class="sidebar-normal"> {{ __('List') }} </span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
            <li class="@if ($activePage == 'plugins') active @endif">
                <a href="{{ route('page.index','plugins') }}">
                    <i class="now-ui-icons ui-2_settings-90"></i>
                    <p>{{ __(" Plugins ") }}</p>
                </a>
            </li>
            <li class="@if ($activePage == 'seo') active @endif">
                <a href="{{ route('page.index','seo') }}">
                    <i class="now-ui-icons business_chart-bar-32"></i>
                    <p>{{ __(" SEO ") }}</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#pagesExamples">
                    <i class="now-ui-icons design_image"></i>
                    <p>
                        {{ __("Pages") }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse @if ($activeNav ?? '' == 'pages') show @endif" id="pagesExamples">
                    <ul class="nav">
                        <li class="@if ($activePage == 'support') active @endif">
                            <a href="{{ route('page.index','support') }}">
                                <span class="sidebar-mini-icon">{{ __("RS") }}</span>
                                <span class="sidebar-normal"> {{ __("RTL Support") }} </span>
                            </a>
                        </li>
                        <li class="@if ($activePage == 'timeline') active @endif">
                            <a href="{{ route('page.index','timeline') }}">
                                <span class="sidebar-mini-icon">{{ __("T") }}</span>
                                <span class="sidebar-normal"> {{ __("Timeline") }} </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @if( auth()->user()->isAdmin() )
                <li>
                    <a data-toggle="collapse" href="#componentsExamples">
                        <i class="now-ui-icons education_atom"></i>
                        <p>
                            {{ __("Components") }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse @if ($activeNav ?? '' == 'components') show @endif" id="componentsExamples">
                        <ul class="nav">
                            <li class="@if ($activePage == 'buttons') active @endif">
                                <a href="{{ route('page.index','buttons') }}">
                                    <span class="sidebar-mini-icon">{{ __("B") }}</span>
                                    <span class="sidebar-normal"> {{ __("Buttons ") }}</span>
                                </a>
                            </li>
                            <li class="@if ($activePage == 'grid') active @endif">
                                <a href="{{ route('page.index','grid') }}">
                                    <span class="sidebar-mini-icon">{{ __("G") }}</span>
                                    <span class="sidebar-normal"> {{ __("Grid System") }} </span>
                                </a>
                            </li>
                            <li class="@if ($activePage == 'panels') active @endif">
                                <a href="{{ route('page.index','panels') }}">
                                    <span class="sidebar-mini-icon">{{ __("P") }}</span>
                                    <span class="sidebar-normal"> {{ __("Panels") }} </span>
                                </a>
                            </li>
                            <li class="@if ($activePage == 'alert') active @endif">
                                <a href="{{ route('page.index','sweet-alert') }}">
                                    <span class="sidebar-mini-icon">{{ __("SA") }}</span>
                                    <span class="sidebar-normal"> {{ __("Sweet Alert") }} </span>
                                </a>
                            </li>
                            <li class="@if ($activePage == 'notifications') active @endif">
                                <a href="{{ route('page.index','notifications') }}">
                                    <span class="sidebar-mini-icon">{{ __("N") }}</span>
                                    <span class="sidebar-normal"> {{ __("Notifications") }} </span>
                                </a>
                            </li>
                            <li class="@if ($activePage == 'icons') active @endif">
                                <a href="{{ route('page.index','icons') }}">
                                    <span class="sidebar-mini-icon">{{ __("I") }}</span>
                                    <span class="sidebar-normal"> {{ __("Icons") }} </span>
                                </a>
                            </li>
                            <li class="@if ($activePage == 'typography') active @endif">
                                <a href="{{ route('page.index','typography') }}">
                                    <span class="sidebar-mini-icon">{{ __("T") }}</span>
                                    <span class="sidebar-normal"> {{ __("Typography") }} </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a data-toggle="collapse" href="#formsExamples">
                        <i class="now-ui-icons files_single-copy-04"></i>
                        <p>
                            {{ __("Forms") }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse @if ($activeNav ?? '' == 'forms') show @endif" id="formsExamples">
                        <ul class="nav">
                            <li class="@if ($activePage == 'regular') active @endif">
                                <a href="{{ route('page.index','regular') }}">
                                    <span class="sidebar-mini-icon">{{ __("RF") }}</span>
                                    <span class="sidebar-normal">  {{ __("Regular Forms") }}</span>
                                </a>
                            </li>
                            <li class="@if ($activePage == 'extended') active @endif">
                                <a href="{{ route('page.index','extended') }}">
                                    <span class="sidebar-mini-icon">{{ __("EF") }}</span>
                                    <span class="sidebar-normal"> {{ __("Extended Forms") }} </span>
                                </a>
                            </li>
                            <li class="@if ($activePage == 'validation') active @endif">
                                <a href="{{ route('page.index','validation') }}">
                                    <span class="sidebar-mini-icon">{{ __("V") }}</span>
                                    <span class="sidebar-normal">  {{ __("Validation Forms") }}</span>
                                </a>
                            </li>
                            <li class="@if ($activePage == 'wizard') active @endif">
                                <a href="{{ route('page.index','wizard') }}">
                                    <span class="sidebar-mini-icon">{{ __("W") }}</span>
                                    <span class="sidebar-normal">  {{ __("Wizard") }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a data-toggle="collapse" href="#tablesExamples">
                        <i class="now-ui-icons design_bullet-list-67"></i>
                        <p>
                            {{ __("Tables") }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse @if ($activeNav ?? '' == 'tables') show @endif" id="tablesExamples">
                        <ul class="nav">
                            <li class="@if ($activePage == 'regulartab') active @endif">
                                <a href="{{ route('page.index','regulart') }}">
                                    <span class="sidebar-mini-icon">{{ __("RT") }}</span>
                                    <span class="sidebar-normal">  {{__("Regular Tables")}}</span>
                                </a>
                            </li>
                            <li class="@if ($activePage == 'extendedtab') active @endif">
                                <a href="{{ route('page.index','extendedt') }}">
                                    <span class="sidebar-mini-icon">{{ __("ET") }}</span>
                                    <span class="sidebar-normal">  {{ __("Extended Tables") }}</span>
                                </a>
                            </li>
                            <li class="@if ($activePage == 'datatables') active @endif">
                                <a href="{{ route('page.index','datatables') }}">
                                    <span class="sidebar-mini-icon">{{ __("DT") }}</span>
                                    <span class="sidebar-normal"> {{ __("DataTables.net") }} </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a data-toggle="collapse" href="#mapsExamples">
                        <i class="now-ui-icons location_pin"></i>
                        <p>
                            {{ __("Maps") }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse @if ($activeNav ?? '' == 'maps') show @endif" id="mapsExamples">
                        <ul class="nav">
                            <li class="@if ($activePage == 'google') active @endif">
                                <a href="{{ route('page.index','google') }}">
                                    <span class="sidebar-mini-icon">{{ __("GM") }}</span>
                                    <span class="sidebar-normal"> {{ __("Google Maps") }} </span>
                                </a>
                            </li>
                            <li class="@if ($activePage == 'fullscreen') active @endif">
                                <a href="{{ route('page.index','fullscreen') }}">
                                    <span class="sidebar-mini-icon">{{ __("FM") }}</span>
                                    <span class="sidebar-normal"> {{ __(" Full Screen Map") }}</span>
                                </a>
                            </li>
                            <li class="@if ($activePage == 'vector') active @endif">
                                <a href="{{ route('page.index','vector') }}">
                                    <span class="sidebar-mini-icon">{{ __("VM") }}</span>
                                    <span class="sidebar-normal"> {{ __(" Vector Map") }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="@if ($activePage == 'wordpress') active @endif">
                    <a href="{{ route('page.index','wordpress') }}">
                        <i class="now-ui-icons design-2_ruler-pencil"></i>
                        <p>{{ __(" Wordpress Themes ") }}</p>
                    </a>
                </li>
                <li class="@if ($activePage == 'backups') active @endif">
                    <a href="{{ route('page.index','backups') }}">
                        <i class="now-ui-icons arrows-1_cloud-upload-94"></i>
                        <p>{{ __(" Backups ") }}</p>
                    </a>
                </li>
                <li class="@if ($activePage == 'security') active @endif">
                    <a href="{{ route('page.index','security') }}">
                        <i class="now-ui-icons objects_support-17"></i>
                        <p>{{ __(" Security ") }}</p>
                    </a>
                </li>
                <li class="@if ($activePage == 'widgets') active @endif">
                    <a href="{{ route('page.index','widgets') }}">
                        <i class="now-ui-icons objects_diamond"></i>
                        <p>{{ __(" Widgets") }}</p>
                    </a>
                </li>
                <li class="@if ($activePage == 'charts') active @endif">
                    <a href="{{ route('page.index','charts') }}">
                        <i class="now-ui-icons business_chart-pie-36"></i>
                        <p>{{ __(" Charts") }}</p>
                    </a>
                </li>
                <li class="@if ($activePage == 'calendar') active @endif">
                    <a href="{{ route('page.index','calendar') }}">
                        <i class="now-ui-icons media-1_album"></i>
                        <p>{{ __(" Calendar") }}</p>
                    </a>
                </li>
                <li class="@if ($activePage == 'readme') active @endif">
                    <a href="{{ route('page.index','readme') }}">
                        <i class="now-ui-icons files_single-copy-04"></i>
                        <p>{{ __(" Read me") }}</p>
                    </a>
                </li>
            @endif
        </ul>

    </div>
</div>