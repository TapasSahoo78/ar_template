<div class="modal fade driverModal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Assigned Driver</h4>
            </div>
            <form class="adminFrm" data-action="{{ route('admin.driver.assigneDriver') }}" method="post">
                @csrf
                <input type="hidden" name="busId" class="busId" value="">
                <input type="hidden" name="routeId" class="routeId" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label required-s">Driver</label>
                                <select name="driver_id" id="driver_id" class="form-control">
                                    {{ getDriver('') }}
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label required-s">Title</label>
                                <input type="Date" class="form-control" name="date" id="date">
                            </div>
                        </div> --}}
                        {{-- <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label required-s">Route</label>
                                <input type="time" class="form-control" name="start_time" id="start_time">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label required-s">Route</label>
                                <input type="time" class="form-control" name="end_time" id="end_time">
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
