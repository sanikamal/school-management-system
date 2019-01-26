<?php 

class Model_Marksheet extends CI_Model 
{	

	public function __construct()
	{
		parent::__construct();

		// classes 
		$this->load->model('model_classes');
		// section
		$this->load->model('model_section');
		// student
		$this->load->model('model_student');
		// subject
		$this->load->model('model_subject');
	}

	/*
	*----------------------------------------------
	* fetches the class's marksheet table 
	*----------------------------------------------
	*/
	public function fetchMarksheetData($classId = null)
	{
		if($classId) {
			$sql = "SELECT * FROM marksheet WHERE class_id = ?";
			$query = $this->db->query($sql, array($classId));
			return $query->result_array();
		} // /if
	}

	/*
	*----------------------------------------------
	* fetches the class's marksheet data by 
	* markshet id 
	*----------------------------------------------
	*/
	public function fetchMarksheetDataByMarksheetId($marksheetId = null)
	{
		if($marksheetId) {
			$sql = "SELECT * FROM marksheet WHERE marksheet_id = ?";
			$query = $this->db->query($sql, array($marksheetId));
			return $query->row_array();
		} // /if
	}

	/*
	*---------------------------------------------------------------------------
	* creates the marksheet function
	* first enters the marksheet name, date and class id in the marksheet table
	* secondly enters the student_id, subject_id into the marksheet_student
	*---------------------------------------------------------------------------
	*/
	public function create($classId = null)
	{
		if($classId) {
			$sectionData = $this->model_section->fetchSectionDataByClass($classId);

			$marksheet_data = array(
				'marksheet_name' => $this->input->post('marksheetName'),
				'marksheet_date' => $this->input->post('date'),
				'class_id' 		 => $classId
			);

			$this->db->insert('marksheet', $marksheet_data);

			$marksheet_id = $this->db->insert_id();

			foreach ($sectionData as $key => $value) {

				$studentData = $this->model_student->fetchStudentByClassAndSection($classId, $value['section_id']);
				$subjectData = $this->model_subject->fetchSubjectDataByClass($classId);

				foreach ($studentData as $student_key => $student_value) {					
					foreach ($subjectData as $subject_key => $subject_value) {
						$marksheet_student_data = array(
							'student_id' => $student_value['student_id'],
							'subject_id' => $subject_value['subject_id'],							
							'marksheet_id' => $marksheet_id,
							'class_id' => $classId,
							'section_id' => $value['section_id']
						);

						$this->db->insert('marksheet_student', $marksheet_student_data);				
					} // /.foreach for subject
				}  // /.foreach for student						

			} // /foreach for student

			return true;
		} // /.class id
		else {
			return false;
		}
	} // /.create marksheet function

	/*
	*-----------------------------------------------------------
	* update marksheet function
	*-----------------------------------------------------------
	*/
	public function update($marksheetId = null, $classId = null)
	{
		if($marksheetId && $classId) {

			$sectionData = $this->model_section->fetchSectionDataByClass($classId);

			$update_marksheet_data = array(
				'marksheet_name' => $this->input->post('editMarksheetName'),
				'marksheet_date' => $this->input->post('editDate'),
				'class_id' 		 => $classId
			);

			$this->db->where('marksheet_id', $marksheetId);
			$this->db->where('class_id', $classId);
			$this->db->update('marksheet', $update_marksheet_data);
			
			// remove the student data from the marksheet student table
			$this->db->where('marksheet_id', $marksheetId);
			$this->db->where('class_id', $classId);
			$this->db->delete('marksheet_student');
		
			foreach ($sectionData as $key => $value) {

				$studentData = $this->model_student->fetchStudentByClassAndSection($classId, $value['section_id']);
				$subjectData = $this->model_subject->fetchSubjectDataByClass($classId);

				foreach ($studentData as $student_key => $student_value) {					
					foreach ($subjectData as $subject_key => $subject_value) {
						$marksheet_student_data = array(
							'student_id' => $student_value['student_id'],
							'subject_id' => $subject_value['subject_id'],							
							'marksheet_id' => $marksheetId,
							'class_id' => $classId,
							'section_id' => $value['section_id']
						);

						$this->db->insert('marksheet_student', $marksheet_student_data);				
					} // /.foreach for subject
				}  // /.foreach for student						

			} // /foreach for student

			return true;
		} // /.class id
		else {
			return false;
		}
	}

	/*
	*-----------------------------------------------------------
	* remove marksheet function
	*-----------------------------------------------------------
	*/
	public function remove($marksheetId = null) 
	{
		if($marksheetId) {
			$this->db->where('marksheet_id', $marksheetId);
			$result = $this->db->delete('marksheet');

			$this->db->where('marksheet_id', $marksheetId);
			$marksheet_student_result = $this->db->delete('marksheet_student');

			return ($result === true && $marksheet_student_result === true ? true: false);
		}
	}

	/*
	*----------------------------------------------------------
	* fetch the marksheet data via class id
	*----------------------------------------------------------
	*/
	public function fetchMarksheetDataByClass($classId = null)
	{
		if($classId) {
			$sql = "SELECT * FROM marksheet WHERE class_id = ?";
			$query = $this->db->query($sql, array($classId));
			return $query->result_array();
		} // /.if
	} // /.fetch marksheet data by class id function

	/*
	*----------------------------------------------------------
	* fetch the student marksheet data of the marksheet student
	*----------------------------------------------------------
	*/
	public function fetchStudentMarksheetData($studentId = null, $classId = null, $marksheetId = null)
	{
		if($studentId && $classId && $marksheetId) {
 			$sql = "SELECT * FROM marksheet_student WHERE student_id = ? AND class_id = ? AND marksheet_id = ?";
			$query = $this->db->query($sql, array($studentId, $classId, $marksheetId));
			return $query->result_array();
		}			
	}

	/*
	*-----------------------------------
	* insert student's subjcet marks
	*-----------------------------------
	*/
	public function createStudentMarks()
	{				
		for($x = 1; $x <= count($this->input->post('studentMarks')); $x++) {			
			$update_data = array(				
				'obtain_mark' 		=> $this->input->post('studentMarks')[$x],				
			);
			
			$this->db->where('marksheet_student_id', $this->input->post('marksheetStudentId')[$x]);
			$this->db->update('marksheet_student', $update_data);						
		} // /for

		// return ($status == true ? true : false);			
	}

	/*
	*-----------------------------------
	* view student's subjcet marks
	*-----------------------------------
	*/
	public function viewStudentMarksheet($studentId = null, $classId = null, $marksheetId = null)
	{		
		if($studentId && $classId && $marksheetId) {			
			$sql = "SELECT * FROM marksheet_student WHERE student_id = ? AND class_id = ? AND marksheet_id = ?";
			$query = $this->db->query($sql, array($studentId, $classId, $marksheetId));			
			return $query->result_array();
		}
	}

	public function fetchStudentMarksByClassSectionStudent($classId = null, $sectionId = null, $studentId = null)
	{
		if($classId && $sectionId && $studentId) {			
			$sql = "SELECT * FROM marksheet_student WHERE class_id = ? AND section_id = ? AND student_id = ?";
			$query = $this->db->query($sql, array($classId, $sectionId, $studentId));		
			return $query->row_array();
		}
	}

	/*
	*------------------------------------
	* count total marksheet information 
	*------------------------------------
	*/	
	public function countTotalMarksheet() 
	{
		$sql = "SELECT * FROM marksheet";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

}