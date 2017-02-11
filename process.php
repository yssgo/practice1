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
    $sql="SELECT * FROM user WHERE name='".$_POST['author']."'";
    $result=mysqli_query($conn,$sql);
    if($result->num_rows == 0){
        $author=mysqli_real_escape_string($conn,$_POST['author']);
        $password=mysqli_real_escape_string($conn,$_POST['password']);
        $sql="INSERT INTO user (name,password) VALUES('{$author}','{$password}')";
        mysqli_query($conn,$sql);
        $user_id=mysqli_insert_id($conn);
    }else{
        $row=mysqli_fetch_assoc($result);
        $id=$row['id'];
        $user_id=$id;
    }
    $sql="INSERT INTO topic (title,description,author,created) VALUES(";
    $title=mysqli_real_escape_string($conn,$_POST['title']);
    $description=mysqli_real_escape_string($conn,$_POST['description']);
    $sql .="'".$title."', ";
    $sql .="'".$description."', ";
    $sql .="'".$user_id."', ";
    $sql .="now())";
    $result=mysqli_query($conn,$sql);
    $location="./index.php";
    if($cfgvar!=""){
        $location .= "?cfgvar=".$cfgvar;
    }
    header('Location: '.$location);
?>
