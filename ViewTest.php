<?php
session_start();
require ("config.php");
if(isset($_SESSION['UID'])){
  if($_SESSION['IsAdmin']==0){
    $_SESSION['VUID'] = $_SESSION['UID'];
  }
}
else{
  header("Location: Login.php");
}
if(isset($_SESSION['VtestID'])){}
else{
  echo "<html><script>alert('You don't have a test selected, you are being logged out, sorry for the inconvenience');</html></script>";
  header("Location: Logout.php");
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
        $params = array(":TID"=> $_SESSION['VtestID']);
        $sql->execute($params);
        $r = $sql->fetch(PDO::FETCH_ASSOC);
        $examName = $r["Exam_Name"];
        echo "$examName";
       ?>
    </titles>

    <div style="padding-top: 20px">
      <?php
        //get result
        $s = $db->prepare("SELECT resultID FROM results WHERE EID = '$_SESSION[VtestID]' AND UID = '$_SESSION[VUID]'");
        $s->execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $reID = $r["resultID"]; // getting result ID

        require "config.php";
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        $db= new PDO($connection_string, $dbuser, $dbpass);
        try{
          //Get IDs for Q1 - Q5
          $sql = $db->prepare("SELECT Q1, Q2, Q3, Q4, Q5, Q1P, Q2P, Q3P, Q4P, Q5P from QuestionAssignments Where EID = :TID");
          $params = array(":TID"=> $_SESSION['VtestID']);
          $sql->execute($params);
          $QIDS = $sql->fetch(PDO::FETCH_ASSOC);
          //Q1
          $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
          $params = array(":QID"=> $QIDS['Q1']);
          $sql2->execute($params);
          $QText = $sql2->fetch(PDO::FETCH_ASSOC);

          //get studnet response
          $sql3 = $db->prepare("SELECT Submission from answers Where questionID = '$QIDS[Q1]' and resultID = '$reID'");
          $sql3->execute();
          $SUB = $sql3->fetch(PDO::FETCH_ASSOC);

          echo "<div class='test'>";
          echo "  <lable for=Q1A> 1) ($QIDS[Q1P] Points) </lable>";
          echo "  <lable for=Q1A> $QText[questionText] </lable><br>";
          echo "  <textarea form = 'test' name = 'Q1A' id='Q1A'>$SUB[Submission]</textarea>";
          echo "</div>";
          echo "<br>";

          //Q2
          if($QIDS['Q2'] != NULL && $QIDS['Q2'] != 0){
            $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
            $params = array(":QID"=> $QIDS['Q2']);
            $sql2->execute($params);
            $QText = $sql2->fetch(PDO::FETCH_ASSOC);

            //get studnet response
            $sql3 = $db->prepare("SELECT Submission from answers Where questionID = '$QIDS[Q2]' and resultID = '$reID'");
            $sql3->execute();
            $SUB = $sql3->fetch(PDO::FETCH_ASSOC);

            echo "<div class='test'>";
            echo "<lable for=Q2A> 2) ($QIDS[Q2P] Points) </lable>";
            echo "<lable for=Q2A> $QText[questionText] </lable><br>";
            echo "<textarea form = 'test' name = 'Q2A' id='Q2A'>$SUB[Submission]</textarea>";
            echo "</div>";
            echo "<br>";
          }
          //Q3
          if($QIDS['Q3'] != NULL && $QIDS['Q3'] != 0){
            $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
            $params = array(":QID"=> $QIDS['Q3']);
            $sql2->execute($params);
            $QText = $sql2->fetch(PDO::FETCH_ASSOC);

            //get studnet response
            $sql3 = $db->prepare("SELECT Submission from answers Where questionID = '$QIDS[Q3]' and resultID = '$reID'");
            $sql3->execute();
            $SUB = $sql3->fetch(PDO::FETCH_ASSOC);


            echo "<div class='test'>";
            echo "<lable for=Q3A> 3) ($QIDS[Q3P] Points) </lable>";
            echo "<lable for=Q3A> $QText[questionText] </lable><br>";
            echo "<textarea form = 'test' name = 'Q3A' id='Q3A'>$SUB[Submission]</textarea>";
            echo "</div>";
            echo "<br>";
          }
          //Q4
          if($QIDS['Q4'] != NULL && $QIDS['Q4'] != 0){
            $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
            $params = array(":QID"=> $QIDS['Q4']);
            $sql2->execute($params);
            $QText = $sql2->fetch(PDO::FETCH_ASSOC);

            //get studnet response
            $sql3 = $db->prepare("SELECT Submission from answers Where questionID = '$QIDS[Q4]' and resultID = '$reID'");
            $sql3->execute();
            $SUB = $sql3->fetch(PDO::FETCH_ASSOC);

            echo "<div class='test'>";
            echo "<lable for=Q4A> 4) ($QIDS[Q4P] Points) </lable>";
            echo "<lable for=Q4A> $QText[questionText] </lable> <br>";
            echo "<textarea form = 'test' name = 'Q4A' id='Q4A'>$SUB[Submission]</textarea>";
            echo "</div>";
            echo "<br>";
          }
          //Q5
          if($QIDS['Q5'] != NULL && $QIDS['Q5'] != 0){
            $sql2 = $db->prepare("SELECT questionText from questions Where questionID = :QID");
            $params = array(":QID"=> $QIDS['Q5']);
            $sql2->execute($params);
            $QText = $sql2->fetch(PDO::FETCH_ASSOC);

            //get studnet response
            $sql3 = $db->prepare("SELECT Submission from answers Where questionID = '$QIDS[Q5]' and resultID = '$reID'");
            $sql3->execute();
            $SUB = $sql3->fetch(PDO::FETCH_ASSOC);

            echo "<div class='test'>";
            echo "<lable for=Q5A> 5) ($QIDS[Q5P] Points) </lable>";
            echo "<lable for=Q5A> $QText[questionText] </lable> <br>";
            echo "<textarea form = 'test' name = 'Q5A' id='Q5A'>$SUB[Submission]</textarea>";
            echo "</div>";
            echo "<br>";
          }
        }
        finally{}
       ?>
    </div>
  </body>
</html>
