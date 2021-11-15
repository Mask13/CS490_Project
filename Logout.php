<html>
	<head>
		<title>Logout</title>
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
        body{
           background-color: black;
           background-image: url('https://i1.wp.com/thumbs.gfycat.com/FeminineVillainousFlea-size_restricted.gif');
           height: 100%;
           background-position: center;
           background-repeat: no-repeat;
           background-size: cover;
           color: white;
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
            font-family: Sans-serif;
            position: relative; top:0px;

            background-repeat:no-repeat;
            background-position:bottom left;
            background-position:bottom left, top right, 0 0, 0 0;
            background-clip:border-box;

            -moz-border-radius:8px;
            -webkit-border-radius:8px;
            border-radius:8px;

            -moz-box-shadow:0 0 1px #fff inset;
            -webkit-box-shadow:0 0 1px #fff inset;
            box-shadow:0 0 1px #fff inset;
            }
 </style>
  <body>
    <div id= container>
      <font size="9">
      <center><form name="loginform" id="myForm" method="POST">
          <center style="position: relative; color:white" > You have Logged Out.:</center>
          <center style="font-size: 15px; position: relative; color:gray" > Click on Login to Log back in.</center>
          <button class = "button" onclick="location.href = 'Login.php';"
            type="button" name="Login"> Login</button>
  		</form></center>
    </div>
	</body>
</html>
<?php
session_start();
session_unset();
session_destroy();

//get session cookie and delete/clear it for this session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
	//clones then destroys since it makes it's lifetime
	//negative (in the past)
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
?>
