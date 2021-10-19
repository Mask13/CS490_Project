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

// for loop for all questions in the exam
$questions = array("Q1", "Q2", "Q3", "Q4", "Q5");
foreach ($questions as $value) {
  $s = $db->prepare("SELECT $value FROM QuestionAssignments WHERE EID = '$EID'");
  $s-> execute();
  $r = $s->fetch(PDO::FETCH_ASSOC);
  $qID = $r["$value"];

  // Null Check: Questions
  if ($r["$value"] != NULL && $r["$value"] != 0) {
    echo "$value";
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
    //chdir("app");
    $value .="P";

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
        $s = $db->prepare("SELECT functionName FROM questions WHERE questionID = '$qID'");
        $s->execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $funcName = $r["functionName"];

        // full String for the command used in python file
        $pycommand = $dataString."\nprint(".$funcName."(".$Qinput."))";

        file_put_contents("gradera.py", $pycommand);

        $strOutput = NULL;
        $stat = NULL;
        $output = exec("python gradera.py", $strOutput, $stat);
        echo "student output";
        echo "$output";

        // =======================================================
        // Getting Actual Answers
        // =======================================================

        $aInput = "Answer".$x;
        $s = $db->prepare("SELECT $aInput FROM questions WHERE questionID = '$qID'");
        $s->execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $Ansinput = $r["$aInput"];
        echo "Expected Output";
        echo "$Ansinput";

        // =======================================================
        // Comparing Answers
        // =======================================================

        // if ran answer is the same as the expected output($Ansinput) then "Correct"
        if($output == $Ansinput) {
          $counterCorrect += 1;
        }
        // else, "incorrect"
        else {
          $counterCorrect += 0;
        }
      }
    }
    // =======================================================
    // Giving Points
    // =======================================================
    $s = $db->prepare("SELECT $value FROM QuestionAssignments WHERE EID = '$EID' ");
    $s->execute();
    $r = $s->fetch(PDO::FETCH_ASSOC);
    echo "<pre>" . var_export($r, true) . "</pre>";
    echo "$value";
    echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";

    $qPoints = $r["$value"];

    $studentPoints +=($counterCorrect/$testAmount) * $qPoints;
    $testAmount = 0;
    $counterCorrect = 0;
    echo "$studentPoints";
  }
}

$s = $db->prepare("SELECT Total_Points FROM exam WHERE EID = '$EID' ");
$t = $s->execute();
$r = $s->fetch(PDO::FETCH_ASSOC);
$totalPoints = $r["Total_Points"];
echo "<pre>" . var_export($t, true) . "</pre>";
echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";

echo "$studentPoints";

// global Student grade percentage
$studentPercent = $studentPoints / $totalPoints;
echo "$studentPercent";

$sql = $db->prepare("UPDATE results SET result= '$studentPoints' Where EID = '$_SESSION[EID]' and UID = '$_SESSION[SID]'");
$r = $sql->execute();
echo "<pre>" . var_export($r, true) . "</pre>";
echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";
?>
