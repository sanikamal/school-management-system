<?php 

class Pages extends MY_Controller
{
	public function view($page = 'login')
	{
        if (!file_exists(APPPATH.'views/'.$page.'.php'))
        {
            // Whoops, we don't have a page for that!
            show_404();
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter

        if($page == 'section' || $page == 'subject' || $page == 'student' || $page == 'marksheet' || $page == 'accounting') {
            $this->load->model('model_classes');
            $data['classData'] = $this->model_classes->fetchClassData();

            $this->load->model('model_teacher');
            $data['teacherData'] = $this->model_teacher->fetchTeacherData();

            
            $this->load->model('model_accounting');
            $data['totalIncome'] = $this->model_accounting->totalIncome();
            $data['totalExpenses'] = $this->model_accounting->totalExpenses();
            $data['totalBudget'] = $this->model_accounting->totalBudget();
        }

        if($page == 'setting') {
            $this->load->model('model_users');
            $this->load->library('session');
            $userId = $this->session->userdata('id');
            $data['userData'] = $this->model_users->fetchUserData($userId);
        }

        if($page == 'dashboard') {
            $this->load->model('model_student');
            $this->load->model('model_teacher');
            $this->load->model('model_classes');
            $this->load->model('model_marksheet');
            $this->load->model('model_accounting');

            $data['countTotalStudent'] = $this->model_student->countTotalStudent();
            $data['countTotalTeacher'] = $this->model_teacher->countTotalTeacher();
            $data['countTotalClasses'] = $this->model_classes->countTotalClass();
            $data['countTotalMarksheet'] = $this->model_marksheet->countTotalMarksheet();

            $data['totalIncome'] = $this->model_accounting->totalIncome();
            $data['totalExpenses'] = $this->model_accounting->totalExpenses();
            $data['totalBudget'] = $this->model_accounting->totalBudget();
        }

        if($page == 'login') {
            $this->isLoggedIn();
            $this->load->view($page, $data);
        } 
        else{
            $this->isNotLoggedIn();

            $this->load->view('templates/header', $data);
            $this->load->view($page, $data);    
            $this->load->view('templates/footer', $data);    
        }
	}
    
}