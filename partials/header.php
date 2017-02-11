<?php
    session_start();

    if(!isset($_SESSION["isLoggedIn"])){
        header('Location: login.php');
        exit();
    }
require_once './lib/class.mysql.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Social Network</title>
     <!-- Compiled and minified CSS -->
     <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">
<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>

  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
       
</head>
<body>
<header>
  <nav>
    <div class="nav-wrapper">
      <a href="#!" class="brand-logo left">My Social Network</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="./">Startside</a></li>
        <li><a href="showUsers.php">Se brugere</a></li>
        <li><a href="logout.php">Log ud</a></li>
      </ul>
       <form action="search.php" method="post" class="right">
        <div class="input-field">
          <input id="search" type="search" name="searchInput" placeholder="Søg..." required>
          <label class="label-icon" for="search"><i class="material-icons">search</i></label>
          <i class="material-icons">close</i>
        </div>
      </form>
    </div>
  </nav>
</header>
<div class="row">