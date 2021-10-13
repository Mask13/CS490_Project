<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <div>
      <titles style= "position:relative; top: 6">
        New Test
      </titles>
      <button style= "float:right;"type="button" onclick="location.href = 'https://web.njit.edu/~as3655/CS490/Logout.php';"
           class = "button" name="Login"> Logout
      </button>
      <button style= "float:right;"type="button" onclick="location.href = 'https://web.njit.edu/~as3655/CS490/AdminHome.php';"
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
   <form name="NewTest" id="myForm" method="POST">
     <input type="text" name="TestName" id="TestName" placeholder="Test Name"></input><br>
     <input type= "number" id="Q1ID" placeholder="Question 1 ID"></input><br>
     <input type= "number" id="Q1P" placeholder="Question 1 Points"></input><br>
     <input type= "number" id="Q2ID" placeholder="Question 2 ID"></input><br>
     <input type= "number" id="Q2P" placeholder="Question 2 Points"></input><br>
     <input type= "number" id="Q3ID" placeholder="Question 3 ID"></input><br>
     <input type= "number" id="Q3P" placeholder="Question 3 Points"></input><br>
     <input type= "number" id="Q4ID" placeholder="Question 4 ID"></input><br>
     <input type= "number" id="Q4P" placeholder="Question 4 Points"></input><br>
     <input type= "number" id="Q5ID" placeholder="Question 5 ID"></input><br>
     <input type= "number" id="Q5P" placeholder="Question 5 Points"></input><br>
     <input type= "number" id="Total_Points" placeholder="Total Points"></input><br>
     <input class= "button" type="submit" value="Make Test"/>
   </form>
  </body>
</html>

<?php
  //Put the exam into the exams table
  require "config.php";
  $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
  $db= new PDO($connection_string, $dbuser, $dbpass);
  if(isset($_POST['TestName']) && isset($_POST['Total_Points'] && isset($_POST['Q1ID'] && isset($_POST['Q1P'])){
    try{
      $sql = $db->prepare("INSERT INTO `exams`
                  (Exam_Name, Total_Points) VALUES
                  (:TestName, :points)");
      $params = array(":TestName"=> $_POST['TestName'], ":points"=>$_POST['Total_Points']);
      $r = $sql->execute($params);
      echo "<pre>" . var_export($r, true) . "</pre>";
      echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";
    }
    //put the question into QuestionAssignments with the EID
    try{
      $sql = $db->prepare("SELECT EID from exams Where Exam_Name = $_POST['TestName']");
      $r = $sql->execute();
      echo "<pre>" . var_export($r, true) . "</pre>";
      echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";
      $EID = $sql->fetch();
      $sql2 = $db->prepare("INSERT INTO `QuestionAssignments`
                  (EID, Q1, Q1P) VALUES
                  (:EID, :Q1, :Q1P)");
      $params = array(":EID"=> $EID, ":Q1"=>$_POST['Q1ID'], ":Q1P"=>$_POST['Q1P']);
      $r = $sql2->execute($params);
      echo "<pre>" . var_export($r, true) . "</pre>";
      echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";
    }
  }
  //for question 2
  if(isset($_POST['Q2ID'] && isset($_POST['Q2P'])){
    try{
      $sql = $db->prepare("SELECT EID from exams Where Exam_Name = $_POST['TestName']");
      $r = $sql->execute();
      echo "<pre>" . var_export($r, true) . "</pre>";
      echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";
      $EID = $sql->fetch();
      $sql2 = $db->prepare("INSERT INTO `QuestionAssignments`
                  (EID, Q2, Q2P) VALUES
                  (:EID, :Q2, :Q2P)");
      $params = array(":EID"=> $EID, ":Q2"=>$_POST['Q2ID'], ":Q2P"=>$_POST['Q2P']);
      $r = $sql2->execute($params);
      echo "<pre>" . var_export($r, true) . "</pre>";
      echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";
    }
  }
  //for question 3
  if(isset($_POST['Q3ID'] && isset($_POST['Q3P'])){
    try{
      $sql = $db->prepare("SELECT EID from exams Where Exam_Name = $_POST['TestName']");
      $r = $sql->execute();
      echo "<pre>" . var_export($r, true) . "</pre>";
      echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";
      $EID = $sql->fetch();
      $sql2 = $db->prepare("INSERT INTO `QuestionAssignments`
                  (EID, Q3, Q3P) VALUES
                  (:EID, :Q3, :Q3P)");
      $params = array(":EID"=> $EID, ":Q3"=>$_POST['Q3ID'], ":Q3P"=>$_POST['Q3P']);
      $r = $sql2->execute($params);
      echo "<pre>" . var_export($r, true) . "</pre>";
      echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";
    }
  }
  //for question 4
  if(isset($_POST['Q4ID'] && isset($_POST['Q4P'])){
    try{
      $sql = $db->prepare("SELECT EID from exams Where Exam_Name = $_POST['TestName']");
      $r = $sql->execute();
      echo "<pre>" . var_export($r, true) . "</pre>";
      echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";
      $EID = $sql->fetch();
      $sql2 = $db->prepare("INSERT INTO `QuestionAssignments`
                  (EID, Q4, Q4P) VALUES
                  (:EID, :Q4, :Q4P)");
      $params = array(":EID"=> $EID, ":Q4"=>$_POST['Q4ID'], ":Q4P"=>$_POST['Q4P']);
      $r = $sql2->execute($params);
      echo "<pre>" . var_export($r, true) . "</pre>";
      echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";
    }
  }
  //for question 5
  if(isset($_POST['Q5ID'] && isset($_POST['Q5P'])){
    try{
      $sql = $db->prepare("SELECT EID from exams Where Exam_Name = $_POST['TestName']");
      $r = $sql->execute();
      echo "<pre>" . var_export($r, true) . "</pre>";
      echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";
      $EID = $sql->fetch();
      $sql2 = $db->prepare("INSERT INTO `QuestionAssignments`
                  (EID, Q5, Q5P) VALUES
                  (:EID, :Q5, :Q5P)");
      $params = array(":EID"=> $EID, ":Q5"=>$_POST['Q5ID'], ":Q5P"=>$_POST['Q5P']);
      $r = $sql2->execute($params);
      echo "<pre>" . var_export($r, true) . "</pre>";
      echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";
    }
  }

 ?>
