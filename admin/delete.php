<?php

include_once("includes/logged.php");
if(isset( $_GET["id"])){
 try{
    include_once("includes/conn.php");
     $id=$_GET["id"];
     $sql="DELETE FROM `users` WHERE id = ?";
     $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
      echo "delete successfully";
}catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();}
}else{
       echo "ivalid request";
}

?>
<?php

include_once("includes/logged.php");
if(isset( $_GET["id"])){
 try{
    include_once("includes/conn.php");
     $id=$_GET["id"];
     $sql="DELETE FROM `newlist` WHERE id = ?";
     $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
      echo "delete successfully";
}catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();}
}else{
       echo "ivalid request";
}



?>