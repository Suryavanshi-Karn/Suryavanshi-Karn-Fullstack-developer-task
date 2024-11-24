<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <!-- <h5 class="pt-2">Edit {{$data['data']->admin_name}}</h5> -->
                                    <h5 class="pt-2">Edit Teacher :  {{$data['data']->teacher_name}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                    		<form id="editTeacherData" method="post" action="saveTeacher?id={{$data['data']->id}}">
                                <h4 class="form-section"><i class="ft-info"></i>Details</h4>
                    			@csrf
                                <div class="row">
                        			
									<div class="col-sm-6">
                        				<label>Teacher Name<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="text" id="teacher_name" name="teacher_name" placeholder="Enter Your Teacher Name"  value="{{$data['data']->teacher_name}}"><br/>
                        			</div>

								</div>
								
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('editTeacherData','post')">Update</button>
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