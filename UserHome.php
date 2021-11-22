<?php
session_start();
require ("config.php");
if(isset($_SESSION['UID'])){
  if($_SESSION['IsAdmin']== 0){}
  elseif($_SESSION['IsAdmin']== 1){
    header("Location: AdminHome.php");
  }
  else{
    header("Location: Login.php");
  }
}
else{
  header("Location: Login.php");
}
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db= new PDO($connection_string, $dbuser, $dbpass);
$getname = $db->prepare("SELECT Username from users Where UID = '$_SESSION[UID]'");
$getname->execute();
$stuName = $getname->fetch(PDO::FETCH_ASSOC);
$_SESSION["stuName"] = $stuName["Username"];
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Student Home</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/jumbotron/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
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
    </style>
    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">
  </head>
  <body>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" style="display: inline-flex;">
  <a class="navbar-brand" href="#">CSClasses</a>
  <form action="Logout.php" class="form-inline my-2 my-lg-0" style="display: inline-flex; margin-inline-start: auto;">
    <button class="btn btn-outline-success my-2 my-sm-0" style="background-color: rgb(230, 231, 208); " type="submit" href="Logout.php">Logout</button>
  </form>
</nav>
<main role="main">
  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron" style="background-image: url('https://i.pinimg.com/originals/19/c9/5a/19c95a8ad1c90d89bc9d5c7bc2054151.gif'); color: rgb(232,234,154);">
    <div class="container">
      <h1 class="display-3">Hello, <?php echo "$_SESSION[stuName]";?></h1>
      <h3 class="display-5">Take an Exam</h3>
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
          <input class="btn btn-secondary" type="submit" value="Take Test &raquo;"></input>
      </form>
    </div>
  </div>

  <div class="container">
    <div class="col-md-4">
      <h2>Your Exam Table</h2>
      <p>This Table will display all information on your past exams that were released.</p>
      <?php
          require "config.php";
          $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
          $db= new PDO($connection_string, $dbuser, $dbpass);
          try{
            $sql = "SELECT EID, result, commentQ1, commentQ2, commentQ3, commentQ4, commentQ5, resultID from results Where UID = '$_SESSION[UID]' AND released='1'";
              echo "<table>"; // list box select command
              echo "<tr>";
              echo "<th>Exam Name</th>";
              echo "<th>Result</th>";
              echo "<th>Comment1</th>";
              echo "<th>Comment2</th>";
              echo "<th>Comment3</th>";
              echo "<th>Comment4</th>";
              echo "<th>Comment5</th>";
              echo "<th>ResultID</th>";
              echo "</tr>";
              foreach ($db->query($sql) as $row){//Array or records stored in $row
                $sql2 = $db->prepare("SELECT Exam_Name from exams Where EID = '$row[EID]'");
                $sql2->execute();
                $row2 = $sql2->fetch(PDO::FETCH_ASSOC);
                echo "<tr>";
                echo "<td>$row2[Exam_Name]</td>";
                echo "<td>$row[result]</td>";
                echo "<td>$row[commentQ1]</td>";
                echo "<td>$row[commentQ2]</td>";
                echo "<td>$row[commentQ3]</td>";
                echo "<td>$row[commentQ4]</td>";
                echo "<td>$row[commentQ5]</td>";
                echo "<td>$row[resultID]</td>";
                echo "</tr>";
              }
              echo "</table>";// Closing of list box
          }
          finally{}
      ?>
    </div>
    <div class="col-md-4">
      <br><h2>View Your Past Exams</h2>
      <p>Click on this button to see your actual Exams.</p>
      <form name = "VTest" id = "VTest" method="post">
        <?php
            include "config.php";
            $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
            $db= new PDO($connection_string, $dbuser, $dbpass);
            try{
              $sql = "SELECT EID, Exam_Name from exams";
              echo "<select id='VtestID' name='VtestID' value=''>Tests</option>"; // list box select command
              foreach ($db->query($sql) as $row){//Array or records stored in $row
                echo "<option value=$row[EID]>$row[Exam_Name]</option>";
              }
              echo "</select>";// Closing of list box
            }
            finally{}
        ?>
        <input class="btn btn-secondary" type="submit" role="button" value = "Visit &raquo;"></input>
      </form>
  </div>
  </body>
</html>
<?php
    if(isset($_POST["testID"])){
      $_SESSION['testID'] = $_POST['testID'];
      //redirect to test taking page
      echo'<html><script type="text/javascript">window.open("TestTake.php","_self");</script></html>';
      exit();
    }
    if(isset($_POST["VtestID"])) {
      $_SESSION['VtestID'] = $_POST['VtestID'];
      //redirect to test taking page
      echo'<html><script type="text/javascript">window.open("graderDisplay.php","_self");</script></html>';
      exit();
    }
?>
