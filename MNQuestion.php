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
        width:60%;
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
        background-image: url('https://images.unsplash.com/photo-1445905595283-21f8ae8a33d2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1052&q=80');
        height: auto;
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
      .button:hover {
        background-color: rgb(69, 74, 28);
      }
      .button:active {
        background-color: rgb(69, 74, 28);
        box-shadow: 0 5px #666;
        transform: translateY(4px);
      }
      .formNQ{
        width:40%;
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
              $sql = "SELECT questionID, questionText, category, difficultyLevel, Answer1, Answer2, Answer3, Answer4, Answer5, QI1, QI2, QI3, QI4, QI5 from `questions`";
            }
            elseif($_POST['difficulty'] == "all"){
              $sql = "SELECT questionID, questionText, category, difficultyLevel, Answer1, Answer2, Answer3, Answer4, Answer5, QI1, QI2, QI3, QI4, QI5 from `questions` WHERE category = '$_POST[catagory]'";
            }
            elseif ($_POST['catagory'] == "all") {
              $sql = "SELECT questionID, questionText, category, difficultyLevel, Answer1, Answer2, Answer3, Answer4, Answer5, QI1, QI2, QI3, QI4, QI5 from `questions` WHERE difficultyLevel = '$_POST[difficulty]'";
            }
            else{
              $sql = "SELECT questionID, questionText, category, difficultyLevel, Answer1, Answer2, Answer3, Answer4, Answer5, QI1, QI2, QI3, QI4, QI5 from `questions` WHERE difficultyLevel = '$_POST[difficulty]' and category = '$_POST[catagory]'";
            }
          }
          else{
            $sql = "SELECT questionID, questionText, category, difficultyLevel, Answer1, Answer2, Answer3, Answer4, Answer5, QI1, QI2, QI3, QI4, QI5 from `questions`";
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
            echo "<td>$row[QI4]</td>";
            echo "<td>$row[Answer4]</td>";
            echo "<td>$row[QI5]</td>";
            echo "<td>$row[Answer5]</td>";
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
   <form class = "formNQ" name="NewQuestion" id="NewQuestion" method="POST">
     <textarea rows="5" form = 'NewQuestion' class= "formInput1" name = "QT" id="QT" placeholder="Question Text"></textarea><br>
     <!-- Info for test case 1 -->
     <input class= "formInput1" type= "Text" name = "QI1" id="QI1" placeholder="Question Test 1"></input><br>
     <input class= "formInput1" type= "Text" name = "QA1" id="QA1" placeholder="Answer 1"></input><br>
     <!-- Info for test case 2 -->
     <input class= "formInput1" type= "Text" name = "QI2" id="QI2" placeholder="Question Test 2"></input><br>
     <input class= "formInput1" type= "Text" name = "QA2" id="QA2" placeholder="Answer 2"></input><br>
     <!-- Info for test case 3 -->
     <input class= "formInput1" type= "Text" name = "QI3" id="QI3" placeholder="Question Test 3"></input><br>
     <input class= "formInput1" type= "Text" name = "QA3" id="QA3" placeholder="Answer 3"></input><br>
     <!-- Info for test case 4 -->
     <input class= "formInput1" type= "Text" name = "QI4" id="QI4" placeholder="Question Test 4"></input><br>
     <input class= "formInput1" type= "Text" name = "QA4" id="QA4" placeholder="Answer 4"></input><br>
     <!-- Info for test case 5 -->
     <input class= "formInput1" type= "Text" name = "QI5" id="QI5" placeholder="Question Test 5"></input><br>
     <input class= "formInput1" type= "Text" name = "QA5" id="QA5" placeholder="Answer 5"></input><br>

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
     <select name = "QuestionConstrain" id="QuestionConstrain" value="">
       <option value="F">For Loop</option>
       <option value="W">While Loop</option>
       <option value="R">Recursion</option>
       <option value="NULL">No Constrain</option>
     </select><br>
     <input class= "formInput1" type= "Text" name = "QFN" id ="QFN" placeholder="Function Name"></input><br>
     <input class= "button" class= "button" type="submit" value="Make Question"/>
   </form>
  </body>
</html>

<?php
  require "config.php";
  $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
  $db= new PDO($connection_string, $dbuser, $dbpass);
  if(isset($_POST['QuestionConstrain']) && ($_POST['QuestionConstrain'] != "NULL")){
    //if there are 5 test cases and 1 constrain
    if(isset($_POST['QFN']) && isset($_POST['QT']) && isset($_POST['QC']) && isset($_POST['QD']) && isset($_POST['QA1']) && isset($_POST['QA2']) && isset($_POST['QA3']) && isset($_POST['QA4']) && isset($_POST['QA5']) && isset($_POST['QI1']) && isset($_POST['QI2']) && isset($_POST['QI3']) && isset($_POST['QI4']) && isset($_POST['QI5']) && isset($_POST['QuestionConstrain'])){
     try{
       $sql = $db->prepare("INSERT INTO `questions`
                   (functionName, questionText, category, difficultyLevel, QI1, Answer1, QI2, Answer2, QI3, Answer3, QI4, Answer4, QI5, Answer5, QuestionConstrain) VALUES
                   (:QFN, :QT, :QC, :QD, :QI1, :QA1, :QI2, :QA2, :QI3, :QA3, :QI4, :QA4, :QI5, :QA5, :QuestionConstrain)");
       $params = array(":QFN"=> $_POST['QFN'], ":QT"=> $_POST['QT'], ":QC"=>$_POST['QC'], ":QD"=>$_POST['QD'], ":QA1"=>$_POST['QA1'],
         ":QA2"=>$_POST['QA2'], ":QA3"=>$_POST['QA3'], ":QA4"=>$_POST['QA4'], ":QA5"=>$_POST['QA5'], ":QI1"=>$_POST['QI1'], ":QI2"=>$_POST['QI2'], ":QI3"=>$_POST['QI3'], ":QI4"=>$_POST['QI4'], ":QI5"=>$_POST['QI5'], ":QuestionConstrain"=>$_POST['QuestionConstrain']);
       $r = $sql->execute($params);
     }
     finally{}
    }
    //if there are 4 test cases and 1 constrain
    elseif(isset($_POST['QFN']) && isset($_POST['QT']) && isset($_POST['QC']) && isset($_POST['QD']) && isset($_POST['QA1']) && isset($_POST['QA2']) && isset($_POST['QA3']) && isset($_POST['QA4']) && isset($_POST['QI1']) && isset($_POST['QI2']) && isset($_POST['QI3']) && isset($_POST['QI4']) && isset($_POST['QuestionConstrain'])){
     try{
       $sql = $db->prepare("INSERT INTO `questions`
                   (functionName, questionText, category, difficultyLevel, QI1, Answer1, QI2, Answer2, QI3, Answer3, QI4, Answer4, QuestionConstrain) VALUES
                   (:QFN, :QT, :QC, :QD, :QI1, :QA1, :QI2, :QA2, :QI3, :QA3, :QI4, :QA4, :QuestionConstrain)");
       $params = array(":QFN"=> $_POST['QFN'], ":QT"=> $_POST['QT'], ":QC"=>$_POST['QC'], ":QD"=>$_POST['QD'], ":QA1"=>$_POST['QA1'],
         ":QA2"=>$_POST['QA2'], ":QA3"=>$_POST['QA3'], ":QA4"=>$_POST['QA4'], ":QI1"=>$_POST['QI1'], ":QI2"=>$_POST['QI2'], ":QI3"=>$_POST['QI3'], ":QI4"=>$_POST['QI4'], ":QuestionConstrain"=>$_POST['QuestionConstrain']);
       $r = $sql->execute($params);
     }
     finally{}
    }
    //if there are 3 test cases and 1 constrain
    elseif(isset($_POST['QFN']) && isset($_POST['QT']) && isset($_POST['QC']) && isset($_POST['QD']) && isset($_POST['QA1']) && isset($_POST['QA2']) && isset($_POST['QA3']) && isset($_POST['QI1']) && isset($_POST['QI2']) && isset($_POST['QI3']) && isset($_POST['QuestionConstrain'])){
      try{
        $sql = $db->prepare("INSERT INTO `questions`
                    (functionName, questionText, category, difficultyLevel, QI1, Answer1, QI2, Answer2, QI3, Answer3, QuestionConstrain) VALUES
                    (:QFN, :QT, :QC, :QD, :QI1, :QA1, :QI2, :QA2, :QI3, :QA3, :QuestionConstrain)");
        $params = array(":QFN"=> $_POST['QFN'], ":QT"=> $_POST['QT'], ":QC"=>$_POST['QC'], ":QD"=>$_POST['QD'], ":QA1"=>$_POST['QA1'],
          ":QA2"=>$_POST['QA2'], ":QA3"=>$_POST['QA3'], ":QI1"=>$_POST['QI1'], ":QI2"=>$_POST['QI2'], ":QI3"=>$_POST['QI3'], ":QuestionConstrain"=>$_POST['QuestionConstrain']);
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
          ":QA2"=>$_POST['QA2'], ":QI1"=>$_POST['QI1'], ":QI2"=>$_POST['QI2'], ":QuestionConstrain"=>$_POST['QuestionConstrain']);
        $r = $sql->execute($params);
      }
      finally{}
    }
    //if there is 1 test case and 1 constrain
    elseif(isset($_POST['QFN']) && isset($_POST['QT']) && isset($_POST['QC']) && isset($_POST['QD']) && isset($_POST['QA1']) && isset($_POST['QI1']) && isset($_POST['QuestionConstrain'])){
      try{
        $sql = $db->prepare("INSERT INTO `questions`
                    (functionName, questionText, category, difficultyLevel, QI1, Answer1, QuestionConstrain) VALUES
                    (:QFN, :QT, :QC, :QD, :QI1, :QA1, :QuestionConstrain)");
        $params = array(":QFN"=> $_POST['QFN'], ":QT"=> $_POST['QT'], ":QC"=>$_POST['QC'], ":QD"=>$_POST['QD'], ":QA1"=>$_POST['QA1'], ":QI1"=>$_POST['QI1'], ":QuestionConstrain"=>$_POST['QuestionConstrain']);
        $r = $sql->execute($params);
      }
      finally{}
    }
  }
  if(isset($_POST['QuestionConstrain']) && ($_POST['QuestionConstrain'] == "NULL")){
    //if there are 5 test cases and no constrains
    if(isset($_POST['QFN']) && isset($_POST['QT']) && isset($_POST['QC']) && isset($_POST['QD']) && isset($_POST['QA1']) && isset($_POST['QA2']) && isset($_POST['QA3']) && isset($_POST['QA4']) && isset($_POST['QA5']) && isset($_POST['QI1']) && isset($_POST['QI2']) && isset($_POST['QI3']) && isset($_POST['QI4']) && isset($_POST['QI5'])){
      try{
        $sql = $db->prepare("INSERT INTO `questions`
                    (functionName, questionText, category, difficultyLevel, QI1, Answer1, QI2, Answer2, QI3, Answer3, QI4, Answer4, QI5, Answer5) VALUES
                    (:QFN, :QT, :QC, :QD, :QI1, :QA1, :QI2, :QA2, :QI3, :QA3, :QI4, :QA4, :QI5, :QA5)");
        $params = array(":QFN"=> $_POST['QFN'], ":QT"=> $_POST['QT'], ":QC"=>$_POST['QC'], ":QD"=>$_POST['QD'], ":QA1"=>$_POST['QA1'],
          ":QA2"=>$_POST['QA2'], ":QA3"=>$_POST['QA3'], ":QA4"=>$_POST['QA4'], ":QA5"=>$_POST['QA5'], ":QI1"=>$_POST['QI1'], ":QI2"=>$_POST['QI2'], ":QI3"=>$_POST['QI3'], ":QI4"=>$_POST['QI4'], ":QI5"=>$_POST['QI5']);
        $r = $sql->execute($params);
      }
      finally{}
    }
    //if there are 4 test cases and no constrains
    elseif(isset($_POST['QFN']) && isset($_POST['QT']) && isset($_POST['QC']) && isset($_POST['QD']) && isset($_POST['QA1']) && isset($_POST['QA2']) && isset($_POST['QA3']) && isset($_POST['QA4']) && isset($_POST['QI1']) && isset($_POST['QI2']) && isset($_POST['QI3']) && isset($_POST['QI4'])){
      try{
        $sql = $db->prepare("INSERT INTO `questions`
                    (functionName, questionText, category, difficultyLevel, QI1, Answer1, QI2, Answer2, QI3, Answer3, QI4, Answer4) VALUES
                    (:QFN, :QT, :QC, :QD, :QI1, :QA1, :QI2, :QA2, :QI3, :QA3, :QI4, :QA4)");
        $params = array(":QFN"=> $_POST['QFN'], ":QT"=> $_POST['QT'], ":QC"=>$_POST['QC'], ":QD"=>$_POST['QD'], ":QA1"=>$_POST['QA1'],
          ":QA2"=>$_POST['QA2'], ":QA3"=>$_POST['QA3'], ":QA4"=>$_POST['QA4'], ":QI1"=>$_POST['QI1'], ":QI2"=>$_POST['QI2'], ":QI3"=>$_POST['QI3'], ":QI4"=>$_POST['QI4']);
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
  }

 ?>
