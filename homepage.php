<?php   include_once("includes/layouts/header.php");?>
<article>
    <?php if(isset($_GET['loginstatus']) &&$_GET['loginstatus']=="-1")
          { 
        ?>
            <script>
            $(function(){
                $(".registrationform").hide();                 
//                alert("Invalid Login! ");
                    $("#err").html("Invalid Login! ");//updated
                    $("#err").fadeIn(2000);
                    $("#err").fadeOut(2000);
        //            $(".registrationform").hide();                 
//                       $(".loginform").show();                                       
            })
            </script>
    <?php }
          else if(isset($_GET['registrationstatus']) &&$_GET['registrationstatus']=="registered")
          { 
        ?>
            <script>
            $(function(){
                $(".loginform").show(); 
                $(".registrationform").hide();
//                alert("Registration Already Exist !");
                    $("#err").html("Registration Already Exist ! Please Login to Continue");//updated
                    $("#err").fadeIn(2000);
                    $("#err").fadeOut(2000);        
            })
            </script>
          <?php }
          else if(isset($_GET['status']) && ($_GET['status']=="loggedin")){?>
            <script>
                $(function(){
                    $(".loginform").show(); 
                    $(".registrationform").hide();
                    $("#err").html("Successful Registration !  Please Login ");//updated
                    $("#err").fadeIn(2000);
                    $("#err").fadeOut(2000);
                    $
                       })
            </script>
        <?php }?>        
            
    <div id="homepage" name="homepage" class="homepage">        
        <div id="welcomeform" class="welcomeform">    
            <h1> Welcome to Student Health Center </h1>
              
        </div>        
            
        <div id="loginform" class="loginform"> 
                <div class="heading">                             
                        <a  href="homepage.php" id="hrefRegistation">+ Add Admin</a>      
                    </div>
                <br/><br/><br/><br/>                
                <br/>
            <div>
                <form action="includes/submit.php" method="post" name="studentloginform" id="studentloginform">                 
                    <input type="hidden" name="loginset" value="loginset"/>                        
                    <table class="tblogin">
                        <tr>
                            <td colspan="2"><label> <center> <h3><strong>Admin Login</strong></h3></center></label></td>
                        </tr>     
                        <tr>
                            <td><label for="studentid" >student id </label> </td>
                            <td><input type="text" id="studentid" name="studentid" required autofocus/></td>
                        </tr>    
                        <tr>
                            <td><label for="password" >Password</label> </td>
                            <td><input id="password" name="password" type="password" /></td>
                        </tr>                        
                        <tr>
                             <td colspan="2"><center><input type="submit" class="btnlogin" id="btnlogin" 
                                                       name="btnlogin" value="Login"/></center></td>
                        </tr>                         
                    </table>
                </form>
            </div>          
        </div> 
       
        <div class="registrationform">         
                <div class="heading">                             
                    <a  href="homepage.php" id="hrefLogin">+ Admin Login</a>      
                </div>
            <br/><br/><br/><br/>                
            <br/>
            <div>
                <form action="includes/submit.php" method="post" name="studentregistrationform" id="studentregistrationform">                 
                 <input type="hidden" name="registrationset" value="registrationset"/>                        
                    <table class="tbregistration">
                        <tr>
                            <td colspan="2"><label> <center> <h3><strong>Admin Registration</strong></h3></center></label></td>
                        </tr>     
                        <tr>
                            <td><label for="studentid" >student id </label> </td>
                            <td><input type="text" id="studentid" name="studentid" required autofocus/></td>
                        </tr>    
                        <tr>
                            <td><label for="password" >Password</label> </td>
                            <td><input id="password" name="password" type="password" /></td>
                        </tr>                        
                        <tr>
                             <td colspan="2"><center><input type="submit" class="btnregistration" id="btnregistration" 
                                                       name="btnregistration" value="Register"/></center></td>
                        </tr>                         
                    </table>
                </form>
            </div>          
        </div>  
       <br/>
       <br/>
       
    </div>    
          
</article>
    <?php   include_once("includes/layouts/footer.php");?>