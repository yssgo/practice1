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
  $sql="SELECT * FROM `user` WHERE `name` = '{$author}'";
  $result=mysqli_query($conn,$sql);
  if($result->num_rows > 0){
    $row=mysqli_fetch_assoc($result);
    $user_id=$row['id'];
    if($password !== htmlspecialchars($row['password'])){
      $invalid_password=TRUE;
    }
  }else{
    $sql="INSERT INTO `user` (`id`, `name`, `password`) VALUES (NULL,'{$author}','{$password}')";
    $result=mysqli_query($conn, $sql);
    $user_id=mysqli_insert_id($conn);
  }
  if($invalid_password===TRUE){
      if($cfgvar==""){
        header("Location:invalid.php");
      }else{
        header("Location:invalid.php?cfgvar=".$cfgvar);
      }
  }else{
    $topic_id=mysqli_real_escape_string($conn,$_POST['topic_id']);
    $title=mysqli_real_escape_string($conn,$_POST['title']);
    $description=mysqli_real_escape_string($conn,$_POST['description']);
    $sql="UPDATE `topic` SET `title` = '{$title}', `description`='{$description}', `author`='{$user_id}', `created`=now() WHERE `topic`.`id`={$topic_id}";
    if(!mysqli_query($conn,$sql)){
      print_r($sql);
      echo "레코드 갱신 에러: ".mysqli_error($conn)."<br>";
      echo "<br>";
    }else{
          if($cfgvar==""){              
            header("Location:index.php?id=".$topic_id);
          }else{
            header("Location:index.php?id=".$topic_id."&cfgvar=".$cfgvar);
          }      
    }
  }
?>
