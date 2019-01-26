<?php 	

class Model_Subject extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*
	*----------------------------------------------
	* fetches the class's subject data 
	*----------------------------------------------
	*/
	public function fetchSubjectDataByClass($classId = null)
	{
		if($classId) {
			$sql = "SELECT * FROM subject WHERE class_id = ?";
			$query = $this->db->query($sql, array($classId));
			return $query->result_array();
		}
	}

	/*
	*----------------------------------------------
	* fetches the class's subject information
	* through class_id and section_id 
	*----------------------------------------------
	*/
	public function fetchSubjectByClassSection($classId = null, $subjectId = null)
	{
		if($classId && $subjectId) {
			$sql = "SELECT * FROM subject WHERE class_id = ? AND subject_id = ?";
			$query = $this->db->query($sql, array($classId, $subjectId));
			$result = $query->row_array();
			return $result;
		}		
	}


	/*
	*----------------------------------------------
	* insert the subject info function
	*----------------------------------------------
	*/
	public function create($classId = null)
	{
		if($classId) {
			$insert_data = array(
				'name' => $this->input->post('subjectName'),
				'total_mark' => $this->input->post('totalMark'),
				'class_id' 	   => $classId,
				'teacher_id'   => $this->input->post('teacherName')
			);

			$query = $this->db->insert('subject', $insert_data);
			return ($query == true ? true : false);
		}
	}

	/*
	*----------------------------------------------
	* update the subject info function
	*----------------------------------------------
	*/
	public function update($classId = null, $subjectId = null)
	{
		if($classId && $subjectId) {
			$update_data = array(
				'name' => $this->input->post('editSubjectName'),
				'total_mark' => $this->input->post('editTotalMark'),
				'class_id' 	   => $classId,
				'teacher_id'   => $this->input->post('editTeacherName')
			);

			$this->db->where('class_id', $classId);
			$this->db->where('subject_id', $subjectId);
			$query = $this->db->update('subject', $update_data);
			return ($query == true ? true : false);
		}
	}

	/*
	*----------------------------------------
	* remove the class's subject information
	*----------------------------------------
	*/
	public function remove($subjectId = null)
	{
		if($subjectId) {
			$this->db->where('subject_id', $subjectId);
			$result = $this->db->delete('subject');
			return ($result === true ? true: false); 
		}
	}

}