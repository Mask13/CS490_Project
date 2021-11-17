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
    <button style= "float:right;"type="button" onclick="location.href = 'UserHome.php';"
           class = "button" name="Login"> Back
   </button>
  </head>
  <style>
    #container{
        width: 700px;
        height: 200%;
        background: inherit;
        position: absolute;
        overflow: hidden;
        top: 50%;
        left: 50%;
        border-style: groove;
        margin-left: -300px;
        margin-top: -250px;
        border-radius: 8px;
        font-size: 20px;
    }
    textarea {
        font-size: .8rem;
        letter-spacing: 1px;
    }
    textarea {
        padding: 20px;
        width: 600px;
        max-width: 100%;
        line-height: 1.5;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-shadow: 1px 1px 1px #999;
    }
    body{
        background-color: #000033;
        background-image: url('https://media.giphy.com/media/q3k9yg1qoFzoy1D8du/giphy-downsized-large.gif');
        background-repeat: repeat;
        height: auto;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        color: #bcbdbe;
    }
    .button {
        background-color: Transparent;
        border: inset #c6a226;
        color: #bcbdbe;
        padding: 15px 19px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        border-radius: 25px;
        font-size: 16px;
    }
    .button:hover {
        background-color: rgb(69, 74, 28);
      }
    .button:active {
      background-color: rgb(69, 74, 28);
      box-shadow: 0 5px #666;
      transform: translateY(4px);
    }
    titles{
        width: 200px;
        text-align: center;
        font-size: 50;
        font-family: Trebuchet MS;
        text-decoration-color:#c6a226;
        border-bottom: 5px solid #c6a226;
        border-top: 5px solid #c6a226;
        padding: 2px;
    }
    .test{
        padding: 20px;
        font-size: 30;
        font-family: Trebuchet MS;
        text-decoration-color:#c6a226;
        border-bottom: 5px solid #c6a226;
        border-top: 5px solid #c6a226;
    }
  </style>
  <body>
    <titles>
      <?php
        require "config.php";
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        $db= new PDO($connection_string, $dbuser, $dbpass);
        $sql = $db->prepare("SELECT Exam_Name from exams Where EID = :TID");
        $params = array(":TID"=> $_SESSION['testID']);
        $sql->execute($params);
        $r = $sql->fetch(PDO::FETCH_ASSOC);
        $examName = $r["Exam_Name"];
        echo "$examName";
       ?>
    </titles>

    <div style="padding-top: 20px">
      <form name= "test" id="test" method="post">
        <?php
          require "config.php";
          $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
          $db= new PDO($connection_string, $dbuser, $dbpass);
          try{
            //Get IDs for Q1 - Q5
            $sql = $db->prepare("SELECT Q1, Q2, Q3, Q4, Q5, Q1P, Q2P, Q3P, Q4P, Q5P from QuestionAssignments Where EID = :TID");
            $params = array(":TID"=> $_SESSION['testID']);
            $sql->execute($params);
            $QIDS = $sql->fetch(PDO::FETCH_ASSOC);
            //Q1
            $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
            $params = array(":QID"=> $QIDS['Q1']);
            $sql2->execute($params);
            $QText = $sql2->fetch(PDO::FETCH_ASSOC);
            echo "<div class='test'>";
            echo "  <lable for=Q1A> 1) ($QIDS[Q1P] Points) </lable>";
            echo "  <lable for=Q1A> $QText[questionText] </lable><br>";
            echo "  <textarea form = 'test' name = 'Q1A' id='Q1A'></textarea>";
            echo "</div>";
            echo "<br>";
            //Q2
            if($QIDS['Q2'] != NULL && $QIDS['Q2'] != 0){
              $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
              $params = array(":QID"=> $QIDS['Q2']);
              $sql2->execute($params);
              $QText = $sql2->fetch(PDO::FETCH_ASSOC);
              echo "<div class='test'>";
              echo "<lable for=Q2A> 2) ($QIDS[Q2P] Points) </lable>";
              echo "<lable for=Q2A> $QText[questionText] </lable><br>";
              echo "<textarea form = 'test' name = 'Q2A' id='Q2A'></textarea>";
              echo "</div>";
              echo "<br>";
            }
            //Q3
            if($QIDS['Q3'] != NULL && $QIDS['Q3'] != 0){
              $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
              $params = array(":QID"=> $QIDS['Q3']);
              $sql2->execute($params);
              $QText = $sql2->fetch(PDO::FETCH_ASSOC);
              echo "<div class='test'>";
              echo "<lable for=Q3A> 3) ($QIDS[Q3P] Points) </lable>";
              echo "<lable for=Q3A> $QText[questionText] </lable><br>";
              echo "<textarea form = 'test' name = 'Q3A' id='Q3A'></textarea>";
              echo "</div>";
              echo "<br>";
            }
            //Q4
            if($QIDS['Q4'] != NULL && $QIDS['Q4'] != 0){
              $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
              $params = array(":QID"=> $QIDS['Q4']);
              $sql2->execute($params);
              $QText = $sql2->fetch(PDO::FETCH_ASSOC);
              echo "<div class='test'>";
              echo "<lable for=Q4A> 4) ($QIDS[Q4P] Points) </lable>";
              echo "<lable for=Q4A> $QText[questionText] </lable> <br>";
              echo "<textarea form = 'test' name = 'Q4A' id='Q4A'></textarea>";
              echo "</div>";
              echo "<br>";
            }
            //Q5
            if($QIDS['Q5'] != NULL && $QIDS['Q5'] != 0){
              $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
              $params = array(":QID"=> $QIDS['Q5']);
              $sql2->execute($params);
              $QText = $sql2->fetch(PDO::FETCH_ASSOC);
              echo "<div class='test'>";
              echo "<lable for=Q5A> 5) ($QIDS[Q5P] Points) </lable>";
              echo "<lable for=Q5A> $QText[questionText] </lable> <br>";
              echo "<textarea form = 'test' name = 'Q5A' id='Q5A'></textarea>";
              echo "</div>";
              echo "<br>";
            }
          }
          finally{}
         ?>
         <input class = "button" type="submit" value="Submit">
       </form>
    </div>
  </body>
</html>

<?php
if (!empty($_POST)) {
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
  header("Location: UserHome.php");
}
 ?>
