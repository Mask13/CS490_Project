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
    <div>
      <titles style= "position:relative; top: 6">
        Hello Admin
      </titles>
    <button style= "float:right;"type="button" onclick="location.href = 'Logout.php';"
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
    <button type="button" onclick="location.href = 'Tests.php';"
           class = "button" name="MNTest"> View Tests
   </button>
   <!-- Questons -->
   <button type="button" onclick="location.href = 'Questions.php';"
          class = "button" name="MNTest"> View Questions
  </button>
  <!-- display current students here-->
  <center><titles style="position:relative; top:60">Students</titles></center>
  <form method="post">
      <?php
        require "config.php";
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        $db= new PDO($connection_string, $dbuser, $dbpass);
        try{
          $sql ="SELECT UID, Username from users Where IsAdmin = 0";

          echo "<select id='studentID' name='studentID' value=''>Student Name</option>"; // list box select command

          foreach ($db->query($sql) as $row){//Array or records stored in $row
            echo "<option value=$row[UID]>$row[Username]</option>";
          }
          echo "</select>";// Closing of list box
        }
        finally{}
     ?>
     <input class= "button" type="submit" value="See tests"/>
  </form>
  <form method="post">
    <input type="number" name="RID" placeholder="RID">
    <input type="text" name="comments" placeholder="Comment">
    <input type="number" step="0.01" name="newGrade" placeholder="New Grade">
    <input type="submit" value="release grade">
  </form>
  </body>
</html>

<?php
  if(isset($_POST["Request_Test"]) || isset($_POST["studentID"])){
    GetTests();
  }

  if(isset($_POST["RID"]) && isset($_POST["comments"]) && isset($_POST["newGrade"])){
    $sql = $db->prepare("UPDATE results SET released = 1, comments='$_POST[comments]', newGrade = '$_POST[newGrade]' Where resultID= '$_POST[RID]'");
    $sql->execute();
  }

  function GetTests(){
    require "config.php";
    $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
    $db= new PDO($connection_string, $dbuser, $dbpass);
    try{
      $sql = "SELECT EID, result, comments, newGrade, resultID from results Where UID = '$_POST[studentID]'";
      echo "<table>"; // list box select command
      echo "<tr>";
      echo "<td>Exam Name</td>";
      echo "<td>Result</td>";
      echo "<td>Comment</td>";
      echo "<td>newGrade</td>";
      echo "<td>ResultID</td>";
      echo "</tr>";
      foreach ($db->query($sql) as $row){//Array or records stored in $row
        $sql2 = $db->prepare("SELECT Exam_Name from exams Where EID = '$row[EID]'");
        $sql2->execute();
        $row2 = $sql2->fetch(PDO::FETCH_ASSOC);
        echo "<tr>";
        echo "<td>$row2[Exam_Name]</td>";
        echo "<td>$row[result]</td>";
        echo "<td>$row[comments]</td>";
        echo "<td>$row[newGrade]</td>";
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
