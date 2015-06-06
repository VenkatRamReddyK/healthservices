<?php include_once("sessions.php");?>
<?php include_once("macrodefines.php");?>
<?php include_once("db_connection.php");?>


<?php

// <editor-fold desc="Authentication Module">
    //does there a record exist with the student id with $studentid and date of birth with $dob 
        function authenticate($student_id,$student_dob){     
        global $conn;
            //select count(*) from student where student_id=012519336 and student_dob = "1990-05-19"
            //select student_name from student WHERE student_id=012519336 AND student_dob="1990-05-19";
            $student_dob=  convert_date_time($student_dob);
            $query="SELECT * ";
            $query.="FROM `student` s ";
            $query.="WHERE s.student_id=";
            $query.=$student_id;
            $query.=" AND s.student_dob='{$student_dob}'";        
            $query.=" LIMIT 1";
            $retval=  confirm_query($query);                                

                while($row =mysqli_fetch_assoc($retval)){	
                    return htmlentities($row["student_name"]);
                }
                return -1;
        }
 
        function authenticateAdmin($student_id,$password){     
            global $conn;                
            $query="SELECT * from `admin` a "
                    . "WHERE a.studentid='".$student_id."' "
                    . "AND password='".$password."' "
                    . "LIMIT 1";        
            $retval=  confirm_query($query);                                        
            while($row =mysqli_fetch_assoc($retval)){	
                return htmlentities($row["studentid"]);
            }
            return -1;
         }
         
         function doesAdminExist($studentid){     
            global $conn;                
            $query="SELECT a.studentid from `admin` a "
                    . "WHERE a.studentid='".$studentid."' LIMIT 1";                                        
            $retval=  confirm_query($query);                                        
            $count=mysqli_affected_rows($conn);            
            return $count;
         }
         function newRegistration($studentid,$password){
             global $conn;                
            $query="INSERT INTO `admin` VALUES('"
                    . "$studentid". "','"
                    . "$password"
                    . "')";        
            $retval=  confirm_query($query);                                        
            while($row =mysqli_fetch_assoc($retval)){	
                return htmlentities($row["studentid"]);
            }
            return -1;
            
         }
// </editor-fold>
// <editor-fold desc="Appointments">
    function appointmentsExist($studentid){            
        global $conn;
        // display appointment details for the student with $studentid 
        $query="select a.appointmentdate,a.appointmenttime,c.categoryname s.student_name "
                . "from `appointment` a, `student` s, `category` c "
                . "where student_id=".$studentid." and s.student_id=a.appointmentid and a.appointmentid=c.categoryid";
        $retval=  confirm_query($query);                        
        if(noofrow($retval)==1)
            return true; 
        else 
            return false;        
    }
    function getAppointment($appointmentid){            
        global $conn;
        //  display appointment details for the student with $studentid 
        //  $query="select a.appointmentdate,a.appointmenttime,c.categoryname s.student_name from appointment a, student s, category c where a.appointmentid=".$appointmentid." and s.student_id=a.appointmentid and a.appointmentid=c.categoryid";
        $query="SELECT a.studentid, a.appointmentdate,a.appointmenttime,s.student_name,c.categoryname "; 
        $query.="FROM `appointment` a, `student` s, `category` c ";
        $query.="WHERE a.appointmentid='{$appointmentid}' and a.studentid=s.student_id and a.categoryid=c.categoryid ";
        $query.="LIMIT 1;";
        $appointment_details=confirm_query($query);                        
        return $appointment_details;
    }
    function getAllAppointments(){            
        global $conn;
            // display appointment details for the student with $studentid 
        //select a.appointmentdate, s.student_name,c.categoryname 
        //from appointment a, student s, category c  
        //WHERE s.student_id=a.studentid 
        //And c.categoryid=a.categoryid;
        $query="SELECT a.appointmentid, a.appointmentdate, a.appointmenttime,s.student_id, s.student_name,c.categoryname ";
        $query.="FROM `appointment` a, `student` s, `category` c "; 
        $query.="WHERE s.student_id=a.studentid ";
        $query.="And c.categoryid=a.categoryid;";
//        $query.="GROUP BY s.student_name "
//        $query.="ORDER BY position ASC ";
        $appointment_set = confirm_query($query);                
        return $appointment_set;        
        }
        
    function makeAnAppointment($appointmentdate,$appointmenttime,$categoryid,$studentid){	
        global $conn;
//            INSERT INTO appointment (appointmentdate, appointmenttime, categoryid, studentid) 
//	VALUES ('2014-12-24', '15:00:00', 2, 12519336)
        $appointmentdate=convert_date_time($appointmentdate);//"2014-12-30";
        $query = "INSERT INTO `appointment` ";
        $query.="(appointmentdate, appointmenttime, categoryid, studentid) ";
        $query.="VALUES('";
        $query.=$appointmentdate."','";
        $query.=$appointmenttime."','";
        $query.=$categoryid."','";
        $query.=$studentid."');";            
        $retval = confirm_query($query); 		
        
        return mysqli_affected_rows($conn);
}		

    function updateAnAppointment($appointmentdate,$appointmenttime,$categoryid,$appointmentid){	
            global $conn;
            
            $appointmentdate=convert_date_time($appointmentdate);//"2014-12-30";
            $query = "UPDATE `appointment` ";
            $query.="SET ";
            $query.="appointmentdate='".$appointmentdate."', ";
            $query.="appointmenttime='".$appointmenttime."', ";
            $query.="categoryid='".$categoryid."' ";     
            $query.="WHERE appointmentid='".$appointmentid."'";            
            $retval = confirm_query($query); 		
            return mysqli_affected_rows($conn);
    }	

    function getStudentName($appointmentid){
         $selectquery="SELECT s.student_name "
               . "FROM `appointment` a, `student` s "
               . "WHERE a.studentid=s.student_id AND a.appointmentid='".$appointmentid."'";
        $selectretval = confirm_query($selectquery); 	
        while($studentdetails  =  mysqli_fetch_assoc($selectretval)){            
            return $studentdetails["student_name"];
        }
        return "";
    }
    function getStudentId($appointmentid){
        $selectquery="SELECT studentid "
               . "FROM `appointment` "
               . "WHERE appointmentid='".$appointmentid."'";
        $selectretval = confirm_query($selectquery); 	
        while($studentdetails  =  mysqli_fetch_assoc($selectretval)){            
            return $studentdetails["studentid"];
        }
        return "";
        
    }
    function getStudentEmail($studentid){
//         $selectquery="SELECT s.student_email "
//               . "FROM appointment a, student s "
//               . "WHERE a.studentid=s.student_id AND a.appointmentid='".$appointmentid."'";
        $selectquery="SELECT s.student_email "
               . "FROM `student` s "
               . "WHERE s.student_id='".$studentid."' LIMIT 1";
         
        $selectretval = confirm_query($selectquery); 	
        while($studentdetails  =  mysqli_fetch_assoc($selectretval)){            
            return $studentdetails["student_email"];
        }
        return "";
    }
    
    function deleteAnAppointment($appointmentid){
        global $conn;
//        SELECT s.student_name FROM appointment a, student s WHERE a.studentid=s.student_id AND a.appointmentid=9;
//DELETE FROM appointment WHERE appointmentid=9;
        // selecting the student name for which appointment has been deleted
      	$studentname=getStudentName($appointmentid);
        // deleting the appointment with appointment id
       $deletequery="DELETE FROM `appointment` "
               . "WHERE appointmentid='".$appointmentid."'";
        $deleteretval = confirm_query($deletequery); 		       
        return array(mysqli_affected_rows($conn),$studentname);
    }
// </editor-fold>

// <editor-fold desc="Groups">    
    function getAllGroups(){            
        global $conn;
            // display appointment details for the student with $studentid 
        //select a.appointmentdate, s.student_name,c.categoryname 
        //from appointment a, student s, category c  
        //WHERE s.student_id=a.studentid 
        //And c.categoryid=a.categoryid;
        $query="SELECT g.groupid, g.groupname, g.startdate, g.enddate, c.categoryname ";
        $query.="FROM `group` g, `category` c "; 
        $query.="WHERE g.categoryid=c.categoryid";
//        $query.="GROUP BY s.student_name "
//        $query.="ORDER BY position ASC ";
        $group_set = confirm_query($query);                
        return $group_set;        
        }
     function getGroupList(){          
        global $conn;
        $group_set=getAllGroups();
        $output="<select name='selectgroup' id='selectgroup' >";
        $output.="<option selected value='selectgroup'> - - Select - - </option>";                       
        while($group_details = mysqli_fetch_assoc($group_set)) {                                                        
              $groupid=$group_details["groupid"]; 
              $groupname=$group_details["groupname"];                           
               $output.="<option value='{$groupid}'>";
               $output.=$groupname;
               $output.="</option>";                       
        }
            $output.="</select>";
            return $output;
            
    }
    
    function getGroup($groupId){
        global $conn;
        $query="SELECT g.groupid, g.groupname,g.groupdescription,g.startdate, g.enddate, c.categoryname "
                . "FROM `group` g, `category` c "
                . "WHERE g.groupid='{$groupId}' "
                . "AND g.categoryid=c.categoryid "
                . "LIMIT 1";
        $group_details=confirm_query($query);                        
        return $group_details;
     }
    function getGroupName($groupId){
        global $conn;
        $query="SELECT groupname "
                . "FROM `group` "
                . "WHERE groupid='{$groupId}' "                
                . "LIMIT 1";
        $selectretval=confirm_query($query);                        
        while($groupdetails  =  mysqli_fetch_assoc($selectretval)){            
            return $groupdetails["groupname"];
        }
        return "";        
     }
   
    function createNewGroup($groupname,$groupdescription,$startdate,$enddate,$categoryid){
        global $conn;
//        INSERT INTO emailtemplate(templatename,subject,body) 
//VALUES("Flood Alerts","Flood Alert Warning !","Flood alert warning tommorow morning");
        $query="INSERT INTO `group` (groupname,groupdescription,startdate,enddate,categoryid) VALUES('"
                .$groupname."','"
                .$groupdescription."','"
                .$startdate."','"
                .$enddate."','"
                .$categoryid."');";
        $retval=confirm_query($query);
        return mysqli_affected_rows($conn);        
    }    
//    echo createNewGroup("test group name","test group description","2014-01-01","2015-02-03",1);

    function updateGroup($groupname,$groupdescription,$startdate,$enddate,$categoryid,$groupid){
        global $conn;
        $query="UPDATE `group` SET "
                . "groupname='{$groupname}', "
                . "groupdescription='{$groupdescription}', "
                . "startdate='{$startdate}', "
                . "enddate='{$enddate}', "
                . "categoryid='{$categoryid}' "
                . "WHERE groupid='{$groupid}' ";        
        $retval=  confirm_query($query);
        return mysqli_affected_rows($conn);        
    }    
//    $groupid=8;
//    $categoryid=1;
//    $groupname="updated group name";
//    $groupdescription="updated description";
//    $startdate="2015-02-02";
//    $enddate="2015-02-03";
//    echo updateGroup($groupname,$groupdescription,$startdate,$enddate,$categoryid,$groupid);

    
    function deleteGroup($groupid){
        global $conn;
        $groupname=getGroupName($groupid);
        // deleting the appointment with appointment id
        $deletequery="DELETE FROM `group` "
               . "WHERE groupid='".$groupid."'";
        $deleteretval = confirm_query($deletequery); 		        
        return array(mysqli_affected_rows($conn),$groupname);
    }   
        
// </editor-fold>

// <editor-fold desc="Settings">    
    function getTemplateName($templateId){
        
        global $conn;
        $query="SELECT * FROM `emailtemplate` "
                . "WHERE templateid='{$templateId}' LIMIT 1";
        $selectretval=confirm_query($query);                        
        while($templatedetails=  mysqli_fetch_assoc($selectretval)){            
            return $templatedetails["templatename"];
        }
        return "";  
    }
    
      function getTemplateList(){
          global $conn;          
        $template_set=getAllEmailTemplates();
        $output="<select name='selecttemplate' id='selecttemplate' >";
        $output.="<option selected value='selecttemplate'> - - Select - - </option>";                       
        while($template_details = mysqli_fetch_assoc($template_set)) {                                                        
              $templateid=$template_details["templateid"]; 
              $templatename=$template_details["templatename"];                           
               $output.="<option value='{$templateid}'>";
               $output.=$templatename;
               $output.="</option>";                       
        }
        $output.="</select>";
        return $output;                
      }
        
    function getTemplateDetails($templateId){
        
        global $conn;
        $query="SELECT * FROM `emailtemplate` "
                . "WHERE templateid='{$templateId}' LIMIT 1";
        $selectretval=confirm_query($query);                               
        return $selectretval;  
    }

    
    function getAllEmailTemplates(){            
        global $conn;
        // display appointment details for the student with $studentid 
        //select a.appointmentdate, s.student_name,c.categoryname 
        //from appointment a, student s, category c  
        //WHERE s.student_id=a.studentid 
        //And c.categoryid=a.categoryid;
        //select t.templateid, t.subject,t.body from `emailtemplate` t;
        $query="SELECT t.templatename, t.templateid, t.subject,t.body ";
        $query.="FROM `emailtemplate` t;"; 
//        $query.="WHERE g.categoryid=c.categoryid;";
//        $query.="GROUP BY s.student_name "
//        $query.="ORDER BY position ASC ";
        $group_set = confirm_query($query);                
        return $group_set;        
        }
        
 function createNewTemplate($templatename,$subject,$body){
        global $conn;
//        INSERT INTO emailtemplate(templatename,subject,body) 
//VALUES("Flood Alerts","Flood Alert Warning !","Flood alert warning tommorow morning");
        $query="INSERT INTO `emailtemplate` (templatename,subject,body) VALUES('"
                .$templatename."','"
                .$subject."','"
                .$body."');";
        $retval=  confirm_query($query);
        return mysqli_affected_rows($conn);        
    }    
//    echo createNewTemplate("test template","test subject","test body");

    function updateTemplate($templatename,$subject,$body,$templateid){
        global $conn;
        $query="UPDATE `emailtemplate` SET "
                . "templatename='{$templatename}', "
                . "subject='{$subject}', "
                . "body='{$body}' "
                . "WHERE templateid='{$templateid}'";        
        $retval=  confirm_query($query);
        return mysqli_affected_rows($conn);        
    }    
//    $templatename="updated template";
//    $subject="updated subject";
//    $body="updated body";
//    $templateid=7;
//    echo updateTemplate($templatename,$subject,$body,$templateid);
    
    function deleteTemplate($templateid){
        global $conn;
//        $selectretval=getTemplate($templateid);
//        $templateName="";
//        while($template_details  =  mysqli_fetch_assoc($selectretval)){            
//            $templateName=$template_details["templatename"];
//        }
       $templateName= getTemplateName($templateid);
        
        // deleting the appointment with appointment id
        $deletequery="DELETE FROM `emailtemplate` "
               . "WHERE templateid='".$templateid."'";
        $deleteretval = confirm_query($deletequery); 		        
        return array(mysqli_affected_rows($conn),$templateName);
    }      
//      function getTemplateList($templateid){
//        global $conn;
//        $query="SELECT t.templateid, t.templatename "
//                . "FROM emailtemplate t "
//                . "WHERE t.templateid='".$templateid."' "
//                . "LIMIT 1";
//        $template_set = confirm_query($query);                
//        while($template_details = mysqli_fetch_assoc($template_set)) {                                                        
//              $templatename=$template_details["templatename"];               
//            return $templatename;            
//        }
//        return "";          
//      }
    
// </editor-fold>

// <editor-fold desc="Campaigns">    
    function getAllCampaigns(){            
        global $conn;
            // display appointment details for the student with $studentid 
        //select a.appointmentdate, s.student_name,c.categoryname 
        //from appointment a, student s, category c  
        //WHERE s.student_id=a.studentid 
        //And c.categoryid=a.categoryid;
//        select t.templateid, t.subject,t.body from `emailtemplate` t;
        $query="SELECT c.campaignid,c.campaignname, c.campaigndescription,c.chrondata,c.timeframe,g.groupname,t.templatename "
                . "FROM `campaign` c, `group` g, `emailtemplate` t "
                . "WHERE c.groupid=g.groupid "
                . "AND c.templateid=t.templateid "
                . "ORDER BY campaignname"; 
//        $query.="WHERE g.categoryid=c.categoryid;";
//        $query.="GROUP BY s.student_name "
//        $query.="ORDER BY position ASC ";
        $group_set = confirm_query($query);                
        return $group_set;        
        }
        
    function getCampaign($campaignid){
   global $conn;
        $query="SELECT c.campaignid,c.campaignname, c.campaigndescription,c.chrondata,c.timeframe,g.groupname,t.templatename "
                . "FROM `campaign` c ,`emailtemplate` t, `group` g "
                . "WHERE c.campaignid= "
                . "'{$campaignid}' "
                . "AND c.templateid=t.templateid "
                . "AND c.groupid=g.groupid ";                
//        $query.="GROUP BY s.student_name "
//        $query.="ORDER BY position ASC ";
        $group_set = confirm_query($query);                
        return $group_set;        

    }

    function createNewCampaign($campaginname,$campaigndescription,$groupid,$templateid,$timeframe,$chrondata){
    global $conn;
        $query="INSERT INTO `campaign` (campaignname,campaigndescription,groupid,templateid,timeframe,chrondata) VALUES('"
            .$campaginname."','"
            .$campaigndescription."','"
            .$groupid."','"
            .$templateid."','"
            .$timeframe."','"
            .$chrondata."');";
        $retval=confirm_query($query);
        return mysqli_affected_rows($conn);        
    }    
//    echo createNewCampaign("campagin 2","this is a test campaign 2",11,2,"12:12:10","w2");
function updateCampaign($campaignName, $campaignDescription, $groupid, $templateid, $timeframe, $chrondata,$updateCampaignId){
      global $conn;
        $query="UPDATE `campaign` SET "
                . "campaignname='{$campaignName}', "
                . "campaigndescription='{$campaignDescription}', "
                . "groupid='{$groupid}', "
                . "templateid='{$templateid}', "
                . "timeframe='{$timeframe}', "               
                . "chrondata='{$chrondata}' "
                . "WHERE campaignid='{$updateCampaignId}'";        
        $retval=  confirm_query($query);
        return mysqli_affected_rows($conn);      
    
}
    function deleteCampaigns($campaignid){
        global $conn;
        $selectretval=getCampaign($campaignid);
        $camapaignName="";
        while($campaign_details = mysqli_fetch_assoc($selectretval)){            
            $campaignName=$campaign_details["campaignname"];
        }        
        // deleting the appointment with appointment id
        $deletequery="DELETE FROM `campaign` "
               . "WHERE campaignid='".$campaignid."'";
        $deleteretval = confirm_query($deletequery); 		        
        return array(mysqli_affected_rows($conn),$campaignName);
    }   

//     echo updateCampaign("campaignName", "campaignDescription", 13, 3, "12:22:00", "chrondata",597);
     
      
        
//</editor-fold>
        
//     <editor-fold desc="Categories">    
    function getAllCategories(){
        global $conn;
        $query="SELECT c.categoryid, c.categoryname ";
        $query.="FROM `category` c;";     
        $category_set = confirm_query($query);                
        return $category_set;            
    }
    function getCategoriesName($categoryid){
        global $conn;
        $query="SELECT c.categoryname ";
        $query.="FROM `category` c ";     
        $query.="WHERE categoryid='".$categoryid."'";
        $category_set = confirm_query($query);                
        while($category_details = mysqli_fetch_assoc($category_set)) {                                                        
              $categoryname=$category_details["categoryname"];               
            return $categoryname;            
        }
        return "";
    }   
    function getCategoryList(){
        $category_set=getAllCategories();
        $output="<select name='selectcategory' id='selectcategory' >";
        $output.="<option selected value='selectcategory'> - - Select - - </option>";                       
        while($category_details = mysqli_fetch_assoc($category_set)) {                                                        
              $categoryid=$category_details["categoryid"]; 
              $categoryname=$category_details["categoryname"];                           
               $output.="<option value='{$categoryid}'>";
               $output.=$categoryname;
               $output.="</option>";                       
        }
            $output.="</select>";
            return $output;
    }
    
// </editor-fold>

// <editor-fold desc="Helper functions  ">        
    
    function redirect_to($newlocation){header('Location: '.$newlocation);}
    
    function noofrow($result){return mysqli_num_rows($result);}
    
    function convert_date_time($_examdatetime){
        $examdatetime=str_replace("/","-",$_examdatetime);
        return $examdatetime;
    }
 
    function confirm_query($query){
        global $conn;		
        $retval = mysqli_query($conn,$query) or die('Query "' . $query . '" failed: ' . mysqli_error($conn)); 				
        return $retval;	
    }
   
        function email_to_user($to,$name,$appointmentdate,$appointmenttime ,$action){
			$adminname="Student Health Services";
			$adminemail="admin@shs.csulb.edu";
			
			$message = "<!DOCTYPE html><html>
			<head><meta http-equiv='Content-Type content='text/html; charset=utf-8' />
			<title>Appointment Confirmation</title>
			<style type='text/css'>
			body { font-size: 13px; font-family: Arial, sans-serif;}
			</style></head><body>";
		
			$message.="<h3><b>Dear $name,  </b></h3>";
                        if($action=="created"){
                            $message.="<br/><p>Your Appointment has been <strong>created</strong><br/></p>";
                            $subject="Appointment Creation Confirmation From Student Health Services";
                        }
                        else if($action=="updated"){
                            $message.="<br/><p>Your Appointment has been <strong>Updated</strong><br/></p>";                            
                            $subject="Appointment Updation Confirmation From Student Health Services";
                        }
                        else{
                            $message.="<br/><p>Your Appointment has been <strong>deleted</strong><br/></p>";                            
                            $subject="Appointment Deletion Confirmation From Student Health Services";
                        }
			if($action=="created" || $action=="updated"){
                        $message.="<br/><p>Appointment Date: [ $appointmentdate ]</p>"
                                . "<br/><p>Appointment Time: [ $appointmenttime ]</p>";
                        
                        }
                        
			$message.="<br/><p>Regards, <br/> <strong>$adminname.</p>"
                                . "<p>[$adminemail]</p>";
			
			$headers = 	'From: '.$adminname.' <'.$adminemail.'>'. "\r\n" .
						"Content-Type: text/html; charset=UTF-8\n".
						'X-Mailer: PHP/' . phpversion();	
			$status=null;
			if (! mail($to,$subject,$message,$headers) ) 			{
				$status="<h2>The email has failed! Make sure your email address is valid.</h2><br/>";	
				$_SESSION['status'].=$status;
			}
			else{
				$status="<h2>The email was sent successfully to :</h2> <br/> <strong>[ ".$name." ] : ".$to." <strong> <br/>";	
				$_SESSION['status'].=$status;
			}
}
function email_appointments($to,$name,$appointmentdate,$appointmenttime ,$categoryname){
    
    			$adminname="Student Health Services";
			$adminemail="admin@shs.csulb.edu";
			
			$message = "<!DOCTYPE html><html>
			<head><meta http-equiv='Content-Type content='text/html; charset=utf-8' />
			<title>Appointment Confirmation</title>
			<style type='text/css'>
			body { font-size: 13px; font-family: Arial, sans-serif;}
			</style></head><body>";
		
			$message.="<h3><b>Dear $name,  </b></h3>";
                            
                        
                        $subject="Appointment Remainder From Student Health Services";
                        $message.="<br/><p><strong> Your Appointment is Scheduled on </strong><br/></p>";
                        
			
                        $message.="<br/><p>Appointment Date: [ $appointmentdate ]</p>"
                                . "<br/><p>Appointment Time: [ $appointmenttime ]</p>"
                                . "<br/><p>Category: [ $categoryname ]</p>";                                    
                        
			$message.="<br/><p>Regards, <br/> <strong>$adminname.</p>"
                                . "<p>[$adminemail]</p>";
			
			$headers = 	'From: '.$adminname.' <'.$adminemail.'>'. "\r\n" .
						"Content-Type: text/html; charset=UTF-8\n".
						'X-Mailer: PHP/' . phpversion();	
			$status=null;
			if (! mail($to,$subject,$message,$headers) ) 			{
				$status="<h2> email has failed! Make sure your email address is valid.</h2><br/>";	
				$_SESSION['status'].=$status;
			}
			else{
				$status="<h2> email was sent successfully to :</h2> <br/> <strong>[ ".$name." ] : ".$to." <strong> <br/>";	
				$_SESSION['status'].=$status;
			}
}
function email_greetings($studentname,$studentemail){
    
    			$adminname="Student Health Services";
			$adminemail="admin@shs.csulb.edu";
			
			$message = "<!DOCTYPE html><html>
			<head><meta http-equiv='Content-Type content='text/html; charset=utf-8' />
			<title>Appointment Confirmation</title>
			<style type='text/css'>
			body { font-size: 13px; font-family: Arial, sans-serif;}
			</style></head><body>";
		
			$message.="<h3><b>Dear $studentname,  </b></h3>";
                            
                        
                        $subject="Birthday Greetings From Student Health Services";
                        $message.="<br/><p>Student Health Services, wishes you a prosperus birthday, <br/></p>";
                        $message.="<br/><p>Birthdays are good for you, the more you have the longer you live<br/></p>";
                        
			
                                                        
                        
			$message.="<br/><p>Regards, <br/> <strong>$adminname.</p>"
                                . "<p>[$adminemail]</p>";
			
			$headers = 	'From: '.$adminname.' <'.$adminemail.'>'. "\r\n" .
						"Content-Type: text/html; charset=UTF-8\n".
						'X-Mailer: PHP/' . phpversion();	
			$status=null;
			if (! mail($studentemail,$subject,$message,$headers) ) 			{
				$status="<h2> email has failed! Make sure your email address is valid.</h2><br/>";	
				$_SESSION['status'].=$status;
			}
			else{
				$status="<h2> email was sent successfully to :</h2> <br/> <strong>[ ".$studentname." ] : ".$studentemail." <strong> <br/>";	
				$_SESSION['status'].=$status;
			}
    
}
// </editor-fold>
// 
// <editor-fold desc="Session Management ">        
    // session management for students
    function isStudentSessionExist(){
        if(isset($_SESSION["STUDENT_SESSION"]))
            return true;
        else
            return false;
    }

    function createStudentSession($student_id){
        if(!isStudentSessionExist())        
            $_SESSION["STUDENT_SESSION"]=$student_id;
    }

    function getStudentSession(){
        return $_SESSION["STUDENT_SESSION"];
    }
    // session management for admin 
    function isAdminSessionExist(){
        if(isset($_SESSION["ADMIN_SESSION"]))
            return true;
        else
            return false;
    }
  
    function createAdminSession($student_id){
        if(!isStudentSessionExist())        
            $_SESSION["ADMIN_SESSION"]=$student_id;
    }    
   
    function getAdminSession(){
        return $_SESSION["ADMIN_SESSION"];
    }
    
    function create_logout_href(){
        echo "<p> Hello World ! </p>";
//        if(isStudentSessionExist()){
//                echo "<p class=\"welcomenote\"> Welcome ".getStudentSession()."   !</p>";
//                echo "<a href=\"includes/logout.php\" style=\" float:right; color:red; padding:10px;\" >Logout</a>"; 	
//        }
//        else{
//            echo "<p class=\"welcomenote\"> Please Login ";
//            echo "<a href=\"Homepage/login.php\" style=\" float:right; color:red; padding:10px;\" >Logout</a>";            
//            echo "  !</p>";
//        }
    }
        
    function logout(){ 
		if(isStudentSessionExist()) // CLOSE STUDENT SESSION
                    $_SESSION['STUDENT_SESSION']=null;	
                else if(isAdminSessionExist())	// CLOSE ADMIN SESSION
                        $_SESSION['ADMIN_SESSION']=null;	
//		redirect_to("login.php");					
	}
        
// </editor-fold> 
        
// <editor-fold desc="under testing  ">
    function insert_into_students($campusid,$email,$examid,$firstname,$lastname,$status){	
        global $conn;
            $query = "INSERT INTO cpestudents(campusid,email,examid,firstname,lastname,status)
            VALUES('$campusid','$email','$examid','$firstname','$lastname','$status')";	
            $retval = confirm_query($query); 		
    }		

    function insert_into_exams($examdate,$roomno,$capacity){	
        global $conn;
            $query = "INSERT INTO cpeexams(examdate,roomno,capacity)
            VALUES('$examdate','$roomno','$capacity')";	
            $retval = confirm_query($query); 		
    }

    function registration_status($campusid,$examid){							
            // for this exam did the student with campus id exist			
            $query = "SELECT regid FROM cpestudents WHERE campusid='$campusid' AND examid='$examid'";	
            $retval = confirm_query($query); 
            while($row =  mysqli_fetch_assoc($retval))
            {	
                    return "exist"; 
            } 
            return "notexist";
    }
    
// </editor-fold>

// <editor-fold desc="details about Students  ">

// </editor-fold>        
        		
    // <editor-fold desc="details about Students  ">

    function loadCSV(){
        global $conn;
        $file_size= $_FILES['csv']['size'];
        if ($file_size> 0) { 

            //get the csv file 
            $file = $_FILES['csv']['tmp_name']; 
            $handle = fopen($file,"r"); 

            //loop through the csv file and insert into database 
            do { 
                $selectquery="SELECT student_id FROM appscheduler_bookings WHERE student_id='".$data[0]."'";
                $selectretval=  confirm_query($selectquery);
                
                $count=mysqli_affected_rows($conn);
                echo "Count: ",$count;
                if($count>0){
                    continue;
                }
                else{
                if ($data[0]) { 
                    $query="INSERT INTO `appscheduler_bookings`(student_id,student_name, student_email, student_phone,student_city,student_state,student_zip,student_add_1,student_add_2,student_notes,student_dob,student_mis,appointment_id,appointment_d,appointment_t) VALUES 
                        ( 
                            '".addslashes($data[0])."', 
                            '".addslashes($data[1])."', 
                            '".addslashes($data[2])."', 
                            '".addslashes($data[3])."', 
                            '".addslashes($data[4])."', 
                            '".addslashes($data[5])."', 
                            '".addslashes($data[6])."', 
                            '".addslashes($data[7])."', 
                            '".addslashes($data[8])."', 
                            '".addslashes($data[9])."', 
                            '".addslashes($data[10])."', 
                            '".addslashes($data[11])."', 
                            '".addslashes($data[12])."',                                   
                            '".addslashes($data[13])."',
                            '".addslashes($data[14])."' 
                        )"; 
                    $retval=  confirm_query($query);
                    echo $retval;
                } 
                
                }
                
            } while ($data = fgetcsv($handle,1000,",","'")); 
            header('Location: upload.php?success=1'); die; 
        } 
    }

    // </editor-fold>        
    
    function birthdayGreetings(){
        $query="SELECT student_name,student_email "
                . "FROM `student` "
                . "WHERE MONTH(student_dob) = MONTH(NOW()) AND DAY(student_dob) = DAY(NOW());";
                //DATE_ADD(NOW(), INTERVAL -".$ndays." DAY)        
        $selectretval=confirm_query($query);                        
        $birthdayList=array();
         while($studentdetails  =  mysqli_fetch_assoc($selectretval)){                         
            $curStudentDetails=array("studentname"=>$studentdetails["student_name"],"studentemail"=>$studentdetails["student_email"]);
            array_push($birthdayList,$curStudentDetails);
        }
        return $birthdayList;        
 }
    function appointmentsRemainderBefore($ndays){        
        $query="SELECT s.student_name,s.student_email,a.appointmentdate,a.appointmenttime,c.categoryname "
                . "FROM `appointment` a ,`student` s, `category` c "
                . "WHERE a.studentid=s.student_id AND a.categoryid=c.categoryid "
                . "AND MONTH(a.appointmentdate) = MONTH(NOW()) AND DAY(a.appointmentdate) = DAY(DATE_ADD(NOW(), INTERVAL -'".$ndays."' DAY));";     //DATE_ADD(NOW(), INTERVAL 9 DAY)        
        $selectretval=confirm_query($query);                        
        $appointmentList=array();
         while($appointmentDetails  =  mysqli_fetch_assoc($selectretval)){                         
            $curAppointmentDetails=array("studentname"=>$appointmentDetails["student_name"],"studentemail"=>$appointmentDetails["student_email"],"categoryname"=>$appointmentDetails["categoryname"],"appointmentdate"=>$appointmentDetails["appointmentdate"],"appointmenttime"=>$appointmentDetails["appointmenttime"]);
            array_push($appointmentList,$curAppointmentDetails);
        }
        return $appointmentList;            
    }
    
?>