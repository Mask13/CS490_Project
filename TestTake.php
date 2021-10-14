<?php
session_start();
require ("config.php");
if(isset($_SESSION['UID'])){
  if($_SESSION['IsAdmin']== 0){}
  else{
    header("Location: https://web.njit.edu/~as3655/CS490/Login.php");
  }
}
else{
  header("Location: https://web.njit.edu/~as3655/CS490/Login.php");
}
if(isset($_SESSION['testID'])){}
else{
  header("Location: https://web.njit.edu/~as3655/CS490/UserHome.php");
}
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Test Taker</title>
  </head>
  <body>
    <form method="post">
      <?php
        require "config.php";
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        $db= new PDO($connection_string, $dbuser, $dbpass);
        try{
          //Get IDs for Q1 - Q5
          $sql = $db->prepare("SELECT Q1, Q2, Q3, Q4, Q5 from QuestionAssignments Where EID = :TID");
          $params = array(":TID"=> $_SESSION['testID']);
          $sql->execute($params);
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          //Q1
          $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
          $params = array(":QID"=> $result['Q1']);
          $sql2->execute($params);
          $QText = $stmt->fetch(PDO::FETCH_ASSOC);
          echo "<lable for=Q1A> $QText['questionText'] </lable>";
          echo "<input type='text' id='Q1A'></input>"
          //Q2
          if($result['Q2'] != NULL){
            $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
            $params = array(":QID"=> $result['Q2']);
            $sql2->execute($params);
            $QText = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<lable for=Q2A> $QText['questionText'] </lable>";
            echo "<input type='text' id='Q2A'></input>"
          }
          //Q3
          if($result['Q3'] != NULL){
            $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
            $params = array(":QID"=> $result['Q3']);
            $sql2->execute($params);
            $QText = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<lable for=Q3A> $QText['questionText'] </lable>";
            echo "<input type='text' id='Q3A'></input>"
          }
          //Q4
          if($result['Q4'] != NULL){
            $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
            $params = array(":QID"=> $result['Q4']);
            $sql2->execute($params);
            $QText = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<lable for=Q4A> $QText['questionText'] </lable>";
            echo "<input type='text' id='Q4A'></input>"
          }
          //Q5
          if($result['Q5'] != NULL){
            $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
            $params = array(":QID"=> $result['Q5']);
            $sql2->execute($params);
            $QText = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<lable for=Q5A> $QText['questionText'] </lable>";
            echo "<input type='text' id='Q5A'></input>"
          }
        }
       ?>
       <input type="submit" value="Submit">
     </form>
  </body>
</html>

<?php
require "config.php";
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db= new PDO($connection_string, $dbuser, $dbpass);
if (isset($_POST['Q1A'])){
   
}

 ?>
