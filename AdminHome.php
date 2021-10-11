<?php
session_start();
require ("config.php");
if(isset($_SESSION['UID'])){
  if($_SESSION['IsAdmin']== 1){}
  else{
    header("Location: https://web.njit.edu/~as3655/CS490/Login.php");
  }
}
else{
  header("Location: https://web.njit.edu/~as3655/CS490/Login.php");
}
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin</title>
    <div>
      <titles style= "position:relative; top: 6">
        Hello Admin
      </titles>
    <button style= "float:right;"type="button" onclick="location.href = 'https://web.njit.edu/~as3655/CS490/Logout.php';"
           class = "button" name="Login"> Logout
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
           background-image: url('https://images.unsplash.com/photo-1445905595283-21f8ae8a33d2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1052&q=80');
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
 </style>
  <body>
    <!-- Tests section -->
    <button type="button" onclick="location.href = 'https://web.njit.edu/~as3655/CS490/Logout.php';"
           class = "button" name="MNTest"> Make New Test
   </button>
   <!-- Questons -->
   <button type="button" onclick="location.href = 'https://web.njit.edu/~as3655/CS490/Logout.php';"
          class = "button" name="MNTest"> Make New Question
  </button>
  <!-- display current students here-->
  <center><titles style="position:relative; top:60">Students</titles></center>
  <form action="Request_Test" method="post">
    <?php
        include "config.php";
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        $db= new PDO($connection_string, $dbuser, $dbpass);
        try{
          $sql ="SELECT UID, Username from users Where IsAdmin = 0";

          echo "<select id='studentID' name='studentID' value=''>Student Name</option>"; // list box select command

          foreach ($dbo->query($sql) as $row){//Array or records stored in $row
            echo "<option value=$row[UID]>$row[Username]</option>";
          }

          echo "</select>";// Closing of list box
        }
     ?>
     <input class= "button" type="submit" value="See tests"/>
  </form>

  </body>
</html>

<?php
    if(isset($_POST["Request_Test"]) && isset($_POST["studentID"])){
      GetTests();
    }
    function GetTests(){
      include "config.php";
      $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
      $db= new PDO($connection_string, $dbuser, $dbpass);
      try{
        $sql = "SELECT EID, result, ResultID from results Where UID = $_POST['studentID']";
        echo "<tbody>"; // list box select command
        foreach ($db->query($sql) as $row){//Array or records stored in $row
          $sql2 = "SELECT Exam_Name from exams Where EID = $row['EID']";
          $db->query($sql2) as $row2
          echo "<tr>";
          echo "<td>$row2[Exam_Name]</td>";
          echo "<td>$row[result]</td>";
          echo "</tr>";
        }

        echo "</tbody>";// Closing of list box
      }
    }
 ?>
