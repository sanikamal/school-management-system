var base_url = $("#base_url").val();

$(document).ready(function() {
	$("#topClassMainNav").addClass('active');
	$("#topNavSection").addClass('active');

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
			url: base_url + 'section/fetchSectionTable/' + classId,
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
function addSection(classId = null)
{
	if(classId) {
		$("#addSectionForm")[0].reset();
		$(".form-group").removeClass('has-error').removeClass('has-success');
		$('.text-danger').remove();
		$("#add-section-message").html('');

		$("#addSectionForm").unbind('submit').bind('submit', function() {
			$("#add-section-message").html('');

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

						$("#add-section-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');					
						
						$("#addSectionForm")[0].reset();
						$(".form-group").removeClass('has-error').removeClass('has-success');
						$(".text-danger").remove();		

						$("#manageSectionTable").load(base_url + 'section/fetchUpdateSectionTable/' + classId);

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
* update class's section function
*----------------------------
*/
function editSection(sectionId = null, classId = null)
{
	if(sectionId && classId) {
		/*Clear the form*/
		$("#editSectionForm")[0].reset();
		$(".form-group").removeClass('has-error').removeClass('has-success');
		$('.text-danger').remove();
		$("#edit-section-messages").html('');
				
		$.ajax({
			url: base_url + 'section/fetchSectionByClassSection/'+classId+'/'+sectionId,
			type: 'post',
			dataType: 'json',
			success:function(response) {
				$("#editSectionName").val(response.section_name);

				$("#editTeacherName").val(response.teacher_id);

				$("#editSectionForm").unbind('submit').bind('submit', function() {
					var form = $(this);
					var url = form.attr('action');
					var type = form.attr('method');

					$.ajax({
						url: url + '/' + classId + '/' + sectionId,
						type: type,
						data: form.serialize(),
						dataType: 'json',
						success:function(response) {
							if(response.success == true) {
								$("#edit-section-messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
								  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
								  response.messages + 
								'</div>');					

								$("#manageSectionTable").load(base_url + 'section/fetchUpdateSectionTable/' + classId);
							
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
function removeSection(sectionId = null, classId = null) 
{
	if(sectionId && classId) {
		// remove section btn clicked
		$("#removeSectionBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: base_url + 'section/remove/'+sectionId,
				type: 'post',
				dataType: 'json',
				success:function(response) {
					if(response.success === true) {
						$("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');

						$("#manageSectionTable").load(base_url + 'section/fetchUpdateSectionTable/' + classId);

						$("#removeSectionModal").modal('hide');
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