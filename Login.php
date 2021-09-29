<html>
	<head>
		<title>Login</title>
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
	<header>
		<div align = "right">
			<button class = "button"
			type="button" name="Home"> Home</button>
		</div>
	<body>
		<!-- This is how you comment -->
    <div>
        <font size="6">
        <center> Login:</center>
		</div>

    <center><form name="loginform" id="myForm" method="POST">
			<div style= "position:relative; right: 4px;">
        <label class = "label" for="email">Username: </label>
			  <input class = "formInput1" type="username" id="username" name="username" placeholder="Enter Username"/>
      </div>
      <div style="margin-bottom: 20px">
        <label class = "label" for="pass">Password: </label>
			  <input class = "formInput2" type="password" id="pass" name="password" placeholder="Enter Password"/>
      </div>
      <input class= "button" type="submit" value="Login"/>
		</form></center>
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

    $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
    try
    {
        $db = new PDO($connection_string, $dbuser, $dbpass);
        //CHANGE FOR NEW DATABASE
        $stmt = $db->prepare("SELECT IsAdmin, username, password, UID from `acc.login` where username = :username LIMIT 1");

        $params = array(":username"=> $userName);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        //echo "<pre>" . var_export($stmt->errorInfo(), true) . "</pre>";
    }
    finally{}
    if($result){
        $userpassword = $result['password'];
        if(password_verify($passWord, $userpassword)){
            $_SESSION['IsAdmiin'] = $result['IsAdmin'];
            //echo $_SESSION['IsAdmiin'];
            if($_SESSION['IsAdmiin']==0){
                echo'<script type="text/javascript">window.open("https://web.njit.edu/~as3655/CS490/UserHome.php","_self");</script>';
            }
            else{
                echo'<script type="text/javascript">window.open("https://web.njit.edu/~as3655/CS490/AdminHome.php","_self");</script>';
            }
        }
    }
}
?>
