<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <div>
      <titles style= "position:relative; top: 6">
        New Test
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
      /*All sections */
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
      splitscreen{
        width:80%;
        float: right;
        padding-top: 30px;
      }
      table, th, td {
        border: 1px solid black;
        border-radius: 10px;
        border-color: #c6a226;
        color: white;
        padding: 2px;
        padding-bottom: 6px;
      }
      th, td {
        background-color: black;
        font-family: Bahnschrift;
        padding: 5px;
      }
      text{
        font-size: 20px;
      }
      br {
        line-height: 250%;
      }
      body{
        background-color: #000033;
        background-image: url('https://media.giphy.com/media/BHNfhgU63qrks/giphy.gif');
        height: 100%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        color: #bcbdbe;
      }
      /* All Classes */
      .button {
        background-color: rgb(230, 231, 208);
        border: inset #c6a226;
        color: #c6a226;
        padding: 15px 19px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        border-radius: 25px;
        font-size: 16px;
      }
      .button:hover {background-color: rgb(69, 74, 28);}

      .button:active {
        background-color: rgb(69, 74, 28);
        box-shadow: 0 5px #666;
        transform: translateY(4px);
      }
      .formNT{
        width:20%;
        position: relative; top:90px;
      }
      .formNt input{
        width: 95%;
        padding: 10px;
        margin:3px;
        border: 2px solid #c6a226;
        border-radius: 25px;
        box-sizing: border-box;
        resize: vertical;
      }
      .qForm-Container{
        display: table;
        width: 100%;
        float: left;
      }
      .formField{
        display: table-cell;
        margin-right:7px;
        background-color: Transparent;
        border: inset #c6a226;
        color: #bcbdbe;
        padding: 10px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        border-radius: 25px;
        font-size: 16px;
      }
      .qForm-Container select{
        display: table-cell;
        margin-right:7px;
        background-color: Transparent;
        border: inset #c6a226;
        color: #bcbdbe;
        padding: 10px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        border-radius: 25px;
        font-size: 16px;
      }
      .qForm-Container select option{
        background-color: black;
      }
  </style>
  <body>
    <!-- Display All Questons -->
    <splitscreen>
      <!-- Form to choose what difficulty and catagory to display-->
      <form class="qForm-Container" method="post">
        <select name="difficulty" value="">Difficulty</option>
          <option value="all">Difficulty</option>
          <option value="easy">Easy</option>
          <option value="medium">Medium</option>
          <option value="hard">Hard</option>
        </select>
        <select name="catagory" value="">Catagory</option>
          <option value="all">Catagory</option>
          <option value="for">For</option>
          <option value="while">While</option>
          <option value="recursion">Recursion</option>
          <option value="other">Other</option>
        </select>
        <input type="submit" class="formField" value="Submit" style="padding: 10px 24px;"></input>
      </form>
      <!-- Display All Questons -->
      <?php
        require "config.php";
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        $db= new PDO($connection_string, $dbuser, $dbpass);
        try{
          if(isset($_POST['difficulty'])&&isset($_POST['catagory'])){
            if($_POST['difficulty'] == "all" && $_POST['catagory'] == "all"){
              $sql = "SELECT questionID, questionText, category, difficultyLevel, Answer1, Answer2, Answer3, QI1, QI2, QI3  from `questions`";
            }
            elseif($_POST['difficulty'] == "all"){
              $sql = "SELECT questionID, questionText, category, difficultyLevel, Answer1, Answer2, Answer3, QI1, QI2, QI3  from `questions` WHERE category = '$_POST[catagory]'";
            }
            elseif ($_POST['catagory'] == "all") {
              $sql = "SELECT questionID, questionText, category, difficultyLevel, Answer1, Answer2, Answer3, QI1, QI2, QI3  from `questions` WHERE difficultyLevel = '$_POST[difficulty]'";
            }
            else{
              $sql = "SELECT questionID, questionText, category, difficultyLevel, Answer1, Answer2, Answer3, QI1, QI2, QI3  from `questions` WHERE difficultyLevel = '$_POST[difficulty]' and category = '$_POST[catagory]'";
            }
          }
          else{
            $sql = "SELECT questionID, questionText, category, difficultyLevel, Answer1, Answer2, Answer3, QI1, QI2, QI3  from `questions`";
          }
          echo "<table>"; // list box select command
          echo "<tr>";
          echo "<td>Question ID</td>";
          echo "<td>Question Text</td>";
          echo "<td>Catagory</td>";
          echo "<td>Difficulty</td>";
          echo "<td>Input</td>";
          echo "<td>Expected Output:</td>";
          echo "<td>Input</td>";
          echo "<td>Expected Output:</td>";
          echo "<td>Input</td>";
          echo "<td>Expected Output:</td>";
          echo "</tr>";
          foreach ($db->query($sql) as $row){//Array or records stored in $row
            echo "<tr>";
            echo "<td>$row[questionID]</td>";
            echo "<td>$row[questionText]</td>";
            echo "<td>$row[category]</td>";
            echo "<td>$row[difficultyLevel]</td>";
            echo "<td>$row[QI1]</td>";
            echo "<td>$row[Answer1]</td>";
            echo "<td>$row[QI2]</td>";
            echo "<td>$row[Answer2]</td>";
            echo "<td>$row[QI3]</td>";
            echo "<td>$row[Answer3]</td>";
            echo "</tr>";
          }

          echo "</table>";// Closing of list box
        }
        finally{}
       ?><br>
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
    </splitscreen>
   <form class = "formNT" name="NewTest" id="myForm" method="POST">
     <input type="text" name="TestName" id="TestName" placeholder="Test Name"></input><br>
     <input type= "number" name = "Q1ID" id="Q1ID" placeholder="Question 1 ID"></input><br>
     <input type= "number" name = "Q1P" id="Q1P" placeholder="Question 1 Points"></input><br>
     <input type= "number" name = "Q2ID" id="Q2ID" placeholder="Question 2 ID"></input><br>
     <input type= "number" name = "Q2P" id="Q2P" placeholder="Question 2 Points"></input><br>
     <input type= "number" name = "Q3ID" id="Q3ID" placeholder="Question 3 ID"></input><br>
     <input type= "number" name = "Q3P" id="Q3P" placeholder="Question 3 Points"></input><br>
     <input type= "number" name = "Q4ID" id="Q4ID" placeholder="Question 4 ID"></input><br>
     <input type= "number" name = "Q4P" id="Q4P" placeholder="Question 4 Points"></input><br>
     <input type= "number" name = "Q5ID" id="Q5ID" placeholder="Question 5 ID"></input><br>
     <input type= "number" name = "Q5P" id="Q5P" placeholder="Question 5 Points"></input><br>
     <input type= "number" name = "Total_Points" id="Total_Points" placeholder="Total Points"></input><br>
     <input class= "button" type="submit" value="Make Test"/>
   </form>
  </body>
</html>

<?php
  //Put the exam into the exams table
  require "config.php";
  $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
  $db= new PDO($connection_string, $dbuser, $dbpass);
  if(isset($_POST['TestName']) && isset($_POST['Total_Points']) && isset($_POST['Q1ID']) && isset($_POST['Q1P'])) {
    try{
      $sql = $db->prepare("INSERT INTO `exams`
                  (Exam_Name, Total_Points) VALUES
                  (:TestName, :points)");
      $params = array(":TestName"=> $_POST['TestName'], ":points"=>$_POST['Total_Points']);
      $r = $sql->execute($params);
    }
    finally{}
    //put the question into QuestionAssignments with the EID
    try{
      $sql = $db->prepare("SELECT EID from `exams` Where Exam_Name = '$_POST[TestName]'");
      $r = $sql->execute();
      $EID = $sql->fetch();
      $sql2 = $db->prepare("INSERT INTO `QuestionAssignments`
                  (EID, Q1, Q1P) VALUES
                  (:EID, :Q1, :Q1P)");
      $params = array(":EID"=> $EID['EID'], ":Q1"=>$_POST['Q1ID'], ":Q1P"=>$_POST['Q1P']);
      $r = $sql2->execute($params);
    }
    finally{}
  }
  //for question 2
  if(isset($_POST['Q2ID']) && isset($_POST['Q2P'])) {
    try{
      $sql = $db->prepare("SELECT EID from exams Where Exam_Name = '$_POST[TestName]'");
      $r = $sql->execute();
      $EID = $sql->fetch();
      $sql2 = $db->prepare("UPDATE `QuestionAssignments`
                  SET Q2= '$_POST[Q2ID]', Q2P='$_POST[Q2P]' WHERE EID = '$EID[EID]' ");
      $r = $sql2->execute();
    }
    finally{}
  }
  //for question 3
  if(isset($_POST['Q3ID']) && isset($_POST['Q3P'])){
    try{
      $sql = $db->prepare("SELECT EID from exams Where Exam_Name = '$_POST[TestName]'");
      $r = $sql->execute();
      $EID = $sql->fetch();
      $sql2 = $db->prepare("UPDATE `QuestionAssignments`
                  SET Q3= '$_POST[Q3ID]', Q3P='$_POST[Q3P]' WHERE EID = '$EID[EID]' ");
      $r = $sql2->execute();
    }
    finally{}
  }
  //for question 4
  if(isset($_POST['Q4ID']) && isset($_POST['Q4P'])){
    try{
      $sql = $db->prepare("SELECT EID from exams Where Exam_Name = '$_POST[TestName]'");
      $r = $sql->execute();
      $EID = $sql->fetch();
      $sql2 = $db->prepare("UPDATE `QuestionAssignments`
                  SET Q4= '$_POST[Q4ID]', Q4P='$_POST[Q4P]' WHERE EID = '$EID[EID]' ");
      $r = $sql2->execute();
    }
    finally{}
  }
  //for question 5
  if(isset($_POST['Q5ID']) && isset($_POST['Q5P'])){
    try{
      $sql = $db->prepare("SELECT EID from exams Where Exam_Name = '$_POST[TestName]'");
      $r = $sql->execute();
      $EID = $sql->fetch();
      $sql2 = $db->prepare("UPDATE `QuestionAssignments`
                  SET Q5= '$_POST[Q5ID]', Q5P='$_POST[Q5P]' WHERE EID = '$EID[EID]' ");
      $r = $sql2->execute();
    }
    finally{}
  }

 ?>
