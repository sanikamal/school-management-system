<!DOCTYPE html>
<html>
<head>
  <title><?php echo $title; ?></title>

  <!-- bootstrap css -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
  <!-- boostrap theme -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap-theme.min.css') ?>">
  <!-- datatables css -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatables/media/css/jquery.dataTables.min.css') ?>">
  <!-- fileinput css -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fileinput/css/fileinput.min.css') ?>">
  <!-- fullcalendar css -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fullcalendar/fullcalendar.min.css') ?>">  
  <!-- keith calendar css -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/keith-calendar/jquery.calendars.picker.css') ?>"> 

  <!-- custom css -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('custom/css/custom.css') ?>"> 

  <!-- jquery -->
  <script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery.min.js') ?>"></script>
  

</head>
<body>

<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
<nav class="navbar navbar-success bg-success navbar-static-top" style="background-color: midnightblue;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo base_url('dashboard') ?>">RuaSMS</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li id="topNavDashboard"><a href="<?php echo base_url('dashboard') ?>"> <i class="glyphicon glyphicon-dashboard"></i> Dashboard <span class="sr-only">(current)</span></a></li>
        <!-- <li><a href="#">Class</a></li> -->
        <li class="dropdown" id="topClassMainNav">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-edit"></i> Class <span class="caret"></span></a>
          <ul class="dropdown-menu">            
            <li id="topNavClass"><a href="<?php echo base_url('classes'); ?>">Manage Class</a></li>                        
            <li id="topNavSection"><a href="<?php echo base_url('section') ?>">Manage Section</a></li>                                 
            <li id="topNavSubject"><a href="<?php echo base_url('subject') ?>">Manage Subject</a></li>           
          </ul>
        </li>
        <li class="dropdown" id="topStudentMainNav">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-list-alt"></i> Student <span class="caret"></span></a>

          <ul class="dropdown-menu">
            <li id="addStudentNav"><a href="<?php echo base_url('student?opt=addst') ?>">Add Student</a></li>                        
            <li id="addBulkStudentNav"><a href="<?php echo base_url('student?opt=bulkst') ?>">Add Bulk Student</a></li>                        
            <li id="manageStudentNav"><a href="<?php echo base_url('student?opt=mgst') ?>">Manage Student</a></li>           
          </ul>
        </li>
        <li id="topNavTeacher"><a href="<?php echo base_url('teacher') ?>"> <i class="glyphicon glyphicon-briefcase"></i> Teacher</a></li>

        <li class="dropdown" id="topAttendanceMainNav">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-time"></i> Attendance <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li id="takeAttendNav"><a href="<?php echo base_url('attendance?atd=add') ?>">Take Attendance</a></li>
            <li id="attenReport"><a href="<?php echo base_url('attendance?atd=report') ?>">Attendance Report</a></li>
          </ul>
        </li>       
        <li class="dropdown" id="topMarksheetMainNav">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-duplicate"></i> Marksheet <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li id="manageMarksheet"><a href="<?php echo base_url('marksheet?opt=mngms') ?>">Manage Marksheet</a></li>
            <li id="manageMarks"><a href="<?php echo base_url('marksheet?opt=mgmk') ?>">Manage Marks</a></li>
          </ul>
        </li>

        <li class="dropdown" id="topAccountMainNav">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-indent-left"></i> Accounting <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li id="createStudentNav"><a href="<?php echo base_url('accounting?opt=crtpay') ?>">Create Student Payment</a></li>                        
            <li id="managePayNav"><a href="<?php echo base_url('accounting?opt=mgpay') ?>">Manage Payment</a></li>                        
            <li id="expNav"><a href="<?php echo base_url('accounting?opt=mgexp') ?>">Expenses</a></li>           
            <li id="incomeNav"><a href="<?php echo base_url('accounting?opt=ime') ?>">Income</a></li>           
          </ul>
        </li>
      </ul>      
      <ul class="nav navbar-nav navbar-right">        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-user"></i> <span class="caret"></span></a>
          <ul class="dropdown-menu">            
            <li><a href="<?php echo base_url('setting') ?>">Setting</a></li>                       
            <li><a href="<?php echo base_url('users/logout'); ?>">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container-fluid bg-warning">

  
