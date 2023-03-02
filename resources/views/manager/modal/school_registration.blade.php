<div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
    <h4 class="modal-title" id="myLargeModalLabel">School Informations</h4>
    <p><sub class="text-danger">*</sub>:&nbsp; This symbol means a field should filled</p>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>
    <div class="modal-body">
        <form  method="POST" action="{{ route('manager.save-school') }}">
            @csrf
            <div class="form-group row">
            <label class="col-lg-3 col-form-label"><sub class="text-danger">*</sub>&nbsp;School Name</label>
            <div class="col-lg-9">
            <input required type="text" name="school_name" id="school_name" class="form-control">
            </div>
            </div>
            <div class="form-group row">
            <label class="col-lg-3 col-form-label"><sub class="text-danger">*</sub>&nbsp;Country</label>
            <div class="col-lg-9">
            <input required type="text" name="country" id="country" class="form-control">
            </div>
            </div>
            <div class="form-group row">
            <label class="col-lg-3 col-form-label"><sub class="text-danger">*</sub>&nbsp;Region</label>
            <div class="col-lg-9">
            <input required type="text" name="region" id="region" class="form-control">
            </div>
            </div>
            <div class="form-group row">
            <label class="col-lg-3 col-form-label"><sub class="text-danger">*</sub>&nbsp; District</label>
            <div class="col-lg-9">
            <input required type="text" name="district" id="district" class="form-control">
            </div>
            </div>
            <div class="form-group row">
            <label class="col-lg-3 col-form-label">Street</label>
            <div class="col-lg-9">
            <input type="text" name="street" id="street" class="form-control">
            </div>
            </div>
            <div class="form-group row">
            <label class="col-lg-3 col-form-label"><sub class="text-danger">*</sub>&nbsp; School Registration Number</label>
            <div class="col-lg-9">
            <input required type="text" name="scool_number" id="scool_number" class="form-control">
            </div>
            </div>
            <div class="form-group row">
            <label class="col-lg-3 col-form-label"></label>
            <div class="col-lg-9">
            <div class="text-end">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </div>
            </div>
          
           
        </form>
    </div>
    </div>
    </div>
    </div>