<?php

session_start();

if(!isset($_SESSION["isLoggedIn"])){
    header('Location: login.php');
    exit();
}

require './lib/class.mysql.php';

print_r($_GET);

if($_POST){
    if(!empty($_POST["userId"])){
        $conn = new dbconnector();
        $query = $conn->newQuery("INSERT INTO `friends` (UserOneId, UserTwoId)VALUES(:USERONE, :USERTWO)");
        $query->bindParam(":USERONE", $_SESSION["id"], PDO::PARAM_STR);
        $query->bindParam(":USERTWO", $_POST["userId"], PDO::PARAM_STR);
        if($query->execute()){
            echo 'Du har anmodet ' . $_POST["userId"] . ' om venskab.';
            $conn = null;
        }else{
            echo 'Anmodning allerede sendt til bruger.';
        }
    }
}

