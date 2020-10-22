<!-- Sidenav -->
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
                aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <div class="row">
                <div class="col-sm-12">
                    <img src="{{ getSingleMedia(settingSession('get'),'site_logo',null) }}" class="navbar-brand-img" alt="site_logo">
                </div>
{{--                <div class="col-sm-12">--}}
{{--                    <h1 class="text-primary m-2 mt-3"><b>{{env('APP_NAME', 'Granth')}}</b></h1>--}}
{{--                </div>--}}
            </div>
        </a>

        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <i class="ni ni-bell-55"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right"
                     aria-labelledby="navbar-default_dropdown_1">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="{{ asset('assets/img/theme/team-1-800x800.jpg') }}">
              </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome!</h6>
                    </div>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>My profile</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>Settings</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>Activity</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>Support</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#!" class="dropdown-item">
                        <i class="ni ni-user-run"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </li>
        </ul>

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <h1 class="text-primary m-2"><b>{{env('APP_NAME', 'Granth')}}</b></h1>
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#sidenav-collapse-main" aria-controls="sidenav-main"
                                aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended"
                           placeholder="Search" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Navigation -->
            @php
    
            $auth_user=authSession();
            $role_id=$auth_user->role_id;
            $college_id=$auth_user->college_id;
if($role_id===1){
//ADMIN LINKS
                $menu = Menu::new([                
                    Spatie\Menu\Link::to(route('home'),'<i class="ni ni-tv-2 text-primary"></i> '.trans('messages.home'))->addClass('nav-link'),
                    Spatie\Menu\Link::to(route('assistant.index'), '<i class="fas fa-user text-primary"></i> '.trans('messages.admin_assistant'))->addClass('nav-link'),
                    Spatie\Menu\Link::to(route('category.index'), '<i class="fas fa-list text-primary"></i> '.trans('messages.category'))->addClass('nav-link'),
                    Spatie\Menu\Link::to(route('college.index'), '<i class="fas fa-book text-primary"></i> '.trans('messages.college'))->addClass('nav-link'),
                    Spatie\Menu\Link::to(route('author.index'), '<i class="fas fa-user-edit text-primary"></i> '.trans('messages.contributors'))->addClass('nav-link'),
                    Spatie\Menu\Link::to(route('book.index'), '<i class="fas fa-book text-primary"></i> '.trans('messages.book'))->addClass('nav-link'), 
                    Spatie\Menu\Link::to(route('admin.settings'), '<i class="fas fa-cogs text-primary"></i> '.'Setting')->addClass('nav-link'),
                    Spatie\Menu\Link::to(route('term-condition'), '<i class="fas fa-handshake text-primary"></i> '.'Terms of Service')->addClass('nav-link'),
                    Spatie\Menu\Link::to(route('users_feedback'), '<i class="fas fa-comments text-primary"></i> '.'Users Feedback')->addClass('nav-link'),
                ])->addClass('navbar-nav');
}
elseif($role_id===5){
                $roles = array_map("trim", explode(";;", $auth_user->admin_assistant_roles));            
    
                $menu = Menu::new()
                ->add(Spatie\Menu\Link::to(route('home'),'<i class="ni ni-tv-2 text-primary"></i> '.trans('messages.home'))->addClass('nav-link'))
                ->addif(in_array("category", $roles, true), Spatie\Menu\Link::to(route('category.index'), '<i class="fas fa-list text-primary"></i> '.trans('messages.category'))->addClass('nav-link'))
                ->addif(in_array("college", $roles, true), Spatie\Menu\Link::to(route('college.index'), '<i class="fas fa-book text-primary"></i> '.trans('messages.college'))->addClass('nav-link'))
                ->addif(in_array("contributors", $roles, true), Spatie\Menu\Link::to(route('author.index'), '<i class="fas fa-user-edit text-primary"></i> '.trans('messages.contributors'))->addClass('nav-link'))
                ->addif(in_array("content", $roles, true), Spatie\Menu\Link::to(route('book.index'), '<i class="fas fa-book text-primary"></i> '.trans('messages.book'))->addClass('nav-link')) 
                ->addif(in_array("terms_of_service", $roles, true), Spatie\Menu\Link::to(route('term-condition'), '<i class="fas fa-handshake text-primary"></i> '.'Terms of Service')->addClass('nav-link'))
                ->addif(in_array("user_feedback", $roles, true), Spatie\Menu\Link::to(route('users_feedback'), '<i class="fas fa-comments text-primary"></i> '.'Users Feedback')->addClass('nav-link'))
                ->addClass('navbar-nav');
}
else{
//SUB ADMIN LINKS
                $menu = Menu::new([                
                    Spatie\Menu\Link::to(route('school.show', [$college_id]), '<i class="fas fa-book text-primary"></i> '.trans('messages.college'))->addClass('nav-link'),
                    Spatie\Menu\Link::to(route('school.tutor', [$college_id]), '<i class="fas fa-user-edit text-primary"></i> '.trans('messages.tutor'))->addClass('nav-link'),
                    Spatie\Menu\Link::to(route('school.student', [$college_id]), '<i class="fas fa-user text-primary"></i> '.trans('messages.student'))->addClass('nav-link'),
                ])->addClass('navbar-nav');
}
            @endphp
            {!! $menu->render() !!}
            <br>
            <span>{{'Version: '.config('app.version')}}</span>
        </div>
    </div>
</nav>