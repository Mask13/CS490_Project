<?php
session_start();
require ("config.php");
if(isset($_SESSION['id'])){
  if($_SESSION['id'] == 3){
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
          .formInput1{
            width: 40%;
            padding: 10px;
            border: 2px solid #c6a226;
            border-radius: 1px;
            box-sizing: border-box;
            resize: vertical;
          }
          .formInput2{
            width: 40%;
            padding: 10px;
            border: 2px solid #c6a226;
            border-radius: 1px;
            box-sizing: border-box;
            resize: vertical;
          }
          .label {
            padding: 12px 12px 12px 0;
            display: inline-block;
          }
 </style>
  <body>

  </body>
</html>
