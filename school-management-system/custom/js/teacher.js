var manageTeacherTable;
var base_url = $("#base_url").val();

$(document).ready(function() {
	$("#topNavTeacher").addClass('active');

	manageTeacherTable = $("#manageTeacherTable").DataTable({
		'ajax' : base_url + 'teacher/fetchTeacherData',
		'order' : []
	});

	/*
	*-------------------------------------------------
	* click on the add teacher model button
	*-------------------------------------------------
	*/
	$("#addTeacherModelBtn").unbind('click').bind('click', function() {
		$('#registerDate').calendarsPicker({
			dateFormat: 'yyyy-mm-dd'
		});
		
		$('#dob').calendarsPicker({
			dateFormat: 'yyyy-mm-dd'
		});

		$("#photo").fileinput({
			overwriteInitial: true,
		    maxFileSize: 1500,
		    showClose: false,
		    showCaption: false,
		    showBrowse: false,
		    browseOnZoneClick: true,
		    removeLabel: '',
		    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
		    removeTitle: 'Cancel or reset changes',
		    elErrorContainer: '#kv-avatar-errors-2',
		    msgErrorClass: 'alert alert-block alert-danger',
		    defaultPreviewContent: '<img src="'+base_url+'assets/images/default/default_avatar.png" alt="Your Avatar" style="width:208px;height:200px;"><h6 class="text-muted">Click to select</h6>',
		    layoutTemplates: {main2: '{preview} {remove} {browse}'},								    
			allowedFileExtensions: ["jpg", "png", "gif", "JPG", "PNG", "GIF"]
		});

		/*remove error messages*/
		$(".form-group").removeClass('has-success').removeClass('has-error');
		$(".text-danger").remove();
		$("#add-teacher-messages").html('');

		$("#createTeacherForm").unbind('submit').bind('submit', function() {
			var form = $(this);
			var formData = new FormData($(this)[0]);
			var url = form.attr('action');
			var type = form.attr('method');

			$.ajax({
				url : url,
				type : type,
				data: formData,
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				async: false,
				success:function(response) {					

					if(response.success == true) {						
						$("#add-teacher-messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');		

						manageTeacherTable.ajax.reload(null, false);
						$('.form-group').removeClass('has-error').removeClass('has-success');
						$('.text-danger').remove();
						clearForm();
					}	
					else {									
						if(response.messages instanceof Object) {							
							$.each(response.messages, function(index, value) {
								var key = $("#" + index);

								key.closest('.form-group')
								.removeClass('has-error')
								.removeClass('has-success')
								.addClass(value.length > 0 ? 'has-error' : 'has-success')
								.find('.text-danger').remove();							

								key.after(value);

							});
						}
						else {							
							$("#add-teacher-messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  response.messages + 
							'</div>');						
						}							
					} // /else
				} // /success
			}); // /ajax

			return false;
		});	
	}); // /click on the add teacher button

	
});

/*
*-------------------------------------------------
* edits teacher information function
*-------------------------------------------------
*/
function editTeacher(teacherId = null)
{
	if(teacherId) {
		$('#editRegisterDate').calendarsPicker({
			dateFormat: 'yyyy-mm-dd'
		});
		
		$('#editDob').calendarsPicker({
			dateFormat: 'yyyy-mm-dd'
		});

		$("#editPhoto").fileinput({
			overwriteInitial: true,
		    maxFileSize: 1500,
		    showClose: false,
		    showCaption: false,
		    showBrowse: false,
		    browseOnZoneClick: true,
		    removeLabel: '',
		    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
		    removeTitle: 'Cancel or reset changes',
		    elErrorContainer: '#kv-avatar-errors-2',
		    msgErrorClass: 'alert alert-block alert-danger',
		    defaultPreviewContent: '<img src="'+base_url+'assets/images/default/edit_avatar.png" alt="Your Avatar" style="width:208px;height:200px;"><h6 class="text-muted">Click to select</h6>',
		    layoutTemplates: {main2: '{preview} {remove} {browse}'},								    
			allowedFileExtensions: ["jpg", "png", "gif", "JPG", "PNG", "GIF"]
		});

		$(".form-group").removeClass('has-error').removeClass('has-success');
		$('.text-danger').remove();
		// photo
		$('#edit-upload-image-message').html('');
		$(".fileinput-remove-button").click();	

		// information
		$('#edit-personal-teacher-message').html('');

		

		$.ajax({
			url: base_url + 'teacher/fetchTeacherData/'+teacherId,
			type: 'post',
			dataType: 'json',
			success:function(response){
				$("#editFname").val(response.fname);
				$("#editLname").val(response.lname);
				$("#editDob").val(response.date_of_birth);
				$("#editAge").val(response.age);
				$("#editContact").val(response.contact);
				$("#editEmail").val(response.email);
				$("#editAddress").val(response.address);
				$("#editCity").val(response.city);
				$("#editCountry").val(response.country);
				$("#editRegisterDate").val(response.register_date);
				$("#editJobType").val(response.job_type);

				$("#teacher_photo").attr('src', base_url + response.image);

				// submit the teacher information form
				$("#updateTeacherInfoForm").unbind('submit').bind('submit', function() {
					var form = $(this);
					var url = form.attr('action');
					var type = form.attr('method');

					$.ajax({
						url: url + '/' + teacherId,
						type: type,
						data: form.serialize(),
						dataType: 'json',
						success:function(response) {
							if(response.success == true) {						
								$("#edit-personal-teacher-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
								  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
								  response.messages + 
								'</div>');		

								manageTeacherTable.ajax.reload(null, false);
								$('.form-group').removeClass('has-error').removeClass('has-success');
								$('.text-danger').remove();								
							}	
							else {									
								if(response.messages instanceof Object) {							
									$.each(response.messages, function(index, value) {
										var key = $("#" + index);

										key.closest('.form-group')
										.removeClass('has-error')
										.removeClass('has-success')
										.addClass(value.length > 0 ? 'has-error' : 'has-success')
										.find('.text-danger').remove();							

										key.after(value);

									});
								}
								else {							
									$("#edit-personal-teacher-message").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
									  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									  response.messages + 
									'</div>');						
								}							
							} // /else
						} // /success
					}); // /ajax
					return false;
				});  // /submit the teacher information form

				// submit the teacher photo form
				$("#updateTeacherPhotoForm").unbind('submit').bind('submit', function() {					
					var form = $(this);
					var formData = new FormData($(this)[0]);
					var url = form.attr('action') + '/' + teacherId;
					var type = form.attr('method');

					$.ajax({
						url : url,
						type : type,
						data: formData,
						dataType: 'json',
						cache: false,
						contentType: false,
						processData: false,
						async: false,
						success:function(response) {					

							if(response.success == true) {						
								$("#edit-upload-image-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
								  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
								  response.messages + 
								'</div>');		

								manageTeacherTable.ajax.reload(null, false);
								$('.form-group').removeClass('has-error').removeClass('has-success');
								$('.text-danger').remove();								

								$(".fileinput-remove-button").click();	

								$.ajax({
									url: 'teacher/fetchTeacherData/'+teacherId,
									type: 'post',
									dataType: 'json',
									success:function(response) {
										$("#teacher_photo").attr('src', '../' + response.image);
									}
								});							

							}	
							else {																							
								$("#edit-upload-image-message").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
								  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
								  response.messages + 
								'</div>');																					
							} // /else
						} // /success
					}); // /ajax
					return false;
				}); // /submit the teacher photo form

			} // /success
		}); // /ajax

	} // /if 
}

/*
*-------------------------------------------------
* removes teacher function
*-------------------------------------------------
*/
function removeTeacher(teacherId = null)
{
	if(teacherId) {
		$("#removeTeacherBtn").unbind('click').bind('click', function() {
			$.ajax({
				url : base_url + 'teacher/remove/'+teacherId,
				type: 'post',
				dataType: 'json',
				success:function(response) {
					if(response.success == true) {
						$("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
						  	'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  	response.messages + 
						'</div>');

						manageTeacherTable.ajax.reload(null, false);
						$("#removeTeacherModal").modal('hide');
					}
					else{
						$("#remove-messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
						  	'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  	response.messages + 
						'</div>');
					}
				} // /response
			}); // /ajax
		}); // /remove teacher button clicked of the modal button
	} // /if
}

/*
*-------------------------------------------------
* clears the form 
*-------------------------------------------------
*/
function clearForm()
{
	$('input[type="text"]').val('');
	$('select').val('');
	$(".fileinput-remove-button").click();	
}