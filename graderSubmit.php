<?php

require "config.php";
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
try {
  $sql = $db->prepare("SELECT Username from users Where IsAdmin = 0");
  $sql->execute();
}
finally{}

include "autograde.php"; 

$questions = array("Q1", "Q2", "Q3", "Q4", "Q5");
foreach ($questions as $qNum) {
      if ($_POST["B1$qNum"] == $qPoints) {

        // updating points
        $s = $db->prepare("UPDATE answers SET QP = '$_POST['B1$qNum']' WHERE questionID = '$qID'");
        $r = $s->execute();

        $qPoints = $_POST["B1$qNum"];
        header("Refresh:0; url=autograde.php");
        // change the score in autograder 
        // then refresh
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