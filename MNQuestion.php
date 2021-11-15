<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <div>
      <titles style= "position:relative; top: 6">
        New Question
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
      /* custom radio from W3Schools */
      label{
        display: block;
        position: relative;
        padding-left: 35px;
        cursor: pointer;
        font-size: 20px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      label input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
      }
      .radio {
        position: absolute;
        top: 8;
        left: 8;
        height: 15px;
        width: 15px;
        background-color: #eee;
        border-radius: 50%;
      }
      label:hover input ~ .radio {
        background-color: #ccc;
      }
      label input:checked ~ .radio {
        background-color: #c6a226;
      }
      .radio:after {
        content: "";
        position: absolute;
        display: none;
      }
      label input:checked ~ .radio:after {
        display: block;
      }
      label .radio:after {
        top: 4px;
        left: 4px;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #000033;
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
        background-image: url('https://media.giphy.com/media/q3k9yg1qoFzoy1D8du/giphy-downsized-large.gif');
        height: 100%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        color: #bcbdbe;
      }
      /* All Classes */
      .formInput1{
        width: 95%;
        padding: 10px;
        border: 2px solid #c6a226;
        border-radius: 25px;
        box-sizing: border-box;
        resize: vertical;
      }
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
      .formNQ{
        width:20%;
        position: relative; top:10px;
      }
      .formNQ select{
        width: 95%;
        padding: 10px;
        border: 2px solid #c6a226;
        border-radius: 25px;
        box-sizing: border-box;
        resize: vertical;
      }
      .formNQ select option{
        width: 75%;
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
          echo "<th>Question ID</th>";
          echo "<th>Question Text</th>";
          echo "<th>Catagory</th>";
          echo "<th>Difficulty</th>";
          echo "<th>Input</th>";
          echo "<th>Expected Output:</th>";
          echo "<th>Input</th>";
          echo "<th>Expected Output:</th>";
          echo "<th>Input</th>";
          echo "<th>Expected Output:</th>";
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
       ?>
    </splitscreen>
   <!-- Display all tests with a SQL Query. View Test, and Delete Test -->
   <br>
   <br>
   <form class = "formNQ" name="NewQuestion" id="myForm" method="POST">
     <input class= "formInput1" type= "Text" name = "QT" id="QT" placeholder="Question Text"></input><br>
     <!-- Info for test case 1 -->
     <input class= "formInput1" type= "Text" name = "QI1" id="QI1" placeholder="Question Test 1"></input><br>
     <input class= "formInput1" type= "Text" name = "QA1" id="QA1" placeholder="Answer 1"></input><br>
     <!-- Info for test case 2 -->
     <input class= "formInput1" type= "Text" name = "QI2" id="QI2" placeholder="Question Test 2"></input><br>
     <input class= "formInput1" type= "Text" name = "QA2" id="QA2" placeholder="Answer 2"></input><br>
     <!-- Info for test case 3 -->
     <input class= "formInput1" type= "Text" name = "QI3" id="QI3" placeholder="Question Test 3"></input><br>
     <input class= "formInput1" type= "Text" name = "QA3" id="QA3" placeholder="Answer 3"></input><br>

     <!-- More Info for Question -->
     <select name = "QC" id="QC" value="">
       <option value="for">For</option>
       <option value="while">While</option>
       <option value="recursion">Recursion</option>
       <option value="other">Other</option>
     </select><br>
     <select name = "QD" id="QD" value="">
       <option value="easy">Easy</option>
       <option value="medium">Medium</option>
       <option value="hard">Hard</option>
     </select><br>
     <input class= "formInput1" type= "Text" name = "QFN" id ="QFN" placeholder="Function Name"></input><br>
     <label style="padding-top: 13px;"for="F">For Loop
       <input class = "radio" type= "radio" name = "QCN" id="F" value="F"></input>
       <span style="margin-top:10px;"class="radio"></span>
     </label><br>
     <label for="W">While Loop
       <input class = "radio" type= "radio" name = "QCN"  id="W" value="W"></input>
       <span class="radio"></span>
     </label><br>
     <label for="R">Recursion
       <input class = "radio" type= "radio" name = "QCN" id="R" value="R"></input>
       <span class="radio"></span>
     </label><br>
     <input  style="margin-top: -15px;"class= "button" class= "button" type="submit" value="Make Question"/>
   </form>
  </body>
</html>

<?php
  require "config.php";
  $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
  $db= new PDO($connection_string, $dbuser, $dbpass);
  //if there are 3 test cases and 1 constrain
  if(isset($_POST['QFN']) && isset($_POST['QT']) && isset($_POST['QC']) && isset($_POST['QD']) && isset($_POST['QA1']) && isset($_POST['QA2']) && isset($_POST['QA3']) && isset($_POST['QI1']) && isset($_POST['QI2']) && isset($_POST['QI3']) && isset($_POST['QCN'])){
    try{
      $sql = $db->prepare("INSERT INTO `questions`
                  (functionName, questionText, category, difficultyLevel, QI1, Answer1, QI2, Answer2, QI3, Answer3, QuestionConstrain) VALUES
                  (:QFN, :QT, :QC, :QD, :QI1, :QA1, :QI2, :QA2, :QI3, :QA3, :QCN)");
      $params = array(":QFN"=> $_POST['QFN'], ":QT"=> $_POST['QT'], ":QC"=>$_POST['QC'], ":QD"=>$_POST['QD'], ":QA1"=>$_POST['QA1'],
        ":QA2"=>$_POST['QA2'], ":QA3"=>$_POST['QA3'], ":QI1"=>$_POST['QI1'], ":QI2"=>$_POST['QI2'], ":QI3"=>$_POST['QI3'], ":QCN"=>$_POST['QCN']);
      $r = $sql->execute($params);
    }
    finally{}
  }
  //if there are 2 test cases and 1 constrain
  elseif(isset($_POST['QFN']) && isset($_POST['QT']) && isset($_POST['QC']) && isset($_POST['QD']) && isset($_POST['QA1']) && isset($_POST['QI1']) && isset($_POST['QA2']) && isset($_POST['QI2']) && isset($_POST['QC'])){
    try{
      $sql = $db->prepare("INSERT INTO `questions`
                  (functionName, questionText, category, difficultyLevel, QI1, Answer1, QI2, Answer2, QuestionConstrain) VALUES
                  (:QFN, :QT, :QC, :QD, :QI1, :QA1, :QI2, :QA2, :QC)");
      $params = array(":QFN"=> $_POST['QFN'], ":QT"=> $_POST['QT'], ":QC"=>$_POST['QC'], ":QD"=>$_POST['QD'], ":QA1"=>$_POST['QA1'],
        ":QA2"=>$_POST['QA2'], ":QI1"=>$_POST['QI1'], ":QI2"=>$_POST['QI2'], ":QCN"=>$_POST['QCN']);
      $r = $sql->execute($params);
    }
    finally{}
  }
  //if there is 1 test case and 1 constrain
  elseif(isset($_POST['QFN']) && isset($_POST['QT']) && isset($_POST['QC']) && isset($_POST['QD']) && isset($_POST['QA1']) && isset($_POST['QI1']) && isset($_POST['QCN'])){
    try{
      $sql = $db->prepare("INSERT INTO `questions`
                  (functionName, questionText, category, difficultyLevel, QI1, Answer1, QuestionConstrain) VALUES
                  (:QFN, :QT, :QC, :QD, :QI1, :QA1, :QCN)");
      $params = array(":QFN"=> $_POST['QFN'], ":QT"=> $_POST['QT'], ":QC"=>$_POST['QC'], ":QD"=>$_POST['QD'], ":QA1"=>$_POST['QA1'], ":QI1"=>$_POST['QI1'], ":QCN"=>$_POST['QCN']);
      $r = $sql->execute($params);
    }
    finally{}
  }
  //if there are 3 test cases and no constrains
  elseif(isset($_POST['QFN']) && isset($_POST['QT']) && isset($_POST['QC']) && isset($_POST['QD']) && isset($_POST['QA1']) && isset($_POST['QA2']) && isset($_POST['QA3']) && isset($_POST['QI1']) && isset($_POST['QI2']) && isset($_POST['QI3'])){
    try{
      $sql = $db->prepare("INSERT INTO `questions`
                  (functionName, questionText, category, difficultyLevel, QI1, Answer1, QI2, Answer2, QI3, Answer3) VALUES
                  (:QFN, :QT, :QC, :QD, :QI1, :QA1, :QI2, :QA2, :QI3, :QA3)");
      $params = array(":QFN"=> $_POST['QFN'], ":QT"=> $_POST['QT'], ":QC"=>$_POST['QC'], ":QD"=>$_POST['QD'], ":QA1"=>$_POST['QA1'],
        ":QA2"=>$_POST['QA2'], ":QA3"=>$_POST['QA3'], ":QI1"=>$_POST['QI1'], ":QI2"=>$_POST['QI2'], ":QI3"=>$_POST['QI3']);
      $r = $sql->execute($params);
    }
    finally{}
  }
  //if there are 2 test cases and no constrains
  elseif(isset($_POST['QFN']) && isset($_POST['QT']) && isset($_POST['QC']) && isset($_POST['QD']) && isset($_POST['QA1']) && isset($_POST['QI1']) && isset($_POST['QA2']) && isset($_POST['QI2'])){
    try{
      $sql = $db->prepare("INSERT INTO `questions`
                  (functionName, questionText, category, difficultyLevel, QI1, Answer1, QI2, Answer2) VALUES
                  (:QFN, :QT, :QC, :QD, :QI1, :QA1, :QI2, :QA2)");
      $params = array(":QFN"=> $_POST['QFN'], ":QT"=> $_POST['QT'], ":QC"=>$_POST['QC'], ":QD"=>$_POST['QD'], ":QA1"=>$_POST['QA1'],
        ":QA2"=>$_POST['QA2'], ":QI1"=>$_POST['QI1'], ":QI2"=>$_POST['QI2']);
      $r = $sql->execute($params);
    }
    finally{}
  }
  //if there is 1 test case and no constrains
  elseif(isset($_POST['QFN']) && isset($_POST['QT']) && isset($_POST['QC']) && isset($_POST['QD']) && isset($_POST['QA1']) && isset($_POST['QI1'])){
    try{
      $sql = $db->prepare("INSERT INTO `questions`
                  (functionName, questionText, category, difficultyLevel, QI1, Answer1) VALUES
                  (:QFN, :QT, :QC, :QD, :QI1, :QA1)");
      $params = array(":QFN"=> $_POST['QFN'], ":QT"=> $_POST['QT'], ":QC"=>$_POST['QC'], ":QD"=>$_POST['QD'], ":QA1"=>$_POST['QA1'], ":QI1"=>$_POST['QI1']);
      $r = $sql->execute($params);
    }
    finally{}
  }
 ?>
