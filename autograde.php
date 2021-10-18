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
    chdir("/app")
    file_put_contents("gradera.py", $dataString);
    $StringLen = strlen($dataString);

    // Alternative //
    /*
    $dataString = $r["Submission"];
    file_put_contents("grader.py", $dataString);
    $StringLen = strlen($dataString);
    */


    // =======================================================
    // Getting Actual Answers
    // =======================================================

    //$s = $db->prepare("SELECT QuestionID FROM answers WHERE resultID = '$reID' ");
    //$s->execute();
    //$r = $s->fetch(PDO::FETCH_ASSOC);

    //$qID = $r["QuestionID"];

    $s = $db->prepare("SELECT Answer FROM questions WHERE questionID = '$qID'");
    $s->execute();
    $r = $s->fetch(PDO::FETCH_ASSOC);

    $dataAnswer = $r["Answer"];
    file_put_contents("graderb.py", $dataAnswer);
    $AnswerLen = strlen($dataAnswer);

    // Alternative //
    /*
    $dataAsnwer = $r["Answer"];
    file_put_contents("grader.py", $dataAnswer, FILE_APPEND);
    $AnswerLen = strlen($dataAnswer);
    */


    // =======================================================
    // Comparing Answers
    // =======================================================

    // exec(): do the checking of the two strings

    // Alternative: We could do a checking of two files and compare the answers of them using the quick diff command

    $output = exec("diff <(python gradera.py) <(python graderb.py)");
    echo "$output";
    echo "$dataAnswer";
    echo "$dataString";
    // if nothing is returned, then it is "Correct"
    if (strlen($output) == 0) {
      $Correct = TRUE;
    }
    // else, then it is "Incorrect"
    else {
      $Correct = FALSE;
    }

    // Boolean Check for "Correct" or "Incorrect" //

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
