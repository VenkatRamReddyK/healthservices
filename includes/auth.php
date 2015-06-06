<?php include_once("../includes/db_connection.php");?> 
<?php include_once("../includes/functions.php");?>
<?php
    $studentid=$_POST['studentid'];//"012519336";
    $studentdob=$_POST['studentdob'];//"1990-05-19";
    $sname=authenticate($studentid, $studentdob);
     $responsecode=array('studentname' => $sname);
    echo json_encode($responsecode);

?>