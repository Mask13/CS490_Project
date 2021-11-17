<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin</title>
    <div>
      <titles style= "position:relative; top: 6">
        Questions
      </titles>
      <button style= "float:right;"type="button" onclick="location.href = 'Logout.php';"
           class = "button3" name="Login"> Logout
      </button>
      <button style= "float:right;"type="button" onclick="location.href = 'AdminHome.php';"
           class = "button3" name="Login"> Home
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
      table, th, td {
        border: 1px solid black;
        border-radius: 10px;
        border-color: #c6a226;
        color: white;
        padding: 3px;
        padding-bottom: 6px;
        margin-left: auto;
        margin-right: auto;
      }
      th, td {
        background-color: black;
        font-family: Bahnschrift;
        padding: 10px;
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
      .formInput1{
        width: 20%;
        padding: 10px;
        border: 2px solid #c6a226;
        border-radius: 25px;
        box-sizing: border-box;
        resize: vertical;
        margin: 20px;
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
           class = "button3" name="MNTest"> Make New Question
   </button><br><br>
   <!-- Display all Questions with a SQL Query. -->
   <?php
       require "config.php";
       $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
       $db= new PDO($connection_string, $dbuser, $dbpass);
       try{
         $sql = "SELECT questionID, questionText, category, difficultyLevel, Answer1, Answer2, Answer3, Answer4, QI1, QI2, QI3, QI4  from `questions`";
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
           echo "</tr>";
         }

         echo "</table>";// Closing of list box
       }
       finally{}
    ?>
   <form id="myForm" method="POST">
     <input class = "formInput1" type= "number" name ="questionID" placeholder="Insert Question ID"></input>
      <input class = "button3" type="submit" name="Delete" value="Delete"></input>
   </form>
  </body>
</html>

<?php
    if(isset($_POST["questionID"])){
      try{
        require ("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        $db= new PDO($connection_string, $dbuser, $dbpass);
        $sql = $db->prepare("DELETE FROM `questions` WHERE questionID = :id");
        $r = $sql->execute(array(":id"=>$_POST["questionID"]));
        echo("<meta http-equiv='refresh' content='1'>");
      }
      finally{}
    }
 ?>
