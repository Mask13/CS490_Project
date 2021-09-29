<?php
session_start();
require ("config.php");
if(isset($_SESSION['id'])){
  if($_SESSION['IsAdmiin']== 1){
    echo 'hello admin';
  }
  else{
    header("Location: https://web.njit.edu/~as3655/CS490/Login.php");
  }
}
else{
  header("Location: https://web.njit.edu/~as3655/CS490/Login.php");
}
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin</title>
    <button type="button" onclick="location.href = 'https://web.njit.edu/~as3655/CS490/Logout.php';"
           class = "button" name="Login"> Logout
   </button>
  </head>
  <style>
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
              font-size: 16px;
          }
          .label {
            padding: 12px 12px 12px 0;
            display: inline-block;
          }
          .titles{
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
    <center><header class=titles>Tests</header></center>
    <button type="button" onclick="location.href = 'https://web.njit.edu/~as3655/CS490/Logout.php';"
           class = "button" name="MNTest"> Make New Test
   </button>
   <!-- display current tests that are made here -->

   <!-- Questons -->
   <center><header class=titles>Questons</header></center>
   <button type="button" onclick="location.href = 'https://web.njit.edu/~as3655/CS490/Logout.php';"
          class = "button" name="MNTest"> Make New Question
  </button>
  <!-- display current questions that in the bank here -->
  </body>
</html>
