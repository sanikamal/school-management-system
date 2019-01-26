var base_url = $("#base_url").val();

$(document).ready(function() {
	$("#topClassMainNav").addClass('active');
	$("#topNavSubject").addClass('active');

	/*
	*-------------------------------
	* fetches the class section
	* information 	
	*-------------------------------
	*/

	var classSideBar = $(".classSideBar").attr('id');
	var classId = classSideBar.substring(7);

	getClassSection(classId);

}); // /document

/*
*----------------------------
* get class section function
*----------------------------
*/
function getClassSection(classId = null) 
{
	if(classId) {
		$(".list-group-item").removeClass('active');
		$("#classId"+classId).addClass('active');
		$.ajax({
			url: base_url + 'subject/fetchSubjectTable/' + classId,
			type: 'post',		
			success:function(response) {
				$(".result").html(response);
			} // /success
		}); // /ajax 
	}
}

/*
*----------------------------
* add section function
*----------------------------
*/
function addSubject(classId = null)
{
	if(classId) {
		$("#addSubjectForm")[0].reset();
		$(".form-group").removeClass('has-error').removeClass('has-success');
		$('.text-danger').remove();
		$("#add-subject-message").html('');

		$("#addSubjectForm").unbind('submit').bind('submit', function() {
			$("#add-subject-message").html('');

			var form = $(this);
			var url = form.attr('action') + '/' + classId;
			var type = form.attr('method');

			$.ajax({
				url: url,
				type: type,
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					if(response.success == true) {					

						$("#add-subject-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');					
						
						$("#addSubjectForm")[0].reset();
						$(".form-group").removeClass('has-error').removeClass('has-success');
						$(".text-danger").remove();		

						$("#manageSubjectTable").load(base_url + 'subject/fetchUpdateSubjectTable/' + classId);

					}
					else {
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
				} // /success
			}); // /ajax

			return false;
		});
	} // /if
}

/*
*----------------------------
* update class's subject function
*----------------------------
*/
function editSubject(subjectId = null, classId = null)
{
	if(subjectId && classId) {
		/*Clear the form*/
		$("#editSubjectForm")[0].reset();
		$(".form-group").removeClass('has-error').removeClass('has-success');
		$('.text-danger').remove();
		$("#edit-subject-messages").html('');
				
		$.ajax({
			url: base_url + 'subject/fetchSubjectByClassSection/'+classId+'/'+subjectId,
			type: 'post',
			dataType: 'json',
			success:function(response) {
				$("#editSubjectName").val(response.name);
				$("#editTotalMark").val(response.total_mark);
				$("#editTeacherName").val(response.teacher_id);	

				$("#editSubjectForm").unbind('submit').bind('submit', function() {
					var form = $(this);
					var url = form.attr('action') + '/' + classId + '/' + subjectId;
					var type = form.attr('method');

					$.ajax({
						url: url,
						type: type,
						data: form.serialize(),
						dataType: 'json',
						success:function(response) {
							if(response.success == true) {
								$("#edit-subject-messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
								  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
								  response.messages + 
								'</div>');					

								$("#manageSubjectTable").load('subject/fetchUpdateSubjectTable/' + classId);
							
								$(".form-group").removeClass('has-error').removeClass('has-success');
								$(".text-danger").remove();
							}
							else {
								
								$.each(response.messages, function(index, value) {
									var key = $("#" + index);

									key.closest('.form-group')
									.removeClass('has-error')
									.removeClass('has-success')
									.addClass(value.length > 0 ? 'has-error' : 'has-success')
									.find('.text-danger').remove();							

									key.after(value);

								});
																						
							} // /else
						} // /success
					}); // /ajax

					return false;
				});


			} // /successs
		}); // /ajax		

	}
}

/*
*----------------------------
* removes class's section function
*----------------------------
*/
function removeSubject(subjectId = null, classId = null) 
{
	if(subjectId && classId) {
		// remove section btn clicked
		$("#removeSubjectBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: base_url + 'subject/remove/'+subjectId,
				type: 'post',
				dataType: 'json',
				success:function(response) {
					if(response.success === true) {
						$("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');

						$("#manageSubjectTable").load('subject/fetchUpdateSubjectTable/' + classId);

						$("#removeSubjectModal").modal('hide');
					} 
					else {
						$("#remove-messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
						  	'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  	response.messages + 
						'</div>');						
					}
				} // /success
			}); // /ajax
			return false;
		}); // /remove section btn clicked
	}
}