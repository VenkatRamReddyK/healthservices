<?php   include_once("includes/layouts/header.php");?>
<?php   include_once("includes/functions.php");?>
<article>
    <div class="settings">
        <?php $setting_set=getAllEmailTemplates(); ?>                
        <div class="allSettings">
            
            <form action="includes/submit.php" method="post" id="deleteEmailTemplateForm">    
            <caption><h1>All settings </h1></caption>
            <div class="heading">                             
                <a href="settings.php" id="hrefCreateNewSetting">+ new settings</a>                       
            </div>
            
            <table class="tbSettings">                 
                <!--<th> Settings Id </th>-->
                <thead><tr><th> Template Name </th><th> Subject</th><th>Body</th>
                            <th> Edit </th><th> Delete </th> </tr> </thead>            
                <tbody>        
                <?php while($settingdetails = mysqli_fetch_assoc($setting_set)) { ?>  
                <input type="hidden" id="deleteEmailTemplates" name="deleteEmailTemplates" />                        
                <input type="hidden" name="templateid[]" value="<?php echo $settingdetails["templateid"];  ?>" />                        
                <?php       
                            echo "<tr>";
                                echo "<td>";
                                    echo $settingdetails["templatename"];             
                                echo "</td> <td>";
                                    echo $settingdetails["subject"];             
                                echo "</td> <td>";
                                    echo $settingdetails["body"];                                             
                                echo "</td> <td>";
                                $settingid=urlencode($settingdetails["templateid"]); 
                ?>                        
                <a href="settings.php" data-updateid="<?php echo  $settingid; ?>"> edit </a>           
                 <?php
                                echo "</td> <td>";
                                    echo "<input type=\"checkbox\" name=\"deletecheckedsettings[]\" value=".$settingdetails["templateid"].">";
                                echo "</td>";
                            echo "</tr>";
                    }
                ?>
                </tbody>        
            </table>
            <input type="button" class="btndelete" id="btnDeleteSettings" name="btnDeleteSettings"  value="delete" />                    
            </form>
        </div>
        
                <!--New Email Settings-->
         <div class="newEmailSettings">            
            <form action="includes/submit.php" method="post" id="newEmailSettingsForm"  >                                     
                <input type="hidden" id="createEmailSettings" name="createEmailSettings" value=""/>                        
                <table  class="tbNewEmailSettings" >
                    <tr><td colspan="2"><label> <center> <h3><strong>New Email Settings</strong></h3></center></label></td>
                    </tr><tr>
                        <td><label for="emailSettingsName" >Name</label> </td>
                        <td><input type="text" id="emailSettingsName" data-value="Name" name="emailSettingsName" value="" required autofocus/></td>
                    </tr>    <tr>
                        <td><label for="emailSettingsSubject" >Subject</label> </td>
                        <td><input id="emailSettingsSubject" data-value="Subject" name="emailSettingsSubject" type="text" /></td>
                    </tr>    <tr>
                        <td><label for="emailSettingsBody" > Body</label> </td>
                        <td><input id="emailSettingsBody" data-value="body" name="emailSettingsBody" type="textarea" /></td>
                    </tr>    <tr>
                        <td colspan="2" ><center><input type="button" class="btnNew" id="btnNewEmailSettings" name="btnNewEmailSettings"  value="New Email Settings"/></center></td>
                    </tr>    
                </table>
            </form>                  
        </div>
        
                 <!--Update Email Settings--> 
        <div class="updateEmailSettings">            
            <form action="includes/submit.php" method="post" id="updateEmailSettingsForm"  >                                     
                <input type="hidden" id="updateEmailSettings" name="updateEmailSettings" value=""/>                        
                <input type="hidden" id="updateTemplateId" name="updateTemplateId" value=""/>      
                <table  class="tbUpdateEmailSettings" >
                    <tr><td colspan="2"><label> <center> <h3><strong>Updating Email Settings</strong></h3></center></label></td>
                    </tr><tr>
                        <td><label for="emailSettingsName" >Name</label> </td>
                        <td><input type="text" id="emailSettingsName" data-value="Name" name="emailSettingsName" value="" required autofocus/></td>
                    </tr>    <tr>
                        <td><label for="emailSettingsSubject" >Subject</label> </td>
                        <td><input id="emailSettingsSubject" data-value="Subject" name="emailSettingsSubject" type="text" /></td>
                    </tr>    <tr>
                        <td><label for="emailSettingsBody" > Body</label> </td>
                        <td><input id="emailSettingsBody" data-value="body" name="emailSettingsBody" type="textarea" /></td>
                    </tr>    <tr>
                        <td colspan="2" ><center><input type="button" class="btnUpdate" id="btnUpdateEmailSettings" name="btnUpdateEmailSettings"  value="Update Email Settings"/></center></td>
                    </tr>    
                </table>
            </form>                  
        </div>
                 
    </div>
</article>
    
<?php   include_once("includes/layouts/footer.php");?>
