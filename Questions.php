<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin</title>
    <div>
      <titles style= "position:relative; top: 6">
        Questions
      </titles>
      <button style= "float:right;"type="button" onclick="location.href = 'https://web.njit.edu/~kz236/CS490/Logout.php';"
           class = "button" name="Login"> Logout
      </button>
      <button style= "float:right;"type="button" onclick="location.href = 'https://web.njit.edu/~kz236/CS490/AdminHome.php';"
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
    <!-- Tests section -->
    <button type="button" onclick="location.href = 'MNQuestion.php';"
           class = "button" name="MNTest"> Make New Question
   </button><br><br>
   <!-- Display all Questions with a SQL Query. -->
   <?php
       require "config.php";
       $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
       $db= new PDO($connection_string, $dbuser, $dbpass);
       try{
         $sql = "SELECT questionID, questionText, category, difficultyLevel, Answer from `questions`";
         echo "<tbody>"; // list box select command
         foreach ($db->query($sql) as $row){//Array or records stored in $row
           echo "<tr>";
           echo "<td>$row[questionID]</td>";
           echo "<td>$row[questionText]</td>";
           echo "<td>$row[category]</td>";
           echo "<td>$row[difficultyLevel]</td>";
           echo "<td>$row[Answer]</td>";
           echo "</tr>";
         }

         echo "</tbody>";// Closing of list box
       }
       finally{}
    ?>
   <form id="myForm" method="POST">
     <input type= "number" id="questionID"></input>
      <input class = "button" type="submit" id="Delete" value="Delete"></input>
     <input class = "button" type="submit" id="Edit" value="Edit"></input>
   </form>
  </body>
</html>

<?php
    if(isset($_POST["TestID"])){
      if(isset($_POST["Delete"])){
        try{
          require ("config.php");
          $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
          $db= new PDO($connection_string, $dbuser, $dbpass);
          $sql = $db->prepare("DELETE FROM `questions` WHERE questionID = :id");
          $r = $sql->execute(array(":id"=>$_POST["questionID"]));
          echo "<pre>" . var_export($r, true) . "</pre>";
          echo "<pre>" . var_export($sql->errorInfo(), true) . "</pre>";
          header("Refresh:0");
        }
        finally{}
      }
    }
 ?>
