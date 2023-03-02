<div class="modal fade" id="class_result" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
    <div class="modal-header">
    <h4 class="modal-title" id="myLargeModalLabel">Class Subject for recording Results</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form  method="POST" action="{{ route('manager.school-record-results') }}">
            @csrf
            <div class="form-group row">
            <label class="col-lg-3 col-form-label">Select Class</label>
            <div class="col-lg-9">
            <select onchange="getSubjects(this.value)" required name="class_id" id="class_id" class="form-select form-control">
               <option value=""></option>
                @foreach (App\Models\Darasa::where('schools_id',Session::get('school_id'))->get() as $class)
                    <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                @endforeach
            </select>
            </div>
            </div>
            
            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Select Sujects</label>
                <div class="col-lg-9">
                <select required name="subject_id" id="class_subject_id" class="form-select form-control">
                 
                </select>
                </div>
                </div>
          
            <div class="text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    </div>
    </div>
    </div>
<script>
function getSubjects(class_id){
    $.ajax({
            type:'get',
            url:'/mget-class-subjects',
            data:{class_id:class_id},
            success:function(data){
              
            $('#class_subject_id').html(data)
            // $('#delete_paid'+teacher_id).modal("hide");
            
            }
          
        });
}
</script>