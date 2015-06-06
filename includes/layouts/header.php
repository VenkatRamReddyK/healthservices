<?php   include_once("includes/functions.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Health Services</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" type="text/css" href="includes/css/jquery.datatables.css"/>
  <link rel="stylesheet" href="includes/css/runnable.css" />
  <link rel="stylesheet" type="text/css" href="includes/css/style.css"/>     
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'/>
  
  <script src="includes/js/jquery.min.js"></script>    
  <script type="text/javascript" src="includes/js/script.js"></script>
  
</head>
    <body>        
        <header>
            <nav class="navigation">
                <ul class="nav">
                    <li><a href="appointments.php">Appointments</a></li>
                    <li><a href="groups.php">Groups</a></li>
                    <li><a href="campaigns.php">Campaigns</a></li>
                    <li><a href="settings.php">Settings</a></li>                    
                    <?php
                      if(isStudentSessionExist()){
                          echo " <li><a href=\"logout.php\">".getStudentSession()." Logout</a></li>";
                      }else{
                          echo "<li><a href=\"homepage.php\">Login</a></li>";
                      }
                    ?>   
                </ul>
            </nav>            
        </header>
        <p><?php    echo "Student Session: ".getStudentSession(); ?></p>
        <div id="err"> 
            
        </div>
        
        <?php 
            if(basename($_SERVER['PHP_SELF'])!="homepage.php"){
                if (!isStudentSessionExist()){
                   redirect_to("homepage.php");
                }
            }
                
            
        ?>