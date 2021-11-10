<html>
<body>

<?php
// =======================================================
// Database Connection
// =======================================================
session_start();
$EID = $_SESSION['EID'];
$UID = $_SESSION["SID"];


require "config.php";
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
try {
  $sql = $db->prepare("SELECT Username from users Where IsAdmin = 0");
  $sql->execute();
}
finally{}

// global variable for total Points for student
global $studentPoints;
global $counterCorrect;
global $messedupName;
global $messedupConstrain;
global $finalScore;
global $totalPoints;
global $finalPercent;
global $testAmount;

$TestCaseArray = array();

$outputArray = array();


// for loop for all questions in the exam
$questions = array("Q1", "Q2", "Q3", "Q4", "Q5");
foreach ($questions as $value) {
  $s = $db->prepare("SELECT $value FROM QuestionAssignments WHERE EID = '$EID'");
  $s-> execute();
  $r = $s->fetch(PDO::FETCH_ASSOC);
  $qID = $r["$value"];

  // Null Check: Questions
  if ($r["$value"] != NULL && $r["$value"] != 0) {

    // =======================================================
    // Getting Student Answers
    // =======================================================

    $s = $db->prepare("SELECT resultID FROM results WHERE EID = '$EID' and UID = '$UID' ");
    $s->execute();
    $r = $s->fetch(PDO::FETCH_ASSOC);
    $reID = $r["resultID"];

    $s = $db->prepare("SELECT Submission FROM answers WHERE resultID = '$reID' and QuestionID = '$qID'");
    $s->execute();
    $r = $s->fetch(PDO::FETCH_ASSOC);

    $dataString = $r["Submission"];
    $value .="P"; // value changes to valueP

    // going thru Question Input
    for($x = 1; $x <= 3; $x++) {
      // getting each test case
      $qInput = "QI".$x;
      $s = $db->prepare("SELECT $qInput FROM questions WHERE questionID = '$qID'");
      $s->execute();
      $r = $s->fetch(PDO::FETCH_ASSOC);
      $Qinput = $r["$qInput"];

      // Null Check: Question Inputs
      if ($Qinput != NULL && strlen($Qinput) != 0) {

        // getting amount of test cases
        $testAmount += 1;

        // getting function name
        if($messedupName != true){
          $s = $db->prepare("SELECT functionName FROM questions WHERE questionID = '$qID'");
          $s->execute();
          $r = $s->fetch(PDO::FETCH_ASSOC);
          $funcName = $r["functionName"];

          if(str_contains($dataString, "def ".$funcName."(")){
            $messedupName = false;
          }
          else{
            $messedupName = true;
            $brokenProg = explode("(",$dataString);
            $brokenProg[0]= "def ".$funcName;
            $dataString = implode("(", $brokenProg);
          }
        }

        // full String for the command used in python file
        $pycommand = $dataString."\nprint(".$funcName."(".$Qinput."))";

        file_put_contents("gradera.py", $pycommand);

        $strOutput = NULL;
        $stat = NULL;
        $output = exec("python gradera.py", $strOutput, $stat);
        array_push($outputArray, $output);

        // updating answers database with student test answers
        $studentTestAns = "STA".$x;

        $s = $db->prepare("UPDATE answers SET $studentTestAns = '$output' WHERE questionID = '$qID' and resultID = '$reID'");
        $r = $s->execute();

        // =======================================================
        // Getting Actual Answers
        // =======================================================

        $aInput = "Answer".$x;
        $s = $db->prepare("SELECT $aInput FROM questions WHERE questionID = '$qID'");
        $s->execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $Ansinput = $r["$aInput"];

        // =======================================================
        // Comparing Answers
        // =======================================================

        if($output == $Ansinput) {
          $counterCorrect += 1;
          array_push($TestCaseArray, true);
        }
        else {
          $counterCorrect += 0;
          array_push($TestCaseArray, false);
        }
      }
    }
    // =======================================================
    // Giving Points
    // =======================================================

    $s = $db->prepare("SELECT $value FROM QuestionAssignments WHERE EID = '$EID' ");
    $s->execute();
    $r = $s->fetch(PDO::FETCH_ASSOC);


    $qPoints = $r["$value"];

    // updating QP
    $s = $db->prepare("UPDATE answers SET QP = '$qPoints' WHERE questionID = '$qID' and resultID = '$reID'");
    $r = $s->execute();

    $FNPoints = 0;

    $testPoints = $qPoints - (2 + 1);

    //Check constraints
    $s = $db->prepare("SELECT QuestonConstrain from questions WHERE questionID = '$qID'");
    $s->execute();
    $r = $s->fetch(PDO::FETCH_ASSOC);
    $constraint = $r["QuestonConstrain"];
    if ($constraint = "F"){
      if(str_contains($dataString, "for")|| str_contains($dataString, "For")){
        $messedupConstrain = false;
      }
      else{
        $messedupConstrain = true;
      }
    }
    elseif ($constraint = "W") {
      if(str_contains($dataString, "while")|| str_contains($dataString, "While")) {
        $messedupConstrain = false;
      }
      else{
        $messedupConstrain = true;
      }
    }
    elseif ($constraint = "R"){
      if(sizeof(explode($funcName,$dataString))>=3) {
        $messedupConstrain = false;
      }
      else{
        $messedupConstrain = true;
      }
    }

    if($messedupName == false){
      $FNPoints += 2;

      if (($counterCorrect / $testAmount) == 1) {
        $studentPoints += $qPoints;
      }
      else {
        $studentPoints += $FNPoints;
      }
    }
    else{
      if (($counterCorrect / $testAmount) == 1) {
        $studentPoints += $testPoints;
      }
      else {
        $studentPoints += 0;
      }
    }
    if($messedupConstrain){} // **need to do for Constraints** //
    else{
      $cPoints += 1;
      $testPoints += 1;
    }

    // updating FN
    $s = $db->prepare("UPDATE answers SET FNP = '$FNPoints' WHERE questionID = '$qID' and resultID = '$reID'");
    $r = $s->execute();

    // updating CP
    $s = $db->prepare("UPDATE answers SET CP = '$cPoints' WHERE questionID = '$qID' and resultID = '$reID'");
    $r = $s->execute();

    // updating studentPoints
    $s = $db->prepare("UPDATE answers SET STP = '$studentPoints' WHERE questionID = '$qID' and resultID = '$reID'");
    $r = $s->execute();

    $finalScore += $studentPoints;
    $totalPoints += $qPoints;

    // =======================================================
    // Making the Table
    // =======================================================

    $s = $db->prepare("SELECT questionText FROM questions WHERE questionID = '$qID'");
    $s->execute();
    $r = $s->fetch(PDO::FETCH_ASSOC);

    $qText = $r["questionText"];

    for($x = 1; $x <= $testAmount; $x++) {

      $aInput00 = "Answer".$x;
      $s = $db->prepare("SELECT $aInput00 FROM questions WHERE questionID = '$qID'");
      $s->execute();
      $r = $s->fetch(PDO::FETCH_ASSOC);
      $expAnswer = $r["$aInput00"];

      if ($outputArray[$y] == $expAnswer) {
        $testNum = "TCP".$x;
        $s = $db->prepare("UPDATE answers SET $testNum = '1' WHERE questionID = '$qID' and resultID = '$reID'");
        $r = $s->execute();
      }
      else {
        $testNum = "TCP".$x;
        $s = $db->prepare("UPDATE answers SET $testNum = '0' WHERE questionID = '$qID' and resultID = '$reID'");
        $r = $s->execute();
      }

    }

    $messedupName = false;
    $testAmount = 0;
    $counterCorrect = 0;
    $studentPoints = 0;
    $FNPoints = 0;
    $cPoints = 0;
  }

  $outputArray = array();
}

$finalPercent = ($finalScore / $totalPoints) * 100;

$sql = $db->prepare("UPDATE results SET result= '$finalScore' Where EID = '$EID' and UID = '$UID'");
$r = $sql->execute();

echo "Finished grading";
header("Location: graderSubmit.php");

?>

</body>
</html>
