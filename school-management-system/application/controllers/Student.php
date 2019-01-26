<?php 

class Student extends MY_Controller 
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

		// loading the form validation library
		$this->load->library('form_validation');		
	}

	/*
	*------------------------------------
	* validates the student's information
	* form and inserts into the database
	*------------------------------------
	*/
	public function create()
	{
		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'fname',
				'label' => 'First Name',
				'rules' => 'required'
			),
			array(
				'field' => 'age',
				'label' => 'Age',
				'rules' => 'required'
			),			
			array(
				'field' => 'contact',
				'label' => 'Contact',
				'rules' => 'required'
			),
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'required'
			),
			array(
				'field' => 'registerDate',
				'label' => 'Register Date',
				'rules' => 'required'
			),
			array(
				'field' => 'className',
				'label' => 'Class',
				'rules' => 'required'
			),
			array(
				'field' => 'sectionName',
				'label' => 'Section',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true) {	
			$imgUrl = $this->uploadImage();
			$create = $this->model_student->create($imgUrl);					
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

		echo json_encode($validator);
	}

	/*
	*------------------------------------
	* returns the uploaded image url 
	*------------------------------------
	*/
	public function uploadImage() 
	{
		$type = explode('.', $_FILES['photo']['name']);				
		$type = $type[count($type)-1];		
		$url = 'assets/images/students/'.uniqid(rand()).'.'.$type;
		if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
			if(is_uploaded_file($_FILES['photo']['tmp_name'])) {			
				if(move_uploaded_file($_FILES['photo']['tmp_name'], $url)) {
					return $url;
				}	else {
					return false;
				}			
			}
		} 
	}

	/*
	*------------------------------------
	* fetch the class's section
	*------------------------------------
	*/
	public function fetchClassSection($classId = null)
	{
		if($classId) {
			$sectionData = $this->model_section->fetchSectionDataByClass($classId);
			if($sectionData) {
				foreach ($sectionData as $key => $value) {
					$option .= '<option value="'.$value['section_id'].'">'.$value['section_name'].'</option>';
				} // /foreach
			}
			else {
				$option = '<option value="">No Data</option>';
			} // /else empty section

			echo $option;
			
		} // /if
	}

	/*
	*------------------------------------
	* fetch the student's information
	*------------------------------------
	*/
	public function fetchStudentData($studentId = null)
	{						
		if($studentId) {
			$result = $this->model_student->fetchStudentData($studentId);			
		} // /if		

		echo json_encode($result);		
	}

	/*
	*------------------------------------
	* fetches the class's section
	*------------------------------------
	*/
	public function getClassSectionTab($classId = null)
	{
		if($classId) {
			$sectionData = $this->model_section->fetchSectionDataByClass($classId);	
			$classData = $this->model_classes->fetchClassData($classId);									
			$tab = array();			
			$tab['sectionData'] = $sectionData;			

			$tab['html'] = '<!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#classStudent" aria-controls="classStudent" role="tab" data-toggle="tab">All Student</a></li>              
            ';            	
            	$x = 1;
            	foreach ($sectionData as $key => $value) {            	
					$tab['html'] .= '<li role="presentation"><a href="#countSection'.$x.'" aria-controls="countSection" role="tab" data-toggle="tab"> Section ('.$value['section_name'].')</a></li>';
					$x++;
				} // /foreach              
            $tab['html'] .= '</ul>

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

              </div>'; 
              	$x = 1;
				foreach ($sectionData as $key => $value) {
					$tab['html'] .= '<div role="tabpanel" class="tab-pane" id="countSection'.$x.'">
						<br /> 
						<div class="well well-sm">
							Class : '.$classData['class_name'].' <br /> 
							Section : '.$value['section_name'].'							
						</div>

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
              
              $tab['html'] .= '              
            </div>';

            echo json_encode($tab);
            // echo $tab;
		}
	}

	public function fetchStudentByClass($classId = null) {
		if($classId) {
			$result = array('data' => array());
			$studentData = $this->model_student->fetchStudentDataByClass($classId);
			foreach ($studentData as $key => $value) {
				$img = '<img src="'.base_url() . $value['image'].'" class="img-circle candidate-photo" alt="Student Image" />';

				$classData = $this->model_classes->fetchClassData($value['class_id']);
				$sectionData = $this->model_section->fetchSectionByClassSection($value['class_id'], $value['section_id']);

				$button = '<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Action <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">			  	
				    <li><a href="#" data-toggle="modal" data-target="#editStudentModal" onclick="updateStudent('.$value['student_id'].')">Edit</a></li>
				    <li><a href="#" data-toggle="modal" data-target="#removeStudentModal" onclick="removeStudent('.$value['student_id'].')">Remove</a></li>			    
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
				$img = '<img src="' . base_url() . $value['image'].'" class="img-circle candidate-photo" alt="Student Image" />';

				$classData = $this->model_classes->fetchClassData($value['class_id']);
				$sectionData = $this->model_section->fetchSectionByClassSection($value['class_id'], $value['section_id']);

				$button = '<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Action <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">			  	
				    <li><a href="#" data-toggle="modal" data-target="#editStudentModal" onclick="updateStudent('.$value['student_id'].')">Edit</a></li>
				    <li><a href="#" data-toggle="modal" data-target="#removeStudentModal" onclick="removeStudent('.$value['student_id'].')">Remove</a></li>			    
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
	*------------------------------------
	* edit the student's information
	*------------------------------------
	*/
	public function updateInfo($studentId = null)
	{
		if($studentId) {

			$validator = array('success' => false, 'messages' => array(), 'sectionData' => array());
			$classId = $this->input->post('editClassName');
			$sectionData = $this->model_section->fetchSectionDataByClass($classId);											
			$validator['sectionData'] = $sectionData;		

			$validate_data = array(
				array(
					'field' => 'editFname',
					'label' => 'First Name',
					'rules' => 'required'
				),
				array(
					'field' => 'editAge',
					'label' => 'Age',
					'rules' => 'required'
				),			
				array(
					'field' => 'editContact',
					'label' => 'Contact',
					'rules' => 'required'
				),
				array(
					'field' => 'editEmail',
					'label' => 'Email',
					'rules' => 'required'
				),
				array(
					'field' => 'editRegisterDate',
					'label' => 'Register Date',
					'rules' => 'required'
				),
				array(
					'field' => 'editClassName',
					'label' => 'Class',
					'rules' => 'required'
				),
				array(
					'field' => 'editSectionName',
					'label' => 'Section',
					'rules' => 'required'
				)
			);

			$this->form_validation->set_rules($validate_data);
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			if($this->form_validation->run() === true) {					
				$updateInfo = $this->model_student->updateInfo($studentId);					
				if($updateInfo == true) {
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
	*------------------------------------
	* edit the student's photo
	*------------------------------------
	*/
	public function updatePhoto($studentId = null)
	{
		if($studentId) {
			$validator = array('success' => false, 'messages' => array());

			if(empty($_FILES['editPhoto']['tmp_name'])) {
				$validator['success'] = false;	
				$validator['messages'] = "The Photo Field is required";
			} 
			else {
				$imgUrl = $this->editUploadImage();
				$update = $this->model_student->updatePhoto($studentId, $imgUrl);					

				if($update == true) {
					$validator['success'] = true;	
					$validator['messages'] = "Successfully Updated";	
				}
				else {
					$validator['success'] = false;
					$validator['messages'] = "Error while inserting the information into the database";
				}					
			} // /else
			echo json_encode($validator);
		} // /if
	}

	/*
	*------------------------------------
	* returns the edited image url 
	*------------------------------------
	*/
	public function editUploadImage() 
	{
		$type = explode('.', $_FILES['editPhoto']['name']);				
		$type = $type[count($type)-1];		
		$url = 'assets/images/students/'.uniqid(rand()).'.'.$type;
		if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
			if(is_uploaded_file($_FILES['editPhoto']['tmp_name'])) {			
				if(move_uploaded_file($_FILES['editPhoto']['tmp_name'], $url)) {
					return $url;
				}	else {
					return false;
				}			
			}
		} 
	}

	/*
	*------------------------------------
	* removes the student's information
	*------------------------------------
	*/
	public function remove($studentId = null) 
	{
		$validator = array('success' => false, 'messages' => array());

		if($studentId) {
			$remove = $this->model_student->remove($studentId);
			if($remove) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully Removed";
			} 
			else {
				$validator['success'] = false;
				$validator['messages'] = "Error while removing the information";	
			} // /else
		} // /if

		echo json_encode($validator);
	}

	/*
	*------------------------------------
	* add student row in bullk section
	*------------------------------------
	*/
	public function getAppendBulkStudentRow($countId = null) 
	{
		if($countId) {
			$classData = $this->model_classes->fetchClassData();			

			$row = '
			<tr id="row'.$countId.'">
                <td>
                	<div class="form-group">
                		<input type="text" class="form-control" id="bulkstfname'.$countId.'" name="bulkstfname['.$countId.']" placeholder="First Name" autocomplete="off">
                	</div>                  
                </td>
                <td>
                	<div class="form-group">
                		<input type="text" class="form-control" id="bulkstlname'.$countId.'" name="bulkstlname" placeholder="Last Name" autocomplete="off">
                	</div>                  
                </td>
                <td>
                	<div class="form-group">
                		<select class="form-control" name="bulkstclassName['.$countId.']" id="bulkstclassName'.$countId.'" onchange="getSelectClassSection('.$countId.')">
	                    <option value="">Select</option>';
	                    foreach ($classData as $key => $value) { 
	                      $row .= '<option value="'.$value["class_id"].'">'.$value['class_name'].'</option>';
	                    } 
	                  $row .= '</select>
                	</div>                  
                </td>
                <td>
                	<div class="form-group">
                		<select class="form-control" name="bulkstsectionName['.$countId.']" id="bulkstsectionName'.$countId.'">
	                    	<option value="">Select Class</option>
	                  	</select>
                	</div>	                  
                </td>
                <td>
                  <button type="button" class="btn btn-default" onclick="removeRow('.$countId.')"><i class="glyphicon glyphicon-trash"></i></button>
                </td>
              </tr>
			';
			echo $row;
		}
	}

	/*
	*------------------------------------
	* create bulk student function
	*------------------------------------
	*/
	public function createBulk()
	{
		$validator = array('success' => false, 'messages' => array());

		$fname = $this->input->post('bulkstfname');
		if(!empty($fname)) {			
			foreach ($fname as $key => $value) {
				$this->form_validation->set_rules('bulkstfname['.$key.']', 'First Name','required');	
			}
		}

		$className = $this->input->post('bulkstclassName');
		if(!empty($className)) {
			foreach ($fname as $key => $value) {
				$this->form_validation->set_rules('bulkstclassName['.$key.']', 'Class','required');	
			}	
		}

		$sectionName = $this->input->post('bulkstsectionName');
		if(!empty($sectionName)) {
			foreach ($sectionName as $key => $value) {
				$this->form_validation->set_rules('bulkstsectionName['.$key.']', 'Section','required');	
			}	
		}
				
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');		
		if($this->form_validation->run()) {			
			$createBulk = $this->model_student->createBulk();			
			if($createBulk == true) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully added";
			}
			else {
				$validator['success'] = false;
				$validator['messages'] = "Error while inserting the information into the database";
			}
		} else {			
			$validator['success'] = false;								
			foreach ($_POST as $key => $value) {					
				if($key == 'bulkstfname') {
					foreach ($value as $number => $data) {
						$validator['messages']['bulkstfname'.$number] = form_error('bulkstfname['.$number.']');
					}
				}
				else if($key == 'bulkstclassName') {
					foreach ($value as $number => $data) {
						$validator['messages']['bulkstclassName'.$number] = form_error('bulkstclassName['.$number.']');
					}
				} 
				else if($key == 'bulkstsectionName') {
					foreach ($value as $number => $data) {
						$validator['messages']['bulkstsectionName'.$number] = form_error('bulkstsectionName['.$number.']');
					}
				}  			
			} // /foreach		
		} // /else

		echo json_encode($validator);
	}


}