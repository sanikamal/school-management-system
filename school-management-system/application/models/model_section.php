<?php 	

class Model_Section extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*
	*----------------------------------------------
	* fetches the class's section data 
	*----------------------------------------------
	*/
	public function fetchSectionDataByClass($classId = null)
	{
		if($classId) {
			$sql = "SELECT * FROM section WHERE class_id = ?";
			$query = $this->db->query($sql, array($classId));
			return $query->result_array();
		}
	}

	/*
	*----------------------------------------------
	* fetches the class's section information
	* through class_id and section_id 
	*----------------------------------------------
	*/
	public function fetchSectionByClassSection($classId = null, $sectionId = null)
	{
		if($classId && $sectionId) {
			$sql = "SELECT * FROM section WHERE class_id = ? AND section_id = ?";
			$query = $this->db->query($sql, array($classId, $sectionId));
			$result = $query->row_array();
			return $result;
		}		
	}

	/*
	*----------------------------------------------
	* insert the section info function
	*----------------------------------------------
	*/
	public function create($classId = null)
	{
		if($classId) {
			$insert_data = array(
				'section_name' => $this->input->post('sectionName'),
				'class_id' 	   => $classId,
				'teacher_id'   => $this->input->post('teacherName')
			);

			$query = $this->db->insert('section', $insert_data);
			return ($query == true ? true : false);
		}
	}

	/*
	*----------------------------------------------
	* update the section info function
	*----------------------------------------------
	*/
	public function update($classId = null, $sectionId = null)
	{
		if($classId && $sectionId) {
			$update_data = array(
				'section_name' => $this->input->post('editSectionName'),
				'class_id' 	   => $classId,
				'teacher_id'   => $this->input->post('editTeacherName')
			);

			$this->db->where('class_id', $classId);
			$this->db->where('section_id', $sectionId);
			$query = $this->db->update('section', $update_data);
			return ($query == true ? true : false);
		}
	}

	/*
	*----------------------------------------
	* remove the class's section information
	*----------------------------------------
	*/
	public function remove($sectionId = null)
	{
		if($sectionId) {
			$this->db->where('section_id', $sectionId);
			$result = $this->db->delete('section');
			return ($result === true ? true: false); 
		}
	}


}