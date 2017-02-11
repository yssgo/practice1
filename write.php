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

  <link rel="stylesheet" type="text/css" href="./style.css">
  <title><?=$prefer['sitename']?>:쓰기</title>
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
                        if($cfgvar!==""){
                            $action_page="process.php?cfgvar=".$cfgvar;
                        }else{
                            $action_page="process.php";
                        }
                        ?>
                        
                        <form class="form-horizontal" action="<?=$action_page?>" method="post">
                            <div class="form-group">
                                <label for="title" class="col-md-2 control-label">제목:</label>
                                <input type="text" class="form-cotrol col-md-10" name="title" id="title" required="required" placeholder="제목을 입력하세요.">
                            </div>
                            <div class="form-group">
                                <label for="author" class="col-md-2 control-label">작성자:</label>
                                <input type="text" class="form-cotrol col-md-10" name="author" id="author" required="required" placeholder="작성자를 입력하세요.">
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-md-2 control-label">비밀번호:</label>
                                <input type="password" class="form-cotrol col-md-10" name="password" id="password" required="required" placeholder="비밀번호를 입력하세요">
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-md-2 control-label">본문:</label>
                                <textarea class="form-cotrol col-md-10" name="description" id="description" required="required" rows="10" placeholder="본문을 입력하세요"></textarea>
                                <?php $oktags2=implode($prefer["allowed_tags"]); ?>
                                <p>(<?=htmlspecialchars($oktags2)?> 태그를 사용할 수 있습니다.)</p>
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-cotrol" role="uploadcare-uploader" />
                                <input type="submit" class="form-cotrol" name="smit_btn">
                            </div>
                        </form>
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

    <script>
        UPLOADCARE_PUBLIC_KEY = "dcae6e6fb54777dc2b72";
    </script>
    <script charset="utf-8" src="//ucarecdn.com/libs/widget/2.10.2/uploadcare.full.min.js"></script>
    <script type="text/javascript">
        var sw=uploadcare.SingleWidget('[role=uploadcare-uploader]');
        sw.onUploadComplete(function(info){
            document.querySelector("#description").value=document.querySelector("#description").value+
            '<img src="'+info.cdnUrl+'" alt="" />';
        });
    </script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

</body>
</html>
