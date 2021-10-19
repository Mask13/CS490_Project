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

// for loop for all questions in the exam
$questions = array("Q1", "Q2", "Q3", "Q4", "Q5");
foreach ($questions as $value) {
  $s = $db->prepare("SELECT $value FROM QuestionAssignments WHERE EID = '$EID'");
  $s-> execute();
  $r = $s->fetch(PDO::FETCH_ASSOC);
  $qID = $r["$value"];
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
    chdir("app");
    
    // going thru Question Input
    for($x = 1; $x <= 3; $x++) {
      
      // getting each test case
      $qInput = "QI".$x;
      $s = $db->prepare("SELECT $qInput FROM questions WHERE questionID = '$qID'");
      $s->execute();
      $r = $s->fetch(PDO::FETCH_ASSOC);
      $Qinput = $r["$qInput"];

      // getting function name
      $s = $db->prepare("SELECT functionName FROM questions WHERE questionID = '$qID'");
      $s->execute();
      $r = $s->fetch(PDO::FETCH_ASSOC);
      $funcName = $r["functionName"];

      // full String for the command used in python file
      $pycommand = $dataString."\n print(".$funcName."(".$Qinput."))";

      file_put_contents("gradera.py", $pycommand);

      $output = exec("python gradera.py");
      echo "$output";
      
      // =======================================================
      // Getting Actual Answers
      // =======================================================

      $aInput = "Answer".$x;
      $s = $db->prepare("SELECT $aInput FROM questions WHERE questionID = '$qID'");
      $s->execute();
      $r = $s->fetch(PDO::FETCH_ASSOC);
      $Ansinput = $r["$aInput"];
      echo "$Ansinput";
      // =======================================================
      // Comparing Answers
      // =======================================================

      // if ran answer is the same as the expected output($Ansinput) then "Correct"
      if($output == $Ansinput) {
        $Correct = TRUE;
      }
      // else, "incorrect"
      else {
        $Correct = FALSE;
      }
    }

    // =======================================================
    // Giving Points
    // =======================================================

    // if "Correct", adds to StudentResult Counter(Global)

    $value .="P";
    $s = $db->prepare("SELECT $value FROM QuestionAssignments WHERE EID = '$EID' ");
    $s->execute();
    $r = $s->fetch(PDO::FETCH_ASSOC);
    echo "<pre>" . var_export($r, true) . "</pre>";
    echo "$value";
    echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";


    $qPoints = $r["$value"];

    // Global Counter //
    if ($Correct == TRUE) {
      $studentPoints += $qPoints;
    }
    else {
      $studentPoints += 0;
    }
  }
}

echo "$studentPoints";
$sql = $db->prepare("UPDATE results SET result= '$studentPoints' Where EID = '$_SESSION[EID]' and UID = '$_SESSION[SID]'");
$sql->execute();

?>
