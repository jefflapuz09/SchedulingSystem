    <!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="http://scheduling.local/images/avatar5.png" class="img-circle" alt="User Imge"  />
                   <!-- <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Imge"  />--> 
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
             </div>
        @endif

        <!-- search form (Optional) -->
<!--        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>-->
        <!-- /.search form -->

        <!-- Sidebar Menu -->
       <!-- <ul class="sidebar-menu">
            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>-->
            <!-- Optionally, you can add icons to the links -->
            <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU</li>
            <li class="active"><a href="{{ url('home') }}"><i class='fa fa-home '></i> <span>Home</span></a></li>
            
        <li><a href="/admin/faculty_loading"><i class='fa  fa-list'></i> <span>Faculty Loading</span></a></li>
        
        <li class="treeview">
            <a href="#"><i class="fa fa-gears"></i> <span>Maintenance Management</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
            <ul class="treeview-menu">
                <li><a href="/admin/section_management"><i class='fa fa-gear'></i> <span>Section Management </span></a></li>
                <li><a href="/admin/room_management"><i class='fa  fa-gear'></i> <span>Room Management</span></a></li>
                </ul>
            </li>

        <li class="treeview">
            <a href="#"><i class="fa fa-folder"></i> <span>Curriculum Management</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
            <ul class="treeview-menu">
            <li><a href="/admin/curiculum_management/curriculum"><i class='fa fa-edit'></i> <span>Curriculum</span></a></li>
            <li><a href="/admin/course_offerings"><i class='fa fa-edit'></i> <span>Course Offering</span></a></li>
            <li><a href="/admin/course_scheduling"><i class='fa fa-edit'></i> <span>Course Scheduling</span></a></li>
                </ul>
            </li>

            
        <li class="treeview">
            <a href="#"><i class="fa fa-male"></i> <span>Instructor</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
        <ul class="treeview-menu">
                <li><a href="/admin/instructor/add_instructor"><i class="fa fa-user-plus"></i> <span>Add Instructor</span></a></li>
                <li><a href="/admin/instructor/view_instructor_account"><i class="fa fa-circle-o"></i> <span>View Instructors</span></a></li>
                </ul>
                </li>
              
        <li class="treeview">
            <a href="#"><i class="fa fa-pencil"></i> <span>Reports</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
        <ul class="treeview-menu">
                <li><a href="/admin/instructor/instructor_reports"><i class="fa fa-circle-o"></i> <span>Instructor Reports</span></a></li>
                <li><a href="{{url('/admin/reports/rooms_occupied')}}"><i class="fa fa-circle-o"></i> <span>Rooms Occupied</span></a></li>
                <li><a href="{{url('/admin/reports/rooms_occupied')}}"><i class="fa fa-circle-o"></i> <span>System Manual</span></a></li>                
                </ul> 
                </li>
                         
                
        <?php $notifications = \App\LoadNotification::where('is_trash',0)->get();?>
                <li class="active"><a href="{{ url('/admin/notification') }}"><i class='fa fa-bell-o '></i> <span>Notifications</span> @if(count($notifications)>0)<label class="label label-warning text-warning"><i class="">{{$notifications->count()}}</i></label> @endif </a></li>
                <li class=""><a href="{{ url('/account/change_password') }}"><i class='fa fa-lock '></i> <span>Change Password</span></a></li>

    <!--<li><a href="/admin/add_curriculum"><i class='fa fa-folder'></i> <span>Add Curriculum</span></a></li>-->
<!--            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>{{ trans('adminlte_lang::message.multilevel') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">{{ trans('adminlte_lang::message.linklevel2') }}</a></li>
                    <li><a href="#">{{ trans('adminlte_lang::message.linklevel2') }}</a></li>
                </ul>
            </li>-->
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
