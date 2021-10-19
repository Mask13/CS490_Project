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
           .formInput1{
             width: 50%;
             padding: 10px;
             border: 2px solid #c6a226;
             border-radius: 25px;
             box-sizing: border-box;
             resize: vertical;
             position: relative; bottom:50px;
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
    <!-- Display All Questons -->
   <!-- Display all tests with a SQL Query. View Test, and Delete Test -->
   <br>
   <br>
   <form name="NewQuestion" id="myForm" method="POST">
     <input class= "formInput1" type= "Text" name = "QT" id="QT" placeholder="Question Text"></input><br>
     <input class= "formInput1" type= "Text" name = "QI1" id="QI1" placeholder="Question Test 1"></input><br>
     <input class= "formInput1" type= "Text" name = "QA1" id="QA1" placeholder="Answer 1"></input><br>
     <input class= "formInput1" type= "Text" name = "QI1" id="QI2" placeholder="Question Test 2"></input><br>
     <input class= "formInput1" type= "Text" name = "QA1" id="QA2" placeholder="Answer 2"></input><br>
     <input class= "formInput1" type= "Text" name = "QI1" id="QI3" placeholder="Question Test 3"></input><br>
     <input class= "formInput1" type= "Text" name = "QA1" id="QA3" placeholder="Answer 3"></input><br>
     <input class= "formInput1" type= "Text" name = "QC" id="QC" placeholder="Question Category"></input><br>
     <input class= "formInput1" type= "Text" name = "QD" id="QD" placeholder="Question Difficulty"></input><br>
     <input class= "formInput1" type= "Text" name = "QFN" id ="QFN" placeholder="Function Name"></input><br>
     <input class= "button" class= "button" type="submit" value="Make Question"/>
   </form>
  </body>
</html>

<?php
  require "config.php";
  $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
  $db= new PDO($connection_string, $dbuser, $dbpass);
  if(isset($_POST['QFN']) && isset($_POST['QT']) && isset($_POST['QC']) && isset($_POST['QD']) && isset($_POST['QA1'])
    && isset($_POST['QA2']) && isset($_POST['QA3']) && isset($_POST['QI1']) && isset($_POST['QI2']) && isset($_POST['QI3'])){
    echo "trying";
    try{
      $sql = $db->prepare("INSERT INTO `questions`
                  (functionName, questionText, category, difficultyLevel, QI1, Answer1, QI2, Answer2, QI3, Answer3) VALUES
                  (:QFN, :QT, :QC, :QD, :QI1, :QA1, :QI2, :QA2, :QI3, :QA3)");
      $params = array(":QFN"=> $_POST['QFN'], ":QT"=> $_POST['QT'], ":QC"=>$_POST['QC'], ":QD"=>$_POST['QD'], ":QA1"=>$_POST['QA1'],
        ":QA2"=>$_POST['QA2'], ":QA3"=>$_POST['QA3'], ":QI1"=>$_POST['QI1'], ":QI2"=>$_POST['QI2'], ":QI3"=>$_POST['QI3']);
      $r = $sql->execute($params);
      echo "<pre>" . var_export($r, true) . "</pre>";
      echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";
    }
    finally{}
  }
  elseif(isset($_POST['QFN']) && isset($_POST['QT']) && isset($_POST['QC']) && isset($_POST['QD']) && isset($_POST['QA1'])
    && isset($_POST['QA2']) && isset($_POST['QI1']) && isset($_POST['QI2'])){
      echo "trying 2";
    try{
      $sql = $db->prepare("INSERT INTO `questions`
                  (functionName, questionText, category, difficultyLevel, QI1, Answer1, QI2, Answer2, QI3, Answer3) VALUES
                  (:QFN, :QT, :QC, :QD, :QI1, :QA1, :QI2, :QA2)");
      $params = array(":QFN"=> $_POST['QFN'], ":QT"=> $_POST['QT'], ":QC"=>$_POST['QC'], ":QD"=>$_POST['QD'], ":QA1"=>$_POST['QA1'],
        ":QA2"=>$_POST['QA2'], ":QI1"=>$_POST['QI1'], ":QI2"=>$_POST['QI2']);
      $r = $sql->execute($params);
      echo "<pre>" . var_export($r, true) . "</pre>";
      echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";
    }
    finally{}
  }
  elseif(isset($_POST['QFN']) && isset($_POST['QT']) && isset($_POST['QC']) && isset($_POST['QD']) && isset($_POST['QA1']) && isset($_POST['QI1'])){
    echo "trying 3";
    try{
      $sql = $db->prepare("INSERT INTO `questions`
                  (functionName, questionText, category, difficultyLevel, QI1, Answer1, QI2, Answer2, QI3, Answer3) VALUES
                  (:QFN, :QT, :QC, :QD, :QI1, :QA1)");
      $params = array(":QFN"=> $_POST['QFN'], ":QT"=> $_POST['QT'], ":QC"=>$_POST['QC'], ":QD"=>$_POST['QD'], ":QA1"=>$_POST['QA1'], ":QI1"=>$_POST['QI1']);
      $r = $sql->execute($params);
      echo "<pre>" . var_export($r, true) . "</pre>";
      echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";
    }
    finally{}
  }
 ?>
