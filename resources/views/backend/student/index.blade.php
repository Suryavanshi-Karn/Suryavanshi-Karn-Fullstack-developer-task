@extends('backend.layouts.app')
@section('content')
<div class="main-content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <section class="users-list-wrapper">
        	<div class="users-list-table">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-sm-7">
                                            <h5 class="pt-2">Students</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-outline-danger px-3 py-1 mr-2" id="listing-filter-toggle"><i class="fa fa-filter"></i> Filter</button>
                                            @if($data['student_add'])
                                                <a href="student_add" class="btn btn-success btn-sm  px-3 py-1 src_data"><i class="fa fa-plus"></i> New</a>
                                            @endif  
                                        </div>
                                    </div>
                                </div>
                                <!-- <hr class="mb-0"> -->
                            	<div class="card-body">
                                    <div class="row mb-2" id="listing-filter-data" style="display: none;">
                                        <div class="col-md-4">
                                            <label>Student Name</label>
                                            <input class="form-control mb-3" type="text" id="search_student_name" name="search_student_name">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Class</label>
                                            <input class="form-control mb-3" type="text" id="search_class" name="search_class">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Yearly Fees</label>
                                            <input class="form-control mb-3" type="text" id="search_yearly_fees" name="search_yearly_fees">
                                        </div>
                                        <div class="col-md-4">
                                            <label>&nbsp;</label><br/>
                                            <input class="btn btn-md btn-primary px-3 py-1 mb-3" id="clear-form-data" type="reset" value="Clear Search">
                                        </div>
                                    </div>
                            		<div class="table-responsive">
                                        <table class="table table-bordered table-hover datatable" id="dataTable" width="100%" cellspacing="0" data-url="student_data">
                                            <thead>
                                                <tr>
                                                    <th class="sorting_disabled" id="id" data-orderable="false" data-searchable="false">Id</th>
                                                    <th id="student_name" data-orderable="false" data-searchable="false">Student Name</th>
                                                    <th id="class_teacher_id" data-orderable="false" data-searchable="false">Teacher Name</th>
                                                    <th id="class" data-orderable="false" data-searchable="false">Class</th>
                                                    <th id="admission_date" data-orderable="false" data-searchable="false">Admission Date</th>
                                                    <th id="yearly_fees" data-orderable="false" data-searchable="false">Yearly Fees</th>
                                                    <th id="action" data-orderable="false" data-searchable="false" width="130px">Action</th> <!-- Always show the Action column -->
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                            	</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection
