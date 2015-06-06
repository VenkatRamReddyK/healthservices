<?php   include_once("includes/layouts/header.php");?>
<?php   include_once("includes/functions.php");?>
<article>
    <?php  loadCSV();   ?> 
    <div class="upload">
        
        
            
            <div>           
            
            <?php if (!empty($_GET['success'])) { 
         
                
             ?>
                <p>Your file has been imported</p>
                
        
            <?php     }else{            ?> 
                             <p>"Problem uploading the file"</p>
            <?php }?>
                <a href="appointments.php" id="hrefGoBack">+ go back</a>    
        </div>
    
</article>
    
<?php   include_once("includes/layouts/footer.php");?>
