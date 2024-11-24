<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Send Notification To App Users</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                    	<div class="card-body">
                    		<form id="sendnotificationform" method="post" action="">
                                @csrf
                             <div class="row">
                            <div class="col-sm-7">
                                <label>GENDER<span style="color:#ff0000"></span></label>
                                  <select class="select2 required" id="gender" value="" name="gender" style="width: 100% !important;" onchange="getUser(this.value)">
                                        <option value="">Select</option>
                                        <option value="All">All</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                    </select><br/>
                                </div>
                              <div class="col-sm-7 ">
                                    <label>USER<span style="color:#ff0000"></span></label>
                                    <select class="form-control select2" id="user" value="" name="user" style="width: 100% !important;" multiple="multiple">
                                        <option value="">ALL</option>
                                    </select>
                              </div>
                          </div>
                        	<hr>
                        	<div class="row">
                        	<div class="col-sm-12">
                        		<div class="pull-right">
                        			<button type="button" class=" notify btn btn-success"  data-url="notify">Send</button>
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-danger px-3 py-1"> Cancel</a>
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

<script>
    $('.select2').select2();
    function getUser(gender){
        $.ajax({
            url:"getUser",
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                gender: gender
            },
            dataType:"JSON",
            success:function(result)
            {
                response = JSON.parse(JSON.stringify(result))
                // response = JSON.parse(result);

                $("#user").empty();
                $("#user").append('<option value="">All</option>');
                for(var j=0; j<response['data']['user'].length; j++)
                {
                    var user_id = response['data']['user'][j]['id'];
                    var name = response['data']['user'][j]['name'];
                    $("#user").append('<option value="'+user_id+'">'+name+'</option>');
                }
            },
        });  
    } 
</script>