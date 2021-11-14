<html>
	<head>
		<title>My Project - Logout</title>
		<button class = "button" onclick="location.href = 'Login.php';"
    type="button" name="Login"> Login</button>
	</head>
  <style>
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
              background-color: Transparent;
              border: inset #c6a226;
              color: #bcbdbe;
              padding: 15px 19px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              font-size: 16px;
            }
 </style>
  <body>
      <text> <font size="6"> <center> You are logged out! <center> <font> </text>
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
