  <!-- HEADER SECTION -->
  <div id="top" style="background-color: rgb(10, 110, 77);">

    <nav class="navbar navbar-inverse navbar-fixed-top " style="padding-top: 10px;" >
        <a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
            <i class="icon-align-justify"></i>
        </a>
        <!-- LOGO SECTION -->
        <header class="navbar-header">

            <a href="index.html" class="navbar-brand">
           SCHOOL NAME: &nbsp; {{ Session::get('school_name') }}
                </a>
        </header>
        <!-- END LOGO SECTION -->
        <ul class="nav navbar-top-links navbar-right">

            <!-- MESSAGES SECTION -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <span class="label label-success">2</span>    <i class="icon-envelope-alt"></i>&nbsp; <i class="icon-chevron-down"></i>
                </a>

                <ul class="dropdown-menu dropdown-messages">
                    <li>
                        <a href="#">
                            <div>
                               <strong>John Smith</strong>
                                <span class="pull-right text-muted">
                                    <em>Today</em>
                                </span>
                            </div>
                            <div>Lorem ipsum dolor sit amet, consectetur adipiscing.
                                <br />
                                <span class="label label-primary">Important</span> 

                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <strong>Raphel Jonson</strong>
                                <span class="pull-right text-muted">
                                    <em>Yesterday</em>
                                </span>
                            </div>
                            <div>Lorem ipsum dolor sit amet, consectetur adipiscing.
                                 <br />
                                <span class="label label-success"> Moderate </span> 
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <strong>Chi Ley Suk</strong>
                                <span class="pull-right text-muted">
                                    <em>26 Jan 2014</em>
                                </span>
                            </div>
                            <div>Lorem ipsum dolor sit amet, consectetur adipiscing.
                                 <br />
                                <span class="label label-danger"> Low </span> 
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>Read All Messages</strong>
                            <i class="icon-angle-right"></i>
                        </a>
                    </li>
                </ul>

            </li>
            <!--END MESSAGES SECTION -->

            <!--TASK SECTION -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <span class="label label-danger">5</span>   <i class="icon-tasks"></i>&nbsp; <i class="icon-chevron-down"></i>
                </a>

                <ul class="dropdown-menu dropdown-tasks">
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong> Profile </strong>
                                    <span class="pull-right text-muted">40% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                        <span class="sr-only">40% Complete (success)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong> Pending Tasks </strong>
                                    <span class="pull-right text-muted">20% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                        <span class="sr-only">20% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong> Work Completed </strong>
                                    <span class="pull-right text-muted">60% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                        <span class="sr-only">60% Complete (warning)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong> Summary </strong>
                                    <span class="pull-right text-muted">80% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                        <span class="sr-only">80% Complete (danger)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>See All Tasks</strong>
                            <i class="icon-angle-right"></i>
                        </a>
                    </li>
                </ul>

            </li>
            <!--END TASK SECTION -->

            <!--ALERTS SECTION -->
            <li class="chat-panel dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <span class="label label-info">8</span>   <i class="icon-comments"></i>&nbsp; <i class="icon-chevron-down"></i>
                </a>

                <ul class="dropdown-menu dropdown-alerts">

                    <li>
                        <a href="#">
                            <div>
                                <i class="icon-comment" ></i> New Comment
                            <span class="pull-right text-muted small"> 4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="icon-twitter info"></i> 3 New Follower
                            <span class="pull-right text-muted small"> 9 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="icon-envelope"></i> Message Sent
                            <span class="pull-right text-muted small" > 20 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="icon-tasks"></i> New Task
                            <span class="pull-right text-muted small"> 1 Hour ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="icon-upload"></i> Server Rebooted
                            <span class="pull-right text-muted small"> 2 Hour ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>See All Alerts</strong>
                            <i class="icon-angle-right"></i>
                        </a>
                    </li>
                </ul>

            </li>
            <!-- END ALERTS SECTION -->

            <!--ADMIN SETTINGS SECTIONS -->

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="icon-user "></i>&nbsp; <i class="icon-chevron-down "></i>
                </a>

                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="icon-user"></i> User Profile </a>
                    </li>
                    <li><a href="#"><i class="icon-gear"></i> Settings </a>
                    </li>
                    <li class="divider"></li>
                    <li><a  href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();"><i class="icon-signout"></i> Logout </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>

            </li>
            <!--END ADMIN SETTINGS -->
        </ul>

    </nav>

</div>
<!-- END HEADER SECTION -->

        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->
          <!--**********************************
            Sidebar start
        ***********************************-->
    
        <!-- MENU SECTION -->
        <div id="left">
            <div class="media user-media well-small"  >
                <a class="user-link" href="#">
                    <img class="media-object img-thumbnail user-img" alt="User Picture" src="{{ auth()->user()->photo }}" width="64" height="64" />
                </a>
                <br />
                <div class="media-body" >
                    <h5 class="media-heading"> {{ Auth::user()->lname }}</h5>
                    <ul class="list-unstyled user-info">
                        
                        <li>
                             <a class="btn btn-success btn-xs btn-circle" style="width: 10px;height: 12px;"></a> Online
                           
                        </li>
                       
                    </ul>
                </div>
                <br />
            </div>

                @if (Auth::user()->role == 'Head Master' 
                || Auth::user()->role == 'Normal Teacher'
                || Auth::user()->role == "Accountant" )
                @include('nav.teaching_staffs')
                @endif
                @if (Auth::user()->role == 'Admin')
                @include('nav.admin')
                @endif
                @if (Auth::user()->role == 'Manager')
                @include('nav.manager')
                @endif
                @if (Auth::user()->role == 'Super Admin')
                @include('nav.super_admin')
                @endif
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->  
  