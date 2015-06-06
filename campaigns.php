<?php   include_once("includes/layouts/header.php");?>
<?php   include_once("includes/functions.php");?> 
<article>
    <div class="campaigns">
          <?php $campaign_set=getAllCampaigns(); ?>        
    
    <div class="allCampaigns">
        <form action="includes/submit.php" method="post" id="deleteCampaignsForm">
           <caption><h1>All Campaigns </h1></caption>
           <div class="heading">                             
                <a href="campaigns.php" id="hrefCreateNewCampaign">+ new campaign</a>                       
            </div>            
            <table class="tbCampaigns">                 
                    <thead><tr>
                        <th> Campaign Name </th>
                        <th> Group Name</th> <th> Template Name</th>  <th> Time Frame </th>
                        <th> Campaign Description</th> <th>edit</th><th>delete</th>
                    </tr></thead>            
                <tbody>        
                <?php while($campaigndetails = mysqli_fetch_assoc($campaign_set)) { ?>                        
                <input type="hidden" name="campaignid[]" value="<?php echo $campaigndetails["campaignid"];  ?>" />                        
                <?php       
                            echo "<tr>";
//                                echo "<td>";
//                                    echo $campaigndetails["campaignid"];             
//                                echo "</td>";
                                echo "<td>";
                                    echo $campaigndetails["campaignname"];             
                                echo "</td> <td>";
                                    echo $campaigndetails["groupname"];                                             
                                echo "</td> <td>";
                                    echo $campaigndetails["templatename"];                                             
                                echo "</td> <td>";
                                    echo $campaigndetails["timeframe"];                                             
                                echo "</td> <td>";
                                    echo $campaigndetails["campaigndescription"];                                             
                                echo "</td> <td>";
                                $campaignid=urlencode($campaigndetails["campaignid"]); 
                ?>        
                <a href="campaigns.php" data-updateid="<?php echo $campaignid; ?> "> edit </a>           
                 <?php
                                echo "</td> <td>";
                                    echo "<input type=\"checkbox\" name=\"deletecheckedcampaigns[]\" value=".$campaigndetails["campaignid"].">";
                                echo "</td>";
                            echo "</tr>";
                    }
                ?>
                </tbody>        
            </table>
           <input type="button" class="btndelete" id="btnDeleteCampaigns" name="deleteCampaign" value="delete" />                    
        </form>
    </div>
        
    <div class="newCampaign">        
        <form action="includes/submit.php" method="post" id="newCampaignForm">
            <input type="hidden" name="createCampaign" id="createCampaign" value="campaign created"/>                        
            <caption><center><h1>New Campaign</h1></center></caption>
             <table class="tbNewCampaign"> 
                 <!--<th> Group Id </th>-->
                 <tr><td>Campaign Name</td><td><input type="text" id="campaignName" name="campaignName" data-value="Campaign Name" autofocus/></td></tr>
                 <tr><td>Campaign Description</td><td><input type="text" id="campaignDescription" data-value="Campaign Description" name="campaignDescription" /></td></tr>                 
                 <tr><td><label for="group">Group</label> </td>
                   <td> <?php echo getGroupList(); ?></td></tr>                       
                 <tr><td><label for="template">Template</label> </td>
                   <td> <?php echo getTemplateList(); ?></td></tr>       
                     
                            <tr>
                               <td><label for="timeframe" >Time Frame</label> </td>
                               <td><input id="timeframe" name="timeframe" type="Time" /></td>
                            </tr>
                            <tr>
                               <td><label for="chrondata" >Chron Data</label> </td>
                               <td><input type="text" id="chrondata" name="chrondata" value="" required autofocus/></td>
                            </tr>
                 <tr><td colspan="2"><center>
                         <input type="button" class="btnNew" id="btnNewCampaign" name="btnNewCampaign"  value="New Campaign" /> 
                         </center>    
                 </td></tr>           
             </table>        
        </form>
    </div>
<div class="updateCampaigns">        
        <form action="includes/submit.php" method="post" id="updateCampaignForm">
            <input type="hidden" name="updateThisCampaign"  value="campaign updated"/>     
            <input type="hidden" name="updateCampaignId" id="updateCampaignId"/>     
            <caption><center><h1>Update Campaign</h1></center></caption>
            <table class="tbUpdateCampaign"> 
                 <!--<th> Group Id </th>-->
                 <tr><td>Campaign Name</td><td><input type="text" id="campaignName" name="campaignName" data-value="Campaign Name" autofocus/></td></tr>
                 <tr><td>Campaign Description</td><td><input type="text" id="campaignDescription" data-value="Campaign Description" name="campaignDescription" /></td></tr>                 
                 <tr><td><label for="group">Group</label> </td>
                   <td> <?php echo getGroupList(); ?></td></tr>                       
                 <tr><td><label for="template">Template</label> </td>
                   <td> <?php echo getTemplateList(); ?></td></tr>                            
                            <tr>
                               <td><label for="timeframe" >Time Frame</label> </td>
                               <td><input id="timeframe" name="timeframe" type="Time" /></td>
                            </tr>
                            <tr>
                               <td><label for="chrondata" >Chron Data</label> </td>
                               <td><input type="text" id="chrondata" name="chrondata" value="" required autofocus/></td>
                            </tr>
                 <tr><td colspan="2"><center>
                         <input type="button" class="btnUpdate" id="btnUpdateCampaign" name="btnUpdateCampaign"  value="Update Campaign" /> 
                         </center>    
                 </td></tr>           
             </table>        
        </form>
    </div>
    </div>
</article>
        
<?php   include_once("includes/layouts/footer.php");?>
