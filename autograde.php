<html>
<body>
<h2>Results of AutoGrader</h2>

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
global $TestCaseArray;




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
        $s = $db->prepare("SELECT functionName FROM questions WHERE questionID = '$qID'");
        $s->execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $funcName = $r["functionName"];

        if(str_contains($dataString, "def ".$funcName."(")){}
        else{
          $messedupName = true;
          $brokenProg = explode("(",$dataString);
          $brokenProg[0]= "def ".$funcName;
          $dataString = implode("(", $brokenProg);
        }

        // full String for the command used in python file
        $pycommand = $dataString."\nprint(".$funcName."(".$Qinput."))";

        file_put_contents("gradera.py", $pycommand);

        $strOutput = NULL;
        $stat = NULL;
        $output = exec("python gradera.py", $strOutput, $stat);
        //echo "student output";
        //echo "$output";

        // =======================================================
        // Getting Actual Answers
        // =======================================================

        $aInput = "Answer".$x;
        $s = $db->prepare("SELECT $aInput FROM questions WHERE questionID = '$qID'");
        $s->execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $Ansinput = $r["$aInput"];
        //echo "Expected Output";
        //echo "$Ansinput";

        // =======================================================
        // Comparing Answers
        // =======================================================

        // if ran answer is the same as the expected output($Ansinput) then "Correct"
        if($output == $Ansinput) {
          $counterCorrect += 1;
          $TestCaseArray[] = true;
        }
        // else, "incorrect"
        else {
          $TestCaseArray[] = false;
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
    //echo "<pre>" . var_export($r, true) . "</pre>";
    //echo "$value";
    //echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";

    $qPoints = $r["$value"];
    if($messedupName){
      $studentPoints +=($counterCorrect/$testAmount) * ($qPoints-2);
    }
    else{
      $studentPoints += 1 + ($counterCorrect/$testAmount) * ($qPoints-2);
    }
    if($messedupConstrain){}
    else{
      $studentPoints += 1;
    }

    // =======================================================
    // Making the Table
    // =======================================================
    

    // Displaying the autograding table

    //$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
    //$db= new PDO($connection_string, $dbuser, $dbpass);
    
    $qNum = substr($value, 0, -1);

    echo "<style>";
    echo " table, th, td {";
    echo " border:1px solid black;}";
    echo "</style>";
    
    echo "<br>";
    echo "<table style='width:100%'>"; 
    echo "	<tr height='40px'>";
    echo "		<th>Question Number</th>";
    echo "		<td style='text-align: center; vertical-align: middle;' colspan='2'>'$qNum'</td>";  // Q# from questionassignments
    echo "		<td style='text-align: center; vertical-align: middle;'>(Change Grade)</td>";
    echo "	</tr>";
    echo "	<tr>";

    $s = $db->prepare("SELECT questionText FROM questions WHERE questionID = '$qID'");
    $s->execute();
    $r = $s->fetch(PDO::FETCH_ASSOC);

    $qText = $r["questionText"];

    echo "		<th>Question Text</th>";
    echo " 		<td style='text-align: center; vertical-align: middle;' colspan='2'>'$qText'</td>"; // questionText from  questions
    echo "		<td style='text-align: center; vertical-align: middle;'>'$qPoints' pts (Total Q Points)</td>"; // QPoints from questionassignments
    echo "	</tr>";
    echo "	<tr>";

    

    echo "		<th>Submission</th>";
    echo " 		<td style='text-align: center; vertical-align: middle;' colspan='2'>'$dataString'</td>"; // Submission from answers
    echo "		<td style='text-align: center; vertical-align: middle;'>5 / '$qPoints' (Student Grade)</td>"; // Total Score
    echo "	</tr>";
    echo "	<tr>";


    echo "		<th>Function Name</th>";
    echo " 		<td style='text-align: center; vertical-align: middle;' colspan='2'>'$funcName'</td>"; // functionName from questions
    echo "		<td style='text-align: center; vertical-align: middle;'>2 / 2</td>"; // funcName Score
    echo "	</tr>";
    echo "	<tr>";


    echo "		<th>Constraints</th>";
    echo " 		<td style='text-align: center; vertical-align: middle;' colspan='2'>Text Input</td>";
    echo "		<td style='text-align: center; vertical-align: middle;'>1 / 1</td>";
    echo "	</tr>";
    echo " 	<tr>";


    echo "		<th></th>";
    echo "		<th>Expected Output</th>";
    echo "		<th>Student Submission</th>";
    echo "		<th></th>";
    echo "	</tr>";
    echo "	<tr>";


    for($x = 1; $x <= $testAmount; $x++) {
      
      $testString = "Test Case ";
      $testCaseName = $testString.$x." Answers";

      $aInput00 = "Answer".$x;
      $s = $db->prepare("SELECT $aInput00 FROM questions WHERE questionID = '$qID'");
      $s->execute();
      $r = $s->fetch(PDO::FETCH_ASSOC);
      $expAnswer = $r["$aInput00"];
      
      echo "		<th>$testCaseName</th>"; 
      echo " 		<td style='text-align: center; vertical-align: middle;'>'$expAnswer'</td>"; // Answer1 from questions
      echo "		<td style='text-align: center; vertical-align: middle;'>7</td>"; // Student Output
      echo "		<td style='text-align: center; vertical-align: middle;'>3.33 / 3.33 (CDP)</td>";
      echo "	</tr>";
      echo "	<tr>";
    }

    echo "</table>";
    $messedupName = false;
    $testAmount = 0;
    $counterCorrect = 0;
    //echo "$studentPoints";
  }
}

//echo "$studentPoints";

$sql = $db->prepare("UPDATE results SET result= '$studentPoints' Where EID = '$_SESSION[EID]' and UID = '$_SESSION[SID]'");
$r = $sql->execute();
?>

</body>
</html>
