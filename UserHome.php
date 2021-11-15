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
      text{
          font-size: 20px;
      }
      br {
          line-height: 250%;
          }
      body{
           background-color: #000033;
           background-image: url('https://i.pinimg.com/originals/19/c9/5a/19c95a8ad1c90d89bc9d5c7bc2054151.gif');
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
          .center {
            margin: 30px;
            position: relative;
            top: 50%;
            left: 30%;
          }
          .container2 {
            margin: 40px;
            padding: 10px;
            height: 100px;
            position: relative;
          }
          table, th, td {
            border: 1px solid black;
            border-radius: 10px;
            border-color: #c6a226;
            color: white;
            padding: 2px;
          }
          th, td {
            background-color: black;
            font-family: Bahnschrift;
            padding: 10px;
          }
          .formInput1{
            width: 30%;
            padding: 10px;
            border: 2px solid #c6a226;
            border-radius: 25px;
            box-sizing: border-box;
            resize: vertical;
            display: inline-table;
          }
 </style>
  <body>
  <div id=container>
    <div class="container2">
      <div class="center">
        <form method="post">
          <?php
              include "config.php";
              $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
              $db= new PDO($connection_string, $dbuser, $dbpass);
              try{
                $sql = "SELECT EID, Exam_Name from exams";

                echo "<select class='formInput1' id='testID' name='testID' value=''>Tests</option>"; // list box select command

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
              $sql = "SELECT EID, result, comments from results Where UID = '$_SESSION[UID]' and released = 1";
              echo "<table>"; // list box select command
              echo "<tr>";
              echo "<td>EID</td>";
              echo "<td>Comments</td>";
              echo "<td>Result</td>";
              echo "<td>Total Points Possible</td>";
              echo "<td>Percent Grade</td>";
              echo "</tr>";
              foreach ($db->query($sql) as $row){//Array or records stored in $row
                $sql2 = $db->prepare("SELECT Total_Points from exams Where EID = '$row[EID]'");
                $sql2->execute();
                $r = $sql2->fetch(PDO::FETCH_ASSOC);
                $percent = 100 * $row['result']/$r['Total_Points'];
                $percent .= '%';
                echo "<tr>";
                echo "<td>$row[EID]</td>";
                echo "<td>$row[comments]</td>";
                echo "<td>$row[result]</td>";
                echo "<td>$r[Total_Points]</td>";
                echo "<td>$percent</td>";
                echo "</tr>";
              }
              echo "</table>";// Closing of list box
            }
            finally{}
        ?>
      </div>
    </div>
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
