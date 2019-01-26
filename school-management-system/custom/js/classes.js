var manageClassTable;
var base_url = $("#base_url").val();

$(document).ready(function() {
	$("#topClassMainNav").addClass('active');
	$("#topNavClass").addClass('active');	

	manageClassTable = $("#manageClassTable").DataTable({
		'ajax' : base_url + 'classes/fetchClassData',
		'order': []
	});

	/*
	*------------------------------------
	* Add class modal button clicked
	*------------------------------------
	*/
	$("#addClassModelBtn").on('click', function() {
		$("#createClassForm")[0].reset();
		$(".form-group").removeClass('has-error').removeClass('has-success');
		$("#add-class-messages").html('');
		$('.text-danger').remove();

		$("#createClassForm").unbind('submit').bind('submit', function() {
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

						$("#add-class-messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');					

						manageClassTable.ajax.reload(null, false);

						$("#createClassForm")[0].reset();
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
					}
				} // /success
			}); // /ajax
			return false;
		}); // /create class form submit
	}); // /add class model btn

}); // /document

function editClass(class_id = null)
{
	if(class_id) {
		/*Clear the form*/
		$(".form-group").removeClass('has-error').removeClass('has-success');
		$('.text-danger').remove();
		$("#edit-class-messages").html('');
		$("#classId").remove();

		$.ajax({
			url: base_url + 'classes/fetchClassData/'+class_id,
			type: 'post',
			dataType: 'json',
			success:function(response) {
				$("#editClassName").val(response.class_name);

				$("#editNumericName").val(response.numeric_name);

				// hidden class_id input field
				$(".edit-class-modal-footer").append('<input type="hidden" name="classId" id="classId" value="'+response.class_id+'" />');

				$("#editClassForm").unbind('submit').bind('submit', function() {
					var form = $(this);
					var url = form.attr('action');
					var type = form.attr('method');


					$.ajax({
						url: url + '/' + class_id,
						type: type,
						data: form.serialize(),
						dataType: 'json',
						success:function(response) {
							if(response.success == true) {
								$("#edit-class-messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
								  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
								  response.messages + 
								'</div>');					

								manageClassTable.ajax.reload(null, false);
							
								$(".form-group").removeClass('has-error').removeClass('has-success');
								$(".text-danger").remove();
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
									$("#edit-class-messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
									  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									  response.messages + 
									'</div>');			
								} // /else									
							} // /else
						} // /success
					}); // /ajax

					return false;
				});


			} // /successs
		}); // /ajax
	} // /
}

/*
*------------------------------------
* remove class function
*------------------------------------
*/
function removeClass(class_id = null)
{
	if(class_id) {
		$("#removeClassBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: base_url + 'classes/remove/' + class_id,
				type: 'post',
				dataType: 'json',
				success:function(response) {
					if(response.success === true) {
						$("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');

						manageClassTable.ajax.reload(null, false);

						$("#removeClassModal").modal('hide');
					} 
					else {
						$("#remove-messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
						  	'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  	response.messages + 
						'</div>');						
					}
				} // /success
			}); // /ajax
		}); // /remove class btn
	} // /if
} // /remove class