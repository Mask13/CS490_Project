<?php

session_start();
$EID = $_SESSION['EID'];
// $reID = $_SESSION["resultID"];

require "config.php";
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db= new PDO($connection_string, $dbuser, $dbpass);

include "autograde.php"; 

$questions = array("Q1", "Q2", "Q3", "Q4", "Q5");
foreach ($questions as $qNum) {
    if (isset($_POST["qPoints$qNum"])) {
        // updating points
        $s = $db->prepare("SELECT $qNum FROM QuestionAssignments WHERE EID = '$EID'");
        $s-> execute();
        $r = $s->fetch(PDO::FETCH_ASSOC);
        $qID = $r['$qNum'];

        $s = $db->prepare("UPDATE answers SET QP =':QP' WHERE QuestionID = '$qID'");
        $params = array(":QP" => $_POST["qPoints$qNum"]);
        $r = $s->execute($params);

        //$qPoints = $_POST["qPoints$qNum"];
        header("Location = autograde.php");
    }

    //  IF $_POST["B2$qNum"] {

    //      change the score in autograder 
    //      then refresh
    //  }

    //  IF $_POST["B3$qNum"] {

    //      change the score in autograder 
    //      then refresh
    //  }

    //  IF $_POST["B4$qNum"] {

    //      change the score in autograder 
    //      then refresh
    //  }

    //  IF $_POST["B5$qNum"] {

    //      change the score in autograder 
    //      then refresh
    //  }

    //  IF $_POST["B6$qNum"] {

    //      change the score in autograder 
    //      then refresh
    //  }

}




?>