<?php
session_start();
require ("config.php");
if(isset($_SESSION['UID'])){
  if($_SESSION['IsAdmin']== 0){}
  else{
    header("Location: Login.php");
  }
}
else{
  header("Location: Login.php");
}
if(isset($_SESSION['testID'])){}
else{
  header("Location: UserHome.php");
}
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Test Taker</title>
  </head>
  <body>
    <form name= "test" id="test" method="post">
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
          echo "<lable for=Q1A> $QText[questionText] </lable><br>";
          echo "<textarea form = 'test' name = 'Q1A' id='Q1A'></textarea>";
          echo "<br>";
          //Q2
          if($QIDS['Q2'] != NULL && $QIDS['Q2'] != 0){
            $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
            $params = array(":QID"=> $QIDS['Q2']);
            $sql2->execute($params);
            $QText = $sql2->fetch(PDO::FETCH_ASSOC);
            echo "<lable for=Q2A> $QText[questionText] </lable><br>";
            echo "<textarea form = 'test' name = 'Q2A' id='Q2A'></textarea>";
            echo "<br>";
          }
          //Q3
          if($QIDS['Q3'] != NULL && $QIDS['Q3'] != 0){
            $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
            $params = array(":QID"=> $QIDS['Q3']);
            $sql2->execute($params);
            $QText = $sql2->fetch(PDO::FETCH_ASSOC);
            echo "<lable for=Q3A> $QText[questionText] </lable><br>";
            echo "<textarea form = 'test' name = 'Q3A' id='Q3A'></textarea>";
            echo "<br>";
          }
          //Q4
          if($QIDS['Q4'] != NULL && $QIDS['Q4'] != 0){
            $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
            $params = array(":QID"=> $QIDS['Q4']);
            $sql2->execute($params);
            $QText = $sql2->fetch(PDO::FETCH_ASSOC);
            echo "<lable for=Q4A> $QText[questionText] </lable> <br>";
            echo "<textarea form = 'test' name = 'Q4A' id='Q4A'></textarea>";
            echo "<br>";
          }
          //Q5
          if($QIDS['Q5'] != NULL && $QIDS['Q5'] != 0){
            $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
            $params = array(":QID"=> $QIDS['Q5']);
            $sql2->execute($params);
            $QText = $sql2->fetch(PDO::FETCH_ASSOC);
            echo "<lable for=Q5A> $QText[questionText] </lable> <br>";
            echo "<textarea form = 'test' name = 'Q5A' id='Q5A'></textarea>";
            echo "<br>";
          }
        }
        finally{}
       ?>
       <input type="submit" action="UserHome.php" value="Submit">
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
//Q2
if (isset($_POST['Q2A'])){
  $sql2 = $db->prepare("SELECT resultID from results Where UID = :UID and EID = :EID");
  $params = array(":UID"=> $_SESSION['UID'], ":EID"=> $_SESSION['testID']);
  $sql2->execute($params);
  $resultID = $sql2->fetch(PDO::FETCH_ASSOC);
  //put Q2 into answers
  $stmt = $db->prepare("INSERT INTO `answers`
            (resultID, QuestionID, Submission) VALUES
            (:resultID, :QuestionID, :Submission)");
  $params = array(":resultID"=> $resultID['resultID'], ":QuestionID"=> $QIDS['Q2'], ":Submission"=> $_POST['Q2A']);
  $stmt->execute($params);
  echo "<pre>" . var_export($stmt->errorInfo(), true) . "</pre>";
}
//Q3
if (isset($_POST['Q3A'])){
  $sql2 = $db->prepare("SELECT resultID from results Where UID = :UID and EID = :EID");
  $params = array(":UID"=> $_SESSION['UID'], ":EID"=> $_SESSION['testID']);
  $sql2->execute($params);
  $resultID = $sql2->fetch(PDO::FETCH_ASSOC);
  //put Q3 into answers
  $stmt = $db->prepare("INSERT INTO `answers`
            (resultID, QuestionID, Submission) VALUES
            (:resultID, :QuestionID, :Submission)");
  $params = array(":resultID"=> $resultID['resultID'], ":QuestionID"=> $QIDS['Q3'], ":Submission"=> $_POST['Q3A']);
  $stmt->execute($params);
  echo "<pre>" . var_export($stmt->errorInfo(), true) . "</pre>";
}
//Q4
if (isset($_POST['Q4A'])){
  $sql2 = $db->prepare("SELECT resultID from results Where UID = :UID and EID = :EID");
  $params = array(":UID"=> $_SESSION['UID'], ":EID"=> $_SESSION['testID']);
  $sql2->execute($params);
  $resultID = $sql2->fetch(PDO::FETCH_ASSOC);
  //put Q4 into answers
  $stmt = $db->prepare("INSERT INTO `answers`
            (resultID, QuestionID, Submission) VALUES
            (:resultID, :QuestionID, :Submission)");
  $params = array(":resultID"=> $resultID['resultID'], ":QuestionID"=> $QIDS['Q4'], ":Submission"=> $_POST['Q4A']);
  $stmt->execute($params);
  echo "<pre>" . var_export($stmt->errorInfo(), true) . "</pre>";
}
//Q5
if (isset($_POST['Q5A'])){
  $sql2 = $db->prepare("SELECT resultID from results Where UID = :UID and EID = :EID");
  $params = array(":UID"=> $_SESSION['UID'], ":EID"=> $_SESSION['testID']);
  $sql2->execute($params);
  $resultID = $sql2->fetch(PDO::FETCH_ASSOC);
  //put Q5 into answers
  $stmt = $db->prepare("INSERT INTO `answers`
            (resultID, QuestionID, Submission) VALUES
            (:resultID, :QuestionID, :Submission)");
  $params = array(":resultID"=> $resultID['resultID'], ":QuestionID"=> $QIDS['Q5'], ":Submission"=> $_POST['Q5A']);
  $stmt->execute($params);
  echo "<pre>" . var_export($stmt->errorInfo(), true) . "</pre>";
}
 ?>
