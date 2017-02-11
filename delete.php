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
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <link href="/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
  <title><?=$prefer['sitename']?>:삭제</title>
  <link rel="stylesheet" type="text/css" href="./style.css">
</head>
<body id="target">
    <div class="container">
        <header class="jumbotron text-center">
            <img src="images/lifecode.png" alt="생코">
            <h1>
            <?php
                        $href="./index.php";
                        if($cfgvar!=""){
                            $href .= "?cfgvar=".$cfgvar;
                        }
                        echo '<a href="'.$href.'">'.$prefer["sitename"].'</a>'."\n";
            ?>  
            </h1>
        </header>
        <div class="row">
            <nav class="col-md-3">
                <?php
                    $sql="SELECT * from `topic`";
                    $result=mysqli_query($conn,$sql);
                ?>
                <ol class="nav nav-pills nav-stacked">
                    <?php
                        while($row=mysqli_fetch_assoc($result)){
                            $id=$row['id'];
                            $title=htmlspecialchars($row['title']);
                            $href="./index.php".'?id='.$id;
                            if($cfgvar!=""){
                                $href .= "&cfgvar=".$cfgvar;
                            }
                            echo '<li><a href="'.$href.'">'.$title.'</a></li>'."\n";
                        }
                    ?>
                </ol>
            </nav>
            <div class="col-md-9">
                <article>
                        
                        <?php
                         if( empty($_GET['id']) == false ){
                              $action_page="delete_process.php?id=".htmlspecialchars($_GET['id']);
                              if($cfgvar!==""){
                                $action_page .="&cfgvar=".$cfgvar;
                              }                         
                            $sql = "SELECT topic.id,title,name,description,user.password FROM topic LEFT JOIN user ON topic.author = user.id WHERE topic.id=".$_GET['id'];
                            $result=mysqli_query($conn,$sql);
                            $row=mysqli_fetch_assoc($result);
                            $title=htmlspecialchars($row['title']);
                            $name=htmlspecialchars($row['name']);                            
                            echo '<h2>'.$title.'</h2>'."\n";
                            echo '<p>'.$name.'</p>'."\n";
                            
                        ?>
                        <script>
                            document.title = "<?=$prefer['sitename']?>:<?=htmlspecialchars($row['title'])?>";
                        </script>
                        <form class="form-horizontal" action="<?=$action_page?>" method="post" onsubmit="return check()">
                            <div class="form-group" style="display:none">
                                <label for="author" class="col-md-2 control-label">작성자:</label>
                                <input type="text" class="form-cotrol col-md-10" name="author" id="author" value="<?=$row['name']?>">
                            </div>                            
                            <div class="form-group">
                                <label for="password" class="col-md-2 control-label">비밀번호:</label>
                                <input type="password" class="form-cotrol col-md-10" name="password" id="password" required="required">
                            </div>                            
                            <div class="form-group">                                
                                <input type="submit" class="form-cotrol" name="smit_btn">
                            </div>
                            
                        </form>
                        <?php
                        }
                        else{
                            if($cfgvar!==""){
                                header("Location: invalid.php?msg=topi%20id가%20없습니다");
                            }else{
                                header("Location: invalid.php?cfgvar=".$cfgvar."msg=topi%20id가%20없습니다");
                            }
                        }
                        ?>
                </article>
                <hr />
                <div id="control">
                    <div class="btn-group" role="group" aria-label="...">
                    <input type="button" value="white" onclick="document.getElementById('target').className='white'" class="btn btn-default btn-lg" />
                    <input type="button" value="black" onclick="document.getElementById('target').className='black'" class="btn btn-default btn-lg" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function check(){
            return window.confirm("정말로 삭제하시겠습니까?");
        }
    </script>
</body>
</html>

