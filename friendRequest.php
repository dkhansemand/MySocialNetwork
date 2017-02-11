<?php

session_start();

if(!isset($_SESSION["isLoggedIn"])){
    header('Location: login.php');
    exit();
}

require './lib/class.mysql.php';

if($_GET){
    if(!empty($_GET["id"]) && isset($_GET["accept"])){
        $conn = new dbconnector();
        $query = $conn->newQuery("UPDATE friends 
            SET friends.StatusConfirm = 1, friends.Action_userId = :USERTWO, friends.ConfirmDate = NOW()
            WHERE friends.userOneId = :ID AND friends.userTwoId = :USERTWO");
            $query->bindParam(":USERTWO", $_SESSION["id"], PDO::PARAM_STR);
        $query->bindParam(":ID", $_GET["id"], PDO::PARAM_STR);
        if($query->execute()){
            $conn = null;
            echo 'venskab accepteret.';
        }
    }elseif(!empty($_GET["id"]) && isset($_GET["ignore"])){
        $conn = new dbconnector();
        $query = $conn->newQuery("DELETE FROM friends WHERE friends.userOneId = :ID AND friends.userTwoId = :USERTWO");
        $query->bindParam(":USERTWO", $_SESSION["id"], PDO::PARAM_STR);
        $query->bindParam(":ID", $_GET["id"], PDO::PARAM_STR);
        if($query->execute()){
            $conn = null;
            echo 'Anmodning fjernet.';
        }
    }elseif(!empty($_GET["id"]) && isset($_GET["add"])){
        $conn = new dbconnector();
        $query = $conn->newQuery("INSERT INTO `friends` (UserOneId, UserTwoId, Action_userId)VALUES(:USERONE, :USERTWO, :USERONE)");
        $query->bindParam(":USERONE", $_SESSION["id"], PDO::PARAM_STR);
        $query->bindParam(":USERTWO", $_GET["id"], PDO::PARAM_STR);
        if($query->execute()){
            echo 'Du har anmodet ' . $_GET["id"] . ' om venskab.';
            $conn = null;
        }else{
            echo 'Anmodning allerede sendt til bruger.';
        }
    }
}

