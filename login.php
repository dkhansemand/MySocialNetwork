<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Social Network</title>
     <!-- Compiled and minified CSS -->
     <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">

  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
       
</head>
<body>
<header>
  <nav>
    <div class="nav-wrapper">
      <a href="#" class="brand-logo">Logo</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="createUser.php">Opret bruger</a></li>
      </ul>
    </div>
  </nav>
  </header>
<?php

session_start();
require_once './lib/class.mysql.php';

if(isset($_SESSION['isLoggedIn'])){
    session_destroy();
}

if($_POST){
    if(!empty($_POST['username']) && !empty($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

            $conn = new dbconnector();
            $query = $conn->newQuery("SELECT id, password FROM `users` WHERE username = :username");
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount()){
                $result = $query->fetch(PDO::FETCH_ASSOC);

                if(password_verify($password, $result['password'])){
                    $_SESSION['id'] = $result['id'];
                    $_SESSION['isLoggedIn'] = true;
                    $conn = null;
                    header('Location: index.php');
                    exit;
                }else{
                    $conn = null;
                    $errorMsg = "Forkert brugernavn/password.";
                }
            }else{
                $errorMsg = "Forkert brugernavn/password.";
            }
    }else{
        $errorMsg = "Alle felter skal udfyldes!";
    }
}

?>
<div class="row">
<div class="col s6 m4">
<form action="" method="post">
    <h2>Login</h2>
    <label>Brugernavn;</label>
    <input type="text" name="username" placeholder="Brugernavn">
    <label>Password</label>
    <input type="password" name="password" placeholder="password">
    <button class="waves-effect waves-light btn" type="submit">Login<i class="material-icons right">send</i></button>
    <p style="color: red"><?=@$errorMsg;?></p>
</form>
<p>Opret en bruger <a class="waves-effect waves-light btn" href="createUser.php" title="">her</a></p>
</div>
</div>
</body>
</html>