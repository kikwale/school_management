<ul class="metismenu" id="menu">
    <?php $route = Route::current(); ?>
  <li class="panel @if (Request::is('admin')) active @endif" >
      <a href="home" >
          <i class="icon-home" ></i>&nbsp;Dashboard

      </a>                   
  </li>

  <li class="panel  @if (Request::is('admin-teaching-staffs') || Request::is('admin-non-teaching-staffs')) active   @endif">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"  data-target="#staffs">
          <i class="icon-user-md" > </i>&nbsp;Staffs

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="staffs">
         
          <li class="@if (Request::is('admin-teaching-staffs')) active @endif"><a href="admin-teaching-staffs"><i class="icon-minus-sign"></i>&nbsp;Teaching Staffs </a></li>
           <li class="@if (Request::is('admin-non-teaching-staffs')) active @endif"><a href="admin-non-teaching-staffs"><i class="icon-minus-sign"></i>&nbsp;Non-Teaching Staffs </a></li>
      </ul>
  </li>
  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"  data-target="#create">
          <i class="icon-pencil" > </i>&nbsp;Create     

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="create">
         
          <li class=""><a href="admin-create-classes"><i class="icon-minus-sign"></i>&nbsp;Classes </a></li>
          <li class=""><a href="admin-create-terms"><i class="icon-minus-sign"></i>&nbsp;Terms </a></li>
           <li class=""><a href="admin-create-streams-combs"><i class="icon-minus-sign"></i>&nbsp;Streams/Combinations </a></li>
          <li class=""><a href="admin-create-subjects"><i class="icon-minus-sign"></i>&nbsp;Subjects </a></li> 
      </ul>
  </li>
  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"  data-target="#contribution">
          <i class="icon-suitcase" > </i>&nbsp;Contributions     

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="contribution">
         
          <li class=""><a href="admin-add-contributions"><i class="icon-minus-sign"></i>&nbsp;Add Contributiion </a></li>
           <li class=""><a href="admin-collect-contributions"><i class="icon-minus-sign"></i>&nbsp;Contribution Collections </a></li>
          <li class=""><a href="admin-contribution-reports"><i class="icon-minus-sign"></i>&nbsp;Contribution Reports </a></li>
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
         
          <li class=""><a href="admin-add-fees"><i class="icon-minus-sign"></i>&nbsp;Add Fee </a></li>
           <li class=""><a href="admin-collect-fees"><i class="icon-minus-sign"></i>&nbsp;Fee Collections </a></li>
          <li class=""><a href="admin-fee-reports"><i class="icon-minus-sign"></i>&nbsp;Fee Reports </a></li>
      </ul>
  </li>
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
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"  data-target="#academic">
          <i class="icon-file-text-alt" > </i> &nbsp;Academics     

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="academic">
         
          <li class=""><a href="#"><i class="icon-minus-sign"></i> &nbsp;class Members </a></li>
           <li class=""><a href="admin-record-results"><i class="icon-minus-sign"></i> &nbsp;Results Recording </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i> &nbsp;Results Reports </a></li>
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
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"  data-target="#attendence">
          <i class="icon-list-alt" > </i> &nbsp;Attendence Management     

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="attendence">
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i>&nbsp;&nbsp;Students Attendence </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i>&nbsp;&nbsp;Teachers Attendence </a></li>
          <li class=""><a href="progress.html"><i class="icon-minus-sign"></i>&nbsp;&nbsp;Attendence Reports</a></li>
      </ul>
  </li>
  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"  data-target="#activity">
          <i class="icon-tasks" > </i>&nbsp;&nbsp;School Activities     

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="activity">
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i>&nbsp;&nbsp;Students Routine </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i>&nbsp;&nbsp;Teacher on Duties </a></li>
          <li class=""><a href="progress.html"><i class="icon-minus-sign"></i>&nbsp;&nbsp;Class Time Table </a></li>
          <li class=""><a href="tabs_panels.html"><i class="icon-minus-sign"></i>&nbsp;&nbsp;School Calender</a></li>
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
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i>&nbsp;&nbsp;Books </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i>&nbsp;&nbsp;Library Users </a></li>
          <li class=""><a href="progress.html"><i class="icon-minus-sign"></i>&nbsp;&nbsp;Issue </a></li>
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
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i>&nbsp;Vehicles </a></li>
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i>&nbsp;Fuel Usage </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i>&nbsp;Routes </a></li>
          <li class=""><a href="progress.html"><i class="icon-minus-sign"></i>&nbsp;Routes Members </a></li>
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
 
  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle"  data-target="#payroll">
          <i class="icon-credit-card" > </i>&nbsp;Payroll Managements     

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="payroll">
         
          <li class=""><a href="button.html"><i class="icon-minus-sign"></i>&nbsp;Deduction </a></li>
           <li class=""><a href="icon.html"><i class="icon-minus-sign"></i>&nbsp;Overtime </a></li>
          <li class=""><a href="progress.html"><i class="icon-minus-sign"></i>&nbsp;Pension Funds </a></li>
          <li class=""><a href="tabs_panels.html"><i class="icon-minus-sign"></i>&nbsp;Allowances</a></li>
          <li class=""><a href="tabs_panels.html"><i class="icon-minus-sign"></i>&nbsp;Loans</a></li>
          <li class=""><a href="tabs_panels.html"><i class="icon-minus-sign"></i>&nbsp;Salary</a></li>
      </ul>
  </li>
 

  <li class="panel ">
      <a href="javascript:void()" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#setting">
          <i class="icon-cogs" > </i>&nbsp;Settings & Promotion     

          <span class="pull-right">
            <i class="icon-angle-left"></i>
          </span>
         {{-- &nbsp; <span class="label label-default">10</span>&nbsp; --}}
      </a>
      <ul class="collapse" id="setting">
         

        <li class=""><a href="admin-academic-years"><i class="icon-minus-sign"></i>&nbsp;Academic Year </a></li>
        <li class=""><a href="admin-set-fees"><i class="icon-minus-sign"></i>&nbsp;Students Fee </a></li>
        <li class=""><a href="admin-set-contributions"><i class="icon-minus-sign"></i>&nbsp;Students Contribution </a></li>
        <li class=""><a href="admin-promote"><i class="icon-minus-sign"></i>&nbsp;Promote Students </a></li>
      </ul>
  </li>
 
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