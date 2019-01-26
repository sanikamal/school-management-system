<?php 

class Marksheet extends MY_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->isNotLoggedIn();

		// loading the section model class
		$this->load->model('model_section');
		// loading the classes model class
		$this->load->model('model_classes');
		// loading the marksheet model class
		$this->load->model('model_marksheet');	
		// loading the subject model class
		$this->load->model('model_subject');

		// load the form validation library
		$this->load->library('form_validation');
	}

	/*
	*----------------------------------------------
	* fetches the class's marksheet table 
	*----------------------------------------------
	*/
	public function fetchMarksheetTable($classId = null)
	{
		if($classId) {			
			$classData = $this->model_classes->fetchClassData($classId);
			$marksheetData = $this->model_marksheet->fetchMarksheetData($classId);
			
			$table = '

			<div class="well">
				Class Name : '.$classData['class_name'].'
			</div>

			<div id="messages"></div>

			<div class="pull pull-right">
	  			<button class="btn btn-default" data-toggle="modal" data-target="#addMarksheetModal" onclick="addMarksheet('.$classId.')">Add Marksheet</button>	
		  	</div>
		  		
		  	<br /> <br />

		  	<!-- Table -->
		  	<table class="table table-bordered" id="manageMarksheetTable">
			    <thead>	
			    	<tr>			    		
			    		<th> Marksheet Name  </th>
			    		<th> Date </th>
			    		<th> Action </th>
			    	</tr>
			    </thead>
			    <tbody>';
			    	if($marksheetData) {
			    		foreach ($marksheetData as $key => $value) {			    			

			    			$button = '<div class="btn-group">
							  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    Action <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu">
							    <li><a type="button" data-toggle="modal" data-target="#editMarksheetModal" onclick="editMarksheet('.$value['marksheet_id'].','.$value['class_id'].')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
							    <li><a type="button" data-toggle="modal" data-target="#removeMarksheetModal" onclick="removeMarksheet('.$value['marksheet_id'].','.$value['class_id'].')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>		    
							  </ul>
							</div>';

				    		$table .= '<tr>
				    			<td>'.$value['marksheet_name'].'</td>
				    			<td>'.$value['marksheet_date'].'</td>
				    			<td>'.$button.'</td>
				    		</tr>
				    		';
				    	} // /foreach				    	
			    	} 
			    	else {
			    		$table .= '<tr>
			    			<td colspan="3"><center>No Data Available</center></td>
			    		</tr>';
			    	} // /else
			    $table .= '</tbody>
			</table>
			';
			echo $table;
		} // /check class id
	} 

	/*
	*----------------------------------------------
	* fetch the marksheet data
	*----------------------------------------------
	*/
	public function fetchMarksheetDataByMarksheetId($marksheetId = null)
	{
		$data = $this->model_marksheet->fetchMarksheetDataByMarksheetId($marksheetId);
		echo json_encode($data);
	}

	/*
	*----------------------------------------------
	* create marksheet funciton
	*----------------------------------------------
	*/
	public function create($classId = null)
	{
		if($classId) {
			$validator = array('success' => false, 'messages' => array());

			$validate_data = array(
				array(
					'field' => 'marksheetName',
					'label' => 'Marksheet Name',
					'rules' => 'required'
				),
				array(
					'field' => 'date',
					'label' => 'Exam Date',
					'rules' => 'required'
				)
			);

			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			if($this->form_validation->run() === true) {	
				$create = $this->model_marksheet->create($classId);					
				if($create == true) {
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
		}
		echo json_encode($validator);
	}

	/*
	*----------------------------------------------
	* fetches the update marksheet table
	*----------------------------------------------
	*/
	public function fetchUpdateMarksheetTable($classId = null)
	{
		if($classId) {
			$classData = $this->model_classes->fetchClassData($classId);
			$marksheetData = $this->model_marksheet->fetchMarksheetData($classId);

			$table = '<thead>	
			    	<tr>			    		
			    		<th> Marksheet Name  </th>
			    		<th> Date </th>
			    		<th> Action </th>
			    	</tr>
			    </thead>

			    <tbody>';
			if($marksheetData) {
	    		foreach ($marksheetData as $key => $value) {			    			

	    			$button = '<div class="btn-group">
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    Action <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">
					    <li><a type="button" data-toggle="modal" data-target="#editMarksheetModal" onclick="editMarksheet('.$value['marksheet_id'].','.$value['class_id'].')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
					    <li><a type="button" data-toggle="modal" data-target="#removeMarksheetModal" onclick="removeMarksheet('.$value['marksheet_id'].','.$value['class_id'].')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>		    
					  </ul>
					</div>';

		    		$table .= '<tr>
		    			<td>'.$value['marksheet_name'].'</td>
		    			<td>'.$value['marksheet_date'].'</td>
		    			<td>'.$button.'</td>
		    		</tr>
		    		';
		    	} // /foreach				    	
	    	} 
	    	else {
	    		$table .= '<tr>
	    			<td colspan="3"><center>No Data Available</center></td>
	    		</tr>';
	    	} // /else

	    	$table .= '</tbody>';

	    	echo $table;
		} // /.classid
	}

	/*
	*----------------------------------------------
	* update marksheet funciton
	*----------------------------------------------
	*/
	public function update($marksheetId = null, $classId = null)
	{
		if($marksheetId && $classId) {
			$validator = array('success' => false, 'messages' => array());

			$validate_data = array(
				array(
					'field' => 'editMarksheetName',
					'label' => 'Marksheet Name',
					'rules' => 'required'
				),
				array(
					'field' => 'editDate',
					'label' => 'Exam Date',
					'rules' => 'required'
				)
			);

			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			if($this->form_validation->run() === true) {	
				$update = $this->model_marksheet->update($marksheetId, $classId);					
				if($update == true) {
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
		}
		echo json_encode($validator);
	}

	/*
	*----------------------------------------------
	* remove marksheet function
	*----------------------------------------------
	*/
	public function remove($marksheetId = null)
	{
		if($marksheetId) {
			$remove = $this->model_marksheet->remove($marksheetId);
			if($remove === true) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully Removed";
			} 
			else{
				$validator['success'] = false;
				$validator['messages'] = "Error while removing the information";
			}
			echo json_encode($validator);
		}
	}

	/*
	*----------------------------------------------
	* fetch marksheet info by class id function
	*----------------------------------------------
	*/
	public function fetchMarksheetDataByClass($classId = null)
	{
		if($classId) {
			$marksheetData = $this->model_marksheet->fetchMarksheetDataByClass($classId);
			if($marksheetData) {
				foreach ($marksheetData as $key => $value) {
					$option .= '<option value="'.$value['marksheet_id'].'">'.$value['marksheet_name'].'</option>';
				} // /foreach
			}
			else {
				$option = '<option value="">No Data</option>';
			} // /else empty section

			echo $option;
		}
	}

	/*
	*----------------------------------------------
	* fetch the student info via marksheet
	*----------------------------------------------
	*/
	public function fetchStudentMarksheet()
	{
		
		$validator = array('success' => false, 'messages' => array(), 'html' => '');

		$validate_data = array(
			array(
				'field' => 'className',
				'label' => 'Class',
				'rules' => 'required'
			),
			array(
				'field' => 'marksheetName',
				'label' => 'Marksheet',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true) {	
					
			$validator['success'] = true;
			$validator['messages'] = "Successfully added";

			$classData = $this->model_classes->fetchClassData($this->input->post('className'));
			$marksheetNameData = $this->model_marksheet->fetchMarksheetDataByMarksheetId($this->input->post('marksheetName'));
			$sectionData = $this->model_section->fetchSectionDataByClass($this->input->post('className'));
			$validator['sectionData'] = $sectionData;

			$validator['html'] = '<div class="panel panel-default">		  	
				<div class="panel-heading">Student Info</div>
				  
				<div class="panel-body">		  
					<div class="well well-sm">
						Class : '.$classData['class_name'].' <br />
						Marksheet Name : '.$marksheetNameData['marksheet_name'].' <br />
						<input type="hidden" id="marksheet_id" value="'.$this->input->post('marksheetName').'" />
					</div>		

					<br /> 	
					<div>
						<!-- Nav tabs -->
					  	<ul class="nav nav-tabs" role="tablist">
					    	<li role="presentation" class="active"><a href="#classStudent" aria-controls="classStudent" role="tab" data-toggle="tab">All Student</a></li>';					   
					    	$x = 1;
			            	foreach ($sectionData as $key => $value) {            	
								$validator['html'] .= '<li role="presentation"><a href="#countSection'.$x.'" aria-controls="countSection" role="tab" data-toggle="tab"> Section ('.$value['section_name'].')</a></li>';
								$x++;
							} // /foreach    					    	

					  	$validator['html'] .= '</ul>

					  	<!-- Tab panes -->
					  	<div class="tab-content">
					    	<div role="tabpanel" class="tab-pane active" id="classStudent">
              	
				              	<br /> <br />

				                <table class="table table-bordered" id="manageStudentTable">
				                  <thead>
				                    <tr>
				                      <th>#</th>
				                      <th>Name</th>
				                      <th>Class</th>
				                      <th>Section</th>				                      
				                      <th>Action</th>
				                    </tr>
				                  </thead>
				                </table>  

				              </div>
					    	<!--/.all student-->
					    	'; 
			              	$x = 1;
							foreach ($sectionData as $key => $value) {
								$validator['html'] .= '<div role="tabpanel" class="tab-pane" id="countSection'.$x.'">									

									<br /> <br />

									<table class="table table-bordered classSectionStudentTable" id="manageStudentTable'.$x.'" style="width:100%;">
					                  <thead>
					                    <tr>
					                      <th>#</th>
					                      <th>Name</th>
					                      <th>Class</th>
					                      <th>Section</th>
					                      <th>Action</th>
					                    </tr>
					                  </thead>
					                </table>  

					             </div>';
					             $x++;
							} // /foreach                                     
			              
			              $validator['html'] .= '
					    	<!--/.section student-->
					  	</div>
					</div>			
				

			</div>';

		} 	
		else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}			
		} // /else
	
		echo json_encode($validator);

	}

	public function fetchStudentByClass($classId = null) {
		if($classId) {
			$result = array('data' => array());
			$studentData = $this->model_student->fetchStudentDataByClass($classId);
			foreach ($studentData as $key => $value) {
				$img = '<img src="'. base_url() . $value['image'].'" class="img-circle candidate-photo" alt="Student Image" />';

				$classData = $this->model_classes->fetchClassData($value['class_id']);
				$sectionData = $this->model_section->fetchSectionByClassSection($value['class_id'], $value['section_id']);			

				$studentMarksheetData = $this->model_marksheet->fetchStudentMarksByClassSectionStudent($value['class_id'], $value['section_id'], $value['student_id']);
				$marksheetId = $studentMarksheetData['marksheet_id'];	

				$button = '<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Action <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">			  	
				    <li><a href="#" data-toggle="modal" data-target="#editMarksModal" onclick="editMarks('.$value['student_id'].','.$classId.')">Edit Marks</a></li>
				    <li><a href="#" data-toggle="modal" data-target="#viewMarksModal" onclick="viewMarks('.$value['student_id'].','.$classId.')">View</a></li>			    
				  </ul>
				</div>';

				$result['data'][$key] = array(
					$img,
					$value['fname'] . ' ' . $value['lname'],
					$classData['class_name'],
					$sectionData['section_name'],
					$button
				);
			} // /foreach	
			echo json_encode($result);
		}
	}

	/*
	*------------------------------------
	* fetch student's data thorugh
	* class id and section id
	*------------------------------------
	*/
	public function fetchStudentByClassAndSection($classId = null, $sectionId = null)
	{
		if($classId && $sectionId) {
			$studentData = $this->model_student->fetchStudentByClassAndSection($classId, $sectionId);
			$result = array('data'=>array());
			foreach ($studentData as $key => $value) {
				$img = '<img src="'. base_url() . $value['image'].'" class="img-circle candidate-photo" alt="Student Image" />';

				$classData = $this->model_classes->fetchClassData($value['class_id']);
				$sectionData = $this->model_section->fetchSectionByClassSection($value['class_id'], $value['section_id']);

				$studentMarksheetData = $this->model_marksheet->fetchStudentMarksByClassSectionStudent($value['class_id'], $value['section_id'], $value['student_id']);
				$marksheetId = $studentMarksheetData['marksheet_id'];

				$button = '<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Action <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">			  	
				    <li><a href="#" data-toggle="modal" data-target="#editMarksModal" onclick="editMarks('.$value['student_id'].','.$classId.')">Edit Marks</a></li>
				    <li><a href="#" data-toggle="modal" data-target="#viewMarksModal" onclick="viewMarks('.$value['student_id'].','.$classId.')">View</a></li>			    
				  </ul>
				</div>';

				$result['data'][$key] = array(
					$img,
					$value['fname'] . ' ' . $value['lname'],
					$classData['class_name'],
					$sectionData['section_name'],
					$button
				);
			} // /froeach			
			echo json_encode($result);
		} // /if		
	}

	/*
	*------------------------------------------------------
	* fetch the student marksheet data function
	*------------------------------------------------------
	*/
	public function studentMarksheetData($studentId = null, $classId = null, $marksheetId = null)
	{
		if($studentId && $classId && $marksheetId) {
			$marksheetName = $this->model_marksheet->fetchMarksheetDataByMarksheetId($marksheetId);
			$marksheetStudentData = $this->model_marksheet->fetchStudentMarksheetData($studentId, $classId, $marksheetId);

			$form = '

			<form class="form-horizontal" action="marksheet/createStudentMarks" method="post" id="createStudentMarksForm">
			  <div class="form-group">
			    <label class="col-sm-2 control-label">Name</label>
			    <div class="col-sm-10">
			      <label class="form-control">'.$marksheetName['marksheet_name'].'</label>
			    </div>
			  </div>';
			  $x = 1;
			  foreach ($marksheetStudentData as $key => $value) {
			  	$subjectData = $this->model_subject->fetchSubjectByClassSection($value['class_id'], $value['subject_id']);			  	

			  	$form .= '<div class="form-group">
			    <label for="inputPassword3" class="col-sm-2 control-label">'.$subjectData['name'].'</label>
			    <div class="col-sm-10">			      
			    	<input type="text" class="form-control" name="studentMarks['.$x.']" id="studentMarks'.$x.'" value="'.$value['obtain_mark'].'" />			    	
			    	<input type="hidden" name="marksheetStudentId['.$x.']" value="'.$value['marksheet_student_id'].'" />			    	

			    </div>

			  </div>';	
			  $x++;
			  }			 

			  $form .= '				 

			  <div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">			    	
			    	<button type="submit" class="btn btn-primary">Save Changes</button>
			    </div>
			  </div>
			</form>';

			echo $form;
		} // /.if
	}

	/*
	*-----------------------------------
	* insert student's subjcet marks
	*-----------------------------------
	*/
	public function createStudentMarks()
	{
				
		$studentMarks = $this->input->post('studentMarks');
		if(!empty($studentMarks)) {			
			foreach ($studentMarks as $key => $value) {
				$this->form_validation->set_rules('studentMarks['.$key.']', 'Marks','required');	
			}
		}
				
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');		

		if($this->form_validation->run()) {			
			$this->model_marksheet->createStudentMarks();			
				
			$validator['success'] = true;
			$validator['messages'] = "Successfully added";			
		} else {			
			$validator['success'] = false;								
			foreach ($_POST as $key => $value) {					
				if($key == 'studentMarks') {
					foreach ($value as $number => $data) {
						$validator['messages']['studentMarks'.$number] = form_error('studentMarks['.$number.']');
					}
				}						
			} // /foreach		
		} // /else

		echo json_encode($validator);
	}

	/*
	*-----------------------------------
	* views student's subjcet marks
	*-----------------------------------
	*/
	public function viewStudentMarksheet($studentId = null, $classId = null, $marksheetId = null)  
	{		
		if($studentId && $classId && $marksheetId) {			
			$studentMarkData = $this->model_marksheet->viewStudentMarksheet($studentId, $classId, $marksheetId);
			$div = '
			<table class="table table-bordered">
				<tr>
					<th>Subject Name</th>
					<th>Total Marks</th>
					<th>Obtain Mark</th>
				</tr>';

				$totalMark = 0;
				$obtainMark = 0;

				foreach ($studentMarkData as $key => $value) {						  		
					$subjectData = $this->model_subject->fetchSubjectByClassSection($value['class_id'], $value['subject_id']);
					$div .= '<tr>					
						<td>'.$subjectData['name'].'</td>
						<td>100</td>
						<td>'.$value['obtain_mark'].'</td>
				</tr>';

				$totalMark += $subjectData['total_mark'];
				$obtainMark += $value['obtain_mark'];

				$percentage = ($obtainMark / $totalMark) * 100;

			  	}		  		

			$div .= '</table>
			<table class="table table-bordered">
				<tr>
					<th>Total Marks</th>
					<td>'.$totalMark.'</td>
				</tr>
				<tr>
					<th>Obtain Mark</th>
					<td>'.$obtainMark.'</td>
				</tr>
				<tr>
					<th>Percentage</th>
					<td>'.$percentage.' % </td>
				</tr>
			</table>
			';

			echo $div;
		} // /if
	}

}