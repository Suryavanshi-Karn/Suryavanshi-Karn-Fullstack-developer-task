@extends('backend.layouts.app')
@section('content')
<div class="wrapper">
    <div class="main-panel">
        <div class="main-content">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <section id="minimal-statistics">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="content-header">Welcome To University Admin Panel</h1>
                          <hr style="border: none; border-bottom: 1px solid black;"> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{$data['total_teacher']}}</h3>
                                                <span>No. Of Teachers</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-users success font-large-1 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{$data['total_student']}}</h3>
                                                <span>No. Of Student</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="fa fa-product-hunt success font-large-1 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{$data['created_teacher']}}</h3>
                                                <span>Teachers created Today</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                            <i class="fa  fa-calendar warning font-large-1 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 danger">{{$data['created_student']}}</h3>
                                                <span>Students created Today</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="fa fa-calendar-times-o danger font-large-1 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                         
 
                    </div>
                  
                </section>
                <div class="row">
    <!-- Line Chart starts -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Active Students in Last 12 Months</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div id="line-chart" class="d-flex justify-content-center"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Line Chart ends -->
</div>

        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    lineChartStudents();
});
</script>

@endsection
<!-- #f43736
#414091 -->