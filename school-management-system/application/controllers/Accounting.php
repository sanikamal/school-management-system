<?php 

class Accounting extends MY_Controller 
{
	public function __construct() 
	{
		parent::__construct();

		$this->isNotLoggedIn();

		// loading the teacher model
		$this->load->model('model_student');
		// loading the classes model		
		$this->load->model('model_classes');
		// loading the section model
		$this->load->model('model_section');		
		// accounting
		$this->load->model('model_accounting');
		

		// loading the form validation library
		$this->load->library('form_validation');	
	}


	/*
	* CREATE PAYMENT
	*---------------------------------------------------------------
	*/

	public function fetchType($type = null)
	{
		if($type == 1) {

			$classData = $this->model_classes->fetchClassData();			

			$div = '<form class="form-horizontal" action="accounting/createIndividual" method="post" id="createIndividualForm">	    	
		  	<div class="form-group">
		    	<label for="className" class="col-sm-2 control-label">Class Name</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="className" id="className">
		      			<option value="">Select Class</option>';
		      			foreach ($classData as $key => $value) {		      				
		      				$div .= '<option value="'.$value['class_id'].'">'.$value['class_name'].'</option>';
		      			} // .foreach
		      		$div .= '</select>
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label for="sectionName" class="col-sm-2 control-label">Section Name</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="sectionName" id="sectionName">
		      			<option value="">Select Class</option>
		      		</select>
		    	</div>
		  	</div>		  				 		  
		  	<div class="form-group">
		    	<label for="studentName" class="col-sm-2 control-label">Student</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="studentName" id="studentName">
		      			<option value="">Select Class & Section</option>
		      		</select>
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label for="paymentName" class="col-sm-2 control-label">Payment Name</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control" id="paymentName" name="paymentName" placeholder="Payment Name">
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label for="startDate" class="col-sm-2 control-label">Start Date</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control" id="startDate" name="startDate" placeholder="Start Date">
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label for="endDate" class="col-sm-2 control-label">End Date</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control" id="endDate" name="endDate" placeholder="End Date">
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label for="totalAmount" class="col-sm-2 control-label">Total Amount</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control" id="totalAmount" name="totalAmount" placeholder="Total Amount">
		    	</div>
		  	</div>
			<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      <button type="submit" class="btn btn-primary">Create</button>
			    </div>
			</div>
		</form>';
		} // /.individual
		else if($type == 2) {
			$classData = $this->model_classes->fetchClassData();			

			$div = '<form class="form-horizontal" action="accounting/createBulk" method="post" id="createBulkForm">	    	

			<div class="col-sm-6">
				<div class="form-group">
			    	<label for="className" class="col-sm-2 control-label">Class Name</label>
			    	<div class="col-sm-10">
			      		<select class="form-control" name="className" id="className">
			      			<option value="">Select Class</option>';
			      			foreach ($classData as $key => $value) {		      				
			      				$div .= '<option value="'.$value['class_id'].'">'.$value['class_name'].'</option>';
			      			} // .foreach
			      		$div .= '</select>
			    	</div>
			  	</div>
			  	<div class="form-group">
			    	<label for="sectionName" class="col-sm-2 control-label">Section Name</label>
			    	<div class="col-sm-10">
			      		<select class="form-control" name="sectionName" id="sectionName">
			      			<option value="">First Select Class</option>
			      		</select>
			    	</div>
			  	</div>		  				 		  		  	
			  	<div class="form-group">
			    	<label for="paymentName" class="col-sm-2 control-label">Payment Name</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="paymentName" name="paymentName" placeholder="Payment Name">
			    	</div>
			  	</div>
			  	<div class="form-group">
			    	<label for="startDate" class="col-sm-2 control-label">Start Date</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="startDate" name="startDate" placeholder="Start Date">
			    	</div>
			  	</div>
			  	<div class="form-group">
			    	<label for="endDate" class="col-sm-2 control-label">End Date</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="endDate" name="endDate" placeholder="End Date">
			    	</div>
			  	</div>
			  	<div class="form-group">
			    	<label for="totalAmount" class="col-sm-2 control-label">Total Amount</label>
			    	<div class="col-sm-10">
			      		<input type="text" class="form-control" id="totalAmount" name="totalAmount" placeholder="Total Amount">
			    	</div>
			  	</div>
			</div>
			<!--/.col-sm-6--> 

			<div class="col-sm-6">
				<div class="page-header">
					<h3>Student Information</h3>
				</div>

				<table id="studentName" class="table table-bordered">
					<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>
						<tr>
							<td colspan="2"><center>First Select Class and Section</center></td>	
						</tr>
					</tbody>
				</table>
			</div>
			  	
			<div class="form-group">
			    <div class="col-sm-offset-1 col-sm-10">
			      <button type="submit" class="btn btn-primary">Create Payment</button>
			    </div>
			</div>
		</form>';
		} // /.bulk
		else {
			$div = '';
		}

		echo $div;
	}

	/*
	*------------------------------------------------
	* fetches the class's section info	
	*------------------------------------------------
	*/
	public function fetchClassSection($classId = null) 
	{
		if($classId) {
			$sectionData = $this->model_section->fetchSectionDataByClass($classId);
			$option = '';
			if($sectionData) {
				foreach ($sectionData as $key => $value) {
					$option .= '<option value="'.$value['section_id'].'">'.$value['section_name'].'</option>';
				} // /foreach
			}
			else {
				$option = '<option value="">No Data</option>';
			} // /else empty section

			echo $option;
		}
	}

	/*
	*------------------------------------------------
	* fetches the student info by class and section 
	*------------------------------------------------
	*/
	public function fetchStudent($classId = null, $sectionId = null, $type = null) 
	{
		if($classId && $sectionId && $type) {

			$studentData = $this->model_student->fetchStudentByClassAndSection($classId, $sectionId);

			if($type == 1) {
				// /.individual
				if($studentData) {
					$option = '';					
					foreach ($studentData as $key => $value) {
						$studentName = $value['fname'] . ' ' .$value['lname'];
						$option .= '<option value="'.$value['student_id'].'">'.$studentName.'</option>';
					} // /foreach
				}
				else {
					$option = '<option value="">No Data</option>';
				} // /else empty section
			}
			else if($type == 2) {

				if($studentData) {				
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>';
						$x = 1;
						foreach ($studentData as $key => $value) {
							$option .= '<tr>
								<td><input type="checkbox" name="studentId['.$x.']" value="'.$value['student_id'].'" class="form-control" /> </td>
								<td>'.$value['fname'] .' '. $value['lname'] .'</td>
							</tr>';
							$x++;
						}							
					$option .= '</tbody>';
				} else {
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>
						<tr>
							<td colspan="2"><center>No Data Available</center></td>	
						</tr>
					</tbody>';
				}				 
			}				

			echo $option;
		}
	}

	/*
	*---------------------------------------------------------
	* fetches the student info for update by class and section 
	*----------------------------------------------------------
	*/
	public function fetchEditStudent($classId = null, $sectionId = null, $type = null) 
	{
		if($classId && $sectionId && $type) {

			$studentData = $this->model_student->fetchStudentByClassAndSection($classId, $sectionId);

			if($type == 1) {
				// /.individual
				if($studentData) {
					foreach ($studentData as $key => $value) {
						$studentName = $value['fname'] . ' ' .$value['lname'];
						$option .= '<option value="'.$value['student_id'].'">'.$studentName.'</option>';
					} // /foreach
				}
				else {
					$option = '<option value="">No Data</option>';
				} // /else empty section
			}
			else if($type == 2) {

				if($studentData) {				
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>';
						$x = 1;
						foreach ($studentData as $key => $value) {
							$option .= '<tr>
								<td><input type="checkbox" name="editStudentId['.$x.']" value="'.$value['student_id'].'" class="form-control" /> </td>
								<td>'.$value['fname'] .' '. $value['lname'] .'</td>
							</tr>';
							$x++;
						}							
					$option .= '</tbody>';
				} else {
					$option = '<thead>
						<tr>
							<th>#</th>							
							<th>Name</th>							
						</tr>						
					</thead>
					<tbody>
						<tr>
							<td colspan="2"><center>No Data Available</center></td>	
						</tr>
					</tbody>';
				}				 
			}				

			echo $option;
		}
	}

	/*
	*------------------------------------------------
	* creates the individual student's payment
	*------------------------------------------------
	*/
	public function createIndividual() 
	{
		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'className',
				'label' => 'Class Name',
				'rules' => 'required'
			),
			array(
				'field' => 'sectionName',
				'label' => 'Section Name',
				'rules' => 'required'
			),
			array(
				'field' => 'studentName',
				'label' => 'Student Name',
				'rules' => 'required'
			),
			array(
				'field' => 'paymentName',
				'label' => 'Payment Name',
				'rules' => 'required'
			),
			array(
				'field' => 'startDate',
				'label' => 'Start Date',
				'rules' => 'required'
			),
			array(
				'field' => 'endDate',
				'label' => 'End Date',
				'rules' => 'required'
			),
			array(
				'field' => 'totalAmount',
				'label' => 'Total Amount',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true) {	
			$create = $this->model_accounting->createIndividual();					
			if($create === true) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully added";
			}
			else {
				$validator['success'] = false;
				$validator['messages'] = "Error while inserting the information into the database";
			}			
		} 	
		else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}			
		} // /else

		echo json_encode($validator);
	}


	/*
	*------------------------------------------------
	* creates the bulk student's payment
	*------------------------------------------------
	*/
	public function createBulk() 
	{
		$validator = array('success' => false, 'messages' => array());
			
		$validate_data = array(
			array(
				'field' => 'className',
				'label' => 'Class Name',
				'rules' => 'required'
			),
			array(
				'field' => 'sectionName',
				'label' => 'Section Name',
				'rules' => 'required'
			),			
			array(
				'field' => 'paymentName',
				'label' => 'Payment Name',
				'rules' => 'required'
			),
			array(
				'field' => 'startDate',
				'label' => 'Start Date',
				'rules' => 'required'
			),
			array(
				'field' => 'endDate',
				'label' => 'End Date',
				'rules' => 'required'
			),
			array(
				'field' => 'totalAmount',
				'label' => 'Total Amount',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true) {				
			$create = $this->model_accounting->createBulk();					
			if($create === true) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully added";
			}
			else {
				$validator['success'] = false;
				$validator['messages'] = "Select at least one student";
			}			
		} 	
		else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}			
		} // /else

		echo json_encode($validator);
	}


	/*
	* /. END OF CREATE PAYMENT SECTION
	*---------------------------------------------------------------
	*/

	/*
	*---------------------------------------------------------------
	* fetch payments' information from the database
	*---------------------------------------------------------------
	*/
	public function fetchPaymentData()
	{
		$paymentData = $this->model_accounting->fetchPaymentData();

		$result = array('data' => array());
		foreach ($paymentData as $key => $value) {

			$button = '
			<div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    Action <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu">
			    <li><a href="#" data-toggle="modal" data-target="#editPayment" onclick="updatePayment('.$value['id'].','.$value['type'].')">Edit</a></li>
			    <li><a href="#" data-toggle="modal" data-target="#removePayment" onclick="removePayment('.$value['id'].')">Remove</a></li>    
			  </ul>
			</div>';

			$result['data'][$key] = array(
				$value['name'],
				$value['start_date'],
				$value['end_date'],
				$button
			);	
		}			

		echo json_encode($result);
	}

	/*
	*---------------------------------------------------------------
	* fetch students' payment information from the database
	*---------------------------------------------------------------
	*/
	public function fetchManageStudentPayData()
	{
		$paymentData = $this->model_accounting->fetchStudentPayData();

		$result = array('data' => array());
		foreach ($paymentData as $key => $value) {
			$classData = $this->model_classes->fetchClassData($value['class_id']);
			$sectionData = $this->model_section->fetchSectionByClassSection($value['class_id'], $value['section_id']);
			$studentData = $this->model_student->fetchStudentData($value['student_id']);
			$paymentNameData = $this->model_accounting->fetchPaymentData($value['payment_name_id']);

			$status = '';

			if($value['status'] == 0) {
				$status = '<label class="label label-info">pending</label>';
			} else if($value['status'] == 1) {
				$status = '<label class="label label-success">Paid</label>';
			} else if($value['status'] == 2) {
				$status = '<label class="label label-danget">Unpaid</label>';
			}

			$button = '
			<div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    Action <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu">			  				  	
			    <li><a href="#" data-toggle="modal" data-target="#editStudentPay" onclick="updateStudentPay('.$value['payment_id'].')">Edit Payment</a></li>
			    <li><a href="#" data-toggle="modal" data-target="#removeStudentPay" onclick="removeStudentPay('.$value['payment_id'].')">Remove</a></li>    
			  </ul>
			</div>';

			$result['data'][$key] = array(
				$paymentNameData['name'],
				$studentData['fname'] . ' ' . $studentData['lname'],
				$classData['class_name'],
				$sectionData['section_name'],
				$status,
				$button
			);	
		}			

		echo json_encode($result);
	}

	/*
	*---------------------------------------------------------------
	* checks payment type id and retreives the form group
	* type = `1` individual student
	* type = `2` bulk student
	*---------------------------------------------------------------
	*/
	public function fetchUpdatePaymentForm($type = null)
	{
		$classData = $this->model_classes->fetchClassData();

		if($type == 1) {
			$option = '<form class="form-horizontal" action="accounting/updatePayment" method="post" id="updatePaymentFrom">	    	
		  	<div class="form-group">
		    	<label for="editClassName" class="col-sm-2 control-label">Class Name</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="editClassName" id="editClassName">
		      			<option value="">Select Class</option>';
		      			foreach ($classData as $key => $value) {		      				
		      				$option .= '<option value="'.$value['class_id'].'">'.$value['class_name'].'</option>';
		      			} // .foreach
		      		$option .= '</select>
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label for="editSectionName" class="col-sm-2 control-label">Section Name</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="editSectionName" id="editSectionName">
		      			<option value="">Select Class</option>
		      		</select>
		    	</div>
		  	</div>		  				 		  
		  	<div class="form-group">
		    	<label for="studentData" class="col-sm-2 control-label">Student</label>
		    	<div class="col-sm-10">
		      		<select class="form-control" name="studentData" id="studentData">
		      			<option value="">Select Class & Section</option>
		      		</select>
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label for="editPaymentName" class="col-sm-2 control-label">Payment Name</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control" id="editPaymentName" name="editPaymentName" placeholder="Payment Name">
		    	</div>
		  	</div> 
		  	<div class="form-group">
		    	<label for="editStartDate" class="col-sm-2 control-label">Start Date</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control" id="editStartDate" name="editStartDate" placeholder="Start Date">
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label for="editEndDate" class="col-sm-2 control-label">End Date</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control" id="editEndDate" name="editEndDate" placeholder="End Date">
		    	</div>
		  	</div>
		  	<div class="form-group">
		    	<label for="editTotalAmount" class="col-sm-2 control-label">Total Amount</label>
		    	<div class="col-sm-10">
		      		<input type="text" class="form-control" id="editTotalAmount" name="editTotalAmount" placeholder="Total Amount">
		    	</div>
		  	</div>
			<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			    	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      	<button type="submit" class="btn btn-primary">Update</button>
			    </div>
			</div>
		</form>';
		}
		else if($type == 2) {
		
			$option = '<form class="form-horizontal" action="accounting/updatePayment" method="POST" id="updatePaymentFrom">
	      	
	      	<div class="row">
	      	
	      	<div class="col-md-6">

				<div class="form-group">
			    	<label for="editClassName" class="col-sm-4 control-label">Class Name</label>
			    	<div class="col-sm-8">
			      		<select class="form-control" name="editClassName" id="editClassName">      	
			      			<option value="">Select Class</option>';			      			
			      			foreach ($classData as $key => $value) {
			      				$option .= '<option value="'.$value['class_id'].'">'.$value['class_name'].'</option>';
			      			}			      		
			      		$option .= '</select>
			    	</div>
			  	</div>	
			  	<div class="form-group">
			    	<label for="editSectionName" class="col-sm-4 control-label">Section Name</label>
			    	<div class="col-sm-8">
			      		<select class="form-control" name="editSectionName" id="editSectionName">
			      			<option value="">First Select Class</option>
			      		</select>
			    	</div>
			  	</div>	
			  	<div class="form-group">
			    	<label for="editPaymentName" class="col-sm-4 control-label">Payment Name</label>
			    	<div class="col-sm-8">
			      		<input type="text" name="editPaymentName" id="editPaymentName" placeholder="Payment Name" class="form-control" />
			    	</div>
			  	</div>	
			  	<div class="form-group">
			    	<label for="editStartDate" class="col-sm-4 control-label">Start Date</label>
			    	<div class="col-sm-8">
			      		<input type="text" name="editStartDate" id="editStartDate" placeholder="Start Date" class="form-control" />
			    	</div>
			  	</div>	
			  	<div class="form-group">
			    	<label for="editEndDate" class="col-sm-4 control-label">End Date</label>
			    	<div class="col-sm-8">
			      		<input type="text" name="editEndDate" id="editEndDate" placeholder="End Date" class="form-control" />
			    	</div>
			  	</div>	
			  	<div class="form-group">
			    	<label for="sectionName" class="col-sm-4 control-label">Total Amount</label>
			    	<div class="col-sm-8">
			      		<input type="text" name="editTotalAmount" id="editTotalAmount" class="form-control" placeholder="Total Amount"/>
			    	</div>
			  	</div>	

			  	<div class="form-group">
			  		<div class="col-sm-offset-2 col-sm-10">
			  			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        	<button type="submit" class="btn btn-primary">Save changes</button>
			        </div>	
			  	</div>
				  	
			</div>
			<!-- /.col-md-6 -->


			<div class="col-md-6">
				<table class="table table-bordered" id="studentData">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
						</tr>
					</thead>
					
				</table>
			</div>
			<!-- /.col-md-6 -->

	      	</div>
	      	<!-- /.row -->
		   		
      		</form>';

		} 
		else {
			$option = '';
		}

		echo $option;
	}

	/*
	*---------------------------------------------------------------
	* fetches the section data by the class id 	
	*---------------------------------------------------------------
	*/
	public function fetchSectionClassForBulkStudent($classId = null)
	{
		if($classId) {
			$sectionData = $this->model_section->fetchSectionDataByClass($classId);

			if($sectionData) {
				$option = '';
				foreach ($sectionData as $key => $value) {
					$option .= '<option value="'.$value['section_id'].'">'.$value['section_name'].'</option>'; 		
				}
			} 
			else {
				$option = '<option value="">No Data</option>';
			}			
		} 
		else {
			$option = '<option value="">First Select Class</option>';
		}

		echo $option;
	}
	
	/*
	*---------------------------------------------------------------
	* fetch payment' information by payment id from the datatable
	* `$id` = payment_name table's id
	*---------------------------------------------------------------
	*/
	public function fetchPaymentById($id = null)
	{
		if($id) {
			$result['name'] = $this->model_accounting->fetchPaymentData($id);
			$result['payment'] = $this->model_accounting->fetchStudentPaymentById($id);

			echo json_encode($result);
		}
	}

	/*
	*---------------------------------------------------------------
	* fetch student data for payment update
	*---------------------------------------------------------------
	*/
	public function fetchStudentForPaymentUpdate($classId = null, $sectionId = null) 
	{
		$studentData = $this->model_student->fetchStudentByClassAndSection($classId, $sectionId);

		if($studentData) {				
			$option = '<thead>
				<tr>
					<th>#</th>							
					<th>Name</th>							
				</tr>						
			</thead>
			<tbody>';
				$x = 1;
				foreach ($studentData as $key => $value) {
					$option .= '<tr>
						<td><input type="checkbox" name="editStudentId['.$x.']" value="'.$value['student_id'].'" id="editStudentId'.$value['student_id'].'" class="form-control" /> </td>
						<td>'.$value['fname'] .' '. $value['lname'] .'</td>
					</tr>';
					$x++;
				}							
			$option .= '</tbody>';
		} else {
			$option = '<thead>
				<tr>
					<th>#</th>							
					<th>Name</th>							
				</tr>						
			</thead>
			<tbody>
				<tr>
					<td colspan="2"><center>No Data Available</center></td>	
				</tr>
			</tbody>';
		}
		echo $option;
	}

	/*
	*---------------------------------------------------------------
	* fetch the manage payment information table function
	*---------------------------------------------------------------
	*/
	public function fetchManagePaymentTable() 
	{
		$div = '
		<div class="panel panel-default">
			<div class="panel-heading">
				Manage Payment
			</div>
			<div class="panel-body">						
				<div id="remove-payment-message"></div>
					<table id="managePaymentTable" class="table table-bordered">
						<thead>
							<tr>
								<th>Name</th>
								<th>Start Date</th>
								<th>End Date</th>
								<th>Options</th>
							</tr>
						</thead>				
					</table>
			</div><!-- /.panel-body -->
		</div><!-- /.panel -->
		';

		echo $div;
	}

	/*
	*---------------------------------------------------------------
	* fetch the manage student's payment information table function
	*---------------------------------------------------------------
	*/
	public function fetchManageStudentPayTable() 
	{
		$div = '
		<div class="panel panel-default">
			<div class="panel-heading">
				Manage Student Payment
			</div>
			<div class="panel-body">						
				<div id="remove-stu-payment-message"></div>
				<table id="manageStudentPayTable" class="table table-bordered">
					<thead>
						<tr>
							<th>Payment Name</th>
							<th>Student Name</th>
							<th>Class</th>
							<th>Section</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>				
				</table>
			</div><!-- /.panel-body -->
		</div><!-- /.panel -->
		';

		echo $div;
	}
	

	/*
	*---------------------------------------------------------------
	* update the payment information
	* id = `payment_name` table's id primary key
	* type = `1` individual student
	* type = `2` bulk student
	*---------------------------------------------------------------
	*/
	public function updatePayment($id = null, $type = null) 
	{
		if($id && $type) {
			$validator = array('success' => false, 'messages' => array());
			if($type == 1) {
				// individual update
				$validate_data = array(
				array(
					'field' => 'editClassName',
					'label' => 'Class Name',
					'rules' => 'required'
				),
				array(
					'field' => 'editSectionName',
					'label' => 'Section Name',
					'rules' => 'required'
				),
				array(
					'field' => 'studentData',
					'label' => 'Student Name',
					'rules' => 'required'
				),
				array(
					'field' => 'editPaymentName',
					'label' => 'Payment Name',
					'rules' => 'required'
				),
				array(
					'field' => 'editStartDate',
					'label' => 'Start Date',
					'rules' => 'required'
				),
				array(
					'field' => 'editEndDate',
					'label' => 'End Date',
					'rules' => 'required'
				),
				array(
					'field' => 'editTotalAmount',
					'label' => 'Total Amount',
					'rules' => 'required'
				)
			);

			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			if($this->form_validation->run() === true) {	
				$create = $this->model_accounting->updatePayment($id, $type);					
				if($create === true) {
					$validator['success'] = true;
					$validator['messages'] = "Successfully added";
				}
				else {
					$validator['success'] = false;
					$validator['messages'] = "Error while inserting the information into the database";
				}			
			} 	
			else {
				$validator['success'] = false;
				foreach ($_POST as $key => $value) {
					$validator['messages'][$key] = form_error($key);
				}			
			} // /else

				echo json_encode($validator);
			}
			else if($type == 2) {
				// bulk update
				$validate_data = array(
					array(
						'field' => 'editClassName',
						'label' => 'Class Name',
						'rules' => 'required'
					),
					array(
						'field' => 'editSectionName',
						'label' => 'Section Name',
						'rules' => 'required'
					),
					array(
						'field' => 'editPaymentName',
						'label' => 'Payment Name',
						'rules' => 'required'
					),
					array(
						'field' => 'editStartDate',
						'label' => 'Start Date',
						'rules' => 'required'
					),
					array(
						'field' => 'editEndDate',
						'label' => 'End Date',
						'rules' => 'required'
					),
					array(
						'field' => 'editTotalAmount',
						'label' => 'Total Amount',
						'rules' => 'required'
					)
				);

				$this->form_validation->set_rules($validate_data);
				$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

				$this->form_validation->set_rules($validate_data);
				$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

				if($this->form_validation->run() === true) {				
					$create = $this->model_accounting->updatePayment($id, $type);					
					if($create === true) {
						$validator['success'] = true;
						$validator['messages'] = "Successfully added";
					}
					else {
						$validator['success'] = false;
						$validator['messages'] = "Select at least one student";
					}			
				} 	
				else {
					$validator['success'] = false;
					foreach ($_POST as $key => $value) {
						$validator['messages'][$key] = form_error($key);
					}			
				} // /else

				echo json_encode($validator);
			} // /.if
		} // /.if id && type
	}

	/*
	*---------------------------------------------------------------
	* remove the payment info from the database
	*---------------------------------------------------------------
	*/
	public function removePayment($id = null)
	{
		if($id) {
			$validator = array('success' => false, 'messages' => array());

			$remove = $this->model_accounting->removePayment($id);
			if($remove === true) {
				$validator['success'] = true;
				$validator['messages'] = 'Successfully Removed';
			}
			else {
				$validator['success'] = false;
				$validator['messages'] = 'Error while removing';
			}

			echo json_encode($validator);
		}
	}

	/*
	*---------------------------------------------------------------
	* Manage student's payment functions section
	* paymentId is for `payment` table
	* not for `payment_name` table
	* the paymentId will get the data from the `payment` table
	* through the `payment` table data, the function will fetch the 
	* data from the `payment_name` table  
	*---------------------------------------------------------------
	*/
	public function fetchStudentPaymentInfo($paymentId = null)
	{
		if($paymentId) {
			$paymentData = $this->model_accounting->fetchStudentPayData($paymentId);
			$paymentNameData = $this->model_accounting->fetchPaymentData($paymentData['payment_name_id']);
			$classData = $this->model_classes->fetchClassData($paymentData['class_id']);
			$sectionData = $this->model_section->fetchSectionByClassSection($paymentData['class_id'], $paymentData['section_id']);
			$studentData = $this->model_student->fetchStudentData($paymentData['student_id']);

			if($paymentData['paid_amount'] == '') {
				$totalPaid = 0;
			} 
			else {
				$totalPaid = $paymentData['paid_amount'];
			}

			$div = '

			<div id="update-student-payment-message"></div>

			<form class="form-horizontal" action="accounting/updateStudentPay" method="post" id="updateStudentPayForm">
      		<div class="col-md-6">
      			<div class="form-group">
				    <label for="paymentName" class="col-sm-4 control-label">Payment Name: </label>
				    <div class="col-sm-8">
				      <input type="email" class="form-control" id="paymentName" placeholder="Payment Name" disabled value="'.$paymentNameData['name'].'"/>
				    </div>
				  </div>				  
				  <div class="form-group">
				    <label for="startDate" class="col-sm-4 control-label">Start Date: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="startDate" placeholder="Start Date" disabled value="'.$paymentNameData['start_date'].'"/>
				    </div>
				  </div>			  
				  <div class="form-group">
				    <label for="endDate" class="col-sm-4 control-label">End Date: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="endDate" placeholder="End Date" disabled value="'.$paymentNameData['end_date'].'">
				    </div>
			  	  </div>
			  	  <div class="form-group">
				    <label for="className" class="col-sm-4 control-label">Class: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="className" placeholder="Class" disabled value="'.$classData['class_name'].'">
				    </div>
			  	  </div>
			  	  <div class="form-group">
				    <label for="section" class="col-sm-4 control-label">Section: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="section" placeholder="Section" disabled value="'.$sectionData['section_name'].'">
				    </div>
			  	  </div>
      		</div><!-- /div.col-md-6 -->

      		<div class="col-md-6">
      			<div class="form-group">
				    <label for="studentName" class="col-sm-4 control-label">Student Name: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="studentName" placeholder="Student Name" disabled value="'.$studentData['fname'].' '.$studentData['lname'].'">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="totalAmount" class="col-sm-4 control-label">Total Amount: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="totalAmount" placeholder="Total Amounts" disabled value="'.$paymentNameData['total_amount'].'">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="totalAmount" class="col-sm-4 control-label">Total Paid: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="totalAmount" placeholder="Total Amounts" disabled value="'.$totalPaid.'">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="studentPayDate" class="col-sm-4 control-label">Payment Date: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="studentPayDate" name="studentPayDate" placeholder="Payment Date" value="'.$paymentData['payment_date'].'">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="paidAmount" class="col-sm-4 control-label">Paid Amount: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="paidAmount" name="paidAmount" placeholder="Paid Amount" ">
				    </div>
				  </div>			  
				  <div class="form-group">
				    <label for="inputPassword3" class="col-sm-4 control-label">Payment Type: </label>
				    <div class="col-sm-8">
				      <select class="form-control" name="paymentType" id="paymentType">
				      	<option value="" '; 
				      	if($paymentData['status'] == 0) {
				      		$div .="selected";
				      	}
				      	$div.= '>Select</option>
				      	<option value="1" '; 
				      	if($paymentData['status'] == 1) {
				      		$div .="selected";
				      	}
				      	$div.= '>Full Payment</option>
				      	<option value="2" '; 
				      	if($paymentData['status'] == 2) {
				      		$div .="selected";
				      	}
				      	$div.= '>Installment</option>
				      </select>
				    </div>				    
			  	  </div>			  	  
			  	  <div class="form-group">
				    <label for="inputPassword3" class="col-sm-4 control-label">Status: </label>
				    <div class="col-sm-8">
				      <select class="form-control" name="status" id="status">
				      	<option value="">Select</option>
				      	<option value="0" '; 
				      	if($paymentData['status'] == 0) {
				      		$div .="selected";
				      	}
				      	$div.= '>Pending</option>
				      	<option value="1" '; 
				      	if($paymentData['status'] == 1) {
				      		$div .="selected";
				      	}
				      	$div.= '>Paid</option>
				      	<option value="2" '; 
				      	if($paymentData['status'] == 2) {
				      		$div .="selected";
				      	}
				      	$div.= '>Unpaid</option>
				      </select>
				    </div>				    
			  	  </div>
      		</div><!-- /div.col-md-6 -->
      			 
			  <div class="form-group">
			    <div class="col-sm-12">
			    	<center>
			      		<button type="submit" class="btn btn-primary">Save Changes</button>
			      		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      	</center>
			    </div>
			  </div>
			</form>';
		echo $div;
		}
	}


	/*
	*---------------------------------------------------------------
	* update student's payment info section
	* paymentId for `payment` table
	*---------------------------------------------------------------
	*/
	public function updateStudentPay($paymentId = null)
	{
		if($paymentId) {
			$validator = array('success' => false, 'messages' => array());

			$validate_data = array(
				array(
					'field' => 'studentPayDate',
					'label' => 'Payment Date',
					'rules' => 'required'
				),
				array(
					'field' => 'paidAmount',
					'label' => 'Paid Amount',
					'rules' => 'required'
				),
				array(
					'field' => 'paymentType',
					'label' => 'Payment Type',
					'rules' => 'required'
				),
				array(
					'field' => 'status',
					'label' => 'Status',
					'rules' => 'required'
				)
			);

			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			if($this->form_validation->run() === true) {	
				$create = $this->model_accounting->updateStudentPay($paymentId);					
				if($create === true) {
					$validator['success'] = true;
					$validator['messages'] = "Successfully added";
				}
				else {
					$validator['success'] = false;
					$validator['messages'] = "Error while inserting the information into the database";
				}			
			} 	
			else {
				$validator['success'] = false;
				foreach ($_POST as $key => $value) {
					$validator['messages'][$key] = form_error($key);
				}			
			} // /else

			echo json_encode($validator);	
		}
	}

	/*
	*---------------------------------------------------------------	
	* paymentId is for `payment` table 
	*---------------------------------------------------------------
	*/
	public function removeStudentPay($paymentId = null) 
	{
		if($paymentId) {
			$validator = array('success' => false, 'messages' => array());

			$remove = $this->model_accounting->removeStudentPay($paymentId);
			if($remove === true) {
				$validator['success'] = true;
				$validator['messages'] = 'Successfully Removed';
			}
			else {
				$validator['success'] = false;
				$validator['messages'] = 'Error while removing';
			}

			echo json_encode($validator);
		}
	}



	/*
	*---------------------------------------------------------------	
	* MANAGE EXPENSES FUNCTION
	*---------------------------------------------------------------
	*/

	/*
	*---------------------------------------------------------------	
	* add expenses function
	*---------------------------------------------------------------
	*/
	public function createExpenses()
	{
		$validator = array('success' => false, 'messages' => array());

		$expname = $this->input->post('subExpensesName');
		if(!empty($expname)) {			
			foreach ($expname as $key => $value) {
				$this->form_validation->set_rules('subExpensesName['.$key.']', 'Expenses Name','required');	
			}
		}

		$expamount = $this->input->post('subExpensesAmount');
		if(!empty($expamount)) {			
			foreach ($expamount as $key => $value) {
				$this->form_validation->set_rules('subExpensesAmount['.$key.']', 'Total Amount','required');	
			}
		}

		$validate_data = array(
			array(
				'field' => 'expensesDate',
				'label' => 'Expenses Date',
				'rules' => 'required'
			),
			array(
				'field' => 'expensesName',
				'label' => 'Expenses Name',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true) {	
			$create = $this->model_accounting->createExpenses();					
			if($create === true) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully added";
			}
			else {
				$validator['success'] = false;
				$validator['messages'] = "Error while inserting the information into the database";
			}			
		} 	
		else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				if($key == 'subExpensesName') {
					foreach ($value as $number => $data) {
						$validator['messages']['subExpensesName'.$number] = form_error('subExpensesName['.$number.']');
					} // /.foreach 
				} // /.if
				else if($key == 'subExpensesAmount') {
					foreach ($value as $number => $data) {
						$validator['messages']['subExpensesAmount'.$number] = form_error('subExpensesAmount['.$number.']');
					} // /.foreach
				} else {
					$validator['messages'][$key] = form_error($key);	
				} // /.				
			} // /.foreach			
		} // /else

		echo json_encode($validator);
	}

	/*
	*---------------------------------------------------------------	
	* fetches the expenses data from the `expenses_name` and 
	* `expenses` table function
	*---------------------------------------------------------------
	*/
	public function fetchExpensesData()
	{
		$expensesData = $this->model_accounting->fetchExpensesNameData();


		$result = array('data' => array());
		foreach ($expensesData as $key => $value) {

			$totalExpensesItem = $this->model_accounting->countTotalExpensesItem($value['id']);

			$button = '
			<div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    Action <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu">
			    <li><a href="#" data-toggle="modal" data-target="#edit-expenses-modal" onclick="updateExpenses('.$value['id'].')">Edit</a></li>
			    <li><a href="#" data-toggle="modal" data-target="#removeExpensesModal" onclick="removeExpenses('.$value['id'].')">Remove</a></li>    
			  </ul>
			</div>';

			$result['data'][$key] = array(
				$value['name'],
				$value['date'],
				$totalExpensesItem,
				$value['total_amount'],
				$button
			);	
		}			

		echo json_encode($result);
	}

	/*
	*---------------------------------------------------------------
	* fetches the expenses data from the database function
	*---------------------------------------------------------------
	*/	
	public function fetchExpensesDataForUpdate($id = null)
	{
		if($id) {

			$expenseNameData = $this->model_accounting->fetchExpensesNameData($id);
			$expensesItemData = $this->model_accounting->fetchExpensesItemData($id);
	
			$table = '<div class="form-group">
          <label for="editExpensesDate" class="col-sm-3 control-label">Expenses Date:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="editExpensesDate" name="editExpensesDate" placeholder="Expenses Date" value="'.$expenseNameData['date'].'" />
          </div>
        </div>
        <div class="form-group">
          <label for="editExpensesName" class="col-sm-3 control-label">Expenses Name:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="editExpensesName" name="editExpensesName" placeholder="Expenses Name" value="'.$expenseNameData['name'].'" />
          </div>
        </div>
        <div class="form-group">
          <label for="editTotalAmount" class="col-sm-3 control-label">Total Amount:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="editTotalAmount" name="editTotalAmount" placeholder="Total Amount"  value="'.$expenseNameData['total_amount'].'"/>
            <input type="hidden" class="form-control" id="editTotalAmountValue" name="editTotalAmountValue" value="'.$expenseNameData['total_amount'].'" />
          </div>
        </div>
        <table class="table table-bordered" id="editSubExpensesTable">
        <thead>
          <tr>
            <th>Name</th>
            <th>Amount</th>
            <th style="width:10%;">Action</th>
          </tr>
        </thead>
        <tbody>';
        	$x = 1;
        	foreach ($expensesItemData as $key => $value) {
        		$table .= '<tr id="row'.$x.'">
		            <td class="form-group">
		            <input type="text" class="form-control" name="editSubExpensesName['.$x.']" id="editSubExpensesName'.$x.'" placeholder="Expenses Name" value="'.$value['expenses_name'].'"/>
		            </td>
		            <td class="form-group">
		            <input type="text" class="form-control" name="editSubExpensesAmount['.$x.']" id="editSubExpensesAmount'.$x.'" onkeyup="editCalculateTotalAmount()" placeholder="Expenses Amount" value="'.$value['expenses_amount'].'" />
		            </td>
		            <td>
		            <button type="button" class="btn btn-default" onclick="removeEditExpensesRow('.$x.')"><i class="glyphicon glyphicon-remove"></i></button>
		            </td>
		          </tr>';
        	$x++;	
        	} // /.foreach          
        $table .= '</tbody>
	    </table>';

	      echo $table;
		}
	}

	/*
	*---------------------------------------------------------------
	* update the expenses function
	*---------------------------------------------------------------
	*/
	public function updateExpenses($id = null)
	{	
		if($id)	{

			$validator = array('success' => false, 'messages' => array());

			$expname = $this->input->post('editSubExpensesName');
			if(!empty($expname)) {			
				foreach ($expname as $key => $value) {
					$this->form_validation->set_rules('editSubExpensesName['.$key.']', 'Expenses Name','required');	
				}
			}

			$expamount = $this->input->post('editSubExpensesAmount');
			if(!empty($expamount)) {			
				foreach ($expamount as $key => $value) {
					$this->form_validation->set_rules('editSubExpensesAmount['.$key.']', 'Total Amount','required');	
				}
			}

			$validate_data = array(
				array(
					'field' => 'editExpensesDate',
					'label' => 'Expenses Date',
					'rules' => 'required'
				),
				array(
					'field' => 'editExpensesName',
					'label' => 'Expenses Name',
					'rules' => 'required'
				)
			);

			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			if($this->form_validation->run() === true) {	
				$create = $this->model_accounting->updateExpenses($id);					
				if($create === true) {
					$validator['success'] = true;
					$validator['messages'] = "Successfully added";
				}
				else {
					$validator['success'] = false;
					$validator['messages'] = "Error while inserting the information into the database";
				}			
			} 	
			else {
				$validator['success'] = false;
				foreach ($_POST as $key => $value) {
					if($key == 'editSubExpensesName') {
						foreach ($value as $number => $data) {
							$validator['messages']['editSubExpensesName'.$number] = form_error('editSubExpensesName['.$number.']');
						} // /.foreach 
					} // /.if
					else if($key == 'editSubExpensesAmount') {
						foreach ($value as $number => $data) {
							$validator['messages']['editSubExpensesAmount'.$number] = form_error('editSubExpensesAmount['.$number.']');
						} // /.foreach
					} else {
						$validator['messages'][$key] = form_error($key);	
					} // /.				
				} // /.foreach			
			} // /else

			echo json_encode($validator);
		}
	}


	/*
	*---------------------------------------------------------------
	* remove the expenses info from the database
	*---------------------------------------------------------------
	*/
	public function removeExpenses($id = null)
	{
		if($id) {
			$validator = array('success' => false, 'messages' => array());

			$remove = $this->model_accounting->removeExpenses($id);
			if($remove === true) {
				$validator['success'] = true;
				$validator['messages'] = 'Successfully Removed';
			}
			else {
				$validator['success'] = false;
				$validator['messages'] = 'Error while removing';
			}

			echo json_encode($validator);
		}
	}



	/*
	*------------------------------------------------------------------
	* fetch the income data for datatables  
	*------------------------------------------------------------------
	*/
	public function fetchIncomeData($id = null)
	{
		$fetchData = $this->model_accounting->fetchIncomeData();
		$result = array('data' => array());
		$x = 1;
		foreach ($fetchData as $key => $value) {
			$fetchPaymentNameData = $this->model_accounting->fetchPaymentData($value['payment_name_id']);

			$button = '<button class="btn btn-primary" data-toggle="modal" data-target="#viewIncomeModal" onclick="viewIncome('.$value['payment_id'].')">View</button>';

			$result['data'][$key] = array(
				$x,
				$fetchPaymentNameData['name'],
				$fetchPaymentNameData['total_amount'],
				$value['paid_amount'],
				$button
			);
			
			$x++;
		}
		echo json_encode($result);
	}	

	/*
	*------------------------------------------------------------------
	* view the payment information function
	* `payment_id` is from `payment` table
	* not from `payment_name` table 
	*------------------------------------------------------------------
	*/
	public function viewIncomeDetail($paymentId = null)
	{
		if($paymentId) {
			$paymentData = $this->model_accounting->fetchStudentPayData($paymentId);
			$paymentNameData = $this->model_accounting->fetchPaymentData($paymentData['payment_name_id']);
			$classData = $this->model_classes->fetchClassData($paymentData['class_id']);
			$sectionData = $this->model_section->fetchSectionByClassSection($paymentData['class_id'], $paymentData['section_id']);
			$studentData = $this->model_student->fetchStudentData($paymentData['student_id']);

			$data = '<table class="table table-bordered table-responsive table-striped">
			<tbody>
				<tr>
					<th>Payment Name : </th>
					<td>'.$paymentNameData['name'].'</td>
				</tr>
				<tr>
					<th>Total Amount : </th>
					<td>'.$paymentNameData['total_amount'].'</td>
				</tr>
				<tr>
					<th>Paid Amount : </th>
					<td>'.$paymentData['paid_amount'].'</td>
				</tr>
				<tr>
					<th>Payment Date : </th>
					<td>'.$paymentData['payment_date'].'</td>
				</tr>
				<tr>
					<th>Class : </th>
					<td>'.$classData['class_name'].'</td>
				</tr>
				<tr>
					<th>Section Date : </th>
					<td>'.$sectionData['section_name'].'</td>
				</tr>
				<tr>
					<th>Student Name : </th>
					<td>'.$studentData['fname'].' '. $studentData['lname'] .'</td>
				</tr>
			</tbody>
			</table>';
			echo $data;
		}
	}


}