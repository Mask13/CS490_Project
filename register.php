<html>
  <head>
    <title>Register</title>
  </head>
  <body>
    <form name="RegisterForm" id="RegisterForm" method="POST">
      <label for="email">Username: </label>
      <input id="username" name="username" placeholder="Enter Username"/>
      <label for="pass">Password: </label>
      <input id="password" type="password" name="password" placeholder="Enter Password"/>
      <input type="submit" name="register"/>
    </form>
  </body>
</html>

<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['username']) && isset($_POST['password'])){
  require ("config.php");
  $username = $_POST['username'];
  $password = $_POST['password'];
  $password = password_hash($password,PASSWORD_BCRYPT);

  $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";

  try{
  $db= new PDO($connection_string, $dbuser, $dbpass);
  echo "should have connected";
  $stmt = $db->prepare("INSERT INTO `users`
            (username, password) VALUES
            (:username, :password)");
  $params = array(":username"=> $username, ":password"=> $password);
  $stmt->execute($params);
  echo "<pre>" . var_export($stmt->errorInfo(), true) . "</pre>";
  }
  catch(Exception $e){
  echo $e->getMessage();
  exit("It didn't work");
  }
}
?>
