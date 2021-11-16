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
    <title>Jumbotron Template · Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/jumbotron/">

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
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

<main role="main">

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3">Hello, world!</h1>
      <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
      <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
    </div>
  </div>

  <div class="container">
    <!-- Example row of columns -->
    <div class="row">
      <div class="col-md-4">
        <h2>Heading</h2>
        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
      </div>
      <div class="col-md-4">
        <h2>Heading</h2>
        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
      </div>
      <div class="col-md-4">
        <h2>Heading</h2>
        <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
      </div>
    </div>

    <hr>

  </div> <!-- /container -->

</main>

<footer class="container">
  <p>&copy; Company 2017-2020</p>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</html>



<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin</title>
    <div class="container2">
      <div class="center">
      <titles_big style="position: relative; left:10px;"> Hello Admin </titles_big>
      <button style= "position: relative; left:100px;" type="button" onclick="location.href = 'Logout.php';"
           class = "button2_5" name="Login"> Logout
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
              background-color: rgb(230, 231, 208);
              border: inset #c6a226;
              color: #c6a226;
              padding: 15px 19px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              border-radius: 32px;
              font-size: 16px;
          }
          .button:hover {background-color: rgb(69, 74, 28);}

          .button:active {
            background-color: rgb(69, 74, 28);
            box-shadow: 0 5px #666;
            transform: translateY(4px);
          }
          .button2_5 {
            background-color: Transparent;
            border: inset #c6a226;
            color: #c6a226;
            padding: 15px 19px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 32px;
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
          .button3 {
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
          .button3:hover {background-color: rgb(69, 74, 28);}

          .button3:active {
            background-color: rgb(69, 74, 28);
            box-shadow: 0 5px #666;
            transform: translateY(4px);
          }
          .button2_5:hover {background-color: rgb(69, 74, 28);}

          .button2_5:active {
            background-color: rgb(69, 74, 28);
            box-shadow: 0 5px #666;
            transform: translateY(4px);
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
            margin: 40px;
            padding: 10px;
            height: 100px;
            position: relative;
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
          </form><br><br>
        </div>
      </div>
      <div class="container2">
        <div class="center">
          <!-- Tests section --><br><br><br>
          <button type ="button" onclick="window.location.href=window.location.href" class = "button3" name="MNTest">Remove Table</button>
          <button type="button" onclick="location.href = 'Tests.php';"
                class = "button3" name="MNTest"> View Tests
          </button><br>
          <!-- Questons -->
          <button type="button" onclick="location.href = 'Questions.php';"
                  class = "button3" name="MNTest"> View Questions
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
      margin-top: 100px;
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
        $sql = "SELECT EID, result, commentQ1, commentQ2, commentQ3, commentQ4, commentQ5, newGrade, resultID from results Where UID = '$_POST[studentID]'";
        echo "<table style='margin-top:10px;'>"; // list box select command
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
        $sql = $db->prepare("SELECT EID, result, comment, newGrade, resultID from results Where UID = '$_POST[studentID]'");
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
