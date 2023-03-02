@extends('layouts.app')

@section('content')
 <!--PAGE CONTENT -->
 <div id="content">

  <div class="inner">
      <div class="row">
          <div class="col-lg-12">


              <h2> Data Tables </h2>



          </div>
      </div>

      <hr />


      <div class="row">
      <div class="col-lg-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  DataTables Advanced Tables
              </div>
              <div class="panel-body">
                  <div class="table-responsive">
                      <table  class="table table-striped table-bordered table-hover" id="dataTables-example">
                          <thead>
                              <tr>
                                  <th>Rendering engine</th>
                                  <th>Browser</th>
                                  <th>Platform(s)</th>
                                  <th>Engine version</th>
                                  <th>CSS grade</th>
                                  <th>CSS grade</th>
                                  <th>CSS grade</th>
                                  <th>CSS grade</th>
                                  <th>CSS grade</th>
                                  <th>CSS grade</th>
                                  <th>CSS grade</th>
                                  <th>CSS grade</th>
                                  <th>CSS grade</th>
                                  <th>CSS grade</th>
                                  <th>CSS grade</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr class="odd gradeX">
                                  <td>Trident</td>
                                  <td>Internet Explorer 4.0</td>
                                  <td>Win 95+</td>
                                  <td class="center">4</td>
                                  <td class="center">X</td>
                                  <td class="center">X</td>
                                  <td class="center">X</td>
                                  <td class="center">X</td>
                                  <td class="center">X</td>
                                  <td class="center">X</td>
                                  <td class="center">X</td>
                                  <td class="center">X</td>
                                  <td class="center">X</td>
                                  <td class="center">X</td>
                                  <td class="center">X</td>
                              </tr>
                              <tr class="even gradeC">
                                  <td>Trident</td>
                                  <td>Internet Explorer 5.0</td>
                                  <td>Win 95+</td>
                                  <td class="center">5</td>
                                  <td class="center">C</td>
                                  <td class="center">C</td>
                                  <td class="center">C</td>
                                  <td class="center">C</td>
                                  <td class="center">C</td>
                                  <td class="center">C</td>
                                  <td class="center">C</td>
                                  <td class="center">C</td>
                                  <td class="center">C</td>
                                  <td class="center">C</td>
                                  <td class="center">C</td>
                              </tr>
                      
                          </tbody>
                      </table>
                  </div>
                 
              </div>
          </div>
      </div>
  </div>
    

      
  </div>

  </div>




</div>
<!--END PAGE CONTENT -->
  
<script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>


<!-- END PAGE LEVEL SCRIPTS -->

<script>
  function deleteTeacher(teacher_id){

    $.ajax({
            type:'get',
            url:'/mdelete-teacher',
            data:{user_id:teacher_id},
            success:function(){
              
            Swal.fire({ 
            position: "top-end", 
            type: "success", 
            title: "Your work has been saved", 
            showConfirmButton: !1, 
            timer: 1500,
            confirmButtonClass: "btn btn-primary",
            buttonsStyling: !1 });
          
            // $('#delete_paid'+teacher_id).modal("hide");
            
            }
          
        });
        }

    
   
</script>
@endsection
