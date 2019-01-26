<?php 

class Model_Classes extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*
	*-----------------------------------------
	* Insert the class info into the database
	*----------------------------------------
	*/
	public function create()
	{
		$insert_data = array(
			'class_name' => $this->input->post('className'),
			'numeric_name' => $this->input->post('numericName')
		);
		$status = $this->db->insert('class', $insert_data);		
		return ($status === true ? true : false);
	}

	/*
	*-----------------------------------------
	* validate the class name
	*----------------------------------------
	*/
	public function validate_classname()
	{
		$className = $this->input->post('className');
		$sql = "SELECT * FROM class WHERE class_name = ?";
		$query = $this->db->query($sql, array($className));

		return ($query->num_rows() == 1 ? true : false);		
	}

	/*
	*-----------------------------------------
	* validate the class numeric name
	*----------------------------------------
	*/
	public function validate_numericname()
	{
		$numericName = $this->input->post('numericName');
		$sql = "SELECT * FROM class WHERE numeric_name = ?";
		$query = $this->db->query($sql, array($numericName));

		return ($query->num_rows() == 1 ? true : false);		
	}

	/*
	*-----------------------------------------
	* fetch class data
	*----------------------------------------
	*/
	public function fetchClassData($classId = null)
	{
		if($classId) {
			$sql = "SELECT * FROM class WHERE class_id = ?";
			$query = $this->db->query($sql, array($classId));
			return $query->row_array();
		} 
		else {
			$sql = "SELECT * FROM class";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}

	/*
	*-----------------------------------------
	* validate the class name
	*----------------------------------------
	*/
	public function validate_editclassname()
	{
		$className = $this->input->post('editClassName');
		$classId = $this->input->post('classId');
		$sql = "SELECT * FROM class WHERE class_name = ? AND class_id != ?";
		$query = $this->db->query($sql, array($className, $classId));

		return ($query->num_rows() == 1 ? true : false);		
	}

	/*
	*-----------------------------------------
	* validate the class numeric name
	*----------------------------------------
	*/
	public function validate_editnumericname()
	{
		$numericName = $this->input->post('editNumericName');
		$classId = $this->input->post('classId');
		$sql = "SELECT * FROM class WHERE numeric_name = ? AND class_id != ?";
		$query = $this->db->query($sql, array($numericName, $classId));

		return ($query->num_rows() == 1 ? true : false);		
	}

	
	/*
	*-----------------------------------------
	* update the class information
	*----------------------------------------
	*/
	public function update()
	{
		$update_data = array(
			'class_name' => $this->input->post('editClassName'),
			'numeric_name' => $this->input->post('editNumericName')
		);

		$this->db->where('class_id', $this->input->post('classId'));
		$query = $this->db->update('class', $update_data);
		
		return ($query === true ? true : false);		
	}	

	/*
	*----------------------------------------
	* remove the class information
	*----------------------------------------
	*/
	public function remove($classId = null)
	{
		if($classId) {
			$this->db->where('class_id', $classId);
			$result = $this->db->delete('class');
			return ($result === true ? true: false); 
		}
	}

	/*
	*------------------------------------
	* count total classes information 
	*------------------------------------
	*/	
	public function countTotalClass() 
	{
		$sql = "SELECT * FROM class";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

}