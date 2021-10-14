<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <div>
      <titles style= "position:relative; top: 6">
        New Question
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
   <form name="NewQuestion" id="myForm" method="POST">
     <input type= "Text" name = "QT" id="QT" placeholder="Question Text"></input><br>
     <input type= "Text" name = "QI" id="QI" placeholder="Question Input"></input><br>
     <input type= "Text" name = "QA" id="QA" placeholder="Expected Output"></input><br>
     <input type= "Text" name = "QC" id="QC" placeholder="Question Category"></input><br>
     <input type= "Text" name = "QD" id="QD" placeholder="Question Difficulty"></input><br>
     <input class= "button" type="submit" value="Make Question"/>
   </form>
  </body>
</html>

<?php
  require "config.php";
  $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
  $db= new PDO($connection_string, $dbuser, $dbpass);
  if(isset($_POST['QT']) && isset($_POST['QA']) && isset($_POST['QC']) && isset($_POST['QD'])) {
    echo "trying";
    try{
      $sql = $db->prepare("INSERT INTO `questions`
                  (questionText, category, difficultyLevel, Answer) VALUES
                  (:QT, :QC, :QD, :QA)");
      $params = array(":QT"=> $_POST['QT'], ":QC"=>$_POST['QC'], ":QD"=>$_POST['QD'], ":QA"=>$_POST['QA']);
      $r = $sql->execute($params);
      echo "<pre>" . var_export($r, true) . "</pre>";
      echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";
    }
    finally{}
  }
 ?>
