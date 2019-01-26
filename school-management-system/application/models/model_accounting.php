<?php 

class Model_Accounting extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

	/*
	*---------------------------------------------------
	* Insert the student payment info into the database
	*---------------------------------------------------
	*/
	public function createIndividual()
	{
		$insert_name = array(
			'name' => $this->input->post('paymentName'),
			'start_date' 	=> $this->input->post('startDate'),
			'end_date' 		=> $this->input->post('endDate'),
			'total_amount' 	=> $this->input->post('totalAmount'),
			'type'			=> 1
		);

		$this->db->insert('payment_name', $insert_name);
		$payment_name_id = $this->db->insert_id();

		$insert_data = array(									
			'class_id' 		=> $this->input->post('className'),
			'section_id' 	=> $this->input->post('sectionName'),
			'student_id' 	=> $this->input->post('studentName'),			
			'payment_name_id' => $payment_name_id
		);
		$status = $this->db->insert('payment', $insert_data);		
		return ($status === true ? true : false);
	}

	/*
	*---------------------------------------------------
	* Insert the bulk payment info into the database
	*---------------------------------------------------
	*/
	public function createBulk()
	{
		if($this->input->post('studentId')) {
			$insert_name = array(
				'name' => $this->input->post('paymentName'),
				'start_date' 	=> $this->input->post('startDate'),
				'end_date' 		=> $this->input->post('endDate'),
				'total_amount' 	=> $this->input->post('totalAmount'),
				'type'			=> 2
			);

			$this->db->insert('payment_name', $insert_name);
			$payment_name_id = $this->db->insert_id();

			for($x = 1; $x <= count($this->input->post('studentId')); $x++) {								
				$insert_data = array(									
					'class_id' 		=> $this->input->post('className'),
					'section_id' 	=> $this->input->post('sectionName'),
					'student_id' 	=> $this->input->post('studentId')[$x],			
					'payment_name_id' => $payment_name_id
				);

				$status = $this->db->insert('payment', $insert_data);
			}
						
			return ($status === true ? true : false);
		} 
		else {
			return false;
		}		
	}	

	/*
	*--------------------------------------------------
	* fetches the payment name from the payment_name table
	*--------------------------------------------------
	*/
	public function fetchPaymentData($id = null) 
	{
		if($id) {
			$sql = "SELECT * FROM payment_name WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM payment_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/*
	*--------------------------------------------------
	* fetches the payment date by the payment name id
	*--------------------------------------------------
	*/
	public function fetchStudentPaymentById($id = null) 
	{
		if($id) {
			$sql = "SELECT * FROM payment WHERE payment_name_id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}		
	}

	/*
	*--------------------------------------------------
	* removes the payment info from the database
	*--------------------------------------------------
	*/
	public function removePayment($id = null) 
	{
		if($id) {
			$this->db->where('id', $id);
			$payment_name = $this->db->delete('payment_name');

			$this->db->where('payment_name_id', $id);
			$payment = $this->db->delete('payment');

			return ($payment_name === true && $payment === true ? true: false); 
		}
	}

	/*
	*---------------------------------------------------------------
	* Manage student's payment functions section
	* id = `payment_name` table's id primary key
	* type = `1` individual student
	* type = `2` bulk student
	*---------------------------------------------------------------
	*/
	public function updatePayment($id = null, $type = null)
	{
		if($id && $type) {

			if($type == 1) {
				$update_name = array(
					'name' => $this->input->post('editPaymentName'),
					'start_date' 	=> $this->input->post('editStartDate'),
					'end_date' 		=> $this->input->post('editEndDate'),
					'total_amount' 	=> $this->input->post('editTotalAmount'),
					'type'			=> 1
				);

				$this->db->where('id', $id);
				$this->db->update('payment_name', $update_name);

				$this->db->where('payment_name_id', $id);
				$this->db->delete('payment');

				$update_payment_data = array(									
					'class_id' 		=> $this->input->post('editClassName'),
					'section_id' 	=> $this->input->post('editSectionName'),
					'student_id' 	=> $this->input->post('studentData'),			
					'payment_name_id' => $id
				);
				
				$status = $this->db->insert('payment', $update_payment_data);		

				return ($status === true ? true : false);								
			} 
			else if($type == 2) {
				if(count($this->input->post('editStudentId')) > 0) {

					$update_data = array(
						'name' 			=> $this->input->post('editPaymentName'),
						'start_date' 	=> $this->input->post('editStartDate'),
						'end_date' 		=> $this->input->post('editEndDate'),
						'total_amount' 	=> $this->input->post('editTotalAmount'),
						'type'			=> 2
					);

					$this->db->where('id', $id);
					$this->db->update('payment_name', $update_data);				

					$this->db->where('payment_name_id', $id);
					$this->db->delete('payment');

					for($x = 1; $x <= count($this->input->post('editStudentId')); $x++) {								
						$update_payment_data = array(									
							'class_id' 		=> $this->input->post('editClassName'),
							'section_id' 	=> $this->input->post('editSectionName'),
							'student_id' 	=> $this->input->post('editStudentId')[$x],			
							'payment_name_id' => $id
						);

						$status = $this->db->insert('payment', $update_payment_data);
					}
							
					return ($status === true ? true : false);
				}
				else {
					return false;
				}	
			}				
		}
	}

	/*
	*--------------------------------------------------
	* fetches the payment date by the payment name id
	*--------------------------------------------------
	*/
	public function fetchStudentPayData($id = null) 
	{
		if($id) {
			$sql = "SELECT * FROM payment WHERE payment_id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM payment";
		$query = $this->db->query($sql);
		return $query->result_array();
	}



	/*
	*---------------------------------------------------------------
	* update student's payment info section
	* paymentId for `payment` table `payment_id`
	*---------------------------------------------------------------
	*/
	public function updateStudentPay($paymentId = null)
	{
		if($paymentId) {
			$update_data = array(
				'payment_date' => $this->input->post('studentPayDate'),
				'paid_amount'  => $this->input->post('paidAmount'),
				'payment_type' => $this->input->post('paymentType'),
				'status'       => $this->input->post('status')
			);

			$this->db->where('payment_id', $paymentId);
			$query = $this->db->update('payment', $update_data);
			return ($query === true ? true: false); 
		}
	}

	/*
	*---------------------------------------------------------------	
	* remove student's payment
	* paymentId is for `payment` table 
	*---------------------------------------------------------------
	*/
	public function removeStudentPay($paymentId = null)
	{
		if($paymentId) {
			$this->db->where('payment_id', $paymentId);
			$payment = $this->db->delete('payment');			
			return ($payment === true ? true: false); 
		} 
		return false;
	}

	/*
	*---------------------------------------------------------------		
	* MANAGE EXPENSES
	*---------------------------------------------------------------
	*/
	/*
	*---------------------------------------------------------------	
	* create expenses function
	* in this function, it will first insert the data into the 
	* `expenses_name` table and after that fetches the last insert id
	* will be kept as a reference key of that particular many 
	* expenses item in `expenses` table
	*---------------------------------------------------------------
	*/
	public function createExpenses()
	{
		$insert_name = array(
			'date' => $this->input->post('expensesDate'),
			'name' 	=> $this->input->post('expensesName'),
			'total_amount' 		=> $this->input->post('totalAmountValue')			
		);

		$this->db->insert('expenses_name', $insert_name);
		$expenses_name_id = $this->db->insert_id();

		for($x = 1; $x <= count($this->input->post('subExpensesName')); $x++) {						
			$insert_data = array(									
				'expenses_name'    => $this->input->post('subExpensesName')[$x],
				'expenses_amount'  => $this->input->post('subExpensesAmount')[$x],			
				'expenses_name_id' => $expenses_name_id
			);
			$status = $this->db->insert('expenses', $insert_data);		
		} // /.for
			
		return ($status === true ? true : false);	
	}

	/*
	*---------------------------------------------------------------	
	* fetches the expense data from the `expenses_name` table
	*---------------------------------------------------------------
	*/
	public function fetchExpensesNameData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM expenses_name WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM expenses_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	}	

	/*
	*---------------------------------------------------------------	
	* fetches the expenses data from the `expenses` table
	* `id` attribute is used to fetch the expenses item 
	* in the `expenses` table	
	*---------------------------------------------------------------
	*/
	public function fetchExpensesItemData($id = null)
	{
		$sql = "SELECT * FROM expenses WHERE expenses_name_id = ?";
		$query = $this->db->query($sql, array($id));
		return $query->result_array();
	}	

	/*
	*---------------------------------------------------------------	
	* counts the total expenses parent sub item
	* expenses_id in the paramter is from `expense_name` table
	* look in the `expense` table to find out the total item 
	* of the parent id
	*---------------------------------------------------------------
	*/
	public function countTotalExpensesItem($expense_id = null)
	{
		if($expense_id) {
			$sql = "SELECT * FROM expenses WHERE expenses_name_id = ?";
			$query = $this->db->query($sql, array($expense_id));
			return $query->num_rows();
		}
	}

	/*
	*---------------------------------------------------------------	
	* `id` key belongs to the `expenses` table `id`
	* through this `id` key, we will update the information in 	
	* the `expenses_table`, and delete the expense items in the 
	* `expenses` table. After that insert the new data 
	*---------------------------------------------------------------
	*/
	public function updateExpenses($id = null)
	{
		if($id) {
			$update_data = array(
				'date' 				=> $this->input->post('editExpensesDate'),
				'name' 				=> $this->input->post('editExpensesName'),
				'total_amount' 		=> $this->input->post('editTotalAmountValue')	
			);

			$this->db->where('id', $id);
			$expenses_name_data = $this->db->update('expenses_name', $update_data);

			/*remove the existing expense item in `expenses` table*/
			$this->db->where('expenses_name_id', $id);
			$remove_expenses_data = $this->db->delete('expenses');

			for($x = 1; $x <= count($this->input->post('editSubExpensesName')); $x++) {						
				$insert_data = array(									
					'expenses_name'    => $this->input->post('editSubExpensesName')[$x],
					'expenses_amount'  => $this->input->post('editSubExpensesAmount')[$x],			
					'expenses_name_id' => $id
				);
				$status = $this->db->insert('expenses', $insert_data);		
			} // /.for

			return ($expenses_name_data == true && $remove_expenses_data == true ? true : false);	
		}
	}



	/*
	*--------------------------------------------------
	* removes the expenses info from the database
	* in expenses_name table id = `id` 
	* in expenses table id = `expense_name_id`
	*--------------------------------------------------
	*/
	public function removeExpenses($id = null) 
	{
		if($id) {
			$this->db->where('id', $id);
			$expenses_name = $this->db->delete('expenses_name');

			$this->db->where('expenses_name_id', $id);
			$expenses = $this->db->delete('expenses');

			return ($expenses_name === true && $expenses === true ? true: false); 
		}
	}

	public function totalIncome() 
	{
		$sql = "SELECT * FROM payment WHERE status = ?";
		$query = $this->db->query($sql, array(1));
		$result = $query->result_array();
		$totalIncome = 0;
		foreach ($result as $key => $value) {
			$totalIncome += $value['paid_amount'];
		}

		return $totalIncome;
	}

	public function totalExpenses() 
	{
		$sql = "SELECT * FROM expenses_name";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$totalExpenses = 0;
		foreach ($result as $key => $value) {
			$totalExpenses += $value['total_amount'];
		}

		return $totalExpenses;
	}

	public function totalBudget() 
	{
		$totalExpenses = $this->totalExpenses();
		$totalIncome = $this->totalIncome();

		return $currentBudget = $totalIncome - $totalExpenses;
	}

	public function fetchIncomeData($id = null)
	{
		$sql = "SELECT * FROM payment WHERE status = ?";
		
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}
}