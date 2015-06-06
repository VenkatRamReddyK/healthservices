<!DOCTYPE html>
<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script>


$(function(){
  $(document).ready(function() {

      $(".chronclass").prop("checked", false);
      $("#chroninput").hide();
      
    $("#chrontype input:radio").click(function() {

        if($(this).val()=="priordate"){

            $("#specificdate").empty();     // 
            
            $("#priordate").append('<input type="number" min="1" max="5" id="priordays"/>');
            $("#chroninput").show();
        }
        else{
            $("#priordate").empty();           
            // creates
            var specifictime = [{val : 1, text: 'Every Day'},{val : 2, text: 'Every Week'},{val : 3, text: 'Every Month'}];
            var sel = $('<select>').appendTo('#specificdate');            
            sel.append($("<option>").attr('value',"").text("- select -"));
            $(specifictime).each(function(){
                sel.append($("<option>").attr('value',this.val).text(this.text));    
            });            
        }         
     });
     $("#specificdate").on('change',function(){
//        $("#specificdate").empty(); 
        alert(this.text);
        if(this.value=="Every Day"){           
           $("#specificdate").append('<input type="time"id="time"/>');
        }else if(this.value==2){
             $("#specificdate").append('<input type="time" id="time"/>');
        }
        else if(this.value==3){
            
        }
        else{
            
        }   
     
     });

      $("#chroninput").click(function(){                  
        var radioselected= $('input:radio[name=theme]:checked').val();
        if (radioselected=="priordate"){
            alert($("#priordays").val());
        }
        else{
//            alert($("#priordays").val());
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
    <div id="specificdate">
        
        
    </div>
    <div id="priordate">
        
        
    </div>
    <input class="option" type="button" id="chroninput" value="submit"/>        
</form>
  </body>
</html>
