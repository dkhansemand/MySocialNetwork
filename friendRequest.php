<?php

session_start();

if(!isset($_SESSION["isLoggedIn"])){
    header('Location: login.php');
    exit();
}

require './lib/class.mysql.php';

if($_GET){
    if(!empty($_GET["id"]) && isset($_GET["confirm"])){
        $conn = new dbconnector();
        $query = $conn->newQuery("UPDATE friends 
            SET friends.StatusConfirm = 1, friends.ConfirmDate = NOW()
            WHERE friends.id = :ID");
        $query->bindParam(":ID", $_GET["id"], PDO::PARAM_STR);
        if($query->execute()){
            $conn = null;
            echo 'venskab accepteret.';
        }
    }elseif(isset($_GET["ignore"])){
        $conn = new dbconnector();
        $query = $conn->newQuery("DELETE FROM friends WHERE id = :ID");
        $query->bindParam(":ID", $_GET["id"], PDO::PARAM_STR);
        if($query->execute()){
            $conn = null;
            echo 'Anmodning fjernet.';
        }
    }
}

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

