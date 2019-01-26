<?php 

class Attendance extends MY_Controller 
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
		// loading the teacher model
		$this->load->model('model_teacher');
		// attendance
		$this->load->model('model_attendance');
		

		// loading the form validation library
		$this->load->library('form_validation');		
	}

	/*
	*------------------------------------------------
	* fetches the attendance type
	* 1 => student
	* 2 => teacehr
	*------------------------------------------------
	*/
	public function fetchAttendaceType($id = null) 
	{
		if($id == 1) {
			$classData = $this->model_classes->fetchClassData();

			// student
			$form = '<div class="form-group">
		    <label for="className" class="col-sm-2 control-label">Class</label>
		    <div class="col-sm-10">
		      <select class="form-control" name="className" id="className">
		      	<option value="">Select</option>
		      	';
		      	foreach ($classData as $key => $value) {
		      		$form .= '<option value="'.$value['class_id'].'">'.$value['class_name'].'</option>';
		      	} // /froeac
		      	$form .='
		      </select>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="sectionName" class="col-sm-2 control-label">Section</label>
		    <div class="col-sm-10">
		      <select class="form-control" name="sectionName" id="sectionName">
		      	<option value="">Select Class</option>		      	
		      </select>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="date" class="col-sm-2 control-label">Date</label>
		    <div class="col-sm-10">
		      <input type="text" class="form-control" id="date" name="date" placeholder="Date" autocomplete="off">
		    </div>
		  </div>
		  <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" class="btn btn-primary">Submit</button>
		    </div>
		  </div>';		 
		} 
		else if($id == 2) {
			// teacher
			$form = '
			  <div class="form-group">
			    <label for="date" class="col-sm-2 control-label">Date</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="date" name="date" placeholder="Date" autocomplete="off">
			    </div>
			  </div>
			  <div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      <button type="submit" class="btn btn-primary">Submit</button>
			    </div>
			  </div>';		
		}
		else{
			$form = '';
		}

		echo $form;
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
	* fetches the class section student, teacher info
	* into the table to mark the attendance	
	* typeId varaible will check the attenadnce type
	*------------------------------------------------
	*/
	public function getAttendanceTable($classId = null, $sectionId = null, $date = null, $typeId = null) 
	{	
		if($typeId == 1) {
			// student information
			$studentData = $this->model_student->fetchStudentByClassAndSection($classId, $sectionId);
			// class information
			$classData = $this->model_classes->fetchClassData($classId);
			// section infromation
			$sectionData = $this->model_section->fetchSectionByClassSection($classId, $sectionId);

			$div = '
			
		    <div class="well">
		    	Attendance Type : Student <br />
		    	Class : '.$classData['class_name'].' <br />
		    	Section : '.$sectionData['section_name'].' <br /> 
		    </div>		

		    <div id="attendance-message"></div>

		    <form method="post" action="attendance/createAttendance" id="createAttendanceForm">

			    <table class="table table-bordered">
			    	<thead>
			    		<tr>
			    			<th style="width:60%;">Name</th>
			    			<th style="width:40%;">Action</th>
			    		</tr>
			    	</thead>
			    	<tbody>';
			    	if($studentData) {
			    		$x = 1;
			    		foreach ($studentData as $key => $value) {
			    			// fetch attedance information through date, class id, section id, and type id
							$attedanceData = $this->model_attendance->fetchMarkAttendance($classId, $sectionId, $date, $typeId, $value['student_id']);
				    		$div .= '<tr>
				    			<td>
				    				'.$value['fname'] . ' ' . $value['lname'].'
				    				<input type="hidden" name="studentId['.$x.']" id="studentId" value="'.$value['student_id'].'" />
				    			</td>
				    			<td>
				    				<select name="attendance_status['.$x.']" id="attendance_status" class="form-control">
				    					<option value="" '; 
										if($attedanceData['mark'] == 0) {
											$div .= 'selected';
										}
										$div .= '></option>
				    					<option value="1" '; 
										if($attedanceData['mark'] == 1) {
											$div .= 'selected';
										}
										$div .= '>Present</option>
				    					<option value="2" '; 
										if($attedanceData['mark'] == 2) {
											$div .= 'selected';
										}
										$div .= '>Absent</option>
				    					<option value="3" '; 
										if($attedanceData['mark'] == 3) {
											$div .= 'selected';
										}
										$div .= '>Late</option>
				    				</select>
				    			</td>
				    		</tr>';
				    		$x++;
				    	} // /foreach
			    	} // /if
			    	else {
			    		$div .= '<tr>
			    			<td colspan="3"><center>No Data Available</center></td>
			    		</tr>';
			    	}		    	
			    	$div .= '</tbody>
			    </table>

			    <center>
			    	<input type="hidden" name="attendance_type" value="'.$typeId.'" />
			    	<input type="hidden" name="date" value="'.$date.'" />
			    	<input type="hidden" name="classId" value="'.$classId.'" />
			    	<input type="hidden" name="sectionId" value="'.$sectionId.'" />

			    	<button type="submit" class="btn btn-primary">Save Changes</button>
			    </center>

		    </form>
			';

			echo $div;
		} 
		else if($typeId == 2) {

			// teacher data
			$teacherData = $this->model_teacher->fetchTeacherData();

			$div = '<div class="well">
			    	Attendance Type : Teacher
			    </div>		

			    <div id="attendance-message"></div>

			    <form method="post" action="attendance/createAttendance" id="createAttendanceForm">

			    <table class="table table-bordered">
			    	<thead>
			    		<tr>
			    			<th style="width:60%;">Name</th>
			    			<th style="width:40%;">Action</th>
			    		</tr>
			    	</thead>
			    	<tbody>';
			    	if($teacherData) {
			    		$x = 1;
			    		foreach ($teacherData as $key => $value) {
			    			// fetch attedance information through date, class id, section id, and type id
							$attedanceData = $this->model_attendance->fetchMarkAttendance('', '', $date, $typeId, '', $value['teacher_id']);
				    		$div .= '<tr>
				    			<td>
				    				'.$value['fname'] . ' ' . $value['lname'].'
				    				<input type="hidden" name="teacherId['.$x.']" id="teacherId" value="'.$value['teacher_id'].'" />
				    			</td>
				    			<td>
				    				<select name="attendance_status['.$x.']" id="attendance_status" class="form-control">
				    					<option value="" '; 
										if($attedanceData['mark'] == 0) {
											$div .= 'selected';
										}
										$div .= '></option>
				    					<option value="1" '; 
										if($attedanceData['mark'] == 1) {
											$div .= 'selected';
										}
										$div .= '>Present</option>
				    					<option value="2" '; 
										if($attedanceData['mark'] == 2) {
											$div .= 'selected';
										}
										$div .= '>Absent</option>
				    					<option value="3" '; 
										if($attedanceData['mark'] == 3) {
											$div .= 'selected';
										}
										$div .= '>Late</option>
				    				</select>
				    			</td>
				    		</tr>';
				    		$x++;
				    	} // /foreach
			    	} // /if
			    	else {
			    		$div .= '<tr>
			    			<td colspan="3"><center>No Data Available</center></td>
			    		</tr>';
			    	}		    	
			    	$div .= '</tbody>
			    </table>

			    <center>
			    	<input type="hidden" name="attendance_type" value="'.$typeId.'" />
			    	<input type="hidden" name="date" value="'.$date.'" />			    	

			    	<button type="submit" class="btn btn-primary">Save Changes</button>
			    </center>

		    </form>

		    ';
			// echo "ok";

		    echo $div;
		}		

	}

	/*
	*------------------------------------------------
	* create the attendance
	*------------------------------------------------
	*/
	public function createAttendance()
	{		
		$validator = array('success' => false, 'messages' => array());
		$attendance = $this->model_attendance->createAttendance($this->input->post('attendance_type'));

		if($attendance == true) {
			$validator['success'] = true;
			$validator['messages'] = 'Successfully Added';
		}
		else {
			$validator['success'] = false;
			$validator['messages'] = 'Error';	
		}

		echo json_encode($validator);

	}

	/*
	*------------------------------------------------
	* fetch the class and section type
	*------------------------------------------------
	*/
	public function fetchClassAndSection() 
	{
		$classData = $this->model_classes->fetchClassData();
		$select = '<div class="form-group">
		    <label for="className" class="col-sm-2 control-label">Class</label>
		    <div class="col-sm-10">
		      <select class="form-control" name="className" id="className">
		      	<option value="">Select</option>';		      	
		      	foreach ($classData as $key => $value) {
		      		$select .= '<option value="'.$value['class_id'].'">'.$value['class_name'].'</option>';
		      	}
		      $select .= '</select>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="sectionName" class="col-sm-2 control-label">Section</label>
		    <div class="col-sm-10">
		      <select class="form-control" name="sectionName" id="sectionName">
		      	<option value="">Select</option>		      	
		      </select>
		    </div>
		  </div>
		  ';
	  echo $select;
	}

	/*
	*------------------------------------------------
	* fetch the attendance report
	*------------------------------------------------
	*/
	public function report($typeId = null, $reportDate = null, $numOfDays = null, $classId = null, $sectionId = null)
	{			
		$year = substr($reportDate, 0, 4);
		$month = substr($reportDate, 5, 7);		

		$classData = $this->model_classes->fetchClassData($classId);
		$sectionData = $this->model_section->fetchSectionByClassSection($classId, $sectionId);

		if($typeId == 1) {
			// student			
			$div = '<div class="well">
				<center>
					<h4>Attendance Type : Student<h4>
					<h4>Class : '.$classData['class_name'].' Section : '.$sectionData['section_name'].'<h4>
					<h4>Year : '.$year.' Month : '.$month.'<h4>		
					<small>	
						P : Present <br />				
						A : Absent <br />
						L : Late <br />
						UN : Undefined <br />
					</small>
				</center>
			</div>

			<div style="overflow-x:auto;">			
			<table class="table table-bordered" style="width:100%;">			
				<tbody style="width:100%;">
					<tr>
						<td style="width:25%;">Name</td>
						';		
						// loop for days
						for($i = 1; $i <= $numOfDays; $i++) {
							$div .= '
								<td style="width:10%;">'.$i.'</td>';	
						} // /for
					$div .= '</tr>';
						
					$studentInfo = $this->model_student->fetchStudentByClassAndSection($classId, $sectionId);

					foreach ($studentInfo as $key => $value) {
						$studentName = $value['fname'] . ' ' . $value['lname'];
						$div .= '
							<tr>
							<td>'.$studentName.'</td>';

							for($i = 1; $i <= $numOfDays; $i++) {
								$attendanceData = $this->model_attendance->getAttendance($i, $reportDate, $value['student_id'], $typeId, $classId, $sectionId);
								
								$div .= '<td>';
								foreach ($attendanceData as $attendanceKey => $attendanceValue) {
									if($attendanceValue['mark'] == 1) {
										// present
										$attendanceStatus = '<span class="label label-success">P</span>';	
									} else if($attendanceValue['mark'] == 2) {
										// absent
										$attendanceStatus = '<span class="label label-primary">A</span>';	
									} else if($attendanceValue['mark'] == 3) {
										// late
										$attendanceStatus = '<span class="label label-warning">L</span>';	
									} else {
										// undefined
										$attendanceStatus = '<span class="label label-danger">UN</span>';	
									}
									
									$div .= $attendanceStatus;
								}
								$div .= '
									</td>';	
								} // /for								

						$div .= '</tr>';		
					} // /foreach
				$div .= '</tbody>
				</table>
			<div>';			
		
		}
		else if($typeId == 2) {
			// teacher
			$div = '<div class="well">
				<center>
					<h4>Attendance Type : Teacher<h4>
					<h4>Year : '.$year.' Month : '.$month.'<h4>			

					<small>	
						P : Present <br />				
						A : Absent <br />
						L : Late <br />
						UN : Undefined <br />
					</small>
				</center>
			</div>

			<div style="overflow-x:auto;">			
			<table class="table table-bordered" style="width:100%;">			
				<tbody style="width:100%;">
					<tr>
						<td style="width:25%;">Name</td>
						';		
						// loop for days
						for($i = 1; $i <= $numOfDays; $i++) {
							$div .= '
								<td style="width:10%;">'.$i.'</td>';	
						} // /for
					$div .= '</tr>';
						
					$teacherData = $this->model_teacher->fetchTeacherData();

					foreach ($teacherData as $key => $value) {
						$teacherName = $value['fname'] . ' ' . $value['lname'];
						$div .= '
							<tr>
							<td>'.$teacherName.'</td>';

							for($i = 1; $i <= $numOfDays; $i++) {
								$attendanceData = $this->model_attendance->getAttendance($i, $reportDate, $value['teacher_id'], $typeId);
								
								$div .= '<td>';
								foreach ($attendanceData as $attendanceKey => $attendanceValue) {
									if($attendanceValue['mark'] == 1) {
										// present
										$attendanceStatus = '<span class="label label-success">P</span>';	
									} else if($attendanceValue['mark'] == 2) {
										// absent
										$attendanceStatus = '<span class="label label-primary">A</span>';	
									} else if($attendanceValue['mark'] == 3) {
										// late
										$attendanceStatus = '<span class="label label-warning">L</span>';	
									} else {
										// undefined
										$attendanceStatus = '<span class="label label-danger">UN</span>';	
									}
									
									$div .= $attendanceStatus;
								}
								$div .= '
									</td>';	
								} // /for								

						$div .= '</tr>';		
					} // /foreach
				$div .= '</tbody>
				</table>
			<div>
			';
		} 

		echo $div;
	}

}