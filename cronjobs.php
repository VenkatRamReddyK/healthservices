<?php   include_once("includes/functions.php");?>
<?php
if(isset($_GET['birthdays']))
{
    
    
    $birthdays=birthdayGreetings();       
    if(count($birthdays)>0){
    echo "Birthday remainders:";
        foreach($birthdays as $birthday){        
//        print_r( $birthday);
        $studentemail=$birthday["studentemail"];
        $studentname=$birthday["studentname"];        
        email_greetings($studentname,$studentemail);
        echo "<br> Birthday Greetings has been sent to :".$studentname." with email: ".$studentemail;
     }  
    }else{
        echo "No Remainders today";
    }     
}
else if(isset($_GET['appointments']) && isset($_GET['ndays'])){    
    $ndays=$_GET['ndays'];    
    $remainders=appointmentsRemainderBefore($ndays);  
    if(count($remainders)>0){
        echo "Appointments remainders:<br>";
        foreach($remainders as $remainder){                  
            $studentemail=$remainder["studentemail"];
            $studentname=$remainder["studentname"];
            $categoryname=$remainder["categoryname"];
            $appointmentdate=$remainder["appointmentdate"];
            $appointmenttime=$remainder["appointmenttime"];
             email_appointments($studentname,$studentemail,$appointmentdate,$appointmenttime ,$categoryname);
             echo "<br>Appointment Remainder {$_SESSION['status']}".$studentname." with email: ".$studentemail;                
        }
    }else{
        echo "No Remainders today";
    }
    
}

?>
