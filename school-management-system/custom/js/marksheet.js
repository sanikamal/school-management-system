var manageStudentTable;
var studentSectionTable = {};
var base_url = $("#base_url").val();

$(document).ready(function() {
	$("#topMarksheetMainNav").addClass('active');

	var request = $("#request").text();

	if(request == 'mngms') {
		// manage marksheet
		$("#manageMarksheet").addClass('active');

		/*
		*-------------------------------
		* fetches the class section
		* information 	
		*-------------------------------
		*/
		var classSideBar = $(".classSideBar").attr('id');
		var classId = classSideBar.substring(7);

		getClassSection(classId);
	}
	else if(request == 'mgmk') {
		// manage marks
		$("#manageMarks").addClass('active');

		$("#className").unbind('change').bind('change', function() {

			var classId = $(this).val();

			$("#marksheetName").load(base_url +'marksheet/fetchMarksheetDataByClass/'+classId);		

			$("#fetchStudentMarksheet").unbind('submit').bind('submit', function() {
				var form = $(this);

				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response) {
						if(response.success == true) {						
							$("#marks-result").html(response.html);

							$('.form-group').removeClass('has-error').removeClass('has-success');
							$('.text-danger').remove();

							$("#manageStudentTable").DataTable({
								'ajax' : base_url + 'marksheet/fetchStudentByClass/'+classId,
								'order' : []
							});

							$.each(response.sectionData, function(index, value) {					
								index += 1;										
								studentSectionTable['studentTable' + index] = $("#manageStudentTable"+index).DataTable({
									'ajax' : base_url + 'marksheet/fetchStudentByClassAndSection/'+value.class_id+'/'+value.section_id,
									'order': []
								});					
							});

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
					} // /.success
				}); // /.ajax

				return false;
			});
		});			

	}
}); // /.document ready

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

		$('.result').load(base_url + 'marksheet/fetchMarksheetTable/' + classId, function() {
			$('#date').calendarsPicker({
				dateFormat: 'yyyy-mm-dd'
			});

		});
				
	}
}

/*
*----------------------------
* add marksheet function
*----------------------------
*/
function addMarksheet(classId = null) 
{
	if(classId) {		

		$('.form-group').removeClass('has-error').removeClass('has-success');
		$('.text-danger').remove();
		$('#add-marksheet-message').html('');
		$("#addMarksheetForm")[0].reset();

		/*
		* -----------------------------------
		* submits the add marksheet form
		* -----------------------------------
		*/
		$("#addMarksheetForm").unbind('submit').bind('submit', function() {
			var form = $(this);
			var url = form.attr('action');
			var type = form.attr('method');
			
			$.ajax({
				url: url + '/' + classId,
				type: type,
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					
					if(response.success == true) {						
						$("#add-marksheet-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');		
						
						$('.form-group').removeClass('has-error').removeClass('has-success');
						$('.text-danger').remove();			

						$("#manageMarksheetTable").load('marksheet/fetchUpdateMarksheetTable/' + classId);
						$("#addMarksheetForm")[0].reset();
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
				} // /.success
			}); // /.ajax
			return false;
		}); // /submi the add markhseet form
	}
}


/*
*----------------------------
* update marksheet function
*----------------------------
*/
function editMarksheet(marksheetId = null, classId = null)
{
	if(marksheetId) {

		$("#editMarksheetForm")[0].reset();
		$('form-group').removeClass('has-error').removeClass('has-success');
		$('.text-danger').remove();
		$('#edit-marksheet-message').html('');

		$("#editDate").calendarsPicker({
			dateFormat: 'yyyy-mm-dd'
		});

		$.ajax({
			url: base_url + 'marksheet/fetchMarksheetDataByMarksheetId/'+marksheetId,
			type: 'post',
			dataType: 'json',
			success:function(response) {
				$("#editMarksheetName").val(response.marksheet_name);
				$("#editDate").val(response.marksheet_date);

				/*
				*-------------------------------------------------------
				* submit the update marksheet form
				*-------------------------------------------------------
				*/
				$("#editMarksheetForm").unbind('submit').bind('submit', function() {
					var form = $(this);
					var url = form.attr('action');
					var type = form.attr('method');

					$.ajax({
						url: url + '/' + marksheetId + '/' + classId,
						type: type,
						data: form.serialize(),
						dataType: 'json',
						success:function(response) {
							if(response.success == true) {						
								$("#edit-marksheet-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
								  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
								  response.messages + 
								'</div>');		
								
								$('.form-group').removeClass('has-error').removeClass('has-success');
								$('.text-danger').remove();			

								$("#manageMarksheetTable").load('marksheet/fetchUpdateMarksheetTable/' + classId);								
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
						} // /.success
					}); // /.ajax

					return false;
				});

			} // /.success
		}); // /.ajax
	} // /.if
}

/*
*------------------------------------------------
* remove marksheet
*------------------------------------------------
*/
function removeMarksheet(marksheetId = null, classId = null)
{
	if(marksheetId) {		
		// remove marksheet btn clicked in the modal
		$("#removeMarksheetBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: base_url + 'marksheet/remove/' + marksheetId,
				type: 'post',
				dataType:'json',
				success:function(response) {
					$("#removeMarksheetModal").modal('hide');

					if(response.success == true) {
						$("#remove-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');						

						$("#manageMarksheetTable").load('marksheet/fetchUpdateMarksheetTable/'+classId);
					} 
					else {
						$("#remove-message").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');
					}
				}
			});
		}); // /.remove marksheet btn clicked
	}
}

/*
*----------------------------------------------------------------------
* MANAGE MARKS OF STUDENT'S MARKSHEET
*----------------------------------------------------------------------
*/
function editMarks(studentId = null, classId = null)
{
	if(studentId && classId) {
		var marksheetId = $("#marksheet_id").val();

		$("#edit-mark-result").load(base_url + 'marksheet/studentMarksheetData/'+studentId+'/'+classId+'/'+marksheetId, function() {

			/*clearing the form error message*/
			$("#createStudentMarksForm")[0].reset();
			$(".form-group").removeClass('has-error').removeClass('has-success');
			$('.text-danger').remove();
			$('#edit-mark-message').html('');

			$("#createStudentMarksForm").unbind('submit').bind('submit', function() {
				var form = $(this);
				var url = form.attr('action');
				var type = form.attr('method');

				$.ajax({
					url: url,
					type: type,
					data: form.serialize(),
					dataType: 'json',
					success:function(response) {
						if(response.success == true) {
							$("#edit-mark-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  response.messages + 
							'</div>');						

							$(".form-group").removeClass('has-error').removeClass('has-success');
							$('.text-danger').remove();							

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
					} // /.successs
				});  // /.ajax
				return false;
			});
		});
	}
}

/*
*----------------------------------------------------------------------
* VIEW MARKS OF STUDENT'S MARKSHEET
*----------------------------------------------------------------------
*/
function viewMarks(studentId = null, classId = null)
{	
	if(studentId && classId) {		
		marksheetId = $("#marksheet_id").val();		
		$("#view-mark-result").load(base_url + 'marksheet/viewStudentMarksheet/'+studentId+'/'+classId+'/'+marksheetId);
	}
}