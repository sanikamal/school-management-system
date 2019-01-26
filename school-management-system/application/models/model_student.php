<?php 

class Model_Student extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

	/*
	*------------------------------------
	* inserts the student's information
	* into the database 
	*------------------------------------
	*/
	public function create($img_url)
	{
		if($img_url == '') {
			$img_url = 'assets/images/default/default_avatar.png';
		} 

		$insert_data = array(
			'register_date' => $this->input->post('registerDate'),
			'class_id' 		=> $this->input->post('className'),
			'section_id'	=> $this->input->post('sectionName'),
			'fname'			=> $this->input->post('fname'),
			'lname' 		=> $this->input->post('lname'),
			'image'			=> $img_url,
			'age'			=> $this->input->post('age'),
			'dob'			=> $this->input->post('dob'),
			'contact'		=> $this->input->post('contact'),
			'email'			=> $this->input->post('email'),
			'address'		=> $this->input->post('address'),
			'city'			=> $this->input->post('city'),
			'country'   	=> $this->input->post('country')
		);

		$status = $this->db->insert('student', $insert_data);		
		return ($status == true ? true : false);
	}

	/*
	*-----------------------------------
	* fetches the student inform
	*-----------------------------------
	*/
	public function fetchStudentData($studentId = null)
	{
		if($studentId) {
			$sql = "SELECT * FROM student WHERE student_id = ?";
			$query = $this->db->query($sql, array($studentId));
			return $query->row_array();
		}		
	}

	/*
	*--------------------------------------------------
	*fetches the student information via class id 
	*--------------------------------------------------
	*/
	public function fetchStudentDataByClass($classId = null)
	{
		if($classId) {
			$sql = "SELECT * FROM student WHERE class_id = ?";
			$query = $this->db->query($sql, array($classId));
			return $query->result_array();
		} // /if
	} 

	/*
	*--------------------------------------------------
	* fetches the student infro via class and section id
	*--------------------------------------------------
	*/
	public function fetchStudentByClassAndSection($classId = null, $sectionId = null)
	{
		if($classId && $sectionId) {
			$sql = "SELECT * FROM student WHERE class_id = ? AND section_id = ?";
			$query = $this->db->query($sql, array($classId, $sectionId));
			return $query->result_array();
		} // /if
	}

	/*
	*-----------------------------------
	* update the student's inform
	*-----------------------------------
	*/	
	public function updateInfo($studentId = null)
	{
		if($studentId) {
			$update_data = array(
				'register_date' => $this->input->post('editRegisterDate'),
				'class_id' 		=> $this->input->post('editClassName'),
				'section_id'	=> $this->input->post('editSectionName'),
				'fname'			=> $this->input->post('editFname'),
				'lname' 		=> $this->input->post('editLname'),				
				'age'			=> $this->input->post('editAge'),
				'dob'			=> $this->input->post('editDob'),
				'contact'		=> $this->input->post('editContact'),
				'email'			=> $this->input->post('editEmail'),
				'address'		=> $this->input->post('editAddress'),
				'city'			=> $this->input->post('editCity'),
				'country'   	=> $this->input->post('editCountry')
			);

			$this->db->where('student_id', $studentId);
			$query = $this->db->update('student', $update_data);
			
			return ($query === true ? true : false);
		}			
	}

	/*
	*-----------------------------------
	* update the student's photo
	*-----------------------------------
	*/
	public function updatePhoto($studentId = null, $imageUrl = null)
	{
		if($studentId && $imageUrl) {
			$update_data = array(
				'image' 	=> $imageUrl
			);

			$this->db->where('student_id', $studentId);
			$query = $this->db->update('student', $update_data);
			
			return ($query === true ? true : false);
		}			
	}

	/*
	*-----------------------------------
	* remove the student's info
	*-----------------------------------
	*/
	public function remove($studentId = null) 
	{
		if($studentId) {
			$this->db->where('student_id', $studentId);
			$result = $this->db->delete('student');
			return ($result === true ? true: false); 
		} // /if
	}

	/*
	*-----------------------------------
	* insert bulk student
	*-----------------------------------
	*/
	public function createBulk()
	{				
		for($x = 1; $x <= count($this->input->post('bulkstfname')); $x++) {						
			$insert_data = array(				
				'class_id' 		=> $this->input->post('bulkstclassName')[$x],
				'section_id'	=> $this->input->post('bulkstsectionName')[$x],
				'image'			=> 'assets/images/default/default_avatar.png',
				'fname'			=> $this->input->post('bulkstfname')[$x],
				'lname' 		=> $this->input->post('bulkstlname')[$x]			
			);

			$status = $this->db->insert('student', $insert_data);						
		} // /for

		return ($status == true ? true : false);	
	}

	/*
	*-------------------------------------------
	* count total student
	*-------------------------------------------
	*/
	public function countTotalStudent()
	{
		$sql = "SELECT * FROM student";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
}
