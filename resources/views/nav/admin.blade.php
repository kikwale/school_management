<ul class="metismenu" id="menu">
    <?php $route = Route::current(); ?>
  <li class="panel @if (Request::is('admin')) active @endif" >
      <a href="home" style="color:rgb(70, 68, 68)" >
          <i class="icon-home" style="color:rgb(245, 198, 128)"></i> Dashboard

      </a>                   
  </li>

  <li class="panel  @if (Request::is('admin-teaching-staffs') || Request::is('admin-non-teaching-staffs')) active   @endif">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" style="color:rgb(70, 68, 68)" data-target="#staffs">
          <i class="icon-user-md" style="color:rgb(245, 198, 128)"> </i> Staffs

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="staffs">
         
          <li class="@if (Request::is('admin-teaching-staffs')) active @endif"><a href="admin-teaching-staffs"><i class="icon-minus-sign"></i> Teaching Staffs </a></li>
           <li class="@if (Request::is('admin-non-teaching-staffs')) active @endif"><a href="admin-non-teaching-staffs"><i class="icon-minus-sign"></i> Non-Teaching Staffs </a></li>
      </ul>
  </li>
  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" style="color:rgb(70, 68, 68)" data-target="#create">
          <i class="icon-pencil" style="color:rgb(245, 198, 128)"> </i> Create     

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="create">
         
          <li class=""><a href="admin-create-classes"><i class="icon-minus-sign"></i> Classes </a></li>
          <li class=""><a href="admin-create-terms"><i class="icon-minus-sign"></i> Terms </a></li>
           <li class=""><a href="admin-create-streams-combs"><i class="icon-minus-sign"></i> Streams/Combinations </a></li>
          <li class=""><a href="admin-create-subjects"><i class="icon-minus-sign"></i> Subjects </a></li> 
      </ul>
  </li>
  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" style="color:rgb(70, 68, 68)" data-target="#contribution">
          <i class="icon-suitcase" style="color:rgb(245, 198, 128)"> </i> Contributions     

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="contribution">
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i> Add Contributiion </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i> Contribution Collections </a></li>
          <li class=""><a href="progress.html"><i class="icon-minus-sign"></i> Contribution Reports </a></li>
      </ul>
  </li>
  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" style="color:rgb(70, 68, 68)" data-target="#fee">
          <i class="icon-suitcase" style="color:rgb(245, 198, 128)"> </i> Fees     

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="fee">
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i> Add Fee </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i> Fee Collections </a></li>
          <li class=""><a href="progress.html"><i class="icon-minus-sign"></i> Fee Reports </a></li>
      </ul>
  </li>
  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" style="color:rgb(70, 68, 68)" data-target="#component-nav">
          <i class="icon-archive" style="color:rgb(245, 198, 128)"> </i> Admission Management     

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="component-nav">
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i> Parents </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i> Students </a></li>
      </ul>
  </li>
  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" style="color:rgb(70, 68, 68)" data-target="#academic">
          <i class="icon-file-text-alt" style="color:rgb(245, 198, 128)"> </i> Academics     

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="academic">
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i> Student Progress </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i> Results Recording </a></li>
      </ul>
  </li>
  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" style="color:rgb(70, 68, 68)" data-target="#attendence">
          <i class="icon-list-alt" style="color:rgb(245, 198, 128)"> </i> Attendence Management     

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="attendence">
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i> Students Attendence </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i> Teachers Attendence </a></li>
          <li class=""><a href="progress.html"><i class="icon-minus-sign"></i> Attendence Reports</a></li>
      </ul>
  </li>
  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" style="color:rgb(70, 68, 68)" data-target="#activity">
          <i class="icon-tasks" style="color:rgb(245, 198, 128)"> </i> School Activities     

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="activity">
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i> Students Routine </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i> Teacher on Duties </a></li>
          <li class=""><a href="progress.html"><i class="icon-minus-sign"></i> Class Time Table </a></li>
          <li class=""><a href="tabs_panels.html"><i class="icon-minus-sign"></i> School Calender</a></li>
      </ul>
  </li>
 
  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" style="color:rgb(70, 68, 68)" data-target="#library">
          <i class="icon-book" style="color:rgb(245, 198, 128)"> </i> Library Managements     

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="library">
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i> Books </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i> Library Users </a></li>
          <li class=""><a href="progress.html"><i class="icon-minus-sign"></i> Issue </a></li>
      </ul>
  </li>
 
  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"  style="color:rgb(70, 68, 68)" data-target="#transport">
          <i class="icon-truck" style="color:rgb(245, 198, 128)"> </i>Transport Managements    

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="transport">
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i>Vehicles </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i> Routes </a></li>
          <li class=""><a href="progress.html"><i class="icon-minus-sign"></i> Routes Members </a></li>
      </ul>
  </li>
  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" style="color:rgb(70, 68, 68)" data-target="#hostel">
          <i class="icon-home" style="color:rgb(245, 198, 128)"> </i>Hostel Managements    

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="hostel">
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i> Rooms </a></li>
          <li class=""><a href="progress.html"><i class="icon-minus-sign"></i> Room Members </a></li>
      </ul>
  </li>
 
  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" style="color:rgb(70, 68, 68)" data-target="#tool">
          <i class="icon-tasks" style="color:rgb(245, 198, 128)"> </i> Teaching Tools    

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="tool">
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i> Syllabus </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i> Scheme of Work </a></li>
          <li class=""><a href="progress.html"><i class="icon-minus-sign"></i> Lesson Plan </a></li>
          <li class=""><a href="tabs_panels.html"><i class="icon-minus-sign"></i> Log Book</a></li>
      </ul>
  </li>
 
  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" style="color:rgb(70, 68, 68)" data-target="#payroll">
          <i class="icon-credit-card" style="color:rgb(245, 198, 128)"> </i> Payroll Managements     

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="payroll">
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i> Deduction </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i> Overtime </a></li>
          <li class=""><a href="progress.html"><i class="icon-minus-sign"></i> Pension Funds </a></li>
          <li class=""><a href="tabs_panels.html"><i class="icon-minus-sign"></i> Allowances</a></li>
          <li class=""><a href="tabs_panels.html"><i class="icon-minus-sign"></i> Loans</a></li>
          <li class=""><a href="tabs_panels.html"><i class="icon-minus-sign"></i> Salary</a></li>
      </ul>
  </li>
 
  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" style="color:rgb(70, 68, 68)" data-target="#setting">
          <i class="icon-cogs" style="color:rgb(245, 198, 128)"> </i> Settings & Promotion     

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="setting">
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i> Academic Year </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i> Class Students </a></li>
          <li class=""><a href="progress.html"><i class="icon-minus-sign"></i> Class Subjects </a></li>
          <li class=""><a href="tabs_panels.html"><i class="icon-minus-sign"></i> Class Teachers </a></li>
          <li class=""><a href="tabs_panels.html"><i class="icon-minus-sign"></i> Set Fee </a></li>
          <li class=""><a href="tabs_panels.html"><i class="icon-minus-sign"></i> Set Contribution </a></li>
      </ul>
  </li>
 
  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" style="color:rgb(70, 68, 68)" data-target="#e_learning">
          <i class="icon-folder-close" style="color:rgb(245, 198, 128)"></i> E-Learning 

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="e_learning" >
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i> Online Materials </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i> Online HomeWork </a></li>
          <li class=""><a href="progress.html"><i class="icon-minus-sign"></i> Online Tests </a></li>
          <li class=""><a href="tabs_panels.html"><i class="icon-minus-sign"></i> Online Exams</a></li>
      </ul>
  </li>
 
  
</ul>