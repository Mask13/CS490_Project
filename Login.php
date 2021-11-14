<html>
	<head>
		<title>Login</title>
	</head>
  <style>
      #container{
            width: 350px;
            height: 450px;
            background: inherit;
            position: absolute;
            overflow: hidden;
            top: 50%;
            left: 50%;
            margin-left: -175px;
            margin-top: -250px;
            border-radius: 8px;
          }
      #container:before{
            width: 400px;
            height: 550px;
            content: "";
            position: absolute;
            top: -25px;
            left: -25px;
            bottom: 0;
            right: 0;
            background: inherit;
            box-shadow: inset 0 0 0 200px rgba(255,255,255,0.2);
            filter: blur(10px);
          }
          form{
            text-align: center;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%,-50%);
          }
      body{
           background-color: #000033;
           background-image: url('https://i1.wp.com/thumbs.gfycat.com/FeminineVillainousFlea-size_restricted.gif');
           height: 100%;
           background-position: center;
           background-repeat: no-repeat;
           background-size: cover;
           color: #bcbdbe;
           }
					 .button {
              background-color: #000033;
              border: 3px outset #c6a226;
              color: white;
              padding: 15px 19px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              font-size: 16px;
              font-family: Trebuchet MS;
              position: relative; top:0px;
            }
          .formInput1{
            width: 100%;
            padding: 10px;
            border: 2px solid #c6a226;
            border-radius: 25px;
            box-sizing: border-box;
            resize: vertical;
            position: relative; bottom:50px;
          }
          .formInput2{
            width: 100%;
            padding: 10px;
            border: 2px solid #c6a226;
            border-radius: 25px;
            box-sizing: border-box;
            resize: vertical;
            position: relative; bottom:40px;
          }
          .label {
            padding: 12px 12px 12px 0;
            display: inline-block;
          }
        }

 </style>
	<body>
		<!-- This is how you comment -->
    <div id= container>
      <font size="9">
      <center><form name="loginform" id="myForm" method="POST">
          <center style="position: relative; bottom: 80px; color:white" > Login:</center>
          <center style="font-size: 15px; position: relative; bottom: 70px; color:gray" > Log in as a instructor or student</center>
  			  <input class = "formInput1" type="username" id="username" name="username" placeholder="Enter Username"/><br>
  			  <input class = "formInput2" type="password" id="pass" name="password" placeholder="Enter Password"/><br>
        <input class= "button" type="submit" value="Login"/>
  		</form></center>
    </div>
	</body>
</html>


<?php
require("config.php");
// session start for login //
session_start();
// authenticate method
unset($_SESSION["authenticated"]);

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);

// CONNECTING TO DATABASE //
if(isset($_POST['username'])&& isset($_POST['password'])){
    require("config.php");
    // getting the username and password
    $userName = $_POST["username"];
    $passWord = $_POST["password"];

    // hash the password
    // might need to manually put in the hashed password in db
    //$passWord = password_hash($passWord, password_bcrypt);
    //filter thing here

		require "config.php";
		$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
		$db= new PDO($connection_string, $dbuser, $dbpass);
    try
    {
        $stmt = $db->prepare("SELECT IsAdmin, username, password, UID from `users` where username = :username LIMIT 1");

        $params = array(":username"=> $userName);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        //echo "<pre>" . var_export($stmt->errorInfo(), true) . "</pre>";
    }
    finally{}
    if($result){
        $userpassword = $result['password'];
        if(password_verify($passWord, $userpassword)){
            $_SESSION['IsAdmin'] = $result['IsAdmin'];
						$_SESSION['UID'] = $result['UID'];
            //echo $_SESSION['IsAdmiin'];
            if($_SESSION['IsAdmin']==0){
                echo'<script type="text/javascript">window.open("UserHome.php","_self");</script>';
            }
            else{
                echo'<script type="text/javascript">window.open("AdminHome.php","_self");</script>';
            }
        }
    }
}
?>
