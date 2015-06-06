
$(document).ready(
    function(){

    // <editor-fold desc="creating data tables for appointments, groups, settings and Campaigns">            
        $('.tbappointments').DataTable(); 	//{"scrollY": "200px"}
        $('.tbGroups').DataTable(); 	
        $('.tbSettings').DataTable(); 	 
        $('.tbCampaigns').DataTable(); 	 
        
    // </editor-fold>    
        
    // <editor-fold desc="create , update, delete and show all appointments">                    
        $("#err").hide();
        $(".updateappointment").hide();
        $(".loadcsv").hide();                                  
        $(".newappointmentdetails").hide();
        $(".newappointment").hide();
        $(".newappointmentlogin").hide();       
        $(".allappointments").show();        
        $(".registrationform").hide();                   
    // </editor-fold>    

 
    // <editor-fold desc="create , update, delete and show all Group">            
        $(".newGroup").hide();
        $(".updateGroup").hide();        
        $(".allSettings").show();
        
// </editor-fold>
    
    // // <editor-fold desc="create , update, delete and show all Email Settings">                    
        $(".newEmailSettings").hide();
        $(".updateEmailSettings").hide();             
        $(".allSettings").show();
    // </editor-fold>
    
    // // <editor-fold desc="create , update, delete and show all Campaigns">                                       
        $(".newCampaign").hide();
        $(".allCampaigns").show();
        $(".updateCampaigns").hide();
        
// </editor-fold>

    // <editor-fold desc="Login & Registration ">            
      $("#hrefRegistation").click(                   
           function(event){       
               event.preventDefault();     
               $(".registrationform").show();                 
               $(".loginform").hide();                                 
           } 
       );
//      $("#btnregistration").click(                   
//           function(event){       
//               event.preventDefault();                    
//               $(".loginform").hide();     
//               $(".registrationform").hide();                    
//               
//           } 
//       );
        
    // </editor-fold>

        
// <editor-fold desc="Appointment Event Handlers">

       $("#hrefCreateNewAppointment").click(                   
           function(event){       
               event.preventDefault();     
               $(".newappointment").show();                   
               $(".newappointmentlogin").fadeIn("slow");
               $(".allappointments").fadeOut("slow");
           } 
       );
       $("#hrefUploadCSV").click(                   
           function(event){       
               event.preventDefault();     
               $(".loadcsv").show();                                  
               $(".allappointments").fadeOut("slow");
           } 
       );

       $("#btnUpdateAppointment").click(function(){    
            var form=$("#updateappointmentform");   
            $.ajax({
                    type:"POST",
                    url:form.attr("action"),
                    data:form.serialize(),
                    success: function(response){
                        res=jQuery.parseJSON(response);
                        console.log(response);
                        if(res.status===1){
                            $("#err").html("Updation Successful");//updated
                            $("#err").fadeIn(2000);
                            $("#err").fadeOut(2000);
                            $(".updateappointment").fadeOut("slow");
                            $(".allappointments").fadeIn("slow");        
                            window.location.href = "appointments.php";
                            alert("Appointment Updated !"+"\n"+"Student Name"+res.studentname+"\n"+"Appointment Date"+res.appointmentdate+"\n"+"appointmenttime"+res.appointmenttime+"\n"+"Category:"+res.categoryname);                        
                        }  else {
                            $("#err").html("Updation Failed");//updated
                            $("#err").fadeIn(2000);
                            $("#err").fadeOut(2000);
                        }
                    }
            });
        });

    // editing an appointment -> with appointment id = updateid             
       $(".tbappointments").find("a").click(                   
           function(event){       
               event.preventDefault();
               var updateid = $(this).data("updateid");
               $.get( "includes/submit.php", { updateappointmentid: updateid} )
                   .done(function( response ) {
                       res=$.parseJSON(response);   
                       $(".updateappointment").find("#student_id").val(res.studentid);
                       $(".updateappointment").find("#updateid").val(updateid);
                       $(".updateappointment").find("#studentname").val(res.student_name);  
                       $(".updateappointment").find("#appointmentdate").val(res.appointmentdate);
                       $(".updateappointment").find("#appointmenttime").val(res.appointmenttime);
                       $(".updateappointment").find("#selectcategory").val(res.categoryname);
                       $("#studentname").attr('readonly',true);
                       $("#selectcategory option").prop('selected', false).filter(function() {
                           return $(this).text() == res.categoryname;  
                       }).prop('selected', true);

                       $(".updateappointment").fadeIn("slow");
                       $(".allappointments").fadeOut("slow");
                   })

           } 
       );

    // Ajax call for creating a new appoitnmen
       $(".newappointment").find("#studentid").blur(function(){
           $(this).val($(this).val().trim());
           if($(this).val().length===0){
               $("#err").html("Student id is required field");
               $("#err").fadeIn(2000);
               $("#err").fadeOut(2000);
           }            
           else
               $("#err").hide();
       });

       // authentication over ajax for inserting a new appointment
       $("#btnVerify").click(function(){    
           var form=$("#studentloginform");
           $("#err").hide();
               $.ajax({
                       type:"POST",
                       url:form.attr("action"),
                       data:form.serialize(),
                       success: function(response){
                       res=$.parseJSON(response);
                       console.log(response);
                           if(res.studentname!==-1){ //valid user 
                               $("#err").html("Authorized user");//updated  
                               $("#err").fadeIn(2000);
                               $("#err").fadeOut(2000);
                               $(".newappointmentdetails").fadeIn("slow");
                               $(".newappointment").find("#studentname").val(res.studentname);    // auto populate student name
                               $(".newappointment").find("#student_id").val($("#studentid").val()); // set student id for creating an appointment
                               $(".newappointment").find("#studentname").attr('readonly',true);
                           }  else { // for invalid user datebase returns -1
                                $("#err").html("UnAuthorized User.");//updated
                                $("#err").fadeIn(2000);
                                $("#err").fadeOut(2000);
                           }
                       }
               });
//            }
       });

// Ajax call for creating a new appointment
   $("#btnNewAppointment").click(function(){    
          var form=$("#newappointmentform");   
          $("#createappointment").val("created");
          $("#err").hide();

       $.ajax({
               type:"POST",
               url:form.attr("action"),
               data:form.serialize(),
               success: function(response){
                   res=jQuery.parseJSON(response);
                   console.log(response);
                   if(res.status===1){
                       $("#err").html("Insertion Successful");//updated
                       $("#err").fadeIn(2000);
                       $("#err").fadeOut(2000);
                       $(".newappointmentdetails").fadeOut("slow");                        
                       $(".newappointmentlogin").fadeOut("slow");      
                       $(".newappointment").hide();                                     
                       $(".allappointments").fadeIn("slow");        
                       window.location.href = "appointments.php";
                       alert("Appointment created !"+"\n"+"Student Name"+res.studentname+"\n"+"Appointment Date"+res.appointmentdate+"\n"+"appointmenttime"+res.appointmenttime+"\n"+"Category:"+res.categoryname);   
                       
                   }  else {                                
                       $("#err").html("Insertion Failed");//updated
                       $("#err").fadeIn(2000);
                       $("#err").fadeOut(2000);
                   }
               }
       });
   });   

    //Ajax call for deleting an appointment
       $("#btndeleteappointment").click(function(){
//              alert("deleting appointment");
          $("#deleteappointments").val("deleted");
          var form=$("#deleteappointmentsform")
          $.ajax({
              type:"POST",
              url:form.attr("action"),
              data:form.serialize(),
              success:function(response){
                  res=$.parseJSON(response);
                  console.log("Deleted Student Names");                                            
                    $.each(res, function() { 
                        $.each(this, function(key, value){
                            alert("Deleted Student Name: "+value);
                        });
                    });                        
                    window.location.href = "appointments.php";
              }

          });

       });

// </editor-fold>

// <editor-fold desc="Group Event Handlers">
    $("#hrefCreateNewGroup").click(                   
        function(event){       
            event.preventDefault();     
            $(".newGroup").show();                   
            $(".newGroup").fadeIn("slow");
            $(".allGroups").fadeOut("slow");
        } 
    );
    // Ajax call for creating a new group
           $(".groups").find("#groupName, #groupDescription, #emailSettingsBody").blur(function(){
               $(this).val($(this).val().trim());
               if($(this).val().length===0){
                   $("#err").html($(this).data("value")+" required field");
                   $("#err").fadeIn(2000);
                   $("#err").fadeOut(2000);
               }            
               else
                   $("#err").hide();
           });
           
             $("#btnNewGroup").click(function(){
                 var form=$("#newGroupForm");   
                  $("#createGroup").val("Group Created");
                  $("#err").hide();
//                 alert("In Group Settings");
               $.ajax({
                       type:"POST",
                       url:form.attr("action"),
                       data:form.serialize(),
                       success: function(response){
                           res=jQuery.parseJSON(response);
                           console.log(response);
                           if(res.status===1){
                               $("#err").html("Insertion Successful");//updated
                               $("#err").fadeIn(2000);
                               $("#err").fadeOut(2000);
                               $(".newGroup").fadeOut("slow");                                                       
                               $(".newGroup").hide();                                     
                               $(".allGroups").fadeIn("slow");        
                               window.location.href = "groups.php";
                               alert("Group created !"+"\n"+"Group Name"+res.groupname+"\n"+"Group Description"+res.groupdescription+"\n"+"Start Date"+res.startdate+"\n"+"End Date"+res.enddate+"\n"+"Category Name"+res.category);   
                           }  else {                                
                               $("#err").html("Insertion Failed");//updated
                               $("#err").fadeIn(2000);
                               $("#err").fadeOut(2000);
                           }
                       }
               });
               
           });

// editing an appointment -> with appointment id = updateid             
            $(".tbGroups").find("a").click(                   
                function(event){       
                    event.preventDefault();
                    var updateid = $(this).data("updateid");
                    $.get( "includes/submit.php", { updategroupid: updateid} )
                        .done(function( response ) {
                            res=$.parseJSON(response);   
                            $(".updateGroup").find("#updateGroupId").val(res.groupid);
                            $(".updateGroup").find("#groupName").val(res.groupname);
                            $(".updateGroup").find("#groupDescription").val(res.groupdescription);  
                            $(".updateGroup").find("#startDate").val(res.startdate);
                            $(".updateGroup").find("#endDate").val(res.enddate);
                            $(".updateGroup").find("#selectcategory option").prop('selected', false).filter(function() {
                                return $(this).text() == res.categoryname;  
                            }).prop('selected', true);
                            $(".updateGroup").fadeIn("slow");
                            $(".allGroups").fadeOut("slow");
                        })
                } 
            );

            $("#btnUpdateGroup").click(function(){
                 var form=$("#updateGroupForm");   
                 $("#updateGroup").val("Group Updated"); // when submitting the form to php this value is checked so as to know which form is submitted                
                 $.ajax({
                         type:"POST",
                         url:form.attr("action"),
                         data:form.serialize(),
                         success: function(response){
                             res=jQuery.parseJSON(response);
                             console.log(response);
                             if(res.status===1){
                                $("#err").html("Updation Successful");//updated
                                $("#err").fadeIn(2000);
                                $("#err").fadeOut(2000);
                                $(".updateGroup").fadeOut("slow");                                                       
                                $(".updateGroup").hide();                                     
                                $(".allGroups").fadeIn("slow");        
                                window.location.href = "groups.php";
                                alert("Group Updated !"+"\n"+"Group Name"+res.groupname+"\n"+"Group Description"+res.groupdescription+"\n"+"Start Date"+res.startdate+"\n"+"End Date"+res.enddate+"\n"+"Category Name"+res.categoryname);   
                            }  else {                                
                                $("#err").html("Updation Failed");//updated
                                $("#err").fadeIn(2000);
                                $("#err").fadeOut(2000);
                                $(".updateGroup").hide();                                     
                                $(".allGroups").fadeIn("slow");   
                                alert("Group Updation Failed !");
                            }
                         }
                 });



            });

               //Ajax call for deleting an appointment
            $("#btnDeleteGroup").click(function(){
              $("#deleteGroups").val("Deleted");
              alert("in deleting group");
              var form=$("#deleteGroupForm");
              $.ajax({
                  type:"POST",
                  url:form.attr("action"),
                  data:form.serialize(),
                  success:function(response){
                      res=$.parseJSON(response);
                      console.log("Deleted Group ");                        
                        $.each(res, function() { 
                            $.each(this, function(key, value){
                                alert("Successfully Deleted Group: "+value);
                            });
                        });                        
                        window.location.href = "groups.php";
                  }
                  
              });
              
           });
           
// </editor-fold>          


// <editor-fold desc="Email Template Event Handlers">
       
        $("#hrefCreateNewSetting").click( function(event){       
                event.preventDefault();     
                $(".newEmailSettings").show();        
                $(".newEmailSettings").fadeIn("slow");
                $(".allSettings").fadeOut("slow");
                
        });
        
        // Ajax call for creating a new appoitnment
           $(".settings").find("#emailSettingsName, #emailSettingsSubject, #emailSettingsBody").blur(function(){
               $(this).val($(this).val().trim());
               if($(this).val().length===0){
                   $("#err").html($(this).data("value")+" required field");
                   $("#err").fadeIn(2000);
                   $("#err").fadeOut(2000);
               }            
               else
                   $("#err").hide();
           });
           
           $("#btnNewEmailSettings").click(function(){
                 var form=$("#newEmailSettingsForm");   
                  $("#createEmailSettings").val("Created");
                  $("#err").hide();
//                 alert("In Email Settings");
               $.ajax({
                       type:"POST",
                       url:form.attr("action"),
                       data:form.serialize(),
                       success: function(response){
                           res=jQuery.parseJSON(response);
                           console.log(response);
                           if(res.status===1){
                               $("#err").html("Insertion Successful");//updated
                               $("#err").fadeIn(2000);
                               $("#err").fadeOut(2000);
                               $(".newEmailSettings").fadeOut("slow");                                                       
                               $(".newEmailSettings").hide();                                     
                               $(".allSettings").fadeIn("slow");        
                               window.location.href = "settings.php";
                               alert("Settings created !"+"\n"+"Template Name"+res.templatename+"\n"+"Template Subject"+res.templatesubject+"\n"+"Template Body"+res.templatebody);   
                           }  else {                                
                               $("#err").html("Insertion Failed");//updated
                               $("#err").fadeIn(2000);
                               $("#err").fadeOut(2000);
                           }
                       }
               });
               
           });

// editing an appointment -> with appointment id = updateid             
           $(".tbSettings").find("a").click(                   
               function(event){       
                   event.preventDefault();                   
                   var updateid = $(this).data("updateid");
                   $.get( "includes/submit.php", { updatetemplateid: updateid} )
                       .done(function( response ) {
                           res=$.parseJSON(response);   
                           $(".updateEmailSettings").find("#updateTemplateId").val(res.templateid);
                           $(".updateEmailSettings").find("#emailSettingsName").val(res.templatename);
                           $(".updateEmailSettings").find("#emailSettingsSubject").val(res.subject);  
                           $(".updateEmailSettings").find("#emailSettingsBody").val(res.body);

                           $(".updateEmailSettings").fadeIn("slow");
                           $(".allSettings").fadeOut("slow");
                       })

               } 
           );

           $("#btnUpdateEmailSettings").click(function(){
                var form=$("#updateEmailSettingsForm");   
                $("#updateEmailSettings").val("Updated"); // when submitting the form to php this value is checked so as to know which form is submitted                
                $.ajax({
                        type:"POST",
                        url:form.attr("action"),
                        data:form.serialize(),
                        success: function(response){
                            res=jQuery.parseJSON(response);
                            console.log(response);
                            if(res.status===1){
                               $("#err").html("Updation Successful");//updated
                               $("#err").fadeIn(2000);
                               $("#err").fadeOut(2000);
                               $(".updateEmailSettings").fadeOut("slow");                                                       
                               $(".updateEmailSettings").hide();                                     
                               $(".allSettings").fadeIn("slow");        
                               window.location.href = "settings.php";
                                alert("Settings Updated !"+"\n"+"Template Name"+res.templatename+"\n"+"Template Subject"+res.templatesubject+"\n"+"Template Body"+res.templatebody);   
                           }  else {                                
                               $("#err").html("Updation Failed");//updated
                               $("#err").fadeIn(2000);
                               $("#err").fadeOut(2000);
                           }
                        }
                });
               
               
               
           });
           
             //Ajax call for deleting an appointment
           $("#btnDeleteSettings").click(function(){
              $("#deleteEmailTemplates").val("Deleted");
              var form=$("#deleteEmailTemplateForm");
              $.ajax({
                  type:"POST",
                  url:form.attr("action"),
                  data:form.serialize(),
                  success:function(response){
                      res=$.parseJSON(response);
                      console.log("Deleted Email Template");                                            
                        $.each(res, function() { 
                            $.each(this, function(key, value){
                                alert("Successfully Deleted Email Template: "+value);
                            });
                        });                        
                  window.location.href = "settings.php";
                  }
                  
              });
              
           });
           
// </editor-fold>     
        
     
     
// <editor-fold desc="Campaign Event Handlers">
//     $("#hrefCreateNewCampaign").click(                   
//        function(event){       
//            event.preventDefault();     
//            $(".newCampaign").show();                   
//            $(".newCampaign").fadeIn("slow");
//            $(".allCampaigns").fadeOut("slow");
//        } 
//    );
        
    $("#hrefCreateNewCampaign").click(                   
        function(event){       
            event.preventDefault();     
            $(".newCampaign").show();                   
            $(".newCampaign").fadeIn("slow");
            $(".allCampaigns").fadeOut("slow");
        });
        $("#btnNewCampaign").click(                
            function(){
               var form=$("#newCampaignForm");
               $.ajax({
                       type:"POST",
                       url:form.attr("action"),
                       data:form.serialize(),
                       success: function(response){
                           res=jQuery.parseJSON(response);
                           console.log(response);
                           if(res.status===1){
                               $("#err").html("Insertion Successful");//updated
                               $("#err").fadeIn(2000);
                               $("#err").fadeOut(2000);
                               $(".newCampaign").fadeOut("slow");                                                       
                               $(".newCampaign").hide();                                     
                               $(".allCampaigns").fadeIn("slow"); 
                               window.location.href = "campaigns.php";
                               alert("Campaign created !"+"\n"+"Campaign Name"+res.campaignname+"\n"+"Group Name"+res.groupname+"\n");//+"Start Date"+res.startdate+"\n"+"End Date"+res.enddate+"\n"+"Category Name"+res.category);   
                           }  else {                                
                               $("#err").html("Insertion Failed");//updated
                               $("#err").fadeIn(2000);
                               $("#err").fadeOut(2000);
                           }
                       }
               });              
            }                 
        );
// editing an appointment -> with appointment id = updateid             
           $(".tbCampaigns").find("a").click(                   
               function(event){       
                   event.preventDefault();
                   $(".allCampaigns").hide();
                   $(".updateCampaigns").show();
                   var updateid = $(this).data("updateid");
                   $.get( "includes/submit.php", { updatecampaignid: updateid} )
                       .done(function( response ) {
                           res=$.parseJSON(response);   
                           $(".updateCampaigns").find("#updateCampaignId").val(res.campaignid);
                           $(".updateCampaigns").find("#campaignName").val(res.campaignname);
                           $(".updateCampaigns").find("#campaignDescription").val(res.campaigndescription);  
                           $(".updateCampaigns").find("#timeframe").val(res.timeframe);
                           $(".updateCampaigns").find("#chrondata").val(res.chrondata);
                           
                           $(".updateCampaigns").find("#selectgroup option").prop('selected', false).filter(function() {
                                return $(this).text() == res.groupname;  
                           }).prop('selected', true);
                           
                           $(".updateCampaigns").find("#selecttemplate option").prop('selected', false).filter(function() {
                                return $(this).text() == res.templatename;  
                           }).prop('selected', true);
                           
                           $(".updateCampaigns").fadeIn("slow");
                           $(".allCampaigns").fadeOut("slow");
                       })

               } 
           );

           $("#btnUpdateCampaign").click(function(){
                var form=$("#updateCampaignForm");   
                $("#updateThisCampaign").val("Updated"); // when submitting the form to php this value is checked so as to know which form is submitted                
                $.ajax({
                        type:"POST",
                        url:form.attr("action"),
                        data:form.serialize(),
                        success: function(response){
                            res=jQuery.parseJSON(response);
                            console.log(response);
                            if(res.status===1){
                               $("#err").html("Updation Successful");//updated
                               $("#err").fadeIn(2000);
                               $("#err").fadeOut(2000);
                               $(".updateCampaigns").fadeOut("slow");                                                       
                               $(".updateCampaigns").hide();                                     
                               $(".allCampaigns").fadeIn("slow");        
                               //alert("Settings Updated !"+"\n"+"Template Name"+res.templatename+"\n"+"Template Subject"+res.templatesubject+"\n"+"Template Body"+res.templatebody);   
                           window.location.href = "campaigns.php";
                                alert("Campaign created !"+"\n"+"Campaign Name"+res.campaignname+"\n"+"Group Name"+res.groupname+"\n"+"Template Name"+res.templatename+"\n");//+"Start Date"+res.startdate+"\n"+"End Date"+res.enddate+"\n"+"Category Name"+res.category);   
                            }  else {                                
                               $("#err").html("Updation Failed");//updated
                               $("#err").fadeIn(2000);
                               $("#err").fadeOut(2000);
                           }
                        }
                });
               
               
               
           });
           
             //Ajax call for deleting an appointment
           $("#btnDeleteCampaigns").click(function(){
              $("#deleteCampaigns").val("Deleted");
              var form=$("#deleteCampaignsForm");
              $.ajax({
                  type:"POST",
                  url:form.attr("action"),
                  data:form.serialize(),
                  success:function(response){
                      res=$.parseJSON(response);
                      console.log("Deleted Campaigns Template");                                            
                        $.each(res, function() { 
                            $.each(this, function(key, value){
                                alert("Successfully Deleted Campaignss: "+value);
                            });
                        });                        
                  window.location.href = "campaigns.php";
                  }
                  
              });
              
           });
           
//btnUpdateCampaign

// </editor-fold>          

    }
);   

