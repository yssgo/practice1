<?php
function db_init($cfg){
    $conn = mysqli_connect($cfg["host"], $cfg["duser"], $cfg["dpw"]);
    if (!$conn) {
        die("연결 실패: " . mysqli_connect_error());
    }
    if(mysqli_select_db($conn, $cfg["dname"]) == FALSE){
        die($cfg["dname"]);
    } 
    return $conn;
}
?>
