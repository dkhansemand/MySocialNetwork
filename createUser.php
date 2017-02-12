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
      <a href="#" class="brand-logo">My Social Network</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="login.php">Login</a></li>
      </ul>
    </div>
  </nav>
  </header>
<?php

require './lib/class.mysql.php';

$conn = new dbconnector();

if($_POST){
    if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email    = $_POST['email'];

        $options  = array('cost' => 10);
        $hash     = password_hash($password, PASSWORD_BCRYPT, $options);

        $query = $conn->newQuery("INSERT INTO users (username, password, email) VALUES (:username, '$hash', :email)");
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);

        if($query->execute()){
            $conn = null;
            $success = 'Din bruger er nu oprettet!';
            header('Refresh: 5; url=login.php');
            exit;
        }

    }else{
        $errorMsg = "Alle felter skal udfyldes!";
    }
}

?>
<div class="row">
<div class="col s6 m4">
<p><?=@$success;?></p>
<h1>
    Opret bruger
</h1>
<form action="" method="POST">
    <input type="text" name="username" placeholder="Brugernavn" required>
    <input type="password" name="password" placeholder="password" required>
    <input type="email" name="email" placeholder="E-mail" required>
    <button type="submit" class="waves-effect waves-light btn">Opret bruger<i class="material-icons right">send</i></button>
    <p style="color:red"><?=@$errorMsg;?></p>
</form>
</div>
</div>
</body>
</html>