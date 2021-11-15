<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin</title>
      <div>
        <titles style= "position:relative; top: 6">
          Tests
        </titles>
        <button style= "float:right;"type="button" onclick="location.href = 'Logout.php';"
            class = "button" name="Login"> Logout
        </button>
        <button style= "float:right;"type="button" onclick="location.href = 'AdminHome.php';"
            class = "button" name="Login"> Home
        </button>
      </div>
  </head><br>
  <style>
      text{
          font-size: 20px;
      }
      br {
          line-height: 250%;
          }
      body{
           background-color: #000033;
           background-image: url('https://media.giphy.com/media/FZGyMkbrq7jQXwneqw/giphy-downsized-large.gif');
           height: 100%;
           background-position: center;
           background-repeat: no-repeat;
           background-size: cover;
           color: #bcbdbe;
           }
          .container {
            height: 50px;
            position: relative;
          }
          .autogradeForm{
            position: relative; left:39%;
            display: inline-block;
            width: 25%;
          }
          .formInput1{
            width: 50%;
            padding: 10px;
            border: 2px solid #c6a226;
            border-radius: 25px;
            box-sizing: border-box;
            resize: vertical;
            margin: 20px;
          }
          .formInput2{
            width: 30%;
            padding: 10px;
            border: 2px solid #c6a226;
            border-radius: 25px;
            box-sizing: border-box;
            resize: vertical;
            margin: 5px;
          }
          .center {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
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
            margin: 0 auto;
          }
          .label {
            padding: 12px 12px 12px 0;
            display: inline-block;
          }
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
          table, th, td {
            border: 1px solid black;
            border-radius: 10px;
            border-color: #c6a226;
            color: white;
            padding: 3px;
            padding-bottom: 6px;
            margin-left: auto;
            margin-right: auto;
          }
          th, td {
            background-color: black;
            font-family: Bahnschrift;
            padding: 10px;
          }
 </style>
  <body>
    <!-- Tests section -->
    <div class="container">
      <div class="center">
        <button type="button" onclick="location.href = 'MNTest.php';"
          class = "button" name="MNTest"> Make New Test
        </button><br><br>
      </div>
    </div>
   <!-- Display all tests with a SQL Query. View Test, and Delete Test -->
   <?php
       require "config.php";
       $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
       $db= new PDO($connection_string, $dbuser, $dbpass);
       try{
         $sql = "SELECT EID, Exam_Name, Total_Points from exams";
         echo "<table>"; // list box select command
         echo "<tr>";
         echo "<td>EID</td>";
         echo "<td>Exam Name</td>";
         echo "<td>Total Points</td>";
         echo "</tr>";
         foreach ($db->query($sql) as $row){//Array or records stored in $row
           echo "<tr>";
           echo "<td>$row[EID]</td>";
           echo "<td>$row[Exam_Name]</td>";
           echo "<td>$row[Total_Points]</td>";
           echo "</tr>";
         }
         echo "</table>";// Closing of list box
       }
       finally{}
    ?><br><br>
    <div class="container">
      <div class="center">
        <form name="Testform" id="myForm" method="POST">
          <input class = "formInput1" type= "number" name = "TestID" id="TestID" placeholder="EID"></input>
            <input class = "button" type="submit" name = "Delete" id="Delete" value="Delete"></input>
        </form><br><br>
      </div>
    </div>
    <form class = "autogradeForm" method="post">
        <?php
          require "config.php";
          $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
          $db= new PDO($connection_string, $dbuser, $dbpass);
          try{
            $sql ="SELECT UID, Username from users Where IsAdmin = 0";

            echo "<select class = 'formInput2' id='studentID' name='studentID'>Student Name</option>"; // list box select command

            foreach ($db->query($sql) as $row){//Array or records stored in $row
              echo "<option value=$row[UID]>$row[Username]</option>";
            }
            echo "</select>";// Closing of list box
          }
          finally{}
          require "config.php";
          $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
          $db= new PDO($connection_string, $dbuser, $dbpass);
          try{
            $sql ="SELECT EID, Exam_Name from exams";

            echo "<select class = 'formInput2' id='EID' name='EID'>Test</option>"; // list box select command

            foreach ($db->query($sql) as $row){//Array or records stored in $row
              echo "<option value=$row[EID]>$row[Exam_Name]</option>";
            }
            echo "</select>";// Closing of list box
          }
          finally{}
      ?>
      <input class = "button" type= "submit" name = "autograde" id="autograde" value="autograde"></input>
    </form>
  </body>
</html>

<?php
    session_start();
    if(isset($_POST["TestID"])){
      if(isset($_POST["Delete"])){
        try{
          require ("config.php");
          $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
          $db= new PDO($connection_string, $dbuser, $dbpass);
          $sql = $db->prepare("DELETE FROM `exams` WHERE EID = :id");
          $r = $sql->execute(array(":id"=>$_POST["TestID"]));
          header("Refresh:0");
        }
        finally{}
      }
    }

    if(isset($_POST["studentID"]) && isset($_POST["EID"])){
      $_SESSION["EID"] = $_POST["EID"];
      $_SESSION["SID"] = $_POST["studentID"];
      sleep(3);
      echo "<html><script> alert($_SESSION["SID"]) </script></html>";
    }
 ?>
