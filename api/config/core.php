<?php
//show error reporting
ini_set('display errors', 1);
error_reporting(E_ALL);
//home page url:
$home_url = "http://localhost/api/";

//page given n URL parameter
$page = isset($_GET['page']) ? $_GET['page']: 1;
//recors per page
$records_per_page = 5;
////calculate query limit clause
$from_record_num = ($records_per_page * $page) - $records_per_page ;



?>