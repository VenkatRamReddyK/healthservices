<?php    include_once("includes/functions.php");?>
<?php 
$status = authenticateAdmin("0125193436","engineer");
echo "session statsus: ".$status;

    if($status!=-1){
        createStudentSession($studentid);
        redirect_to("appointments.php");
    }

createStudentSession("venkat");
if(isStudentSessionExist())
{
    
    echo "student session exist";
}
echo "student session: -> ".getStudentSession();

logout();

if(!isStudentSessionExist())
{
    
    echo "student session closed";
}
echo "student session: -> ".getStudentSession();


?>
