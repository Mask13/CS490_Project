<html>
<header>
<button style= "float:right;"type="button" onclick="location.href = 'AdminHome.php';"
    class = "button" name="Login"> Home
</button>
</header>
<style>
    body{
         background-color: #000033;
         background-image: url('https://images.unsplash.com/photo-1445905595283-21f8ae8a33d2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1052&q=80');
         height:auto;
         background-position: center;
         background-repeat: no-repeat;
         background-size: cover;
         color: #bcbdbe;
    }
    table, th, td {
      border: 1px solid black;
      border-radius: 10px;
      border-color: #c6a226;
      color: white;
      padding: 2px;
      padding-bottom: 6px;
    }
    th, td {
      background-color: black;
      font-family: Bahnschrift;
      padding: 10px;
    }
    .button {
        background-color: Transparent;
        border: inset #c6a226;
        color: #bcbdbe;
        padding: 10px 19px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        border-radius: 25px;
        font-size: 16px;
    }
    .button:hover {background-color: rgb(69, 74, 28);}
    titles{
      width: 200px;
      text-align: center;
      font-size: 40;
      font-family: Trebuchet MS;
      text-decoration-color:#c6a226;
      border-bottom: 5px solid #c6a226;
      border-top: 5px solid #c6a226;
      padding: 2px;
    }
    .formInput1{
      width: 80%;
      padding: 20px;
      border: 2px solid #c6a226;
      border-radius: 10px;
      resize:none;
      display: inline-table;
    }
</style>
<body>
<titles>Results of AutoGrader</titles>

<?php

session_start();
$EID = $_SESSION['EID'];
$UID = $_SESSION["SID"];

require "config.php";
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db= new PDO($connection_string, $dbuser, $dbpass);

$questions = array("Q1", "Q2", "Q3", "Q4", "Q5");
foreach ($questions as $qNum) {

    $s = $db->prepare("SELECT resultID FROM results WHERE EID = '$EID' AND UID = '$UID'");
    $s->execute();
    $r = $s->fetch(PDO::FETCH_ASSOC);
    $reID = $r["resultID"]; // getting result ID

    $s = $db->prepare("SELECT $qNum FROM QuestionAssignments WHERE EID = '$EID'");
    $s-> execute();
    $r = $s->fetch(PDO::FETCH_ASSOC);
    $qID = $r["$qNum"]; // getting question ID

    $value = $qNum."P";

    if ($r["$qNum"] != NULL && $r["$qNum"] != 0) {

        echo "<br>";
        echo "<table style='width:100%'>";
        echo "	<tr height='40px'>";
        echo "		<th>Question Number</th>";
        echo "		<td style='text-align: center; vertical-align: middle;' colspan='2'>$qNum</td>";  // Q# from questionassignments
        echo "		<th>Current Grade</th>";
        echo "    <th>Change Grade</th>";
        echo "	</tr>";
        echo "	<tr>";

        $s = $db->prepare("SELECT questionText FROM questions WHERE questionID = '$qID'");
        $s->execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $qText = $r["questionText"];

        $s = $db->prepare("SELECT $value FROM QuestionAssignments WHERE EID = '$EID' ");
        $s->execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $qPoints = $r["$value"];

        echo "		<th>Question Text</th>";
        echo " 		<td style='text-align: center; vertical-align: middle;' colspan='2'>$qText</td>"; // questionText from  questions
        echo "		<td style='text-align: center; vertical-align: middle;'>$qPoints pts</td>"; // QPoints from questionassignments
        echo "    <td></td>";
        echo "	</tr>";

        $s = $db->prepare("SELECT Submission FROM answers WHERE resultID = '$reID' and QuestionID = '$qID'");
        $s->execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $dataString = $r["Submission"];

        $s = $db->prepare("SELECT STP FROM answers WHERE resultID = '$reID' and QuestionID = '$qID'");
        $s->execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $studentPoints = $r["STP"];

        echo "	<tr>";
        echo "		<th>Submission</th>";
        echo " 		<td style='text-align: center; vertical-align: middle;' colspan='2'>$dataString</td>"; // Submission from answers
        echo "		<td style='text-align: center; vertical-align: middle;'>$studentPoints / $qPoints</td>"; // Total Score
        echo "    <td></td>";
        echo "	</tr>";

        $s = $db->prepare("SELECT functionName FROM questions WHERE questionID = '$qID'");
        $s->execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $funcName = $r["functionName"];

        $s = $db->prepare("SELECT FNP FROM answers WHERE QuestionID = '$qID' and resultID = '$reID'");
        $s->execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $FNPoints = $r["FNP"];

        echo "	<tr>";
        echo "		<th>Function Name</th>";
        echo " 		<td style='text-align: center; vertical-align: middle;' colspan='2'>$funcName</td>"; // functionName from questions
        echo "		<td style='text-align: center; vertical-align: middle;'>$FNPoints / 2</td>"; // funcName Score
        echo "    <td style='text-align: center; vertical-align: middle;'>"; // changing the grade
        echo "      <form method='POST'> <input type='text' name='FNB$qNum' size ='5'>";
        echo " 			<input type='submit' value='Submit' name='B1'> </form>";
        echo "    </td>";
        echo "	</tr>";

        $s = $db->prepare("SELECT CP FROM answers WHERE QuestionID = '$qID' and resultID = '$reID'");
        $s->execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $cPoints = $r["CP"];

        $s = $db->prepare("SELECT QuestionConstrain from questions WHERE questionID = '$qID'");
        $s->execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $constraint = $r["QuestionConstrain"];
        switch ($constraint) {
          case "F":
              $constraint = "For Loop";
              break;
          case "W":
              $constraint = "While Loop";
              break;
          case "R":
              $constraint = "Recursion";
              break;
          default:
              $constraint = "No Constraints";
        }

        echo "	<tr>";
        echo "		<th>Constraints</th>";
        echo " 		<td style='text-align: center; vertical-align: middle;' colspan='2'>$constraint</td>";
        echo "		<td style='text-align: center; vertical-align: middle;'>$cPoints / 1</td>";
        echo "    <td style='text-align: center; vertical-align: middle;'>"; // changing the grade
        echo "      <form method='POST'><input type='text' name='CB$qNum' size ='5'>";
        echo " 			<input type='submit' value='Submit' name='B1'> </form>";
        echo "    </td>";
        echo "	</tr>";
        echo " 	<tr>";
        echo "		<th></th>";
        echo "		<th>Expected Output</th>";
        echo "		<th>Student Submission</th>";
        echo "		<th></th>";
        echo "		<th></th>";
        echo "	</tr>";

        $s = $db->prepare("SELECT testAmount FROM questions WHERE questionID = '$qID'");
        $s->execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $testAmount = $r["testAmount"];

        for($x = 1; $x <= $testAmount; $x++) {

            $testString = "Test Case ";
            $testCaseName = $testString.$x." Answers";

            $testNum = "Answer".$x; // test case expected answers
            $s = $db->prepare("SELECT $testNum FROM questions WHERE questionID = '$qID'");
            $s->execute();
            $r = $s->fetch(PDO::FETCH_ASSOC);
            $expAnswer = $r["$testNum"];

            $stuTestAns = "STA".$x; // student test case answers
            $s = $db->prepare("SELECT $stuTestAns FROM answers WHERE QuestionID = '$qID' and resultID = '$reID'");
            $s->execute();
            $r = $s->fetch(PDO::FETCH_ASSOC);
            $stuAnswer = $r["$stuTestAns"];

            $testNum = "TCP".$x;
            $s = $db->prepare("SELECT $testNum FROM answers WHERE QuestionID = '$qID' and resultID = '$reID'");
            $s->execute();
            $r = $s->fetch(PDO::FETCH_ASSOC);

            $testCasePoints = $r["$testNum"];

            echo "	<tr>";
            echo "		<th>$testCaseName</th>";
            echo " 		<td style='text-align: center; vertical-align: middle;'>$expAnswer</td>";
            echo "		<td style='text-align: center; vertical-align: middle;'>$stuAnswer</td>";

            echo "		<td style='text-align: center; vertical-align: middle;'> $testCasePoints</td>";
            echo "    <td style='text-align: center; vertical-align: middle;'>"; // changing grades
            echo "      <form method='POST'> <input type='text' name='testCase$x$qNum' size ='5'>";
            echo " 			<input type='submit' value='Submit' name='B1'> <form>";
            echo "    </td>";
            echo "	</tr>";
            echo "	<tr>";

        }
        echo "<form name='commentF$qNum' method='POST'>";
        echo "  <textarea class = 'formInput1' form = 'commentF$qNum' name='comment$qNum'></textarea>";
        echo "  <input type='submit' value='release grade'>";
        echo "</form>";
    }
}

$s = $db->prepare("SELECT result FROM results WHERE EID = '$EID' AND UID = '$UID'");
$s->execute();
$r = $s->fetch(PDO::FETCH_ASSOC);
$finalScore = $r["result"];

$s = $db->prepare("SELECT Total_Points FROM exams WHERE EID = '$EID'");
$s->execute();
$r = $s->fetch(PDO::FETCH_ASSOC);
$totalPoints = $r["Total_Points"];

$finalPercent = ($finalScore / $totalPoints) * 100;

// final score
echo "<br>";
echo "<table style='width:100%'>";
echo "  <tr>";
echo "		<th></th>";
echo "		<th>Final Score</th>";
echo "		<th>$finalScore / $totalPoints = $finalPercent%</th>";
echo "		<th></th>";
echo "	</tr>";
echo "</table>";

?>
</body>
</html>

<?php
session_start();
$EID = $_SESSION['EID'];
$UID = $_SESSION["SID"];

require "config.php";
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db= new PDO($connection_string, $dbuser, $dbpass);

$s = $db->prepare("SELECT resultID FROM results WHERE EID = '$EID' AND UID = '$UID'");
$s->execute();
$r = $s->fetch(PDO::FETCH_ASSOC);
$reID = $r["resultID"]; // getting result ID

if (!empty($_POST)) {
    $questions = array("Q1", "Q2", "Q3", "Q4", "Q5");
    foreach ($questions as $qNum) {

        $s = $db->prepare("SELECT $qNum FROM QuestionAssignments WHERE EID = '$EID'");
        $s-> execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $qID = $r["$qNum"]; // getting question ID

        $value = $qNum."P";

        if(isset($_POST["comment$qNum"])){
          $comment = $_POST["comment$qNum"];
          $temp = "comment$qNum";
          $sql = $db->prepare("UPDATE results SET released = 1, :comment='$comment' WHERE resultID= '$reID'");
          $param = array(":comment"=>$temp);
          $sql->execute($param);
          echo "<html><script>alert('$comment');</script></html>";
          break;
        }

        if (isset($_POST["FNB$qNum"])) {
            $s = $db->prepare("SELECT FNP FROM answers WHERE resultID = '$reID' and QuestionID = '$qID'");
            $s->execute();
            $r = $s->fetch(PDO::FETCH_ASSOC);
            $FNP = $r["FNP"];

            $FNB = $_POST["FNB$qNum"];
            $s = $db->prepare("UPDATE answers SET FNP = '$FNB' WHERE QuestionID = '$qID' and resultID = '$reID'");
            $r = $s->execute();

            $s = $db->prepare("SELECT STP FROM answers WHERE resultID = '$reID' and QuestionID = '$qID'");
            $s->execute();
            $r = $s->fetch(PDO::FETCH_ASSOC);
            $STP = $r["STP"];
            $STPOld = $r["STP"];

            if ($FNP != NULL) {
                $STP -= $FNP;
                $STP += $FNB;
            }
            else{
                $STP += $FNB;
            }

            $s = $db->prepare("SELECT result FROM results WHERE resultID = '$reID'");
            $s->execute();
            $r = $s->fetch(PDO::FETCH_ASSOC);
            $RESULT = $r["result"];

            if ($RESULT != NULL) {
                $RESULT -= $STPOld;
                $RESULT += $STP;
            }
            else{
                $RESULT += $STP;
            }

            $s = $db->prepare("UPDATE answers SET STP = '$STP' WHERE resultID = '$reID' and QuestionID = '$qID'");
            $r = $s->execute();

            $s = $db->prepare("UPDATE results SET result = '$RESULT' WHERE resultID = '$reID'");
            $r = $s->execute();

            break;
        }

        if (isset($_POST["CB$qNum"])) {
            $s = $db->prepare("SELECT CP FROM answers WHERE resultID = '$reID' and QuestionID = '$qID'");
            $s->execute();
            $r = $s->fetch(PDO::FETCH_ASSOC);
            $CP = $r["CP"];

            $CB = $_POST["CB$qNum"];
            $s = $db->prepare("UPDATE answers SET CP = '$CB' WHERE QuestionID = '$qID' and resultID = '$reID'");
            $r = $s->execute();

            $s = $db->prepare("SELECT STP FROM answers WHERE resultID = '$reID' and QuestionID = '$qID'");
            $s->execute();
            $r = $s->fetch(PDO::FETCH_ASSOC);
            $STP = $r["STP"];
            $STPOld = $r["STP"];

            if ($CP != NULL) {
                $STP -= $CP;
                $STP += $CB;
            }
            else{
                $STP += $CB;
            }

            $s = $db->prepare("SELECT result FROM results WHERE resultID = '$reID'");
            $s->execute();
            $r = $s->fetch(PDO::FETCH_ASSOC);
            $RESULT = $r["result"];

            if ($RESULT != NULL) {
                $RESULT -= $STPOld;
                $RESULT += $STP;
            }
            else{
                $RESULT += $STP;
            }

            $s = $db->prepare("UPDATE answers SET STP = '$STP' WHERE resultID = '$reID' and QuestionID = '$qID'");
            $r = $s->execute();

            $s = $db->prepare("UPDATE results SET result = '$RESULT' WHERE resultID = '$reID'");
            $r = $s->execute();

            break;
        }

        // Test Cases
        if (isset($_POST["testCase1$qNum"]) && $_POST["testCase1$qNum"] != "") {
            $s = $db->prepare("SELECT TCP1 FROM answers WHERE resultID = '$reID' and QuestionID = '$qID'");
            $s->execute();
            $r = $s->fetch(PDO::FETCH_ASSOC);
            $testPoints = $r["TCP1"];

            $TCP1 = $_POST["testCase1$qNum"];
            $s = $db->prepare("UPDATE answers SET TCP1 = '$TCP1' WHERE QuestionID = '$qID' and resultID = '$reID'");
            $r = $s->execute();

            $s = $db->prepare("SELECT STP FROM answers WHERE resultID = '$reID' and QuestionID = '$qID'");
            $s->execute();
            $r = $s->fetch(PDO::FETCH_ASSOC);
            $STP = $r["STP"];
            $STPOld = $r["STP"];

            if ($testPoints != NULL) {
                $STP -= $testPoints;
                $STP += $TCP1;
            }
            else{
                $STP += $TCP1;
            }

            $s = $db->prepare("SELECT result FROM results WHERE resultID = '$reID'");
            $s->execute();
            $r = $s->fetch(PDO::FETCH_ASSOC);
            $RESULT = $r["result"];

            if ($RESULT != NULL) {
                $RESULT -= $STPOld;
                $RESULT += $STP;
            }
            else{
                $RESULT += $STP;
            }

            $s = $db->prepare("UPDATE answers SET STP = '$STP' WHERE resultID = '$reID' and QuestionID = '$qID'");
            $r = $s->execute();

            $s = $db->prepare("UPDATE results SET result = '$RESULT' WHERE resultID = '$reID'");
            $r = $s->execute();

            break;
        }

        elseif (isset($_POST["testCase2$qNum"]) && $_POST["testCase2$qNum"] != "") {
            $s = $db->prepare("SELECT TCP2 FROM answers WHERE resultID = '$reID' and QuestionID = '$qID'");
            $s->execute();
            $r = $s->fetch(PDO::FETCH_ASSOC);
            $testPoints = $r["TCP2"];

            $TCP2 = $_POST["testCase2$qNum"];
            $s = $db->prepare("UPDATE answers SET TCP2 = '$TCP2' WHERE QuestionID = '$qID' and resultID = '$reID'");
            $r = $s->execute();

            $s = $db->prepare("SELECT STP FROM answers WHERE resultID = '$reID' and QuestionID = '$qID'");
            $s->execute();
            $r = $s->fetch(PDO::FETCH_ASSOC);
            $STP = $r["STP"];
            $STPOld = $r["STP"];

            if ($testPoints != NULL) {
                $STP -= $testPoints;
                $STP += $TCP2;
            }
            else{
                $STP += $TCP2;
            }

            $s = $db->prepare("SELECT result FROM results WHERE resultID = '$reID'");
            $s->execute();
            $r = $s->fetch(PDO::FETCH_ASSOC);
            $RESULT = $r["result"];

            if ($RESULT != NULL) {
                $RESULT -= $STPOld;
                $RESULT += $STP;
            }
            else{
                $RESULT += $STP;
            }

            $s = $db->prepare("UPDATE answers SET STP = '$STP' WHERE resultID = '$reID' and QuestionID = '$qID'");
            $r = $s->execute();

            $s = $db->prepare("UPDATE results SET result = '$RESULT' WHERE resultID = '$reID'");
            $r = $s->execute();

            break;
        }

        elseif (isset($_POST["testCase3$qNum"]) && $_POST["testCase3$qNum"] != "") {
            $s = $db->prepare("SELECT TCP3 FROM answers WHERE resultID = '$reID' and QuestionID = '$qID'");
            $s->execute();
            $r = $s->fetch(PDO::FETCH_ASSOC);
            $testPoints = $r["TCP3"];

            $TCP3 = $_POST["testCase3$qNum"];
            $s = $db->prepare("UPDATE answers SET TCP3 = '$TCP3' WHERE QuestionID = '$qID' and resultID = '$reID'");
            $r = $s->execute();

            $s = $db->prepare("SELECT STP FROM answers WHERE resultID = '$reID' and QuestionID = '$qID'");
            $s->execute();
            $r = $s->fetch(PDO::FETCH_ASSOC);
            $STP = $r["STP"];
            $STPOld = $r["STP"];

            if ($testPoints != NULL) {
                $STP -= $testPoints;
                $STP += $TCP3;
            }
            else{
                $STP += $TCP3;
            }

            $s = $db->prepare("SELECT result FROM results WHERE resultID = '$reID'");
            $s->execute();
            $r = $s->fetch(PDO::FETCH_ASSOC);
            $RESULT = $r["result"];

            if ($RESULT != NULL) {
                $RESULT -= $STPOld;
                $RESULT += $STP;
            }
            else{
                $RESULT += $STP;
            }

            $s = $db->prepare("UPDATE answers SET STP = '$STP' WHERE resultID = '$reID' and QuestionID = '$qID'");
            $r = $s->execute();

            $s = $db->prepare("UPDATE results SET result = '$RESULT' WHERE resultID = '$reID'");
            $r = $s->execute();

            break;
        }
    }
    echo("<meta http-equiv='refresh' content='1'>");
}

?>
