<?php   include_once("includes/layouts/header.php");?>
<?php   include_once("includes/functions.php");?>

<article>
    <div class="groups">
           <?php $group_set=getAllGroups(); ?>        
    
    <div class="allGroups">
        <form action="includes/submit.php" method="post" id="deleteGroupForm">
           <caption><h1>All Groups </h1></caption>
            <div class="heading">                             
                <a href="groups.php" id="hrefCreateNewGroup">+ new group</a>                       
            </div>            
            <table class="tbGroups"> 
                <!--<th> Group Id </th>-->
                <thead><tr><th> Group name </th><th> Start Date</th> 
                            <th> End Date</th> <th> Category Name</th> <th> Edit </th><th> Delete </th></tr> </thead>            
                <tbody>        
                <?php while($groupdetails = mysqli_fetch_assoc($group_set)) { ?>                        
                <input type="hidden" name="groupid[]" value="<?php echo $groupdetails["groupid"];  ?>" />    
                <input type="hidden" id="deleteGroups" name="deleteGroups" value=""/>                        
                <?php       
                            echo "<tr>";
//                                echo "<td>";
//                                    echo $groupdetails["groupid"];             
//                                echo "</td>";
                                echo "<td>";
                                    echo $groupdetails["groupname"];             
                                echo "</td>";
                                echo "<td data-order=".date('Y-m-d',strtotime($groupdetails["startdate"])).">";
                                    echo date('D, F j, Y ',strtotime($groupdetails["startdate"]));	
                                echo "</td>";
                                echo "<td data-order=".date('Y-m-d',strtotime($groupdetails["enddate"])).">";
                                    echo date('D, F j, Y ',strtotime($groupdetails["enddate"]));	
                                echo "</td> <td>";
                                    echo $groupdetails["categoryname"];                                             
                                echo "</td> <td>";
                                $groupid=urlencode($groupdetails["groupid"]); 
                ?>        
                <a href="groups.php" data-updateid="<?php echo $groupid; ?> "> edit </a>           
                 <?php
                                echo "</td> <td>";
                                    echo "<input type=\"checkbox\" name=\"deletecheckedgroups[]\" value=".$groupid.">";
                                echo "</td>";
                            echo "</tr>";
                    }
                ?>
                </tbody>        
            </table>
            <input type="button" class="btndelete" id="btnDeleteGroup" name="btnDeleteGroup" value="delete" />            
        </form>
        </div>
        
    <div class="newGroup">
        <?php $group_set=getAllGroups(); ?>        
        <form action="includes/submit.php" method="post" id="newGroupForm">
            <input type="hidden" name="createGroup" id="createGroup" value=""/>                        
            <caption><center><h1>New Group</h1></center></caption>
             <table class="tbNewGroup"> 
                 <!--<th> Group Id </th>-->
                 <tr><td>Group Name</td><td><input type="text" id="groupName" name="groupName" data-value="Group Name" autofocus/></td></tr>
                 <tr><td>Group Description</td><td><input type="text" id="groupDescription" data-value="Group Description" name="groupDescription" /></td></tr>                 
                 <tr><td><label for="category">Category</label> </td>
                   <td> <?php echo getCategoryList(); ?></td></tr>      
                 <tr>
                        <td><label for="startDate" >Start Date</label> </td>
                        <td><input id="startDate" name="startDate" type="Date" /></td>
                 </tr>
                 <tr>
                        <td><label for="endDate" >End Date</label> </td>
                        <td><input id="endDate" name="endDate" type="Date" /></td>
                 </tr>
                 <tr><td colspan="2"><center>
                         <input type="button" id="btnNewGroup" name="btnNewGroup" class="btnNew" value="New Group" /> 
                         </center>    
                 </td></tr>           
             </table>        
        </form>
    </div>
    <div class="updateGroup">
        <?php $group_set=getAllGroups(); ?>        
        <form action="includes/submit.php" method="post" id="updateGroupForm">
            <input type="hidden" name="updateGroup" id="updateGroup" value=""/>   
            <input type="hidden" id="updateGroupId" name="updateGroupId" value=""/>      
            <caption><center><h1>Update Group</h1></center></caption>
             <table class="tbUpdateGroup"> 
                 <!--<th> Group Id </th>-->
                 <tr><td>Group Name</td><td><input type="text" id="groupName" name="groupName" data-value="Group Name" autofocus/></td></tr>
                 <tr><td>Group Description</td><td><input type="text" id="groupDescription" data-value="Group Description" name="groupDescription" /></td></tr>                 
                 <tr><td><label for="category">Category</label> </td>
                   <td> <?php echo getCategoryList(); ?></td></tr>      
                 <tr>
                        <td><label for="startDate" >Start Date</label> </td>
                        <td><input id="startDate" name="startDate" type="Date" /></td>
                 </tr>
                 <tr>
                        <td><label for="endDate" >End Date</label> </td>
                        <td><input id="endDate" name="endDate" type="Date" /></td>
                 </tr>
                 <tr><td colspan="2"><center>
                         <input type="button" class="btnUpdate" id="btnUpdateGroup" name="btnUpdateGroup" class="btnUpdateGroup" value="Update Group" /> 
                         </center>    
                 </td></tr>           
             </table>        
        </form>
    </div>

    </div>
</article>
    
    
<?php   include_once("includes/layouts/footer.php");?>
