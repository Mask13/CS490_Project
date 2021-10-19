<?php
session_start();
require ("config.php");
if(isset($_SESSION['UID'])){
  if($_SESSION['IsAdmin']== 0){}
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
        Hello Student
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
    <form method="post">
      <?php
          include "config.php";
          $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
          $db= new PDO($connection_string, $dbuser, $dbpass);
          try{
            $sql = "SELECT EID, Exam_Name from exams";

            echo "<select id='testID' name='testID' value=''>Tests</option>"; // list box select command

            foreach ($db->query($sql) as $row){//Array or records stored in $row
              echo "<option value=$row[EID]>$row[Exam_Name]</option>";
            }

            echo "</select>";// Closing of list box
          }
          finally{}
       ?>
       <input class= "button" type="submit" value="Take test"/>
    </form>
    <?php
        require "config.php";
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        $db= new PDO($connection_string, $dbuser, $dbpass);
        try{
          $sql = "SELECT EID, result, comments, newGrade from results Where UID = '$_SESSION[UID]' and released = 1";
          echo "<table>"; // list box select command
          echo "<tr>";
          echo "<td>EID</td>";
          echo "<td>comments</td>";
          echo "<td>Result</td>";
          echo "<td>Total Points Possible</td>";
          echo "<td>Percent Grade</td>";
          echo "</tr>";
          foreach ($db->query($sql) as $row){//Array or records stored in $row
            $sql2 = $db->prepare("SELECT Total_Points from exams Where EID = '$row[EID]'");
            $sql2->execute();
            $r = $sql2->fetch(PDO::FETCH_ASSOC);
            $percent = 100 * $row['newGrade']/$r['Total_Points'];
            $percent .= '%';
            echo "<tr>";
            echo "<td>$row[EID]</td>";
            echo "<td>$row[comments]</td>";
            echo "<td>$row[newGrade]</td>";
            echo "<td>$r[Total_Points]</td>";
            echo "<td>$percent</td>";
            echo "</tr>";
          }
          echo "</table>";// Closing of list box
        }
        finally{}
     ?>
  </body>
</html>
<?php
    if(isset($_POST["testID"])){
      $_SESSION['testID'] = $_POST['testID'];
      //redirect to test taking page
      header("Location: TestTake.php");
      exit();
    }
 ?>
