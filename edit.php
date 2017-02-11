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
  <title><?=$prefer['sitename']?>:편집</title>
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

                <article class="">
<?php
  if(empty($_GET['id'])){
      if($cfgvar==""){
          header("Location:index.php");
      }else{
          header("Location:index.php&cfgvar=".$cfgvar);
      }
    
  }else{
    $id=mysqli_real_escape_string($conn,$_GET['id']);
    $sql="SELECT topic.id, topic.title, topic.description, user.name, topic.created FROM topic LEFT JOIN user ON topic.author=user.id WHERE topic.id=".$id;
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);
/*
    <h2><?=htmlspecialchars($row['title'])?></h2>
    <script>
      document.title = "<?=$config['sitename']?>:<?=htmlspecialchars($row['title'])?>";
    </script>
    <div><?=strip_tags($row['description'],'<a><h1><h2><h3><h4><ul><ol><li><p><br>')?></div>
    <div><?=htmlspecialchars($row['created'])?>|<?=htmlspecialchars($row['name'])?></div>
  */
  }
?>



<?php
if($cfgvar==""){
    $action_page='update.php';
}else{
    $action_page='update.php?cfgvar='.$cfgvar;
}
?>
<form class="" action="<?=$action_page?>" method="post">
  <div class="form-group">
    <?php $row_title=htmlspecialchars($row['title']);?>
    <label for="title">제목</label> <input class="form-control" type="text" id="title" name="title" value="<?=$row_title?>" required="required" placeholder="제목을 입력하세요"/>
  </div>
  <div class="form-group">
    <?php $row_name=htmlspecialchars($row['name']);?>
    <label for="author">작성자</label> <input class="form-control" type="text" id="author" name="author" readonly="readonly" value="<?=$row_name?>" required="required" placeholder="작성자 이름을 입력하세요" />
  </div>
  <div class="form-group">
    <label for="password">비밀번호</label> <input class="form-control" type="password" id="password" name="password" required="required" placeholder="비밀번호를 입력하세요"/>
  </div>
  <div class="form-group">
    <?php $oktags=implode($prefer["allowed_tags"]); ?>
    <?php $row_description=strip_tags($row['description'],$oktags);?>
    <label for="description">본문</label> <textarea class="form-control" id="description" name="description" rows="8" required="required" placeholder="본문을 입력하세요"><?=$row_description?></textarea>
    <?php $oktags2=implode(' ',$prefer["allowed_tags"]); ?>
    <p>(*<?=htmlspecialchars($oktags2)?>* 태그를 사용할 수 있습니다.)</p>
  </div>
  <input type="text" value="<?=$id?>" style="display:none" name="topic_id", id="topic_id" />
  <p><input class="btn btn-default" type="submit" value="전송" /></p>
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
    </div><!--container-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

</body>
</html>
