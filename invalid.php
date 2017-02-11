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
  <title><?=$prefer['sitename']?>:오류</title>
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
if( empty($_GET['msg']) == true ){    
  echo "<div><h2 style=\"color:red\">비밀번호가 틀립니다.</h2></div>\n";
}
else{
echo "<div><h2 style=\"color:red\">".$_GET['msg']."</h2></div>\n";    
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
    </div><!--container-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

</body>
</html>
