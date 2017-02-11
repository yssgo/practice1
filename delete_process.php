<?php
    require("config/config.php");
    require("config/prefer.php");
    require("lib/db.php");    
    if( empty($_GET['cfgvar']) == false ) {
        $cfgvar=$_GET['cfgvar'];
        $conn=db_init(${$cfgvar});
    }else{
        $cfgvar="";
        $conn=db_init($config);
    }    
?>
<?php
  $author=mysqli_real_escape_string($conn,$_POST["author"]);
  $password=mysqli_real_escape_string($conn,$_POST["password"]);
  $sql="SELECT * FROM `topic` WHERE `topic`.`id` = ".$_GET['id'];  
  $result=mysqli_query($conn,$sql);
  $invalid=FALSE;
  $invalid_password=FALSE;
  if($result->num_rows > 0){
    $row=mysqli_fetch_assoc($result);
    $user_id=$row['author'];
    $sql2="SELECT * FROM `user` WHERE `user`.`id` = ".$user_id;  
    $result2=mysqli_query($conn,$sql2);
    if($result2->num_rows > 0){    
        $row2=mysqli_fetch_assoc($result2);
        if($password !== htmlspecialchars($row2['password'])){
            $invalid=TRUE;
            $invalid_password=TRUE;
            $invalid_message="비밀번호가%20틀립니다";
        }
        else{
            $sql3="DELETE FROM `topic` WHERE `topic`.`id` = ".$_GET['id'];
            $result=mysqli_query($conn, $sql3);
        }
    }else{
        $invalid=TRUE;
        $invalid_message="그런%20작성자는%20없습니다";
    }
 }else{
    $invalid=TRUE;
    $invalid_message="그런%20토픽은%20없습니다";
 }
 if($invalid===TRUE){
    if($cfgvar==""){
        header("Location:invalid.php?msg=".$invalid_message);
    }else{
        header("Location:invalid.php?msg=".$invalid_message."&cfgvar=".$cfgvar);
    }
 }else{
    if($cfgvar==""){              
        header("Location:index.php?id=".$topic_id);
    }else{
        header("Location:index.php?id=".$topic_id."&cfgvar=".$cfgvar);
    }
}
  
?>
