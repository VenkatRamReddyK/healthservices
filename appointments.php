<?php   include_once("includes/layouts/header.php");?>
<?php   include_once("includes/functions.php");?>

<article>    
   
    
<div class="appointments">  
    <?php $appointment_set=getAllAppointments(); ?>
    
    <!--All Appointments--> 
    <div class="allappointments">
        <form action="includes/submit.php" method="post" id="deleteappointmentsform">
           <caption><h1>All Appointments </h1></caption>
           <div class="heading">                             
                    <a href="appointments.php" id="hrefCreateNewAppointment">+ new appointment</a>    
                    <a href="appointments.php" id="hrefUploadCSV">Upload from CSV</a>  
            </div>
            <table class="tbappointments"> 
                <!--<th> Appointment Id </th>-->
                <thead><tr><th> Appointment Id </th><th> Appointment Date </th>
                        <th> Appointment Time </th> <th> Student Name</th> 
                        <th> Category Name</th> <th> Edit </th><th> Delete </th></tr> </thead>            
                <tbody>        
                <?php while($appointmentdetails = mysqli_fetch_assoc($appointment_set)) { ?>                                        
                <input type="hidden" name="studentid[]" value=<?php echo $appointmentdetails["student_id"]?>/>                        
                <input type="hidden" id="deleteappointments" name="deleteappointments" />                        
                <?php       
                    echo "<tr>";                    
                        echo "<td>";
                            echo $appointmentdetails["appointmentid"];             
                        echo "</td>";
                        echo "<td data-order=".date('Y-m-d',strtotime($appointmentdetails["appointmentdate"])).">";
                            echo date('D, F j, Y ',strtotime($appointmentdetails["appointmentdate"]));	
                        echo "</td> <td>";
                            echo date('g:i A',strtotime($appointmentdetails["appointmenttime"]));
                        echo "</td> <td>";
                            echo $appointmentdetails["student_name"];             
                        echo "</td> <td>";
                            echo $appointmentdetails["categoryname"];                                             
                        echo "</td> <td>";
                        $appointmentid=urlencode($appointmentdetails["appointmentid"]); 
                ?>        
                <a href="appointments.php" data-updateid="<?php echo  $appointmentid; ?>">edit</a>                
                 <?php
                                echo "</td> <td>";
                                    echo "<input type=\"checkbox\" name=\"deletecheckedappointments[]\" value=".$appointmentdetails["appointmentid"].">";
                                echo "</td>";
                            echo "</tr>";
                    }
                ?>
                </tbody>        
            </table>
                <input type="button" id="btndeleteappointment" name="btndeleteappointment" class="btndelete" value="delete" />                                
        </form>
    </div>   
    <!--New Appointment-->
   <div class="newappointment">    
   <div class="newappointmentlogin">        
       <form action="includes/auth.php" method="post" id="studentloginform" >                     
        <table class="tbnewappointmentlogin">
            <tr><td colspan="2"><label> <center> <h3><strong>Student Details</strong></h3></center></label></td></tr>    <tr>
                <td><label for="studentid" >student id </label> </td>
                <td><input type="text" id="studentid" name="studentid" value="" required autofocus/></td>
            </tr><tr>
                <td><label for="studentdob" >date of birth</label> </td>
                <td><input id="studentdob" name="studentdob" type="Date" value="" /></td>
            </tr><tr>
                <td colspan="2"><center><input type="button" id="btnVerify" 
                      value="Verify"/></center></td>
            </tr>    
        </table>   
    </form>
   </div>
       
        <div class="newappointmentdetails">        
            <form action="includes/submit.php" method="post" id="newappointmentform">                     
                       <input type="hidden" id="student_id" name="student_id" value=""/>        
                      <input type="hidden" name="createappointment" value=""/>                        
                       <table  class="tbnewappointment" >
                           <tr><td colspan="2"><label> <center> <h3><strong>Student Details</strong></h3></center></label></td>
                           </tr><tr>
                               <td><label for="studentname" >student name </label> </td>
                               <td><input type="text" id="studentname" name="studentname" value="" required autofocus/></td>
                           </tr>    <tr>
                               <td><label for="appointmentdate" >Appointment Date</label> </td>
                               <td><input id="appointmentdate" name="appointmentdate" type="Date" /></td>
                           </tr>    <tr>
                               <td><label for="appointmenttime" >Appointment Time</label> </td>
                               <td><input id="appointmenttime" name="appointmenttime" type="Time" /></td>
                           </tr>    <tr>
                               <td><label for="category">Category</label> </td>
                               <td> <?php echo getCategoryList(); ?></td>
                           </tr>  <tr>
                               <td colspan="2" ><center><input type="button" class="btnNew" id="btnNewAppointment" name="btnNewAppointment"  value="New Appointment"/></center></td>
                           </tr>    
                       </table>
                   </form>    
        </div>
    </div>
    
    <!--Update an appointment--> 
    <div class="updateappointment">
    <form action="includes/submit.php" method="post" id="updateappointmentform" >                     
                <input type="hidden" id="student_id" name="student_id" value=""/>        
                <input type="hidden" id="updateid" name="updateid" value=""/>        
               <input type="hidden" name="updateappointment" value=""/>                        
                <table  class="tbupdateappointment" >
                    <tr><td colspan="2"><label> <center> <h3><strong>Student Details</strong></h3></center></label></td>
                    </tr><tr>
                        <td><label for="studentname" >student name </label> </td>
                        <td><input type="text" id="studentname" name="studentname" value="" required autofocus/></td>
                    </tr>    <tr>
                        <td><label for="appointmentdate" >Appointment Date</label> </td>
                        <td><input id="appointmentdate" name="appointmentdate" type="Date" /></td>
                    </tr>    <tr>
                        <td><label for="appointmenttime" >Appointment Time</label> </td>
                        <td><input id="appointmenttime" name="appointmenttime" type="Time" /></td>
                    </tr>    <tr>
                        <td><label for="category">Category</label> </td>
                        <td> <?php echo getCategoryList(); ?></td>
                    </tr>  <tr>
                        <td colspan="2" ><center><input type="button" class="btnUpdate" id="btnUpdateAppointment" name="btnUpdateAppointment"  value="Update Appointment"/></center></td>
                    </tr>    
                </table>
            </form>
    </div>
    
     <div class="loadcsv">
                    <h2>Import Student Appointments CSV File</h2> 
                    <form action="upload.php" method="post" enctype="multipart/form-data" name="form1" id="form1">                       
                      <input name="csv" type="file" id="csv" /> <br/>
                      <input type="submit" name="Submit" value="upload" /> 
                    </form>                         
        </div>
</div>
</article>    
<?php   include_once("includes/layouts/footer.php");?>
