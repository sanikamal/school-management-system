# School Management System
School Management System, is an open source project for people who wants to grab the core idea of the data process within the system.

This system is built with CodeIgniter – PHP framework, bootstrap, and jquery. This system, School Management System, is based on the Web Application. It provides advanced functionality run the daily basic requirement for the school program. The system can be manipulated by one user as an admin.

This application, there are some dependencies you will need to understand. For example, you want to add the section for a class. Without class information, the section information cannot be added to the system. Similarly, these concepts apply to the subject, student, and etc. Without any class and section, the subject, and student information cannot be created by the system.

Please read the below instruction to run the application on your system without any difficulties. There are few changes required in the source code to run the application. So Please follow the steps carefully.

Users:
    Admin

    Username: admin
    password: password
    
    
## Features

- Manage Class

        Add class information
        View, Update, and remove class information
- Manage Section

        Add section information
        View, Update, and remove section information
- Manage Subject

        Add section information
        View, Update, and remove section information
- Manage Student

        Add a single student information
        Add bulk student information
        View, Update, and remove student information
- Manage Teachers

        Add teacher information
        View, Update, and remove teacher information
- Manage Attendance

        Add Teacher and Student attendance information
        View, Update and Remove teacher and student attendance information
- Manage Marksheet

        Add, View, Update, and Remove marksheet name information
        Add, View, Update, and Remove student obtained marks into the marksheet
- Manage Accounting

        Add Student Payment Information
        View, Update, and Remove student payment information
        Add, View, Update, and Remove expenses information
        View Income information
- Change Password
- Change Username

Please Read:

To run this system, you need to create a database in the phpMyAdmin. Either you can create a database namely sms or something else. If you have a database name something else then, you have to change it in the source code. To change the database name in the source code.

Step 1: Go to the application > config > Database.php file.

Step 2: You will see the database name in the $db array. Change the name of the database whatever you desired. As shown below:

```$db['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => 'mysql',
    'database' => 'sms_db',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);```


