<?php include_once("../includes/db_connection.php");?> 
<?php include_once("../includes/functions.php");?>

<?php

// <editor-fold desc="Handlers for Login Session Management ">
if(isset($_POST['loginset']) && isset($_POST['studentid']) && isset($_POST['password'])){
        $studentid=$_POST['studentid'];
        $password=$_POST['password'];
        $status=authenticateAdmin($studentid,$password);    
        if($status!=-1){
            createStudentSession($studentid);
            redirect_to("../appointments.php");
        }
        else
            redirect_to("../homepage.php?loginstatus=-1");    
}
else if(isset($_POST['registrationset']) && isset($_POST['studentid']) && isset($_POST['password'])){
    $studentid=$_POST['studentid'];
    $password=$_POST['password'];
    $loginstatus=doesAdminExist($studentid);    // check whether registration exist    
    if($loginstatus==1){ //Registration exist        
        redirect_to("../homepage.php?registrationstatus=registered");                
    }
    else{
        //New Registration
        $status=newRegistration($studentid,$password);                
        redirect_to("../homepage.php?status=loggedin");
    }
    
}
// </editor-fold>  
//    
// <editor-fold desc="Handlers for Appointments ">

else if(isset($_GET['updateappointmentid'])){
    $updateappointmentid=$_GET['updateappointmentid'];
    $appdetails=getAppointment($updateappointmentid);
    while($curappointment = mysqli_fetch_assoc($appdetails)) {                                                        
        echo json_encode($curappointment);
    }       
}

else if(isset($_POST['updateappointment'])){// updates the record in appointments             
        if(isset($_POST["appointmentdate"]) && isset($_POST["appointmenttime"]) 
                && isset($_POST["selectcategory"])&& isset($_POST["student_id"]) && isset($_POST["studentname"]) ){
            $studentname=$_POST["studentname"];
            $appointmentdate=$_POST["appointmentdate"];
            $appointmenttime=$_POST["appointmenttime"];
            $categoryid=$_POST["selectcategory"];            
            $appointmentid=$_POST["updateid"];
            $category=getCategoriesName($categoryid);      
            
            $studentemail=getStudentEmail($_POST["student_id"]);
            $retval= updateAnAppointment($appointmentdate, $appointmenttime, $categoryid, $appointmentid);                          
            $appointmentstatus=array('status'=>$retval,'studentname'=>$studentname,'appointmentdate'=>$appointmentdate,
                            'appointmenttime'=>$appointmenttime,'categoryname'=>$category);
            email_to_user($studentemail,$studentname,$appointmentdate,$appointmenttime ,"updated");
            echo json_encode($appointmentstatus);
        }
        else {
            $appointmentstatus='{  "status":-1}';
                echo json_encode($appointmentstatus);
        }
}

else if(isset($_POST['createappointment'])){// insert the record into appointments             
        if(isset($_POST["appointmentdate"]) && isset($_POST["appointmenttime"]) 
                && isset($_POST["selectcategory"])&& isset($_POST["student_id"]) && isset($_POST["studentname"]) ){
            $studentname=$_POST["studentname"];
            $appointmentdate=$_POST["appointmentdate"];
            $appointmenttime=$_POST["appointmenttime"];
            $categoryid=$_POST["selectcategory"];
            $studentid=$_POST["student_id"];
            $category=getCategoriesName($categoryid);            
            $studentemail=getStudentEmail($_POST["student_id"]);
            $retval= makeAnAppointment($appointmentdate, $appointmenttime, $categoryid, $studentid);                          
            $appointmentstatus=array('status'=>$retval,'studentname'=>$studentname,'appointmentdate'=>$appointmentdate,
                            'appointmenttime'=>$appointmenttime,'categoryname'=>getCategoriesName($categoryid));
            email_to_user($studentemail,$studentname,$appointmentdate,$appointmenttime ,"created");
            echo json_encode($appointmentstatus);
        }
        else {
            $appointmentstatus='{  "status":-1}';
                echo json_encode($appointmentstatus);
        }
}

else if(isset($_POST['deletecheckedappointments'])){            
        $deleteappointments=$_POST['deletecheckedappointments'];
        $appointmentdeletionstatusAll=array();
        foreach ($deleteappointments as $deleteappointment){
            $retval=deleteAnAppointment($deleteappointment);
            $studentid=getStudentId($deleteappointment);
            $studentemail=getStudentEmail($studentid);
            $appointmentdeletionstatus=array("studentname"=>$retval[1]);//'status'=>$retval[0],            
            array_push($appointmentdeletionstatusAll,$appointmentdeletionstatus);                    
            email_to_user($studentemail,$retval[1],"no date","no time" ,"deleted");            
        }
        echo json_encode($appointmentdeletionstatusAll);            
    }
    
    // </editor-fold>     
    
// <editor-fold desc="Handlers for Groups ">
    // creating a new Form
    else if (isset ($_POST['createGroup'])){
        if(isset($_POST["groupName"]) && isset($_POST["groupDescription"]) 
                && isset($_POST["startDate"]) && isset($_POST["endDate"]) && isset($_POST['selectcategory'])){            
            $groupName=$_POST["groupName"];
            $groupDescription=$_POST["groupDescription"];
            $startDate=$_POST["startDate"];                        
            $endDate=$_POST["endDate"];      
            $categoryid=$_POST["selectcategory"];      
            $category=getCategoriesName($categoryid);            
            $retval= createNewGroup($groupName, $groupDescription, $startDate,$endDate,$categoryid);                                      
            $groupstatus=array('status'=>$retval,
                                     'groupname'=>$groupName,
                                     'groupdescription'=>$groupDescription,
                                     'startdate'=>$startDate,
                                     'enddate'=>$endDate,
                                     'category'=>$category);            
            echo json_encode($groupstatus);
        }
        else {
            $groupstatus=array('status'=>-1);
            echo json_encode($groupstatus);
        }
        
    }
    else if(isset($_GET['updategroupid'])){
        $updateGroupId=$_GET['updategroupid'];
        $groupDetails=getGroup($updateGroupId);
        while($curGroup= mysqli_fetch_assoc($groupDetails)) {                                                        
            echo json_encode($curGroup);
    }       

}

// UPDATING Group SETTINGS
    else if (isset ($_POST['updateGroup'])){
     if(isset($_POST["groupName"]) && isset($_POST["groupDescription"]) 
                && isset($_POST["startDate"])&& isset($_POST["endDate"]) && isset($_POST['selectcategory']) && isset($_POST["updateGroupId"])){            
            $groupid=$_POST["updateGroupId"];
            $groupName=$_POST["groupName"];
            $groupDescription=$_POST["groupDescription"];
            $startDate=$_POST["startDate"];                        
            $endDate=$_POST["endDate"];      
            $categoryid=$_POST["selectcategory"];      
            $category=getCategoriesName($categoryid);            
            $retval= updateGroup($groupName,$groupDescription,$startDate,$endDate,$categoryid,$groupid);
            $groupstatus=array('status'=>$retval,
                                    'groupid'=>$groupid,
                                     'groupname'=>$groupName,
                                     'groupdescription'=>$groupDescription,
                                     'startdate'=>$startDate,
                                     'enddate'=>$endDate,
                                     'categoryname'=>$category);            
            echo json_encode($groupstatus);
        }
        else {
            $groupstatus=array('status'=>-1);
            echo json_encode($groupstatus);
        }
}
  else if (isset($_POST['deletecheckedgroups'])){
        $deletecheckedgroups=$_POST['deletecheckedgroups'];
        $groupsDeletionStatusAll=array();
        foreach ($deletecheckedgroups as $deleteGroup){
            $retval=  deleteGroup($deleteGroup);
            $settingsDeletionStatus=array("status"=>$retval[0],"groupname"=>$retval[1]);//'status'=>$retval[0],            
            array_push($groupsDeletionStatusAll,$settingsDeletionStatus);
        }
        echo json_encode($groupsDeletionStatusAll);                  
    }


//
//
// </editor-fold>     


// <editor-fold desc="Handlers for Templates ">
    // INSERTING A NEW EMAIL SETTINGS
    else if(isset($_POST['createEmailSettings'])){// insert the record into appointments             
        if(isset($_POST["emailSettingsName"]) && isset($_POST["emailSettingsSubject"]) 
                && isset($_POST["emailSettingsBody"])){            
            $emailSettingsName=$_POST["emailSettingsName"];
            $emailSettingsSubject=$_POST["emailSettingsSubject"];
            $emailSettingsBody=$_POST["emailSettingsBody"];                        
            $retval= createNewTemplate($emailSettingsName, $emailSettingsSubject, $emailSettingsBody);                                      
            $templatestatus=array('status'=>$retval,
                                     'templatename'=>$emailSettingsName,
                                     'templatesubject'=>$emailSettingsSubject,
                                     'templatebody'=>$emailSettingsBody);            
            echo json_encode($templatestatus);
        }
        else {
            $templatestatus='{  "status":-1}';
                echo json_encode($templatestatus);
        }
}

else if(isset($_GET['updatetemplateid'])){
    $updateTemplateId=$_GET['updatetemplateid'];

    $templateDetails=getTemplateDetails($updateTemplateId);
    while($curTemplate= mysqli_fetch_assoc($templateDetails)) {                                                        
        echo json_encode($curTemplate);
    }       

}
// UPDATING EMAIL SETTINGS
else if (isset ($_POST['updateEmailSettings'])){
     if(isset($_POST["emailSettingsName"]) && isset($_POST["emailSettingsSubject"]) 
                && isset($_POST["emailSettingsBody"]) && isset($_POST["updateTemplateId"])){            
            $emailSettingsName=$_POST["emailSettingsName"];
            $emailSettingsSubject=$_POST["emailSettingsSubject"];
            $emailSettingsBody=$_POST["emailSettingsBody"];             
            $templateid=$_POST["updateTemplateId"];             
            $retval=  updateTemplate($emailSettingsName, $emailSettingsSubject, $emailSettingsBody, $templateid);            
            $templatestatus=array('status'=>$retval,
                                     'templatename'=>$emailSettingsName,
                                     'templatesubject'=>$emailSettingsSubject,
                                     'templatebody'=>$emailSettingsBody);            
            echo json_encode($templatestatus);
        }
        else {
            $templatestatus='{  "status":-1}';
                echo json_encode($templatestatus);
        }
}
//else if(isset ($_POST['deleteEmailTemplates'])){
else if(isset($_POST['deletecheckedsettings'])){            
        $deletecheckedsettings=$_POST['deletecheckedsettings'];
        $settingsDeletionStatusAll=array();
        foreach ($deletecheckedsettings as $deleteSettings){
            $retval=  deleteTemplate($deleteSettings);
            $settingsDeletionStatus=array("status"=>$retval[0],"templatename"=>$retval[1]);//'status'=>$retval[0],            
            array_push($settingsDeletionStatusAll,$settingsDeletionStatus);
        }
        echo json_encode($settingsDeletionStatusAll);            
}
  
// </editor-fold>     

// <editor-fold desc="Handlers for Campaigns ">
else if(isset($_POST['createCampaign'])){// insert the record into appointments             
        if(isset($_POST["campaignName"]) && isset($_POST["campaignDescription"]) 
                && isset($_POST["selectgroup"]) && isset($_POST["selecttemplate"])
                && isset($_POST["timeframe"]) && isset($_POST["chrondata"]) ){     
            
            $campaignName=$_POST["campaignName"];
            $campaignDescription=$_POST["campaignDescription"];
            $groupid=$_POST["selectgroup"];        
            $templateid=$_POST["selecttemplate"];        
            $timeframe=$_POST["timeframe"];        
            $chrondata=$_POST["chrondata"];        
            $groupName=getGroupName($groupid);
            $templateName=getTemplateName($templateid);
            $retval= createNewCampaign($campaignName, $campaignDescription, $groupid, $templateid, $timeframe, $chrondata);                                      
            $campaignStatus=array('status'=>$retval,
                                     'campaignname'=>$campaignName,
                                     'campaigndescription'=>$campaignDescription,
                                     'groupname'=>$groupName,
                                     'templatename'=>$templateName,
                                     'timeframe'=>$timeframe,   
                                     'chrondata'=>$chrondata                    
                                );            
            echo json_encode($campaignStatus);//$retval;
            //redirect_to("../campaigns.php");
        }
        else {
            $campaignStatus='{  "status":-1}';
              echo json_encode($campaignStatus);//$retval;
              //redirect_to("../campaigns.php");
        }
 }
 else if(isset($_GET['updatecampaignid'])){
    $updateCampaignId=$_GET['updatecampaignid'];

    $campaignDetails=getCampaign($updateCampaignId);
    while($curCampaign= mysqli_fetch_assoc($campaignDetails)) {                                                        
        echo json_encode($curCampaign);
    }       

}
 
 else if(isset($_POST['updateThisCampaign'])){// insert the record into appointments             
        if(isset($_POST["campaignName"]) && isset($_POST["campaignDescription"]) 
                && isset($_POST["selectgroup"]) && isset($_POST["selecttemplate"])
                && isset($_POST["timeframe"]) && isset($_POST["chrondata"]) && isset($_POST['updateCampaignId'])){                 
            $campaignName=$_POST["campaignName"];
            $campaignDescription=$_POST["campaignDescription"];
            $groupid=$_POST["selectgroup"];        
            $templateid=$_POST["selecttemplate"];        
            $timeframe=$_POST["timeframe"];        
            $chrondata=$_POST["chrondata"];        
            $groupName=getGroupName($groupid);
            $templateName=getTemplateName($templateid);
            $updateCampaignId=$_POST['updateCampaignId'];
            $retval= updateCampaign($campaignName, $campaignDescription, $groupid, $templateid, $timeframe, $chrondata,$updateCampaignId);                                      
            $campaignStatus=array('status'=>$retval,
                                     'campaignname'=>$campaignName,
                                     'campaigndescription'=>$campaignDescription,
                                     'groupname'=>$groupName,
                                     'templatename'=>$templateName,
                                     'timeframe'=>$timeframe,   
                                     'chrondata'=>$chrondata                    
                                );            
            echo json_encode($campaignStatus);//$retval;
            //redirect_to("../campaigns.php");
        }
        else {
            $campaignStatus='{  "status":-1}';
              echo json_encode($campaignStatus);//$retval;
              //redirect_to("../campaigns.php");
        }
 }
 else if(isset($_POST['deletecheckedcampaigns'])){            
        $deletecheckedcampaigns=$_POST['deletecheckedcampaigns'];
        $campaignsDeletionStatusAll=array();
        foreach ($deletecheckedcampaigns as $deleteCampaigns){
            $retval=  deleteCampaigns($deleteCampaigns);
            $campaignsDeletionStatus=array("status"=>$retval[0],"campaignname"=>$retval[1]);//'status'=>$retval[0],            
            array_push($campaignsDeletionStatusAll,$campaignsDeletionStatus);
        }
        echo json_encode($campaignsDeletionStatusAll);            
}
// </editor-fold>     


?>