<html>

<header>
<button style= "float:right;"type="button" onclick="location.href = 'AdminHome.php';"
    class = "button" name="Login"> Home
</button>
</header>

<body>
<h2>Results of AutoGrader</h2>

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

        echo "<style>";
        echo " table, th, td {";
        echo " border:1px solid black;}";
        echo "</style>";
        
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
        echo "    <td style='text-align: center; vertical-align: middle;'>New Grade"; // changing the grade
        echo "    </td>";
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
        echo "    <td style='text-align: center; vertical-align: middle;'>New Grade"; // changing the grade
        echo "    </td>";
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
        echo "    <td style='text-align: center; vertical-align: middle;'>New Grade"; // changing the grade
        echo "      <form method='POST'> <input type='text' name='FNB$qNum' size ='5'>";
        echo " 			<input type='submit' value='Submit' name='B1'> </form>";
        echo "    </td>";
        echo "	</tr>";

        $s = $db->prepare("SELECT CP FROM answers WHERE QuestionID = '$qID' and resultID = '$reID'");
        $s->execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $cPoints = $r["CP"];

        echo "	<tr>";
        echo "		<th>Constraints</th>";
        echo " 		<td style='text-align: center; vertical-align: middle;' colspan='2'>Text Input</td>";
        echo "		<td style='text-align: center; vertical-align: middle;'>$cPoints / 1</td>";
        echo "    <td style='text-align: center; vertical-align: middle;'>New Grade"; // changing the grade
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

            $y = $x-1;

            $CDP = ($qPoints * $counterCorrect) / $testAmount;
            //$testPoints = $qPoints - (2 + 1);


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
            echo "    <td style='text-align: center; vertical-align: middle;'>New Grade"; // changing grades
            echo "      <form method='POST'> <input type='text' name='testCase$x$qNum' size ='5'>";
            echo " 			<input type='submit' value='Submit' name='B1'> <form>";
            echo "    </td>";
            echo "	</tr>";
            echo "	<tr>";

        }
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


        if (isset($_POST["FNB$qNum"])) {
            $FNB = $_POST["FNB$qNum"];
            $s = $db->prepare("UPDATE answers SET FNP = '$FNB' WHERE QuestionID = '$qID' and resultID = '$reID'");
            $r = $s->execute();
        }

        if (isset($_POST["CB$qNum"])) {
            $CB = $_POST["CB$qNum"];
            $s = $db->prepare("UPDATE answers SET CP = '$CB' WHERE QuestionID = '$qID' and resultID = '$reID'");
            $r = $s->execute();
        }
        
        $s = $db->prepare("SELECT testAmount FROM questions WHERE questionID = '$qID'");
        $s->execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $testAmount = $r["testAmount"];

        for($x = 1; $x <= $testAmount; $x++) {
            $testNum = "TCP".$x;

            if (isset($_POST["testCase$x$qNum"])) {
                $testCase = $_POST["testCase$x$qNum"];
                $s = $db->prepare("UPDATE answers SET $testNum = '$testCaseAnswer' WHERE QuestionID = '$qID' and resultID = '$reID'");
                $r = $s->execute();
                break;
            }
        }
    }
    echo("<meta http-equiv='refresh' content='1'>");
}

?>
