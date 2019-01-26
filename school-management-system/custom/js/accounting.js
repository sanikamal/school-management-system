var managePaymentTable;
var manageStudentPayTable;
var manageExpeneseTable;
var manageIncomeTable;

var base_url = $("#base_url").val();

$(document).ready(function() {
	$("#topAccountMainNav").addClass('active');

	var request = $("#request").text();

	if(request == 'crtpay') {
		$("#createStudentNav").addClass('active');

		// fetching the payment type id
		$("#type").unbind('change').bind('change', function() {
			var id = $(this).val();			

			$("#div-result").load(base_url + 'accounting/fetchType/'+id, function() {
				
				// start and date calendar picker
				$('#startDate').calendarsPicker({
					dateFormat: 'yyyy-mm-dd'
				});
				$('#endDate').calendarsPicker({
					dateFormat: 'yyyy-mm-dd'
				});

				// selecting the class to fetch section data
				$("#className").unbind('change').bind('change', function() {					
					var classId = $(this).val();
					
					$("#sectionName").load(base_url + 'accounting/fetchClassSection/'+classId, function() {
						var sectionId = $(this).val();
						
						$("#studentName").load(base_url + 'accounting/fetchStudent/'+classId+'/'+sectionId+'/'+id);							


						
					}); // /.fetching the selected class's section date					

					// change in section
					$("#sectionName").unbind('change').bind('change', function() {
						var sectionId = $(this).val();
						$("#studentName").load(base_url + 'accounting/fetchStudent/'+classId+'/'+sectionId+'/'+id);
					}); // .change in section

				}); // /.selecting the class to fetch section data			

				/*
				* ----------------------------------------------------
				* submit the create individual form
				* ----------------------------------------------------
				*/
				$("#createIndividualForm").unbind('submit').bind('submit', function() {						
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
								$("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
								  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
								  response.messages + 
								'</div>');		
								
								$('.form-group').removeClass('has-error').removeClass('has-success');
								$('.text-danger').remove();

								$('#createIndividualForm')[0].reset();
								$('#className').val('');
								$('#sectionName').html('<option value="">Select Class</option>');
								$('#studentName').html('<option value="">Select Class & Section</option>');

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
						} // /.success
					}); // /.ajax

					return false;
				});
			
								
				/*
				* ----------------------------------------------------
				* submit the bulk form
				* ----------------------------------------------------
				*/
				$("#createBulkForm").unbind('submit').bind('submit', function() {						
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
								$("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
								  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
								  response.messages + 
								'</div>');		
								
								$('.form-group').removeClass('has-error').removeClass('has-success');
								$('.text-danger').remove();

								$('#createBulkForm')[0].reset();
								$('#className').val('');
								$('#sectionName').html('<option value="">First Select Class</option>');

								$('#studentName').html('<thead><tr><th>#</th><th>Name</th></tr></thead><tbody><tr><td colspan="2"><center>First Select Class and Section</center></td></tr></tbody>');

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
									$("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
									  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									  response.messages + 
									'</div>');										
								}
							}
						} // /.success
					}); // /.ajax

					return false;
				});													
			}); // /.fetching the type form 

		});
	} 
	else if(request == 'mgpay') {
		$("#managePayNav").addClass('active');

		managePaymentTableFunc();

		/*click on the left side bar of manage payment information*/
		$("#managePaymentInfo").unbind('click').bind('click', function() {
			managePaymentTableFunc();
		});
		
		/*click on the left side bar of manage student payment*/
		$("#manageStudentPayInfo").unbind('click').bind('click', function() {
			$("#managePaymentInfo").removeClass('active');
			$("#manageStudentPayInfo").addClass('active');

			$("#managePaymentDiv").load(base_url + 'accounting/fetchManageStudentPayTable', function() {
				manageStudentPayTable = $("#manageStudentPayTable").DataTable({
					'ajax' : 'accounting/fetchManageStudentPayData',
					'order' : []
				});
			});				
		});
	} 
	else if(request == 'mgexp') {
		$("#expNav").addClass('active');

		manageExpeneseTable = $("#manageExpeneseTable").DataTable({
			'ajax' : base_url + 'accounting/fetchExpensesData',
			'order' : []			
		});
		$("#totalAmount").attr('disabled', true);
		$("#expensesDate").calendarsPicker({
			dateFormat: 'yyyy-mm-dd'
		});
	}
	else if(request == 'ime') {
		$("#incomeNav").addClass('active');
		manageIncomeTable = $("#manageIncomeTable").DataTable({
			'ajax' : base_url + 'accounting/fetchIncomeData',
			'order': []
		});
	}
}); // /.document

/*fetching the payment table*/
function managePaymentTableFunc()
{
	$("#managePaymentDiv").load(base_url + 'accounting/fetchManagePaymentTable', function() {
			managePaymentTable = $("#managePaymentTable").DataTable({
				'ajax' : base_url + 'accounting/fetchPaymentData',
				'order' : []			
			});
		});		

	$("#managePaymentInfo").addClass('active');
	$("#manageStudentPayInfo").removeClass('active');
}


/*
*--------------------------------------------------------------------------------
* manage payment's info function
*--------------------------------------------------------------------------------
*/

/*
	UPDATE WANTS HERE
	id = payment_table `id`
	studentype = student type i.e. 1 = individual, 2 = bulk
*/
function updatePayment(id = null, studentType = null)
{
	if(id && studentType) {
		$("#edit-student-messages").html('');

		$("#edit-result").load(base_url + 'accounting/fetchUpdatePaymentForm/'+studentType, function() {
			
			// start and date calendar picker
			$('#editStartDate').calendarsPicker({
				dateFormat: 'yyyy-mm-dd'
			});
			$('#editEndDate').calendarsPicker({
				dateFormat: 'yyyy-mm-dd'
			});

			$.ajax({
				url: base_url + 'accounting/fetchPaymentById/'+id,
				type: 'post',
				dataType: 'json',
				success:function(response) {
					var class_id;
					var section_id;										
					var student_id = [];

					$.each(response.payment, function(index, value) {					
						class_id = value.class_id;
						section_id = value.section_id;										
						student_id[index] = value.student_id;
					});

					$("#editPaymentName").val(response.name.name);
					$("#editStartDate").val(response.name.start_date);
					$("#editEndDate").val(response.name.end_date);
					$("#editTotalAmount").val(response.name.total_amount);
					
					$("#editClassName").val(class_id);


					/*fetching the class's section option value*/
					$("#editSectionName").load(base_url + 'accounting/fetchClassSection/'+class_id, function(index, value) {
						$("#editSectionName").val(section_id);
							
						//fetch the student's data, this is for type = 1, individual
						// $("#editStudentName").load('accounting/fetchStudent/'+class_id+'/'+section_id+'/'+1);

						if(studentType == 1) {
						// individual
							$("#studentData").load(base_url + 'accounting/fetchStudent/'+class_id+'/'+section_id+'/'+studentType, function() {
								$("#studentData").val(student_id); 							
							});
						}
						else if(studentType == 2) {
							// fetch the student's data, this is for type = 2 , bulk
							$("#studentData").load(base_url + 'accounting/fetchStudentForPaymentUpdate/'+class_id+'/'+section_id, function() {
								$.each(student_id, function(stu_index, stu_value) {	
									$("#editStudentId"+stu_value).attr('checked', true);
								});
							}); // /.fetch the student's data 	
						}

							

						var classId;
						$("#editClassName").unbind('change').bind('change', function() {
							classId = $(this).val();
							$("#editSectionName").load(base_url + 'accounting/fetchSectionClassForBulkStudent/'+classId, function() {
								var sectionId = $(this).val();

								// now fetches the student info
								$("#studentData").load(base_url + 'accounting/fetchEditStudent/'+classId+'/'+sectionId+'/'+studentType);						
							});						
						});		

						// change in the section 
						$("#editSectionName").unbind('change').bind('change', function() {
							var selectedSectionId = $(this).val();

							$("#studentData").load(base_url + 'accounting/fetchEditStudent/'+classId+'/'+selectedSectionId+'/'+studentType);						
						});		


						/*
						*-----------------------------------------------------
						* update the student payment form
						* `id` = payment table's `id`
						*-----------------------------------------------------
						*/
						$("#updatePaymentFrom").unbind('submit').bind('submit', function() {
							var form = $(this);
							var url = form.attr('action');
							var type = form.attr('method');

							$.ajax({
								url: url + '/' + id + '/' + studentType,
								type: type,
								data: form.serialize(),
								dataType: 'json',
								success:function(response) {
									if(response.success == true) {
										$("#edit-student-messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
										  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
										  response.messages + 
										'</div>');		
										
										$('.form-group').removeClass('has-error').removeClass('has-success');
										$('.text-danger').remove();		

										$("#managePaymentTable").ajax.reload(null, false);																							

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
											$("#edit-student-messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
											  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
											  response.messages + 
											'</div>');										
										}
									}
								} // /.success
							});
							return false;
						});
	 
					}); /*fetching the class's section option value*/

				} // /.success
			}); // /ajax


		}); // /.load the type

			
	}
}

/*
*-------------------------------
* remove payment's info function
*-------------------------------
*/

function removePayment(id = null) 
{
	if(id) {
		$("#removePaymentBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: base_url + 'accounting/removePayment/'+id,
				type: 'post',
				dataType: 'json',
				success:function(response) {				

					if(response.success == true) {
						$("#removePayment").modal('hide');

						$("#remove-payment-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');

						managePaymentTable.ajax.reload(null, false);						
					}
					else {
						$("#remove-payment-message").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');
					}
				} // /.success
			});	 // /.ajax
		});
	}
}

/*
*---------------------------------------------------------------------------------------------
* Student's payment section
*---------------------------------------------------------------------------------------------
*/

/*
*------------------------------------------------
* update student payment 
* in this section first of all,
* function fetchces the payment 
* info and update the information
* id = payment_id from the `payment` table
*-------------------------------------------------
*/
function updateStudentPay(id = null)
{
	$("#edit-student-result").load(base_url + 'accounting/fetchStudentPaymentInfo/'+id, function() {

		$("#studentPayDate").calendarsPicker({
			dateFormat: 'yyyy-mm-dd'
		});

		$("#updateStudentPayForm").unbind('submit').bind('submit', function() {
			var form = $(this);
			var url = form.attr('action');
			var type = form.attr('method');

			$.ajax({
				url: url + '/' + id,
				type: type,
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					if(response.success == true) {					

						$("#update-student-payment-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');					
												
						$(".form-group").removeClass('has-error').removeClass('has-success');
						$(".text-danger").remove();		
																								
						manageStudentPayTable.ajax.reload(null, false);
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
				} // /.success
			}); // /ajax

			return false;
		}); // /.udpate student pay form submit


	}); // /result of the update student payment form
}

/*
*-------------------------------
* remove student's payment func
*-------------------------------
*/
function removeStudentPay(id = null)
{
	if(id) {
		$("#removeStudentPayBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: base_url + 'accounting/removeStudentPay/'+id,
				type: 'post',
				dataType: 'json',
				success:function(response) {
					if(response.success == true) {
						$("#removeStudentPay").modal('hide');

						$("#remove-stu-payment-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');

						manageStudentPayTable.ajax.reload(null, false);						
					}
					else {
						$("#remove-stu-payment-message").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');
					}
				} // /.success
			}); // /.ajax
		}); // /.remove button clicked
	} // /.if
}

/*
*-------------------------------
* MANAGE EXPENSES FUNCTIONS
*-------------------------------
*/
/*
*-------------------------------
* ADD EXPENSES FUNCTION
*-------------------------------
*/
function addExpenses() 
{
	$("#createEpxensesForm").unbind('submit').bind('submit', function() {
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
						$("#add-expenses-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');		
						
						$('.form-group').removeClass('has-error').removeClass('has-success');
						$('.text-danger').remove();		

						manageExpeneseTable.ajax.reload(null, false);

						$("#createEpxensesForm")[0].reset();				
						$(".appended-exp-row").remove();
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
		}); // /.ajax funciton
		return false;
	});
}

/*
*-------------------------------
* ADD EXPENSES ROW FUNCTION
*-------------------------------
*/
function addExpensesRow()
{
	var tableLength = $("#addSubExpensesTable tbody tr").length;

	var tableRow;
	var arrayNumber;
	var count;

	if(tableLength > 0) {		
		tableRow = $("#addSubExpensesTable tbody tr:last").attr('id');
		arrayNumber = $("#addSubExpensesTable tbody tr:last").attr('class');
		count = tableRow.substring(3);	
		count = Number(count) + 1;
		arrayNumber = Number(arrayNumber) + 1;					
	} else {
		// no table row
		count = 1;
		arrayNumber = 0;
	}

	var tr = '<tr id="row'+count+'" class="'+arrayNumber+' appended-exp-row">'+			  						
		'<td class="form-group">'+
			'<input type="text" class="form-control"  name="subExpensesName['+count+']" id="subExpensesName'+count+'" placeholder="Expenses Name" />'+						
		'</td>'+
		'<td class="form-group">'+			
			'<input type="text" class="form-control"  name="subExpensesAmount['+count+']" id="subExpensesAmount'+count+'" onkeyup="calculateTotalAmount()" placeholder="Expenses Amount" />'+									
		'</td>'+		
		'<td class="form-group">'+
			'<button type="button" class="btn btn-default" onclick="removeExpensesRow('+count+')"><i class="glyphicon glyphicon-remove"></i></button>'+
		'</td>'+
	'</tr>';
	
	if(tableLength > 0) {							
		$("#addSubExpensesTable tbody tr:last").after(tr);
	} else {				
		$("#addSubExpensesTable tbody").append(tr);
	}				
}

/*
*-------------------------------
* ADD EXPENSES ROW FUNCTION
*-------------------------------
*/
function addEditExpensesRow()
{
	var tableLength = $("#editSubExpensesTable tbody tr").length;

	var tableRow;
	var arrayNumber;
	var count;

	if(tableLength > 0) {		
		tableRow = $("#editSubExpensesTable tbody tr:last").attr('id');
		arrayNumber = $("#editSubExpensesTable tbody tr:last").attr('class');
		count = tableRow.substring(3);	
		count = Number(count) + 1;
		arrayNumber = Number(arrayNumber) + 1;					
	} else {
		// no table row
		count = 1;
		arrayNumber = 0;
	}

	var tr = '<tr id="row'+count+'" class="'+arrayNumber+' appended-exp-row">'+			  						
		'<td class="form-group">'+
			'<input type="text" class="form-control"  name="editSubExpensesName['+count+']" id="editSubExpensesName'+count+'" placeholder="Expenses Name" />'+						
		'</td>'+
		'<td class="form-group">'+			
			'<input type="text" class="form-control"  name="editSubExpensesAmount['+count+']" id="editSubExpensesAmount'+count+'" onkeyup="editCalculateTotalAmount()" placeholder="Expenses Amount" />'+									
		'</td>'+		
		'<td class="form-group">'+
			'<button type="button" class="btn btn-default" onclick="removeEditExpensesRow('+count+')"><i class="glyphicon glyphicon-remove"></i></button>'+
		'</td>'+
	'</tr>';
	
	if(tableLength > 0) {							
		$("#editSubExpensesTable tbody tr:last").after(tr);
	} else {				
		$("#editSubExpensesTable tbody").append(tr);
	}				
}

/*
*-------------------------------
* REMOVE EXPENSES ROW FUNCTION
*-------------------------------
*/
function removeExpensesRow(row = null)
{
	if(row) {
		$("#addSubExpensesTable #row"+row).remove();	
		calculateTotalAmount();
	}
}



/*
*-------------------------------
* CALCULATES THE SUB AMOUNT OF 
* THE EXPENSES AND EVALUATE THE 
* TOTAL AMOUNT OF THE EXPENSES
*-------------------------------
*/
function calculateTotalAmount()
{
	var tableProductLength = $("#addSubExpensesTable tbody tr").length;
	var totalAmount = 0;
	for(x = 0; x < tableProductLength; x++) {
		var tr = $("#addSubExpensesTable tbody tr")[x];
		var count = $(tr).attr('id');
		count = count.substring(3);
					
		totalAmount = Number(totalAmount) + Number($("#subExpensesAmount"+count).val());


	} // /for

	totalAmount = totalAmount.toFixed(2);

	// sub total
	$("#totalAmount").val(totalAmount);
	$("#totalAmountValue").val(totalAmount);
	
}



/*
*--------------------------------------------------------------
* UPDATE EXPESNSE FROM DATABASE
* fetches the expenses data from the expenses and 
* display the expenses data into the edit expenses field
* after that updates the expenses data into the database
*--------------------------------------------------------------
*/
function updateExpenses(id = null) 
{
	if(id) {
		$("#editSubExpensesTable tbody tr").remove();

		$.ajax({
			url: base_url + 'accounting/fetchExpensesDataForUpdate/'+id,
			type: 'post',			
			success:function(response) {
				$("#show-edit-expenses-result").html(response);					

				$("#editTotalAmount").attr('disabled', true);
				$("#editExpensesDate").calendarsPicker({
					dateFormat: 'yyyy-mm-dd'
				});		

				/*SUBMIT FORM*/
				$("#editEpxensesForm").unbind('submit').bind('submit', function() {					
					var form = $(this);
					var url = form.attr('action');
					var type = form.attr('method');

					$.ajax({
						url: url + '/' + id,
						type: type,
						data: form.serialize(),
						dataType: 'json',
						success:function(response) {
							if(response.success == true) {						
								$("#edit-expenses-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
								  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
								  response.messages + 
								'</div>');		
								
								$('.form-group').removeClass('has-error').removeClass('has-success');
								$('.text-danger').remove();		

								manageExpeneseTable.ajax.reload(null, false);
																
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
				}); // /.submit edit expenses form
				
			} // /success
		}); // /.ajax
	} // /.if
} // /.update epxense function

/*
*-------------------------------------
* REMOVE EXPESNSE ROW FROM THE TABLE
*-------------------------------------
*/
function removeEditExpensesRow(row = null)
{
	if(row) {		
		$("#editSubExpensesTable #row"+row).remove();	
		editCalculateTotalAmount();
	}
}

/*
*-------------------------------
* CALCULATE THE TOTAL AMOUNT
*-------------------------------
*/
function editCalculateTotalAmount()
{
	var tableProductLength = $("#editSubExpensesTable tbody tr").length;
	var totalAmount = 0;
	for(x = 0; x < tableProductLength; x++) {
		var tr = $("#editSubExpensesTable tbody tr")[x];
		var count = $(tr).attr('id');
		count = count.substring(3);
					
		totalAmount = Number(totalAmount) + Number($("#editSubExpensesAmount"+count).val());
	} // /for

	totalAmount = totalAmount.toFixed(2);

	// sub total
	$("#editTotalAmount").val(totalAmount);
	$("#editTotalAmountValue").val(totalAmount);
	
}


/*
*-------------------------------
* REMOVE EXPESNSE FROM DATABASE
*-------------------------------
*/
function removeExpenses(id = null)
{
	if(id) {
		$("#removeExpensesBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: base_url + 'accounting/removeExpenses/'+id,
				type: 'post',
				dataType: 'json',
				success:function(response) {
					$("#removeExpensesModal").modal('hide');

					if(response.success == true) {						
						$("#remove-expenses-messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');												

						manageExpeneseTable.ajax.reload(null, false);											
					}	
					else {									
						
						$("#remove-expenses-messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');		
												
					} // /else
				}
			});
		});
	}
}

/*
* -------------------------------------------
* view the income 
* -------------------------------------------
*/
function viewIncome(paymentId = null)
{
	if(paymentId) {
		$('#incomeResult').load(base_url + 'accounting/viewIncomeDetail/'+paymentId);
	}
}