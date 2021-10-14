<?php
session_start();
require ("config.php");
if(isset($_SESSION['UID'])){
  if($_SESSION['IsAdmin']== 0){}
  else{
    header("Location: http://localhost/CS490/Login.php");
  }
}
else{
  header("Location: http://localhost/CS490/Login.php");
}
if(isset($_SESSION['testID'])){}
else{
  header("Location: http://localhost/CS490/UserHome.php");
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
          $QIDS = $sql->fetch(PDO::FETCH_ASSOC);
          //Q1
          $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
          $params = array(":QID"=> $QIDS['Q1']);
          $sql2->execute($params);
          $QText = $sql2->fetch(PDO::FETCH_ASSOC);
          echo "<lable for=Q1A> $QText['questionText'] </lable>";
          echo "<input type='text' id='Q1A'></input>"
          //Q2
          if($result['Q2'] != NULL){
            $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
            $params = array(":QID"=> $QIDS['Q2']);
            $sql2->execute($params);
            $QText = $sql2->fetch(PDO::FETCH_ASSOC);
            echo "<lable for=Q2A> $QText['questionText'] </lable>";
            echo "<input type='text' id='Q2A'></input>"
          }
          //Q3
          if($result['Q3'] != NULL){
            $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
            $params = array(":QID"=> $QIDS['Q3']);
            $sql2->execute($params);
            $QText = $sql2->fetch(PDO::FETCH_ASSOC);
            echo "<lable for=Q3A> $QText['questionText'] </lable>";
            echo "<input type='text' id='Q3A'></input>"
          }
          //Q4
          if($result['Q4'] != NULL){
            $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
            $params = array(":QID"=> $QIDS['Q4']);
            $sql2->execute($params);
            $QText = $sql2->fetch(PDO::FETCH_ASSOC);
            echo "<lable for=Q4A> $QText['questionText'] </lable>";
            echo "<input type='text' id='Q4A'></input>"
          }
          //Q5
          if($result['Q5'] != NULL){
            $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
            $params = array(":QID"=> $QIDS['Q5']);
            $sql2->execute($params);
            $QText = $sql2->fetch(PDO::FETCH_ASSOC);
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
//setup the reslut table entry & and put Q1 into answers
if (isset($_POST['Q1A'])){
  //setup results
  $stmt = $db->prepare("INSERT INTO `results`
            (UID, EID) VALUES
            (:UID, :EID)");
  $params = array(":UID"=> $_SESSION['UID'], ":EID"=> $_SESSION['testID']);
  $stmt->execute($params);
  echo "<pre>" . var_export($stmt->errorInfo(), true) . "</pre>";
  //get result ID
  $sql2 = $db->prepare("SELECT resultID from results Where UID = :UID and EID = :EID");
  $sql2->execute($params);
  $resultID = $sql2->fetch(PDO::FETCH_ASSOC);
  //put Q1 into answers
  $stmt = $db->prepare("INSERT INTO `answers`
            (resultID, QuestionID, Submission) VALUES
            (:resultID, :QuestionID, :Submission)");
  $params = array(":resultID"=> $resultID['resultID'], ":QuestionID"=> $QIDS['Q1'], ":Submission"=> $_POST['Q1A']);
  $stmt->execute($params);
  echo "<pre>" . var_export($stmt->errorInfo(), true) . "</pre>";
}

 ?>