<ol class="breadcrumb">
  <li><a href="<?php echo base_url('dashboard') ?>">Home</a></li> 
  <li class="active">Manage Teacher</li>
</ol>

<div class="panel panel-default">
  <div class="panel-body">  	
    <fieldset>
    	<legend>Manage Teacher</legend>    	

      <div id="messages"></div>

    	<div class="pull pull-right">
    		<button type="button" class="btn btn-default" data-toggle="modal" data-target="#addTeacher" id="addTeacherModelBtn"> 
    			<i class="glyphicon glyphicon-plus-sign"></i> Add Teacher
    		</button>
    	</div>

    	<br /> <br /> <br />    	
    	
    	<table id="manageTeacherTable" class="table table-bordered">
    		<thead>
    			<tr>
    				<th>#</th>
    				<th>Name</th>
    				<th>Age</th>
    				<th>Contact</th>    				
    				<th>Email</th>
    				<th>Action</th>
    			</tr>
    		</thead>
    	</table>	

    </fieldset>	
  </div>
</div>

<!-- add teacher -->
<div class="modal fade" tabindex="-1" role="dialog" id="addTeacher">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Teacher</h4>
      </div>

      <form class="form-horizontal" method="post" id="createTeacherForm" action="teacher/create" enctype="multipart/form-data">

      <div class="modal-body create-modal">
      
      	<div id="add-teacher-messages"></div>

      	<div class="row">
		  	<div class="col-md-12">
		  		<div class="col-md-6">
			  		<div class="form-group">
						<label for="fname" class="col-sm-4 control-label">First Name : </label>
					   	<div class="col-sm-8">
					      <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" />
					    </div>
					</div>
					<div class="form-group">
					    <label for="lname" class="col-sm-4 control-label">Last Name : </label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name"/>
					    </div>
					</div>
					<div class="form-group">
				    	<label for="dob" class="col-sm-4 control-label">DOB: </label>
				    	<div class="col-sm-8">
				      		<input type="text" class="form-control" id="dob" name="dob" placeholder="Date of Birth" />
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label for="age" class="col-sm-4 control-label">Age: </label>
				    	<div class="col-sm-8">
				      		<input type="text" class="form-control" id="age" name="age" placeholder="Age" />
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label for="contact" class="col-sm-4 control-label">Contact: </label>
				    	<div class="col-sm-8">
				      		<input type="text" class="form-control" id="contact" name="contact" placeholder="Contact" />
				    	</div>
				  	</div>	
				  	<div class="form-group">
				    	<label for="email" class="col-sm-4 control-label">Email: </label>
				    	<div class="col-sm-8">
				      		<input type="text" class="form-control" id="email" name="email" placeholder="Email" />
				    	</div>
				  	</div>	
				   	<div class="form-group">
				    	<label for="address" class="col-sm-4 control-label">Address: </label>
				    	<div class="col-sm-8">
				      		<input type="text" class="form-control" id="address" name="address" placeholder="Address" />
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label for="city" class="col-sm-4 control-label">City: </label>
				    	<div class="col-sm-8">
				      		<input type="text" class="form-control" id="city" name="city" placeholder="City" />
				    	</div>
				  	</div>				  	
				  	<div class="form-group">
				    	<label for="country" class="col-sm-4 control-label">Country: </label>
				    	<div class="col-sm-8">
				      		<input type="text" class="form-control" id="country" name="country" placeholder="Country" />
				    	</div>
				  	</div>

		  		</div>
		  		<!-- /col-md-6 -->

		  		<div class="col-md-6">
		  			<div class="form-group">
						<label for="registerDate" class="col-sm-4 control-label">Register Date : </label>
					   	<div class="col-sm-8">
					      <input type="text" class="form-control" id="registerDate" name="registerDate" placeholder="Register Date" />
					    </div>
					</div>
					<div class="form-group">
				    	<label for="jobType" class="col-sm-4 control-label">Job Type: </label>
				    	<div class="col-sm-8">
				      		<select class="form-control" name="jobType" id="jobType">
				      			<option value="">Select an option</option>
				      			<option value="1">Full-Time</option>
				      			<option value="2">Part-Time</option>
				      		</select>
				    	</div>
				  	</div>
			  		<div class="form-group">
					    <label for="photo" class="col-sm-4 control-label">Photo: </label>
					    <div class="col-sm-8">					      	
					      	<!-- the avatar markup -->
							<div id="kv-avatar-errors-1" class="center-block" style="max-width:500px;display:none"></div>							
						    <div class="kv-avatar center-block" style="width:100%">
						        <input type="file" id="photo" name="photo" class="file-loading"/>								        
						    </div>
					    </div>
					</div>
		  		</div>				 
			  		<!-- /col-md-4 -->
		  	</div>
		  	<!-- /col-md-12 -->
		    
		</div>
	 	<!-- /row -->
      </div>
      <!-- /modal-body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- edit teacher -->
<div class="modal fade" tabindex="-1" role="dialog" id="updateTeacherModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Teacher</h4>
      </div>
     
      <div class="modal-body edit-modal">
      
      	<div id="edit-teacher-messages"></div>

      	<!-- Nav tabs -->
	  	<ul class="nav nav-tabs" role="tablist">
	    	<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Photo</a></li>
	    	<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Personal Detail</a></li>	    
		</ul>

	  	<!-- Tab panes -->
	  	<div class="tab-content">
	    	<div role="tabpanel" class="tab-pane active" id="home">
	    		<br /> 

				<form class="form-horizontal" method="post" id="updateTeacherPhotoForm" action="teacher/updatePhoto" enctype="multipart/form-data">

				<div class="row">
					<div class="col-md-12">
						<div id="edit-upload-image-message"></div>

						<div class="col-md-6">
							<center>
								<img src="" id="teacher_photo" alt="Teacher Photo" class="img-thumbnail upload-photo" />
							</center>								
						</div>
						<div class="col-md-6">
							<div class="form-group">
							    <label for="editPhoto" class="col-sm-4 control-label">Photo: </label>
							    <div class="col-sm-8">					      	
							      	<!-- the avatar markup -->
									<div id="kv-avatar-errors-1" class="center-block" style="max-width:500px;display:none"></div>							
								    <div class="kv-avatar center-block" style="width:100%">
								        <input type="file" id="editPhoto" name="editPhoto" class="file-loading"/>								        
								    </div>
							    </div>
							</div>
							<div class="form-group">
							    <div class="col-sm-offset-2 col-sm-10">
							    	<center>
							    		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								      	<button type="submit" class="btn btn-primary">Save Changes</button>
							    	</center>
							    </div>
						  	</div>

						</div>
						<!-- /col-md-6 -->
					</div>
					<!-- /col-md-12 -->
				</div>
				<!-- /row -->
					
				</form>
	    	</div>
	    	<!-- /tab panel of image -->

	    	<div role="tabpanel" class="tab-pane" id="profile">

	    	<br /> 
    		<form class="form-horizontal" method="post" action="teacher/updateInfo" id="updateTeacherInfoForm">
			  	<div class="row">

				  	<div class="col-md-12">
				  		<div id="edit-personal-teacher-message"></div>

				  		<div class="col-md-6">
					  		<div class="form-group">
								<label for="editFname" class="col-sm-4 control-label">First Name : </label>
							   	<div class="col-sm-8">
							      <input type="text" class="form-control" id="editFname" name="editFname" placeholder="First Name" />
							    </div>
							</div>
							<div class="form-group">
							    <label for="editLname" class="col-sm-4 control-label">Last Name : </label>
							    <div class="col-sm-8">
							      <input type="text" class="form-control" id="editLname" name="editLname" placeholder="Last Name"/>
							    </div>
							</div>
							<div class="form-group">
						    	<label for="editDob" class="col-sm-4 control-label">DOB: </label>
						    	<div class="col-sm-8">
						      		<input type="text" class="form-control" id="editDob" name="editDob" placeholder="Date of Birth" />
						    	</div>
						  	</div>
						  	<div class="form-group">
						    	<label for="editAge" class="col-sm-4 control-label">Age: </label>
						    	<div class="col-sm-8">
						      		<input type="text" class="form-control" id="editAge" name="editAge" placeholder="Age" />
						    	</div>
						  	</div>
						  	<div class="form-group">
						    	<label for="editContact" class="col-sm-4 control-label">Contact: </label>
						    	<div class="col-sm-8">
						      		<input type="text" class="form-control" id="editContact" name="editContact" placeholder="Contact" />
						    	</div>
						  	</div>	
						  	<div class="form-group">
						    	<label for="editEmail" class="col-sm-4 control-label">Email: </label>
						    	<div class="col-sm-8">
						      		<input type="text" class="form-control" id="editEmail" name="editEmail" placeholder="Email" />
						    	</div>
						  	</div>	
						   	<div class="form-group">
						    	<label for="editAddress" class="col-sm-4 control-label">Address: </label>
						    	<div class="col-sm-8">
						      		<input type="text" class="form-control" id="editAddress" name="editAddress" placeholder="Address" />
						    	</div>
						  	</div>
						  	<div class="form-group">
						    	<label for="editCity" class="col-sm-4 control-label">City: </label>
						    	<div class="col-sm-8">
						      		<input type="text" class="form-control" id="editCity" name="editCity" placeholder="City" />
						    	</div>
						  	</div>				  	
						  	<div class="form-group">
						    	<label for="editCountry" class="col-sm-4 control-label">Country: </label>
						    	<div class="col-sm-8">
						      		<input type="text" class="form-control" id="editCountry" name="editCountry" placeholder="Country" />
						    	</div>
						  	</div>

				  		</div>
				  		<!-- /col-md-6 -->

				  		<div class="col-md-6">
				  			<div class="form-group">
								<label for="editRegisterDate" class="col-sm-4 control-label">Register Date : </label>
							   	<div class="col-sm-8">
							      <input type="text" class="form-control" id="editRegisterDate" name="editRegisterDate" placeholder="Register Date" />
							    </div>
							</div>
							<div class="form-group">
						    	<label for="editJobType" class="col-sm-4 control-label">Job Type: </label>
						    	<div class="col-sm-8">
						      		<select class="form-control" name="editJobType" id="editJobType">
						      			<option value="">Select an option</option>
						      			<option value="1">Full-Time</option>
						      			<option value="2">Part-Time</option>
						      		</select>
						    	</div>
						  	</div>

				  		</div>				 
					  		<!-- /col-md-4 -->

					  	<div class="form-group">
					    	<div class="col-sm-12">
					    		<center>
					    			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						    	  	<button type="submit" class="btn btn-primary">Save Changes</button>
					    		</center>
					    	</div>
					  	</div>
				  	</div>
				  	<!-- /col-md-12 -->
	    
				</div>
			 	<!-- /row -->				  	
			</form>

	    	</div>	    	
	    	<!-- /tab-panel of teacher information -->
	  	</div>


      </div>
      <!-- /modal-body -->      
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- remove teacher -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeTeacherModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Teacher</h4>
      </div>
      <div class="modal-body">
      	<div id="remove-messages"></div>
        <p>Do you really want to remove ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="removeTeacherBtn">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script type="text/javascript" src="<?php echo base_url('custom/js/teacher.js') ?>"></script>