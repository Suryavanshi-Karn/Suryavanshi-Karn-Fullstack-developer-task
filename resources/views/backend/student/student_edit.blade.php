<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Student :  {{$data['data']->student_name}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                    		<form id="editStudentData" method="post" action="saveStudent?id={{$data['data']->id}}">
                                <h4 class="form-section"><i class="ft-info"></i>Details</h4>
                    			@csrf
                                <div class="row">
                        			<div class="col-sm-6">
                        				<label>Teacher Name<span class="text-danger">*</span></label>
                        				<select class="select2 required" id="class_teacher_id" name="class_teacher_id" style="width: 100% !important;">
                                        <option value="">Select Teacher</option>
                                    @foreach($data['teacher'] as $teacher)
                                        @if($teacher->id == $data['data']->class_teacher_id)
                                        <option value="{{$teacher->id}}" selected>{{$teacher->teacher_name}}</option>
                                         @else
                                        <option value="{{$teacher->id}}">{{$teacher->teacher_name}}</option>
                                        @endif
                                    @endforeach
                                    </select>
									</div>
									<div class="col-sm-6">
                        				<label>Student Name<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="text" id="student_name" name="student_name" value="{{$data['data']->student_name}}" placeholder="Enter Student Name"><br/>
                        			</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
                        				<label>Class<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="text" id="class" name="class" value="{{$data['data']->class}}" placeholder="Enter Class"><br/>
                        			</div>
                                    <div class="col-sm-6">
                        				<label>Yearly Fees<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="text" id="yearly_fees" name="yearly_fees" value="{{$data['data']->yearly_fees}}" placeholder="Enter Yearly Fees"><br/>
                        			</div>
                                    
                                    <div class="col-sm-6">
                        				<label>Admission Date.<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="date" id="admission_date" name="admission_date" value="{{$data['data']->admission_date}}"><br/>
                        			</div>
                        		</div>
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('editStudentData','post')">Update</button>
                                            <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1"> Cancel</a>
                        				</div>
                        			</div>
                        		</div>
                        	</form>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $('.select2').select2();
</script>