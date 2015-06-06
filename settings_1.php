<!DOCTYPE html>
<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script>


$(function(){
  $(document).ready(function() {
//      $("#priordays").hide();
//      $("#specifictime").hide();
//      $("#week").hide();
//      $("#chronoptions").hide();      
//      $("#time").hide();
//      $("#month").hide();
      
      $(".option").hide();
      $(".chronclass").prop("checked", false);
      
    $("#chrontype input:radio").click(function() {
//        radioOption=(this).val();
      if($(this).val()=="priordate"){
          $(".option").hide();
          $("#chronoptions").show();
          $("#priordays").fadeIn("slow");
          $("#chroninput").show();    
          $("#time").show();      
          
      }
      else{
          $(".option").hide();
          $("#chronoptions").show();
          $("#specifictime").fadeIn("slow");        
      }      
     });
     $("#chroninput").click(function(){                  
        var radioselected= $('input:radio[name=theme]:checked').val();
        
        alert(val);
     });
     
      $('#specifictime').on('change', function() {
        if(this.value=="day"){
            $("#month").hide();
            $("#week").hide();
            $("#time").show();
            $("#chroninput").show();
        }else if(this.value=="month"){
             $("#month").show();
             $("#week").hide();
             $("#time").show();
             $("#chroninput").show();
        }
        else if(this.value=="week"){
            $("#week").show();
            $("#month").hide();
            $("#time").show();
            $("#chroninput").show();
        }
        else{
            $("#time").hide();
            $("#week").hide();
            $("#month").hide();             
        }       
      });
});

});
</script>
<meta charset=utf-8/>
<title>Radio Button</title>
</head>
<body>
    <form action="submit.php" method="POST">
        <p id=""></p>
    <div id="chrontype">
        <input type="radio" class="chronclass"  name="theme" value="specificdate"/>Specific Date
        <input type="radio" class="chronclass"  name="theme" value="priordate"/>Prior N Days
    </div>
    <div id="chronoptions">
        <input class="option" type="number" min="1" max="10" id="priordays"/>
 
        <select class="option" id="specifictime" >
            <option selected value='everytime'> - - Select - - </option>
            <option value="day">Every Day</option>
            <option value="week">Every Week</option>
            <option value="month">Every Month</option>               
        </select>
        
         <select class="option" id="week">
            <option selected value='weekday'> - - Select - - </option>
            <option value="0">Sunday</option>
            <option value="1">Monday</option>
            <option value="2">Tuesday</option>            
            <option value="3">Wednesday</option>
            <option value="4">Thursday</option>
            <option value="5">Friday</option>           
            <option value="6">Saturday</option>           
        </select>        
        
        <input class="option" type="number" min="1" max="28" id="month"/>          
        <input class="option" type="time" id="time"/>        
        <input class="option" type="button" id="chroninput" value="submit"/>
        
    </div>
</form>
  </body>
</html>
