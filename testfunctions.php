<?php    include_once("includes/functions.php");?>
<?php

//function birthdayGreetingsBefore($ndays){
//
//        $query="SELECT student_name,student_email FROM `student` WHERE MONTH(student_dob) = MONTH(DATE_ADD(NOW(), INTERVAL -".$ndays." DAY)) AND DAY(student_dob) = DAY(NOW());";        
//        $selectretval=confirm_query($query);                        
//        $birthdayList=array();
//         while($studentdetails  =  mysqli_fetch_assoc($selectretval)){                         
//            $curStudentDetails=array("studentname"=>$studentdetails["student_name"],"studentemail"=>$studentdetails["student_email"]);
//            array_push($birthdayList,$curStudentDetails);
//        }
//        return json_encode($birthdayList);        
// }
//  $campaignsDeletionStatusAll=array();
//        foreach ($deletecheckedcampaigns as $deleteCampaigns){
//            $retval=  deleteCampaigns($deleteCampaigns);
//            $campaignsDeletionStatus=array("status"=>$retval[0],"campaignname"=>$retval[1]);//'status'=>$retval[0],            
//            array_push($campaignsDeletionStatusAll,$campaignsDeletionStatus);
//        }
//        echo json_encode($campaignsDeletionStatusAll); 
// 
 
 
 
print_r(birthdayGreetingsBefore(2));

// function createNewCampaign($campaginname,$campaigndescription,$groupid,$templateid,$timeframe,$chrondata){
//        global $conn;
//
//        $query="INSERT INTO healthservices.campaign(campaignname,campaigndescription,groupid,templateid,timeframe,chrondata) VALUES('"
//            .$campaginname."','"
//            .$campaigndescription."','"
//            .$groupid."','"
//            .$templateid."','"
//            .$timeframe."','"
//            .$chrondata."');";
//        $retval=confirm_query($query);
//        return mysqli_affected_rows($conn);        
//    }    
//    echo createNewCampaign("campagin 2","this is a test campaign 2",11,2,"12:12:10","w2");

//    function updateGroup($groupname,$groupdescription,$startdate,$enddate,$categoryid,$groupid){
//        global $conn;
//        $query="UPDATE healthservices.group SET "
//                . "groupname='{$groupname}', "
//                . "groupdescription='{$groupdescription}', "
//                . "startdate='{$startdate}', "
//                . "enddate='{$enddate}', "
//                . "categoryid='{$categoryid}' "
//                . "WHERE groupid='{$groupid}' ";        
//        $retval=  confirm_query($query);
//        return mysqli_affected_rows($conn);        
//    }    
//    $groupid=8;
//    $categoryid=1;
//    $groupname="updated group name";
//    $groupdescription="updated description";
//    $startdate="2015-02-02";
//    $enddate="2015-02-03";
//    echo updateGroup($groupname,$groupdescription,$startdate,$enddate,$categoryid,$groupid);

    
//    function deleteGroup($groupid){
//        global $conn;
//        // deleting the appointment with appointment id
//        $deletequery="DELETE FROM healthservices.group "
//               . "WHERE groupid='".$groupid."'";
//        $deleteretval = confirm_query($deletequery); 		        
//        return mysqli_affected_rows($conn);
//    }
//    $groupid=8;
//    echo deleteGroup($groupid);

//    function createNewTemplate($templatename,$subject,$body){
//        global $conn;
////        INSERT INTO healthservices.emailtemplate(templatename,subject,body) 
////VALUES("Flood Alerts","Flood Alert Warning !","Flood alert warning tommorow morning");
//        $query="INSERT INTO emailtemplate(templatename,subject,body) VALUES('"
//                .$templatename."','"
//                .$subject."','"
//                .$body."');";
//        $retval=  confirm_query($query);
//        return mysqli_affected_rows($conn);        
//    }    
//    echo createNewTemplate("test template","test subject","test body");
//
//    function updateTemplate($templatename,$subject,$body,$templateid){
//        global $conn;
//        $query="UPDATE healthservices.emailtemplate SET "
//                . "templatename='{$templatename}', "
//                . "subject='{$subject}', "
//                . "body='{$body}' "
//                . "WHERE templateid='{$templateid}'";        
//        $retval=  confirm_query($query);
//        return mysqli_affected_rows($conn);        
//    }    
////    $templatename="updated template";
////    $subject="updated subject";
////    $body="updated body";
////    $templateid=7;
////    echo updateTemplate($templatename,$subject,$body,$templateid);
//    
//    function deleteTemplate($templateid){
//        global $conn;
//        // deleting the appointment with appointment id
//        $deletequery="DELETE FROM healthservices.emailtemplate "
//               . "WHERE templateid='".$templateid."'";
//        $deleteretval = confirm_query($deletequery); 		        
//        return mysqli_affected_rows($conn);
//    }
//        $templateid=6;
//        echo deleteTemplate($templateid);
    
//
//      function getGroupList(){          
//        global $conn;
//        $group_set=getAllGroups();
//        $output="<select name='selectgroup' id='selectgroup' >";
//        $output.="<option selected value='selectgroup'> - - Select - - </option>";                       
//        while($group_details = mysqli_fetch_assoc($group_set)) {                                                        
//              $groupid=$group_details["groupid"]; 
//              $groupname=$groupdetails["groupname"];                           
//               $output.="<option value='{$groupid}'>";
//               $output.=$groupname;
//               $output.="</option>";                       
//        }
//            $output.="</select>";
//            return $output;
//      
//      }
//      function getTemplateList($templateid){
//          global $conn;          
//        $template_set=getAllEmailTemplates();
//        $output="<select name='selecttemplate' id='selecttemplate' >";
//        $output.="<option selected value='selecttemplate'> - - Select - - </option>";                       
//        while($template_details = mysqli_fetch_assoc($template_set)) {                                                        
//              $templateid=$template_details["templateid"]; 
//              $tempaltename=$template_details["templatename"];                           
//               $output.="<option value='{$templateid}'>";
//               $output.=$templatename;
//               $output.="</option>";                       
//        }
//        $output.="</select>";
//        return $output;                
//      }
//      
//     
//      
//      echo getGroupList();
//      echo getTemplateList();
//      function updateCampaign($campaignName, $campaignDescription, $groupid, $templateid, $timeframe, $chrondata,$updateCampaignId){
// 
//      global $conn;
//        $query="UPDATE healthservices.campaign SET "
//                . "campaignname='{$campaignName}', "
//                . "campaigndescription='{$campaignDescription}', "
//                . "groupid='{$groupid}', "
//                . "templateid='{$templateid}', "
//                . "timeframe='{$timeframe}', "                
//                . "chrondata='{$chrondata}' "
//                . "WHERE campaignid='{$updateCampaignId}'";        
//        $retval=  confirm_query($query);
//        return mysqli_affected_rows($conn);      
//    
//}
////    $templatename="updated template";
////    $subject="updated subject";
////    $body="updated body";
////    $templateid=7;
//     echo updateCampaign("campaignName", "campaignDescription", 13, 3, "12:22:00", "chrondata",597);
//    
//    function deleteCampaign($campaignid){
//        global $conn;
//        $selectretval=getCampaign($campaignid);
//        $camapaignName="";
//        while($campaign_details = mysqli_fetch_assoc($selectretval)){            
//            $campaignName=$campaign_details["campaignname"];
//        }        
//        // deleting the appointment with appointment id
//        $deletequery="DELETE FROM healthservices.campaign "
//               . "WHERE campaignid='".$campaignid."'";
//        $deleteretval = confirm_query($deletequery); 		        
//        return array(mysqli_affected_rows($conn),$campaignName);
//    }   

//    print_r(deleteCampaign(606));
    ?>