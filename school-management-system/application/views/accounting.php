<?php 
if($this->input->get('opt') == '' || !$this->input->get('opt')) {
  show_404();
} else {
?>

<div id="request" class="div-hide"><?php echo $this->input->get('opt'); ?></div>

<ol class="breadcrumb">
  <li><a href="<?php echo base_url('dashboard') ?>">Home</a></li> 
  <?php   
  if($this->input->get('opt') == 'crtpay') {
    echo '<li class="active">Create Student Payment</li>';
  } 
  else if ($this->input->get('opt') == 'mgpay') {
    echo '<li class="active">Manage Payment</li>';
  }  
  else if ($this->input->get('opt') == 'mgexp') {
    echo '<li class="active">Manage Expenses</li>';
  }  
  else if ($this->input->get('opt') == 'ime') {
    echo '<li class="active">Income</li>';
  }  
  ?>  
</ol>


<div class="row">
<?php if($this->input->get('opt') == 'crtpay' || $this->input->get('opt') == 'mgexp' || $this->input->get('opt') == 'ime') { ?>
<div class="col-md-12">
  <div class="panel panel-primary">
  	<div class="panel-heading">
  		<?php   
  	    if($this->input->get('opt') == 'crtpay') {
  		    echo 'Create Student Payment';
  		  } 		  
  		  else if ($this->input->get('opt') == 'mgexp') {
  		    echo 'Manage Expenses';
  		  }  
  		  else if ($this->input->get('opt') == 'ime') {
  		    echo 'Income';
  		  }  
  	    ?>  
  	</div>
  	<!-- /.panel-heading -->
  	<div class="panel-body">

  		<div id="messages"></div>

  		<?php   
  	    if($this->input->get('opt') == 'crtpay') { 
  	    	// echo "Create Payment";
  	    ?>

  	    <div class="form-horizontal">
  	    	<div class="form-group">
  	    		<label for="type" class="col-sm-2 control-label">Type</label>
  	    		<div class="col-sm-10">
  	    			<select class="form-control" id="type">
  	    				<option value="">Select Type</option>
  	    				<option value="1">Individual</option>
  	    				<option value="2">Bulk</option>
  	    			</select>
  	    		</div>
  	    	</div>
  	    </div>

  	    <div id="div-result"></div>
  	    
  				   
  	  	<?php } // /.create payment		
  		else if ($this->input->get('opt') == 'mgexp') {
      ?>

      <div id="remove-expenses-messages"></div>

      <div class="pull pull-right">
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#add-expenses-modal" onclick="addExpenses()">Add Expenses</button>        
      </div>

      <br /> <br />

      <table class="table table-bordered" id="manageExpeneseTable">
        <thead class="bg-primary">
          <tr>
            <th>Name</th>
            <th>Date</th>
            <th>Total Item</th>
            <th>Total Amount</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
  		<?php
  		?>
  	 	<?php
  		} // /.manage expenses 
  		else if ($this->input->get('opt') == 'ime') {
  		    // echo 'Income';
      ?>

      <div class="row">
        <div class="col-md-4">
          <div class="well">
            <h5>Current Budget : <span class="badge"><?php echo $totalBudget; ?></span></h5>
          </div>
        </div>
        
        <div class="col-md-8">
          <div class="well">
            <h5>Total Payment : <span class="badge"><?php echo $totalIncome; ?></span></h5>
            <h5>Total Expenses : <span class="badge"><?php echo $totalExpenses; ?></span></h5>
          </div>
        </div>
      </div>

        

      <table id="manageIncomeTable" class="table table-responsive table-bordered">
        <thead class="bg-primary">
          <tr>
            <th>S.no</th>
            <th>Payment Name</th>
            <th>Total Amount</th>
            <th>Paid Amount</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
      <?php
  		} // /.income  		
  	    ?>  
  	</div>
  	<!-- /.panel-body -->
  </div>
</div>
<!-- /.panel -->
<?php
} // /.if create payment, manage expenses, income
else if($this->input->get('opt') == 'mgpay') { ?>
<div class="col-sm-3">
	<div class="panel panel-primary">
		<div class="panel-heading">
			Manage Section
		</div>
		<div class="list-group">
		  	<a type="button" class="list-group-item" id="managePaymentInfo">Manage Payment</a>
		  	<a type="button" class="list-group-item" id="manageStudentPayInfo">Manage Student Payment</a>
		</div>
	</div>
</div><!-- /.col-sm-3 -->
<div class="col-sm-9">
	<div id="managePaymentDiv"></div>	
</div><!-- /.col-sm-9 -->

<?php } // /.manage payment ?>

</div><!-- /div.row -->


<!-- /.update payment -->
<div class="modal fade" tabindex="-1" role="dialog" id="editPayment">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title">Edit Payment</h4>
      	</div>
      
      	<div class="modal-body">
          <div id="edit-student-messages"></div>
      		<div id="edit-result"></div>
    	</div>
      	<!-- /.modal body -->
	                
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- /.remove payment -->
<div class="modal fade" tabindex="-1" role="dialog" id="removePayment">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Payment</h4>
      </div>
      <div class="modal-body">
        <p>Do you really want to remove ? </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="removePaymentBtn">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- 
MANAGE STUDENT PAYMENT  
-->

<!-- /.update student's payment -->
<div class="modal fade" tabindex="-1" role="dialog" id="editStudentPay">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title">Edit Student Payment</h4>
      	</div>
      
      	<div class="modal-body">          
      		<div id="edit-student-result"></div>      		
    	</div>
      	<!-- /.modal body -->
	                
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- /.remove student payment -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeStudentPay">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Payment</h4>
      </div>
      <div class="modal-body">
        <p>Do you really want to remove ? </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="removeStudentPayBtn">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- MANAGE EXPENSES -->
<!-- Add expesnes -->
<div class="modal fade" id="add-expenses-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" >
      <form action="accounting/createExpenses" method="post" class="form-horizontal" id="createEpxensesForm">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Expenses</h4>
      </div>
      <div class="modal-body" style="height: 500px;overflow-y: scroll;">

        <div id="add-expenses-message"></div>

        <div class="form-group">
          <label for="expensesDate" class="col-sm-3 control-label">Expenses Date:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="expensesDate" name="expensesDate" placeholder="Expenses Date" />
          </div>
        </div>
        <div class="form-group">
          <label for="expensesName" class="col-sm-3 control-label">Expenses Name:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="expensesName" name="expensesName" placeholder="Expenses Name" />
          </div>
        </div>
        <div class="form-group">
          <label for="totalAmount" class="col-sm-3 control-label">Total Amount:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="totalAmount" name="totalAmount" placeholder="Total Amount"  />
            <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" />
          </div>
        </div>
        <table class="table table-bordered" id="addSubExpensesTable">
        <thead>
          <tr>
            <th>Name</th>
            <th>Amount</th>
            <th style="width:10%;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $arrayNumber = 0; for($x = 1; $x < 4; $x++) { ?>
          <tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">
            <td class="form-group">
            <input type="text" class="form-control"  name="subExpensesName[<?php echo $x; ?>]" id="subExpensesName<?php echo $x; ?>" placeholder="Expenses Name" />
            </td>          
            <td class="form-group">
            <input type="text" class="form-control" name="subExpensesAmount[<?php echo $x; ?>]" id="subExpensesAmount<?php echo $x; ?>" onkeyup="calculateTotalAmount()" placeholder="Expenses Amount" />
            </td>          
            <td>
            <button type="button" class="btn btn-default" onclick="removeExpensesRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-remove"></i></button>
            </td>
          </tr>
          <?php $arrayNumber++; } // /.foreach?>
        </tbody>
      </table>
      </div><!-- /modal-body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-default" onclick="addExpensesRow()">Add Row</button>
        <button type="submit" class="btn btn-primary" id="createExpensesBtn">Save changes</button>      
      </div>      

      </form>
    </div>
  </div>
</div>

<!-- edit expesnes -->
<div class="modal fade" id="edit-expenses-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" >
      <form action="accounting/updateExpenses" method="post" class="form-horizontal" id="editEpxensesForm">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Expenses</h4>
      </div>
      <div class="modal-body" style="height: 500px;overflow-y: scroll;">

        <div id="edit-expenses-message"></div>

        <div id="show-edit-expenses-result"></div>

        
      </div><!-- /modal-body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-default" onclick="addEditExpensesRow()">Add Row</button>
        <button type="submit" class="btn btn-primary">Save changes</button>      
      </div>      

      </form>
    </div>
  </div>
</div>

<!-- /.remove expenses -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeExpensesModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Expenses</h4>
      </div>
      <div class="modal-body">
        <p>Do you really want to remove ? </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="removeExpensesBtn">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- view payment income -->
<div class="modal fade" tabindex="-1" role="dialog" id="viewIncomeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Income Information</h4>
      </div>
      <div class="modal-body">
        <div id="incomeResult"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript" src="<?php echo base_url('custom/js/accounting.js') ?>"></script>

<?php } // /else ?>