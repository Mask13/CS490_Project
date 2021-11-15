<?php
session_start();
require ("config.php");
if(isset($_SESSION['UID'])){
  if($_SESSION['IsAdmin']== 1){}
  else{
    header("Location: Login.php");
  }
}
else{
  header("Location: Login.php");
}
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin</title>
    <div class="container2">
      <div class="center">
      <titles_big style="position: relative; left:10px;"> Hello Admin </titles_big>
    <button style= "position: relative; left:100px;" type="button" onclick="location.href = 'Logout.php';"
           class = "button" name="Login"> Logout
   </button>
   </div>
  </div>
</head>
  <style>
    #container{
            width: 650px;
            height: 750px;
            background: inherit;
            position: absolute;
            overflow: hidden;
            top: 60%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            /*margin-left: -175px;
            margin-top: -250px;*/
            border-radius: 8px;
      }
      #container:before{
            width: 700px;
            height: 850px;
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            bottom: 0;
            right: 0;
            background: inherit;
            box-shadow: inset 0 0 0 200px rgba(255,255,255,0.2);
            filter: blur(10px);
      }
      table, th, td {
        border: 1px solid black;
        border-radius: 10px;
        border-color: #c6a226;
        color: white;
        padding: 6px;
        padding-bottom: 6px;
      }
      th, td {
        background-color: black;
        font-family: Bahnschrift;
        padding: 10px;
      }
      text{
          font-size: 20px;
      }
      br {
          line-height: 250%;
        }
      body{
           background-color: #000033;
           background-image: url('https://i0.wp.com/gifimage.net/wp-content/uploads/2017/08/space-animated-gif-9.gif');
           height: auto;
           background-position: center;
           background-repeat: no-repeat;
           background-size: cover;
           color: #bcbdbe;
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
          }
          .button2 {
              background-color: Transparent;
              border: inset #c6a226;
              color: #bcbdbe;
              padding: 15px 29px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              border-radius: 27px;
              font-size: 16px;
          }
          .label {
            padding: 12px 12px 12px 0;
            display: inline-block;
          }
          .center {
            margin: 30px;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
          }
          .container2 {
            margin: 30px;
            padding: 10px;
            height: 100px;
            position: relative;
          }
          br2 {
            line-height: 100%;
          }
          titles_big{
            width: 300px;
            text-align: center;
            font-size: 50;
            font-family: Trebuchet MS;
            text-decoration-color:#c6a226;
            border-bottom: 7px solid #c6a226;
            border-top: 7px solid #c6a226;
            padding: 2px;
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
 </style>
  <body>
    <div id= container>
      <!-- display current students here-->
      <div class="container2">
        <div class="center">
          <center><titles style="position:relative; top:60">Students</titles><center><br><br>
          <form method="post">
              <?php
                require "config.php";
                $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
                $db= new PDO($connection_string, $dbuser, $dbpass);
                try{
                  $sql ="SELECT UID, Username from users Where IsAdmin = 0";

                  echo "<select class= 'formInput2' id='studentID' name='studentID' value=''>Student Name</option>"; // list box select command

                  foreach ($db->query($sql) as $row){//Array or records stored in $row
                    echo "<option value=$row[UID]>$row[Username]</option>";
                  }
                  echo "</select>";// Closing of list box
                }
                finally{}
              ?>
              <input class= "button" type="submit" value="See tests"/>
          </form><br><br><br><br>
        </div>
      </div>
      <div class="container2">
        <div class="center">
          <!-- Tests section --><br><br><br>
          <button type="button" onclick="location.href = 'Tests.php';"
                class = "button2" name="MNTest"> View Tests
          </button><br>
          <!-- Questons -->
          <button type="button" onclick="location.href = 'Questions.php';"
                  class = "button2" name="MNTest"> View Questions
          </button>
        </div>
      </div>
    </div>
  </body>
</html>

<html>
<body>

<style>
  body{
    background-color: #000033;
    background-image: url('https://i0.wp.com/gifimage.net/wp-content/uploads/2017/08/space-animated-gif-9.gif');
    height: auto;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    color: #bcbdbe;
    }
    .center {
      margin: 30px;
      position: absolute;
      top: 50%;
      left: 50%;
      -ms-transform: translate(-50%, -50%);
      transform: translate(-50%, -50%);
    }
    .tableContainer{
      margin-bottom: 40%;
      position: relative;
    }
</style>
<div class="tableContainer">
  <div class="center"><br><br><br>
  <?php
    if(isset($_POST["Request_Test"]) || isset($_POST["studentID"])){
      GetTests();
    }

    function GetTests(){
      require "config.php";
      $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
      $db= new PDO($connection_string, $dbuser, $dbpass);
      try{
        $sql = "SELECT EID, result, comments, newGrade, resultID from results Where UID = '$_POST[studentID]'";
        echo "<table>"; // list box select command
        echo "<tr>";
        echo "<th>Exam Name</th>";
        echo "<th>Result</th>";
        echo "<th>Comment</th>";
        echo "<th>ResultID</th>";
        echo "</tr>";
        foreach ($db->query($sql) as $row){//Array or records stored in $row
          $sql2 = $db->prepare("SELECT Exam_Name from exams Where EID = '$row[EID]'");
          $sql2->execute();
          $row2 = $sql2->fetch(PDO::FETCH_ASSOC);
          echo "<tr>";
          echo "<td>$row2[Exam_Name]</td>";
          echo "<td>$row[result]</td>";
          echo "<td>$row[comments]</td>";
          echo "<td>$row[resultID]</td>";
          echo "</tr>";
        }
        echo "</table>";// Closing of list box
        $sql = $db->prepare("SELECT EID, result, comments, newGrade, resultID from results Where UID = '$_POST[studentID]'");
        $sql->execute();
        $glob = $sql->fetch(PDO::FETCH_ASSOC);
      }
      finally{}
    }
  ?>
  </div>
</div>

</body>
</html>
