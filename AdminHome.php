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
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Admin Home</title>

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
  <div class="jumbotron" style="background-image: url('https://media.giphy.com/media/oLzgl79VN6bbrQUSLe/giphy.gif'); color: rgb(232,234,154);">
    <div class="container">
      <h1 class="display-3">Hello, Admin!</h1>
      <h3 class="display-5" style="color: rgb(253, 255, 122)">About the Student</h3>
      <form name = "getTest" id = "getTest" method="post">
        <?php
          require "config.php";
          $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
          $db= new PDO($connection_string, $dbuser, $dbpass);
          try{
            $sql ="SELECT UID, Username from users Where IsAdmin = 0";
            echo "<select class= 'select' id='studentID' name='studentID' value=''>Student Name</option>"; // list box select command
            foreach ($db->query($sql) as $row){//Array or records stored in $row
              echo "<option value=$row[UID]>$row[Username]</option>";
            }
            echo "</select>";// Closing of list box
          }
          finally{}
        ?>
        <input class="btn btn-secondary" form = "getTest" type="submit" value="See tests &raquo;"></input>
      </form>
      <p style="color: rgb(228, 228, 221);">In this current section, you will be able to see information about each student.</p>
      <?php echo "$table"; ?>
    </div>
  </div>

  <div class="container">
    <!-- Example row of columns -->
    <div class="row">
      <!--<div class="col-md-4">
        <h2>Table</h2>
        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
      </div>-->
      <div class="col-md-4">
        <h2>Tests</h2>
        <p>This is where you would Edit, Delete, or Create new Exams.</p>
        <p><a class="btn btn-secondary" href="Tests.php" role="button">Visit &raquo;</a></p>
      </div>
      <div class="col-md-4">
        <h2>Questions</h2>
        <p>This is where you would Edit, Delete, or Create new Questions.</p>
        <p><a class="btn btn-secondary" href="Questions.php" role="button">Visit &raquo;</a></p>
      </div>
    </div>

    <hr>

  </div> <!-- /container -->

</main>

<footer class="container">
  <p>&copy; じゃ Tech 2018-2022</p>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</html>


<html>
<body>
<style>
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
  <?php
    if(isset($_POST["Request_Test"]) || isset($_POST["studentID"])){
      GetTests();
    }

    function GetTests(){
      require "config.php";
      $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
      $db= new PDO($connection_string, $dbuser, $dbpass);
      try{
        $sql = "SELECT EID, result, commentQ1, commentQ2, commentQ3, commentQ4, commentQ5, newGrade, resultID from results Where UID = '$_POST[studentID]'";
        $table = "<table style='margin-top:10px;'><tr><th>Exam Name</th><th>Result</th><th>Comment1</th><th>Comment2</th><th>Comment3</th><th>Comment4</th><th>Comment5</th><th>ResultID</th></tr>"; // list box select command
        foreach ($db->query($sql) as $row){//Array or records stored in $row
          $sql2 = $db->prepare("SELECT Exam_Name from exams Where EID = '$row[EID]'");
          $sql2->execute();
          $row2 = $sql2->fetch(PDO::FETCH_ASSOC);
          $table .= "<tr>";
          $table .= "<td>$row2[Exam_Name]</td>";
          $table .= "<td>$row[result]</td>";
          $table .= "<td>$row[commentQ1]</td>";
          $table .= "<td>$row[commentQ2]</td>";
          $table .= "<td>$row[commentQ3]</td>";
          $table .= "<td>$row[commentQ4]</td>";
          $table .= "<td>$row[commentQ5]</td>";
          $table .= "<td>$row[resultID]</td>";
          $table .= "</tr>";
        }
        $table .= "</table>";// Closing of list box
      }
      finally{}
    }
  ?>

</body>
</html>
