<?php 

class Users extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// loading the users model
		$this->load->model('model_users');

		// loading the form validation library
		$this->load->library('form_validation');		

	}

	public function login()
	{

		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required|callback_validate_username'
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true) {			
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));

			$login = $this->model_users->login($username, $password);

			if($login) {
				$this->load->library('session');

				$user_data = array(
					'id' => $login,
					'logged_in' => true
				);

				$this->session->set_userdata($user_data);

				$validator['success'] = true;
				$validator['messages'] = "index.php/dashboard";				
			}	
			else {
				$validator['success'] = false;
				$validator['messages'] = "Incorrect username/password combination";
			} // /else

		} 	
		else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}			
		} // /else

		echo json_encode($validator);
	} // /lgoin function

	public function validate_username()
	{
		$validate = $this->model_users->validate_username($this->input->post('username'));

		if($validate === true) {
			return true;
		} 
		else {
			$this->form_validation->set_message('validate_username', 'The {field} does not exists');
			return false;			
		} // /else
	} // /validate username function

	public function logout()
	{
		$this->load->library('session');
		$this->session->sess_destroy();
		redirect('login', 'refresh');
	}


	public function updateProfile()
	{
		$this->load->library('session');
		$userId = $this->session->userdata('id');

		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required'
			),
			array(
				'field' => 'fname',
				'label' => 'First Name',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		if($this->form_validation->run() === true) {	
			$update = $this->model_users->updateProfile($userId);					
			if($update === true) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully Update";
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

	public function changePassword()
	{
		$this->load->library('session');
		$userId = $this->session->userdata('id');

		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'currentPassword',
				'label' => 'Current Password',
				'rules' => 'required|callback_validate_current_password'
			),
			array(
				'field' => 'newPassword',
				'label' => 'Password',
				'rules' => 'required|matches[confirmPassword]'
			),
			array(
				'field' => 'confirmPassword',
				'label' => 'Confirm Password',
				'rules' => 'required'
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');		

		if($this->form_validation->run() === true) {	
			$update = $this->model_users->changePassword($userId);					
			if($update === true) {
				$validator['success'] = true;
				$validator['messages'] = "Successfully Update";
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

	public function validate_current_password()
	{
		$this->load->library('session');
		$userId = $this->session->userdata('id');
		$validate = $this->model_users->validate_current_password($this->input->post('currentPassword'), $userId);

		if($validate === true) {
			return true;
		} 
		else {
			$this->form_validation->set_message('validate_current_password', 'The {field} is incorrect');
			return false;			
		} // /else	
	}

}