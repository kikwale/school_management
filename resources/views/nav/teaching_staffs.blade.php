<ul class="metismenu" id="menu">
    <?php $route = Route::current(); ?>
  <li class="panel @if (Request::is('admin')) active @endif" >
      <a href="home" >
          <i class="icon-home" ></i>&nbsp;Dashboard

      </a>                   
  </li>

  @if (Auth::user()->role == "Normal Teacher" || Auth::user()->role == "Accountant" || Auth::user()->role =="Head Master")
    <li class="panel ">
        <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"  data-target="#academic">
            <i class="icon-file-text-alt" > </i> &nbsp;Academics     

            <span class="pull-right">
            <i class="icon-angle-left"></i>
            </span>
        {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
        </a>
        <ul class="collapse" id="academic">
        
            <li class=""><a href="teacher-class-member"><i class="icon-minus-sign"></i> &nbsp;class Members </a></li>
            <li class=""><a href="record-results"><i class="icon-minus-sign"></i> &nbsp;Results Recording </a></li>
            
        </ul>
    </li>

    <li class="panel ">
        <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"  data-target="#attendence">
            <i class="icon-list-alt" > </i> &nbsp;Attendence Management     

            <span class="pull-right">
            <i class="icon-angle-left"></i>
            </span>
        {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
        </a>
        <ul class="collapse" id="attendence">
        
            <li class=""><a href="teacher-rollcall"><i class="icon-minus-sign"></i>&nbsp;&nbsp;RollCall </a></li>
            <li class=""><a href="button.html"><i class="icon-minus-sign"></i>&nbsp;&nbsp;Students Attendence </a></li>
            @if (Auth::user()->role == "Head Master" || Auth::user()->role == "Second Master")
            <li class=""><a href="icon.html"><i class="icon-minus-sign"></i>&nbsp;&nbsp;Teachers Attendence </a></li>
            <li class=""><a href="progress.html"><i class="icon-minus-sign"></i>&nbsp;&nbsp;Attendence Reports</a></li>
            @endif

        </ul>
    </li>

    @if (Auth::user()->role == "Head Master" || Auth::user()->role == "Accountant")
    <li class="panel ">
        <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"  data-target="#contribution">
            <i class="icon-suitcase" > </i>&nbsp;Contributions     
  
            <span class="pull-right">
              <i class="icon-angle-left"></i>
            </span>
           {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
        </a>
        <ul class="collapse" id="contribution">
           
            <li class=""><a href="teacher-add-contributions"><i class="icon-minus-sign"></i>&nbsp;Contributiions </a></li>
             <li class=""><a href="teacher-collect-contributions"><i class="icon-minus-sign"></i>&nbsp;Contribution Collections </a></li>
            <li class=""><a href="teacher-contribution-reports"><i class="icon-minus-sign"></i>&nbsp;Contribution Reports </a></li>
        </ul>
    </li>
    <li class="panel ">
        <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"  data-target="#fee">
            <i class="icon-suitcase" > </i>&nbsp;Fees     
  
            <span class="pull-right">
              <i class="icon-angle-left"></i>
            </span>
           {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
        </a>
        <ul class="collapse" id="fee">
           
            <li class=""><a href="teacher-add-fees"><i class="icon-minus-sign"></i>&nbsp;Fees </a></li>
             <li class=""><a href="teacher-collect-fees"><i class="icon-minus-sign"></i>&nbsp;Fee Collections </a></li>
            <li class=""><a href="teacher-fee-reports"><i class="icon-minus-sign"></i>&nbsp;Fee Reports </a></li>
        </ul>
    </li>
    @endif
  
    @if (Auth::user()->role == "Head Master")
    <li class="panel ">
        <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"  data-target="#component-nav">
            <i class="icon-archive" > </i>&nbsp;Admission Management     
  
            <span class="pull-right">
              <i class="icon-angle-left"></i>
            </span>
           {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
        </a>
        <ul class="collapse" id="component-nav">
           
            <li class=""><a href="admin-parents"><i class="icon-minus-sign"></i> &nbsp;Parents </a></li>
             <li class=""><a href="admin-students"><i class="icon-minus-sign"></i> &nbsp;Students </a></li>
        </ul>
    </li>

    <li class="panel ">
        <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"  data-target="#operation">
            <i class="icon-cogs" > </i>&nbsp;School Operations   
    
            <span class="pull-right">
              <i class="icon-angle-left"></i>
            </span>
           {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
        </a>
        <ul class="collapse" id="operation">
           
          <li class=""><a href="admin-class-students"><i class="icon-minus-sign"></i>&nbsp;Class Students </a></li>
          <li class=""><a href="admin-class-subjects"><i class="icon-minus-sign"></i>&nbsp;Class Subjects </a></li>
          <li class=""><a href="admin-class-teachers"><i class="icon-minus-sign"></i>&nbsp;Class Teachers </a></li>
        </ul>
    </li>

    <li class="panel ">
        <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"  data-target="#library">
            <i class="icon-book" > </i>&nbsp;&nbsp;Library Managements     
  
            <span class="pull-right">
              <i class="icon-angle-left"></i>
            </span>
           {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
        </a>
        <ul class="collapse" id="library">
           
            <li class=""><a href="teacher-books"><i class="icon-minus-sign"></i>&nbsp;&nbsp;Books </a></li>
             <li class=""><a href="teacher-library-users"><i class="icon-minus-sign"></i>&nbsp;&nbsp;Library Users </a></li>
            <li class=""><a href="teacher-borrowers"><i class="icon-minus-sign"></i>&nbsp;&nbsp;Book Borrowers </a></li>
        </ul>
    </li>
   
    <li class="panel ">
        <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"   data-target="#transport">
            <i class="icon-truck" > </i>&nbsp;&nbsp;Transport Managements    
  
            <span class="pull-right">
              <i class="icon-angle-left"></i>
            </span>
           {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
        </a>
        <ul class="collapse" id="transport">
           
            <li class=""><a href="teacher-vehicles"><i class="icon-minus-sign"></i>&nbsp;Vehicles </a></li>
            <li class=""><a href="teacher-routes"><i class="icon-minus-sign"></i>&nbsp;Routes </a></li>
            <li class=""><a href="teacher-stations"><i class="icon-minus-sign"></i>&nbsp;Stations </a></li>
            <li class=""><a href="teacher-vehicle-routes"><i class="icon-minus-sign"></i>&nbsp;Vehicle Routes & Stations </a></li>
            <li class=""><a href="teacher-station-members"><i class="icon-minus-sign"></i>&nbsp;Station Members </a></li>
        </ul>
    </li>
    <li class="panel ">
        <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"  data-target="#hostel">
            <i class="icon-home" > </i>&nbsp;Hostel Managements    
  
            <span class="pull-right">
              <i class="icon-angle-left"></i>
            </span>
           {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
        </a>
        <ul class="collapse" id="hostel">
           
            <li class=""><a href="button.html"><i class="icon-minus-sign"></i>&nbsp;Rooms </a></li>
            <li class=""><a href="progress.html"><i class="icon-minus-sign"></i>&nbsp;Room Members </a></li>
        </ul>
    </li>
   
    @endif

    <li class="panel ">
        <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"  data-target="#activity">
            <i class="icon-tasks" > </i>&nbsp;&nbsp;School Activities     

            <span class="pull-right">
            <i class="icon-angle-left"></i>
            </span>
        {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
        </a>
        <ul class="collapse" id="activity">
        
            <li class=""><a href="teacher-student-routine"><i class="icon-minus-sign"></i>&nbsp;&nbsp;Students Routine </a></li>
            <li class=""><a href="teacher-teacher-duties"><i class="icon-minus-sign"></i>&nbsp;&nbsp;Teacher on Duties </a></li>
            <li class=""><a href="teacher-class-time-table"><i class="icon-minus-sign"></i>&nbsp;&nbsp;Class Time Table </a></li>
            {{-- <li class=""><a href="tabs_panels.html"><i class="icon-minus-sign"></i>&nbsp;&nbsp;School Calender</a></li> --}}
        </ul>
    </li>
    <li class="panel ">
        <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"  data-target="#tool">
            <i class="icon-tasks" > </i>&nbsp;Teaching Tools    

            <span class="pull-right">
            <i class="icon-angle-left"></i>
            </span>
        {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
        </a>
        <ul class="collapse" id="tool">
        
            <li class=""><a href="button.html"><i class="icon-minus-sign"></i>&nbsp;Syllabus </a></li>
            <li class=""><a href="icon.html"><i class="icon-minus-sign"></i>&nbsp;Scheme of Work </a></li>
            <li class=""><a href="progress.html"><i class="icon-minus-sign"></i>&nbsp;Lesson Plan </a></li>
            <li class=""><a href="tabs_panels.html"><i class="icon-minus-sign"></i>&nbsp;Log Book</a></li>
        </ul>
    </li>
  @endif

 

 
  {{-- <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#e_learning">
          <i class="icon-folder-close" ></i>&nbsp;E-Learning 

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}
      </a>
      <ul class="collapse" id="e_learning" >
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i>&nbsp;Online Materials </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i>&nbsp;Online HomeWork </a></li>
          <li class=""><a href="progress.html"><i class="icon-minus-sign"></i>&nbsp;Online Tests </a></li>
          <li class=""><a href="tabs_panels.html"><i class="icon-minus-sign"></i>&nbsp;Online Exams</a></li>
      </ul>
  </li> --}}
 
  
</ul>