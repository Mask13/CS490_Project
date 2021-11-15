<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin</title>
    <div>
      <titles style= "position:relative; top: 6">
        Tests
      </titles>
      <button style= "float:right;"type="button" onclick="location.href = 'Logout.php';"
           class = "button2" name="Login"> Logout
      </button>
      <button style= "float:right;"type="button" onclick="location.href = 'AdminHome.php';"
           class = "button2" name="Login"> Home
      </button>
   </div>
  </head><br>
  <style>
      container {
        position: absolute; left: 50%;
        width: 1000px;
        margin-left: -200px;
      }
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
          .button:hover {background-color: rgb(69, 74, 28)}
          .button2 {
            display: inline-block;
            padding: 15px 25px;
            font-size: 24px;
            text-align: center;
            cursor: pointer;
            outline: none;
            color: #bcbdbe;
            background-color: rgb(230, 231, 208);
            border: inset #c6a226;
            border-radius: 15px;
            box-shadow: 0 9px #999;
            font-size: 16px;
          }
          .button2:active {
            background-color: rgb(69, 74, 28);
            box-shadow: 0 5px #666;
            transform: translateY(4px);
          }
          .button2:hover {background-color: rgb(69, 74, 28);}
          .formInput1{
            width: 10%;
            padding: 10px;
            border: 2px solid #c6a226;
            border-radius: 25px;
            box-sizing: border-box;
            resize: vertical;
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
            margin-bottom: 30px;
          }
          th, td {
            background-color: black;
            font-family: Bahnschrift;
            padding: 10px;
          }
 </style>
  <body>
    <container>
    <!-- Tests section -->
    <button style = "position: relative; left: 55px;" type="button" onclick="location.href = 'MNTest.php';"
           class = "button2" name="MNTest"> Make New Test
   </button><br><br>
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
    ?>
   <form style="position: relative; left: 35px;"name="Testform" id="myForm" method="POST">
     <input class = "formInput1" type= "number" name = "TestID" id="TestID" placeholder="EID"></input>
      <input class = "button" type="submit" name = "Delete" id="Delete" value="Delete"></input>
   </form>
   <form style="margin-left: -20px;" method="post">
       <?php
         require "config.php";
         $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
         $db= new PDO($connection_string, $dbuser, $dbpass);
         try{
           $sql ="SELECT UID, Username from users Where IsAdmin = 0";

           echo "<select class = 'formInput1' id='studentID' name='studentID'>Student Name</option>"; // list box select command

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

           echo "<select class = 'formInput1' id='EID' name='EID'>Test</option>"; // list box select command

           foreach ($db->query($sql) as $row){//Array or records stored in $row
             echo "<option value=$row[EID]>$row[Exam_Name]</option>";
           }
           echo "</select>";// Closing of list box
         }
         finally{}
     ?>
      <input class = "button" type= "submit" name = "autograde" id="autograde" value="autograde"></input>
   </form>
 </container>
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
          echo "<pre>" . var_export($r, true) . "</pre>";
          echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";
          header("Refresh:0");
        }
        finally{}
      }
    }

    if(isset($_POST["studentID"]) && isset($_POST["EID"])){
      $_SESSION["EID"] = $_POST["EID"];
      $_SESSION["SID"] = $_POST["studentID"];
      header("Location: autograde.php");
    }
 ?>
